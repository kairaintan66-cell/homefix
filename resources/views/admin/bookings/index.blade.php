
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantau Pesanan - HomeFix</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

@php
    $daftarBooking = $bookings instanceof \Illuminate\Pagination\AbstractPaginator
        ? $bookings->getCollection()
        : $bookings;

    $jumlahBooking = $bookings instanceof \Illuminate\Pagination\AbstractPaginator
        ? $bookings->total()
        : $daftarBooking->count();

    $jumlahMenunggu = $daftarBooking->where('status', 'menunggu')->count();

    $jumlahDiproses = $daftarBooking->whereIn('status', [
        'dikonfirmasi', 'diproses', 'sedang_dikerjakan'
    ])->count();

    $jumlahSelesai = $daftarBooking->where('status', 'selesai')->count();

    $statusClass = [
        'menunggu' => 'bg-amber-50 text-amber-700',
        'pending' => 'bg-amber-50 text-amber-700',
        'dikonfirmasi' => 'bg-sky-50 text-sky-700',
        'diproses' => 'bg-lime-50 text-lime-800',
        'sedang_dikerjakan' => 'bg-emerald-50 text-emerald-700',
        'selesai' => 'bg-green-100 text-green-800',
        'dibatalkan' => 'bg-rose-50 text-rose-700',
    ];

    $statusLabel = [
        'menunggu' => 'Menunggu',
        'pending' => 'Menunggu',
        'dikonfirmasi' => 'Dikonfirmasi',
        'diproses' => 'Diproses',
        'sedang_dikerjakan' => 'Sedang Dikerjakan',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];
@endphp

