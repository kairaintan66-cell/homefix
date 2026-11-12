<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    // Daftar pesanan pengguna
    public function index(): RedirectResponse
    {
        return redirect()->route('pengguna.dashboard');
    }

    // Form pemesanan
    public function create(Service $service): View
    {
        abort_unless($service->is_active, 404);

        return view('pengguna.bookings.create', compact('service'));
    }

    // Simpan booking
    public function store(Request $request, Service $service): RedirectResponse
    {
        abort_unless($service->is_active, 404);

        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($validated, $service) {
            $user = Auth::user();

            // Simpan alamat pelanggan
            $address = $user->addresses()->create([
                'recipient_name' => $validated['recipient_name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'] ?? null,
                'is_default' => false,
            ]);

            // Buat booking
            $booking = $user->bookings()->create([
                'booking_code' => 'HF-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
                'address_id' => $address->id,
                'booking_date' => $validated['booking_date'],
                'booking_time' => $validated['booking_time'],
                'notes' => $validated['notes'] ?? null,

                'total_price' => 0,
                'service_cost' => 0,
                'material_cost' => 0,
                'additional_cost' => 0,
                'inspection_notes' => null,

                'price_status' => 'belum_diisi',
                'price_submitted_at' => null,
                'price_approved_at' => null,

                'status' => 'menunggu',
            ]);

            // Simpan detail layanan
            $booking->details()->create([
                'service_id' => $service->id,
                'quantity' => 1,
                'price' => 0,
                'subtotal' => 0,
            ]);

            // Pembayaran dibuat setelah pelanggan menyetujui rincian biaya.
        });

        return redirect()
            ->route('pengguna.dashboard')
            ->with('success', 'Booking berhasil dibuat! Silakan menunggu teknisi menerima pesanan dan melakukan pemeriksaan.');
    }

    // Pelanggan menyetujui rincian biaya teknisi
    public function approvePrice(Booking $booking): RedirectResponse
    {
        DB::transaction(function () use ($booking) {

            $currentBooking = Booking::whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Pastikan booking milik pelanggan yang sedang login
            abort_unless(
                (int) $currentBooking->user_id === (int) Auth::id(),
                403,
                'Pesanan ini bukan milik Anda.'
            );

            // Pastikan ada rincian biaya yang menunggu persetujuan
            abort_unless(
                $currentBooking->price_status === 'menunggu_persetujuan',
                422,
                'Tidak ada rincian biaya yang menunggu persetujuan.'
            );

            // Hitung total biaya
            $total = (float) $currentBooking->service_cost
                + (float) $currentBooking->material_cost
                + (float) $currentBooking->additional_cost;

            // Ubah status persetujuan biaya
            $currentBooking->update([
                'total_price' => $total,
                'price_status' => 'disetujui',
                'price_approved_at' => now(),
            ]);

            // Buat atau perbarui pembayaran
            $payment = $currentBooking->payment()->first();

            if ($payment) {
                $payment->update([
                    'amount' => $total,
                    'status' => 'pending',
                ]);
            } else {
                $currentBooking->payment()->create([
                    'payment_code' => 'PAY-' . Str::upper(Str::random(12)),
                    'amount' => $total,
                    'status' => 'pending',
                ]);
            }
        });

        return redirect()
            ->route('pengguna.dashboard')
            ->with('success', 'Rincian biaya berhasil disetujui. Silakan lanjutkan proses pembayaran.');
    }

    // Pelanggan menolak rincian biaya teknisi
    public function rejectPrice(Booking $booking): RedirectResponse
    {
        DB::transaction(function () use ($booking) {

            $currentBooking = Booking::whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Pastikan booking milik pelanggan yang sedang login
            abort_unless(
                (int) $currentBooking->user_id === (int) Auth::id(),
                403,
                'Pesanan ini bukan milik Anda.'
            );

            // Pastikan ada rincian biaya yang menunggu persetujuan
            abort_unless(
                $currentBooking->price_status === 'menunggu_persetujuan',
                422,
                'Tidak ada rincian biaya yang menunggu persetujuan.'
            );

            // Ubah status biaya menjadi ditolak
            $currentBooking->update([
                'price_status' => 'ditolak',
                'price_approved_at' => null,
            ]);
        });

        return redirect()
            ->route('pengguna.dashboard')
            ->with('success', 'Rincian biaya ditolak. Silakan menunggu teknisi mengirimkan rincian biaya baru.');
    }
}
