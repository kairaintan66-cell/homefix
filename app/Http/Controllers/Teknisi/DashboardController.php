<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Technician;
use App\Models\TechnicianSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Mengambil profil teknisi yang sedang login.
     */
    private function technician(): ?Technician
    {
        return Technician::where('user_id', Auth::id())->first();
    }

    /**
     * Mengambil SQL untuk menghitung total durasi booking dalam menit.
     */
    private function bookingDurationSql(): string
    {
        return "(
            SELECT COALESCE(
                SUM(services.duration * booking_details.quantity),
                0
            )
            FROM booking_details
            INNER JOIN services
                ON services.id = booking_details.service_id
            WHERE booking_details.booking_id = bookings.id
        )";
    }

    /**
     * Mengambil booking yang sesuai dengan jadwal,
     * layanan, ketersediaan, dan tidak bentrok.
     */
    private function eligibleBookingsQuery(Technician $technician)
    {
        $serviceIds = $technician->services()->pluck('services.id');

        $query = Booking::query()
            ->whereNull('technician_id')
            ->where('status', 'menunggu');

        // Teknisi harus sudah diverifikasi dan tersedia.
        if (
            !$technician->is_verified ||
            !$technician->is_available ||
            $serviceIds->isEmpty()
        ) {
            return $query->whereRaw('1 = 0');
        }

        // Booking harus memiliki detail layanan.
        $query->whereHas('details');

        // Semua layanan booking harus sesuai keahlian teknisi.
        $query->whereDoesntHave('details', function ($detail) use ($serviceIds) {
            $detail->whereNotIn('service_id', $serviceIds);
        });

        $durationSql = $this->bookingDurationSql();

        // Durasi booking harus lebih dari nol.
        $query->whereRaw("$durationSql > 0");

        // Periksa hari, jam mulai, dan jam selesai sesuai jadwal.
        $query->whereExists(function ($schedule) use (
            $technician,
            $durationSql
        ) {
            $schedule->selectRaw('1')
                ->from('technician_schedules')
                ->where(
                    'technician_schedules.technician_id',
                    $technician->id
                )
                ->where('technician_schedules.is_available', true)

                // Cocokkan hari booking dengan hari jadwal teknisi.
                ->whereRaw("
                    CASE EXTRACT(ISODOW FROM bookings.booking_date)
                        WHEN 1 THEN 'Senin'
                        WHEN 2 THEN 'Selasa'
                        WHEN 3 THEN 'Rabu'
                        WHEN 4 THEN 'Kamis'
                        WHEN 5 THEN 'Jumat'
                        WHEN 6 THEN 'Sabtu'
                        WHEN 7 THEN 'Minggu'
                    END = technician_schedules.day
                ")

                // Waktu mulai booking harus masuk jam kerja.
                ->whereRaw(
                    'bookings.booking_time >= technician_schedules.start_time'
                )
                ->whereRaw(
                    'bookings.booking_time < technician_schedules.end_time'
                )

                // Waktu selesai booking tidak boleh melewati jam kerja.
                ->whereRaw("
                    (
                        bookings.booking_date
                        + technician_schedules.end_time
                    ) >= (
                        bookings.booking_date
                        + bookings.booking_time
                        + (($durationSql) * INTERVAL '1 minute')
                    )
                ");
        });

        // Cegah booking baru bertabrakan dengan booking aktif teknisi.
        $query->whereNotExists(function ($conflict) use (
            $technician,
            $durationSql
        ) {
            $existingDurationSql = "(
                SELECT COALESCE(
                    SUM(
                        existing_services.duration
                        * existing_details.quantity
                    ),
                    0
                )
                FROM booking_details AS existing_details
                INNER JOIN services AS existing_services
                    ON existing_services.id = existing_details.service_id
                WHERE existing_details.booking_id = existing_bookings.id
            )";

            $conflict->selectRaw('1')
                ->from('bookings as existing_bookings')
                ->where(
                    'existing_bookings.technician_id',
                    $technician->id
                )
                ->whereIn('existing_bookings.status', [
                    'dikonfirmasi',
                    'diproses',
                    'sedang_dikerjakan',
                ])

                // Booking lama harus dimulai sebelum booking baru selesai.
                ->whereRaw("
                    (
                        existing_bookings.booking_date
                        + existing_bookings.booking_time
                    ) < (
                        bookings.booking_date
                        + bookings.booking_time
                        + (($durationSql) * INTERVAL '1 minute')
                    )
                ")

                // Booking lama harus selesai setelah booking baru dimulai.
                ->whereRaw("
                    (
                        existing_bookings.booking_date
                        + existing_bookings.booking_time
                        + (($existingDurationSql) * INTERVAL '1 minute')
                    ) > (
                        bookings.booking_date
                        + bookings.booking_time
                    )
                ");
        });

        return $query;
    }

    /**
     * Booking milik teknisi dan booking baru yang sesuai jadwalnya.
     */
    private function availableBookings()
    {
        $technician = $this->technician();

        if (!$technician) {
            return Booking::query()->whereRaw('1 = 0');
        }

        return Booking::query()->where(function ($query) use ($technician) {
            // Booking yang sudah menjadi tanggung jawab teknisi.
            $query->where('technician_id', $technician->id);

            // Booking baru yang belum diambil dan sesuai jadwal.
            $query->orWhereIn(
                'id',
                $this->eligibleBookingsQuery($technician)->select('id')
            );
        });
    }

    /**
     * Dashboard utama teknisi.
     */
    public function index(): View
    {
        $user = Auth::user();
        $technician = $this->technician();
        $query = $this->availableBookings();

        $totalBooking = (clone $query)->count();

        $menunggu = (clone $query)
            ->whereIn('status', ['menunggu', 'dikonfirmasi'])
            ->count();

        $berlangsung = (clone $query)
            ->whereIn('status', ['diproses', 'sedang_dikerjakan'])
            ->count();

        $selesai = (clone $query)
            ->where('status', 'selesai')
            ->count();

        $bookings = (clone $query)
            ->with(['user', 'address', 'details.service'])
            ->orderByDesc('booking_date')
            ->orderByDesc('booking_time')
            ->limit(5)
            ->get();

        return view('teknisi.dashboard', compact(
            'user',
            'technician',
            'totalBooking',
            'menunggu',
            'berlangsung',
            'selesai',
            'bookings'
        ));
    }

    /**
     * Halaman daftar pesanan teknisi.
     */
    public function bookings(): View
    {
        $bookings = $this->availableBookings()
            ->with(['user', 'address', 'details.service'])
            ->orderByDesc('booking_date')
            ->orderByDesc('booking_time')
            ->paginate(10);

        return view('teknisi.bookings', [
            'user' => Auth::user(),
            'technician' => $this->technician(),
            'bookings' => $bookings,
        ]);
    }

    /**
     * Halaman pengaturan jadwal.
     */
    public function schedules(): View
    {
        $technician = $this->technician();

        $days = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu',
        ];

        $schedules = $technician
            ? $technician->schedules()->get()->keyBy('day')
            : collect();

        return view('teknisi.schedules', [
            'user' => Auth::user(),
            'technician' => $technician,
            'days' => $days,
            'schedules' => $schedules,
        ]);
    }

    /**
     * Memperbarui jadwal teknisi.
     */
    public function updateSchedule(Request $request): RedirectResponse
    {
        $technician = $this->technician();

        if (!$technician) {
            return redirect()->route('teknisi.jadwal')
                ->with('error', 'Profil teknisi belum tersedia. Hubungi admin.');
        }

        $validated = $request->validate([
            'day' => [
                'required',
                'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            ],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'is_available' => ['nullable', 'boolean'],
        ]);

        $available = $request->boolean('is_available');

        if (
            $available &&
            (
                empty($validated['start_time']) ||
                empty($validated['end_time'])
            )
        ) {
            return back()->withErrors([
                'start_time' => 'Isi jam mulai dan jam selesai jika jadwal diaktifkan.',
            ])->withInput();
        }

        if (
            $available &&
            $validated['start_time'] >= $validated['end_time']
        ) {
            return back()->withErrors([
                'end_time' => 'Jam selesai harus setelah jam mulai.',
            ])->withInput();
        }

        TechnicianSchedule::updateOrCreate(
            [
                'technician_id' => $technician->id,
                'day' => $validated['day'],
            ],
            [
                'start_time' => $validated['start_time'] ?? null,
                'end_time' => $validated['end_time'] ?? null,
                'is_available' => $available,
            ]
        );

        return redirect()->route('teknisi.jadwal')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Mengirimkan rincian biaya pemeriksaan kepada pelanggan.
     */
    public function submitPrice(
        Request $request,
        Booking $booking
    ): RedirectResponse {
        $technician = $this->technician();

        if (!$technician) {
            return back()->with(
                'error',
                'Profil teknisi belum tersedia. Hubungi admin.'
            );
        }

        $validated = $request->validate([
            'service_cost' => ['required', 'numeric', 'min:0'],
            'material_cost' => ['nullable', 'numeric', 'min:0'],
            'additional_cost' => ['nullable', 'numeric', 'min:0'],
            'inspection_notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use (
            $booking,
            $technician,
            $validated
        ) {
            $currentBooking = Booking::whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Pastikan booking merupakan tanggung jawab teknisi login.
            abort_unless(
                (int) $currentBooking->technician_id === (int) $technician->id,
                403,
                'Pesanan ini bukan tanggung jawab Anda.'
            );

            // Rincian biaya hanya dapat dikirim setelah booking diterima.
            abort_unless(
                $currentBooking->status === 'dikonfirmasi',
                422,
                'Rincian biaya hanya dapat dikirim untuk pesanan yang sudah diterima dan belum dikerjakan.'
            );

            // Hanya boleh mengirim rincian baru jika belum diisi atau ditolak.
            abort_unless(
                in_array(
                    $currentBooking->price_status,
                    ['belum_diisi', 'ditolak'],
                    true
                ),
                422,
                'Rincian biaya sudah dikirim atau telah disetujui pelanggan.'
            );

            $serviceCost = (float) $validated['service_cost'];
            $materialCost = (float) ($validated['material_cost'] ?? 0);
            $additionalCost = (float) ($validated['additional_cost'] ?? 0);

            $totalPrice = $serviceCost + $materialCost + $additionalCost;

            $currentBooking->update([
                'service_cost' => $serviceCost,
                'material_cost' => $materialCost,
                'additional_cost' => $additionalCost,
                'inspection_notes' => $validated['inspection_notes'] ?? null,
                'total_price' => $totalPrice,
                'price_status' => 'menunggu_persetujuan',
                'price_submitted_at' => now(),
                'price_approved_at' => null,
            ]);
        });

        return redirect()
            ->route('teknisi.pesanan')
            ->with(
                'success',
                'Rincian biaya berhasil dikirim kepada pelanggan untuk disetujui.'
            );
    }

    /**
     * Mengatur status pesanan teknisi.
     */
    public function updateBookingStatus(
        Request $request,
        Booking $booking
    ): RedirectResponse {
        $technician = $this->technician();

        if (!$technician) {
            return back()->with(
                'error',
                'Profil teknisi belum tersedia. Hubungi admin.'
            );
        }

        $validated = $request->validate([
            'status' => [
                'required',
                'in:dikonfirmasi,dibatalkan,sedang_dikerjakan,selesai',
            ],
        ]);

        DB::transaction(function () use (
            $booking,
            $technician,
            $validated
        ) {
            // Kunci booking agar tidak diambil dua teknisi sekaligus.
            $currentBooking = Booking::whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            $currentStatus = $currentBooking->status;
            $newStatus = $validated['status'];

            $isUnassigned = $currentBooking->technician_id === null;

            // Booking baru yang masih menunggu.
            if ($currentStatus === 'menunggu') {

                abort_unless(
                    $isUnassigned ||
                    (int) $currentBooking->technician_id === (int) $technician->id,
                    403,
                    'Pesanan sudah diambil oleh teknisi lain.'
                );

                // Hanya boleh menerima atau membatalkan.
                abort_unless(
                    in_array($newStatus, ['dikonfirmasi', 'dibatalkan'], true),
                    422,
                    'Pesanan hanya dapat diterima atau dibatalkan.'
                );

                if ($newStatus === 'dikonfirmasi') {

                    // Kunci baris teknisi agar penerimaan booking berjalan bergantian.
                    $lockedTechnician = Technician::whereKey($technician->id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    // Periksa ulang jadwal, layanan, durasi, dan bentrok.
                    abort_unless(
                        $this->eligibleBookingsQuery($lockedTechnician)
                            ->whereKey($currentBooking->id)
                            ->exists(),
                        403,
                        'Pesanan tidak sesuai dengan jadwal, layanan, ketersediaan, atau bertabrakan dengan pesanan lain.'
                    );
                }

                // Jika diterima, booking menjadi tanggung jawab teknisi.
                $currentBooking->update([
                    'technician_id' => $newStatus === 'dikonfirmasi'
                        ? $technician->id
                        : $currentBooking->technician_id,
                    'status' => $newStatus,
                ]);

                return;
            }

            // Pastikan pesanan merupakan tanggung jawab teknisi login.
            abort_unless(
                (int) $currentBooking->technician_id === (int) $technician->id,
                403,
                'Pesanan ini bukan tanggung jawab Anda.'
            );

            // Alur pengerjaan setelah pesanan diterima.
            $allowedTransitions = [
                'dikonfirmasi' => [
                    'sedang_dikerjakan',
                ],

                'diproses' => [
                    'sedang_dikerjakan',
                ],

                'sedang_dikerjakan' => [
                    'selesai',
                ],
            ];

            abort_unless(
                in_array(
                    $newStatus,
                    $allowedTransitions[$currentStatus] ?? [],
                    true
                ),
                422,
                'Perubahan status pesanan tidak diizinkan.'
            );

            // Pekerjaan hanya boleh dimulai setelah pelanggan menyetujui biaya.
            if ($newStatus === 'sedang_dikerjakan') {
                abort_unless(
                    $currentBooking->price_status === 'disetujui',
                    422,
                    'Pelanggan harus menyetujui rincian biaya sebelum pekerjaan dimulai.'
                );
            }

            $currentBooking->update([
                'status' => $newStatus,
            ]);
        });

        $messages = [
            'dikonfirmasi' => 'Pesanan berhasil diterima.',
            'dibatalkan' => 'Pesanan berhasil dibatalkan.',
            'sedang_dikerjakan' => 'Status pesanan diperbarui. Pekerjaan sedang dikerjakan.',
            'selesai' => 'Pesanan berhasil diselesaikan.',
        ];

        return redirect()->route('teknisi.pesanan')
            ->with('success', $messages[$validated['status']]);
    }
}