<div class="min-h-screen lg:flex">

    @include('admin.partials.sidebar', ['active' => 'bookings'])

    <main class="min-w-0 flex-1 px-4 py-6 sm:px-6 lg:ml-64 lg:px-8 lg:py-8">

        {{-- Header --}}
        <header class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <p class="mb-1 text-xs font-semibold uppercase tracking-[0.16em] text-emerald-700">
                    Manajemen HomeFix
                </p>

                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Pantau Pesanan
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Pantau booking pelanggan dan perkembangan pengerjaan oleh teknisi.
                </p>
            </div>

            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                ← Kembali ke Dashboard
            </a>
        </header>

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validasi Error --}}
        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Statistik --}}
        <section class="grid gap-4 sm:grid-cols-2 2xl:grid-cols-4">

            <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Total Booking
                </p>
                <p class="mt-4 text-3xl font-bold text-slate-900">
                    {{ number_format($jumlahBooking, 0, ',', '.') }}
                </p>
                <p class="mt-2 text-xs text-slate-500">Seluruh pesanan</p>
            </article>

            <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Menunggu
                </p>
                <p class="mt-4 text-3xl font-bold text-amber-600">
                    {{ number_format($jumlahMenunggu, 0, ',', '.') }}
                </p>
                <p class="mt-2 text-xs text-slate-500">Belum dikonfirmasi teknisi</p>
            </article>

            <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Dalam Proses
                </p>
                <p class="mt-4 text-3xl font-bold text-lime-700">
                    {{ number_format($jumlahDiproses, 0, ',', '.') }}
                </p>
                <p class="mt-2 text-xs text-slate-500">Sedang ditangani teknisi</p>
            </article>

            <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Selesai
                </p>
                <p class="mt-4 text-3xl font-bold text-emerald-700">
                    {{ number_format($jumlahSelesai, 0, ',', '.') }}
                </p>
                <p class="mt-2 text-xs text-slate-500">Pengerjaan selesai</p>
            </article>

        </section>

        {{-- Tabel Pesanan --}}
        <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">

            <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div>
                    <h2 class="font-bold text-slate-900">Daftar Pesanan</h2>
                    <p class="mt-1 text-xs text-slate-500">
                        Informasi booking pelanggan dan teknisi yang bertugas.
                    </p>
                </div>

                <span class="w-fit rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-800">
                    {{ number_format($jumlahBooking, 0, ',', '.') }} pesanan
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1200px] text-left text-sm">

                    <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-4 font-semibold sm:px-6">Kode Booking</th>
                            <th class="px-5 py-4 font-semibold">Pelanggan</th>
                            <th class="px-5 py-4 font-semibold">Layanan</th>
                            <th class="px-5 py-4 font-semibold">Teknisi</th>
                            <th class="px-5 py-4 font-semibold">Jadwal</th>
                            <th class="px-5 py-4 font-semibold">Total</th>
                            <th class="px-5 py-4 font-semibold">Pembayaran</th>
                            <th class="px-5 py-4 font-semibold">Status</th>
                            <th class="px-5 py-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($bookings as $booking)

                            @php
                                $status = strtolower($booking->status ?? 'menunggu');

                                $label = $statusLabel[$status]
                                    ?? ucfirst(str_replace('_', ' ', $status));

                                $badge = $statusClass[$status]
                                    ?? 'bg-slate-100 text-slate-700';
                            @endphp

                            <tr class="transition hover:bg-slate-50/80">

                                {{-- Kode Booking --}}
                                <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-800 sm:px-6">
                                    {{ $booking->booking_code ?? '-' }}
                                </td>

                                {{-- Pelanggan --}}
                                <td class="px-5 py-4 text-slate-700">
                                    <p class="font-medium">
                                        {{ $booking->user->name ?? 'Pengguna' }}
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $booking->address->phone ?? '-' }}
                                    </p>
                                </td>

                                {{-- Layanan --}}
                                <td class="px-5 py-4 text-slate-600">
                                    @forelse ($booking->details as $detail)
                                        <div class="mb-1">
                                            {{ $detail->service->name ?? 'Layanan' }}
                                            <span class="text-slate-400">
                                                × {{ $detail->quantity ?? 1 }}
                                            </span>
                                        </div>
                                    @empty
                                        <span class="text-slate-400">Belum ada detail</span>
                                    @endforelse
                                </td>

                                {{-- Teknisi --}}
                                <td class="px-5 py-4">
                                    @if ($booking->technician && $booking->technician->user)
                                        <p class="font-medium text-slate-800">
                                            {{ $booking->technician->user->name }}
                                        </p>
                                        <span class="mt-1 inline-flex rounded-full bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700">
                                            Ditugaskan
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700">
                                            Belum ada teknisi
                                        </span>
                                    @endif
                                </td>

                                {{-- Jadwal --}}
                                <td class="whitespace-nowrap px-5 py-4 text-slate-700">
                                    {{ $booking->booking_date
                                        ? \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d/m/Y')
                                        : '-' }}

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $booking->booking_time
                                            ? substr((string) $booking->booking_time, 0, 5)
                                            : '-' }}
                                    </p>
                                </td>

                                {{-- Total --}}
                                <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-800">
                                    Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}
                                </td>

                                {{-- Pembayaran --}}
                                <td class="px-5 py-4">
                                    <p class="font-medium text-slate-700">
                                        {{ strtoupper($booking->payment->method ?? '-') }}
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ ucfirst($booking->payment->status ?? 'Belum ada') }}
                                    </p>
                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-4">
                                    <span class="inline-flex whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-semibold {{ $badge }}">
                                        {{ $label }}
                                    </span>
                                </td>

                                {{-- Aksi Hapus --}}
                                <td class="px-5 py-4">
                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus booking {{ $booking->booking_code }}? Data terkait juga akan dihapus.')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="inline-flex items-center rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-100">
                                            Hapus
                                        </button>
                                    </form>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="9" class="px-6 py-16 text-center">
                                    <p class="font-semibold text-slate-700">
                                        Belum ada pesanan
                                    </p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Booking pelanggan akan muncul di halaman ini.
                                    </p>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($bookings instanceof \Illuminate\Pagination\AbstractPaginator && $bookings->hasPages())
                <div class="border-t border-slate-100 px-5 py-4 sm:px-6">
                    {{ $bookings->links() }}
                </div>
            @endif

        </section>

        <footer class="py-6 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} HomeFix. Solusi perawatan rumah yang praktis.
        </footer>

    </main>
</div>

</body>
</html>
