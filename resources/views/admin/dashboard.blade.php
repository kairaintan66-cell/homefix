<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - HomeFix</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen antialiased">

@php
    $namaAdmin = auth()->user()->name ?? 'Administrator';

    $formatRupiah = fn ($nilai) =>
        'Rp ' . number_format((float) $nilai, 0, ',', '.');

    $formatRingkas = function ($nilai) {
        $nilai = (float) $nilai;

        if ($nilai >= 1000000000) {
            return 'Rp ' . number_format($nilai / 1000000000, 1, ',', '.') . ' M';
        }

        if ($nilai >= 1000000) {
            return 'Rp ' . number_format($nilai / 1000000, 1, ',', '.') . ' Jt';
        }

        return 'Rp ' . number_format($nilai, 0, ',', '.');
    };

    $jumlahStatus = max(
        1,
        (int) $bookingSelesai
        + (int) $bookingAktif
        + (int) $bookingMenunggu
        + (int) $bookingDibatalkan
    );

    $persentaseSelesai = $totalBooking > 0
        ? min(100, round(($bookingSelesai / $totalBooking) * 100))
        : 0;
@endphp

{{-- SIDEBAR ADMIN --}}
@include('admin.partials.sidebar', ['active' => 'dashboard'])

{{-- KONTEN UTAMA --}}
<main class="hf-admin-content">

    {{-- HEADER --}}
    <header class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="mb-1 text-xs font-bold uppercase tracking-[0.16em] text-emerald-700">
                Ringkasan HomeFix
            </p>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                Dashboard
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                {{ now()->locale('id')->translatedFormat('l, d F Y') }}
            </p>
        </div>

        <div class="inline-flex items-center gap-3 self-start rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm sm:self-auto">
            <svg class="h-5 w-5 text-emerald-700"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="1.8">
                <rect x="3" y="4" width="18" height="17" rx="2"/>
                <path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>

            <span>{{ now()->locale('id')->translatedFormat('F Y') }}</span>
        </div>
    </header>

    {{-- KARTU STATISTIK --}}
    <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 2xl:grid-cols-4">

        {{-- Total Pelanggan --}}
        <article class="hf-stat-card">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="hf-stat-label">Total Pelanggan</p>
                    <p class="hf-stat-value">
                        {{ number_format($totalPelanggan, 0, ',', '.') }}
                    </p>
                </div>

                <span class="hf-stat-icon bg-emerald-50 text-emerald-700">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="10" cy="7" r="4"/>
                        <path d="M20 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </span>
            </div>

            <p class="hf-stat-description">Akun pelanggan terdaftar</p>

            <a href="{{ route('admin.customers.index') }}" class="hf-stat-link">
                Kelola pelanggan <span aria-hidden="true">→</span>
            </a>
        </article>

        {{-- Total Teknisi --}}
        <article class="hf-stat-card">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="hf-stat-label">Total Teknisi</p>
                    <p class="hf-stat-value">
                        {{ number_format($totalTeknisi, 0, ',', '.') }}
                    </p>
                </div>

                <span class="hf-stat-icon bg-lime-50 text-lime-700">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.7 6.3a5 5 0 0 0-6.4 6.4L3 18l3 3 5.3-5.3a5 5 0 0 0 6.4-6.4L14 13l-3-3 3.7-3.7Z"/>
                    </svg>
                </span>
            </div>

            <p class="hf-stat-description">Teknisi terdaftar</p>

            <a href="{{ route('admin.technicians.index') }}" class="hf-stat-link">
                Kelola teknisi <span aria-hidden="true">→</span>
            </a>
        </article>

        {{-- Total Booking --}}
        <article class="hf-stat-card">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="hf-stat-label">Total Booking</p>
                    <p class="hf-stat-value">
                        {{ number_format($totalBooking, 0, ',', '.') }}
                    </p>
                </div>

                <span class="hf-stat-icon bg-amber-50 text-amber-700">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                        <path d="M16 3v4M8 3v4M3 10h18"/>
                    </svg>
                </span>
            </div>

            <p class="hf-stat-description">Seluruh pesanan masuk</p>

            <a href="{{ route('admin.bookings.index') }}" class="hf-stat-link">
                Kelola booking <span aria-hidden="true">→</span>
            </a>
        </article>

        {{-- Total Pendapatan --}}
        <article class="hf-stat-card">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="hf-stat-label">Total Pendapatan</p>
                    <p class="mt-4 break-words text-2xl font-bold tracking-tight text-slate-900">
                        {{ $formatRingkas($totalPendapatan) }}
                    </p>
                </div>

                <span class="hf-stat-icon bg-green-50 text-green-700">
                    <span class="text-sm font-extrabold">Rp</span>
                </span>
            </div>

            <p class="hf-stat-description">Pembayaran yang sudah lunas</p>
        </article>

    </section>

    {{-- GRAFIK DAN STATISTIK BOOKING --}}
    <section class="mt-6 grid grid-cols-1 gap-5 xl:grid-cols-[1.7fr_1fr]">

        {{-- GRAFIK PENDAPATAN --}}
        <article class="hf-panel min-w-0">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h2 class="text-base font-bold text-slate-900">
                        Statistik Pendapatan
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Pendapatan pembayaran lunas tahun {{ now()->year }}
                    </p>
                </div>

                <span class="rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-800">
                    Bulanan
                </span>
            </div>

            <div class="mt-8 flex h-56 items-end gap-2 border-b border-slate-100 px-1 sm:gap-3">
                @foreach ($pendapatanBulanan as $index => $pendapatan)
                    @php
                        $tinggi = (float) $pendapatan > 0
                            ? max(5, min(100, ((float) $pendapatan / max(1, (float) $nilaiMaksimumGrafik)) * 100))
                            : 3;
                    @endphp

                    <div class="group flex h-full min-w-0 flex-1 flex-col items-center justify-end">
                        <div
                            class="relative w-full max-w-12 overflow-hidden rounded-t-md bg-emerald-100 transition-colors group-hover:bg-emerald-200"
                            style="height: {{ $tinggi }}%"
                            title="{{ $bulanLabels[$index] ?? '' }}: {{ $formatRupiah($pendapatan) }}"
                        >
                            @if ((float) $pendapatan > 0)
                                <div class="absolute inset-x-0 bottom-0 rounded-t-md bg-emerald-600"
                                     style="height: 65%">
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-3 flex justify-between gap-1 text-[10px] text-slate-500 sm:text-xs">
                @foreach ($bulanLabels as $label)
                    <span class="min-w-0 flex-1 text-center">{{ $label }}</span>
                @endforeach
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                <span class="h-2.5 w-2.5 rounded-sm bg-emerald-600"></span>
                <span>Total pembayaran lunas per bulan</span>
            </div>
        </article>

        {{-- STATISTIK STATUS BOOKING --}}
        <article class="hf-panel min-w-0">
            <h2 class="text-base font-bold text-slate-900">
                Statistik Booking
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Ringkasan status seluruh pesanan
            </p>

            <div class="mt-7 space-y-5">
                @foreach ([
                    ['label' => 'Selesai', 'value' => $bookingSelesai, 'color' => 'bg-emerald-500'],
                    ['label' => 'Berlangsung', 'value' => $bookingAktif, 'color' => 'bg-lime-500'],
                    ['label' => 'Menunggu', 'value' => $bookingMenunggu, 'color' => 'bg-amber-500'],
                    ['label' => 'Dibatalkan', 'value' => $bookingDibatalkan, 'color' => 'bg-rose-500'],
                ] as $status)
                    <div>
                        <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                            <span class="text-slate-600">{{ $status['label'] }}</span>

                            <span class="font-semibold tabular-nums text-slate-900">
                                {{ number_format($status['value'], 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-slate-100">
                            <div
                                class="h-full rounded-full {{ $status['color'] }}"
                                style="width: {{ min(100, ((int) $status['value'] / $jumlahStatus) * 100) }}%"
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-7 rounded-xl border border-emerald-100 bg-emerald-50/80 p-4">
                <p class="text-xs font-semibold text-emerald-800">
                    Tingkat Penyelesaian
                </p>

                <p class="mt-1 text-3xl font-bold text-emerald-700">
                    {{ $persentaseSelesai }}%
                </p>

                <p class="mt-1 text-xs text-emerald-700">
                    Persentase booking berstatus selesai
                </p>
            </div>
        </article>

    </section>

    {{-- PESANAN TERBARU --}}
    <section class="hf-panel mt-6 overflow-hidden !p-0">

        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-5 sm:px-6">
            <div>
                <h2 class="text-base font-bold text-slate-900">
                    Pesanan Terbaru
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Booking terakhir yang masuk ke HomeFix
                </p>
            </div>

            <a href="{{ route('admin.bookings.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-700 transition hover:text-emerald-900">
                Lihat Semua <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-left text-sm">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-4 font-semibold sm:px-6">ID Pesanan</th>
                        <th class="px-5 py-4 font-semibold">Pelanggan</th>
                        <th class="px-5 py-4 font-semibold">Teknisi</th>
                        <th class="px-5 py-4 font-semibold">Layanan</th>
                        <th class="px-5 py-4 font-semibold">Harga</th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($pesananTerbaru as $booking)
                        @php
                            $status = strtolower($booking->status ?? 'menunggu');

                            $statusLabel = ucfirst(
                                str_replace(['_', '-'], ' ', $status)
                            );

                            $statusClass = in_array($status, ['selesai', 'completed'])
                                ? 'bg-emerald-50 text-emerald-700'
                                : (in_array($status, ['dibatalkan', 'cancelled', 'canceled'])
                                    ? 'bg-rose-50 text-rose-700'
                                    : (in_array($status, ['menunggu', 'pending', 'menunggu_teknisi'])
                                        ? 'bg-amber-50 text-amber-700'
                                        : 'bg-lime-50 text-lime-800'));

                            $namaLayanan = optional(
                                optional($booking->details->first())->service
                            )->name ?? 'Layanan HomeFix';
                        @endphp

                        <tr class="transition hover:bg-slate-50/80">
                            <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-800 sm:px-6">
                                {{ $booking->booking_code ?? '-' }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-slate-700">
                                {{ $booking->user->name ?? 'Pelanggan' }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">
                                {{ $booking->technician->user->name ?? 'Belum ditentukan' }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-slate-600">
                                {{ $namaLayanan }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-800">
                                {{ $formatRupiah($booking->total_price) }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                <a href="{{ route('admin.bookings.index') }}"
                                   class="font-semibold text-emerald-700 transition hover:text-emerald-900">
                                    Lihat Booking
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-xl text-slate-400">
                                    —
                                </div>

                                <p class="mt-3 font-semibold text-slate-700">
                                    Belum ada pesanan
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Pesanan terbaru akan tampil di bagian ini.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="py-6 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} HomeFix. Solusi perawatan rumah yang praktis.
    </footer>

</main>

</body>
</html>
