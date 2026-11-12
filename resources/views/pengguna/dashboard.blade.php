<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#047857">

    <title>Dashboard Pengguna - HomeFix</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-20 border-b border-gray-100 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4 sm:px-6">
            <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tight text-emerald-800">
                HomeFix<span class="text-emerald-500">.</span>
            </a>

            <div class="flex items-center gap-3 sm:gap-5">
                <span class="hidden text-sm font-medium text-gray-600 sm:block">
                    Halo, {{ auth()->user()->name }}
                </span>

                <a href="{{ route('profile.edit') }}"
                    class="hidden text-sm font-semibold text-emerald-700 transition hover:text-emerald-900 sm:block">
                    Profil
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-800">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-5 py-8 sm:px-6 sm:py-10">

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                <p class="font-semibold">Terjadi kesalahan:</p>
                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Sambutan --}}
        <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-900 via-emerald-800 to-green-700 px-6 py-9 text-white shadow-lg shadow-emerald-900/10 sm:px-10 sm:py-12">
            <div class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full border-[35px] border-white/5"></div>
            <div class="pointer-events-none absolute -bottom-24 right-36 h-48 w-48 rounded-full bg-white/5"></div>

            <div class="relative z-10 max-w-2xl">
                <p class="mb-3 text-xs font-bold tracking-[0.2em] text-emerald-200">
                    DASHBOARD PENGGUNA
                </p>

                <h1 class="text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl">
                    Halo, {{ auth()->user()->name }}!
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-7 text-emerald-50 sm:text-base">
                    Ada masalah di rumah? Temukan teknisi dan pesan layanan
                    perbaikan rumah dengan lebih mudah melalui HomeFix.
                </p>

                <a href="#layanan"
                    class="mt-7 inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-bold text-emerald-900 shadow-sm transition hover:bg-emerald-50">
                    Cari Layanan
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </section>

        {{-- Menu Utama --}}
        <section class="mt-10">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-gray-900">
                    Menu Utama
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Akses fitur HomeFix dengan mudah.
                </p>
            </div>

            <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Cari Layanan --}}
                <a href="#layanan"
                    class="group rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-md">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 transition group-hover:bg-emerald-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 10.5 12 3l9 7.5"/>
                            <path d="M5 9v11h14V9M9 20v-6h6v6"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 group-hover:text-emerald-800">
                        Cari Layanan
                    </h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Temukan layanan perbaikan dan perawatan rumah sesuai kebutuhanmu.
                    </p>
                </a>

                {{-- Pesanan Saya --}}
                <a href="#pesanan"
                    class="group rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-md">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="17" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18M8 14h3"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 group-hover:text-emerald-800">
                        Pesanan Saya
                    </h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Lihat detail pesanan, jadwal, dan status pengerjaan layananmu.
                    </p>
                </a>

                {{-- Profil Saya --}}
                <a href="{{ route('profile.edit') }}"
                    class="group rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition duration-200 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-md">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50 text-teal-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M5 21v-2a7 7 0 0 1 14 0v2"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 group-hover:text-emerald-800">
                        Profil Saya
                    </h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Periksa dan perbarui informasi akunmu.
                    </p>
                </a>

            </div>
        </section>

        {{-- Daftar Layanan --}}
        <section id="layanan" class="mt-14 scroll-mt-24">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold tracking-wide text-emerald-700">
                        SOLUSI UNTUK RUMAHMU
                    </span>

                    <h2 class="mt-3 text-2xl font-bold tracking-tight text-gray-900 md:text-3xl">
                        Temukan Layanan
                        <span class="text-emerald-700">HomeFix</span>
                    </h2>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-gray-500">
                        Pilih layanan yang kamu butuhkan untuk perbaikan
                        dan perawatan rumah dengan lebih praktis.
                    </p>
                </div>

                <div class="flex w-fit items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-emerald-700"
                        viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 10.5 12 3l9 7.5"/>
                        <path d="M5 9v11h14V9"/>
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">
                        Layanan Rumah
                    </span>
                </div>
            </div>

            {{-- Grid Layanan --}}
            <div class="mt-7 grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">

                @forelse (
                    \App\Models\Service::where('is_active', true)
                        ->with('category')
                        ->orderBy('id')
                        ->take(8)
                        ->get() as $service
                )

                    <article class="group flex min-w-0 flex-col overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-emerald-200 hover:shadow-xl hover:shadow-emerald-900/5">

                        {{-- Gambar --}}
                        <div class="relative overflow-hidden bg-emerald-50">
                            @if ($service->image)
                                <img
                                    src="{{ asset('storage/' . $service->image) }}"
                                    alt="{{ $service->name }}"
                                    loading="lazy"
                                    class="h-48 w-full object-cover transition duration-500 group-hover:scale-105"
                                >
                            @else
                                <div class="flex h-48 w-full items-center justify-center bg-gradient-to-br from-emerald-50 via-green-50 to-gray-100">
                                    <div class="flex h-20 w-20 items-center justify-center rounded-2xl border border-white bg-white/90 text-emerald-700 shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            width="38" height="38"
                                            viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14.7 6.3a5 5 0 0 0-6.4 6.4L3 18l3 3 5.3-5.3a5 5 0 0 0 6.4-6.4L14 13l-3-3z"/>
                                        </svg>
                                    </div>
                                </div>
                            @endif

                            <div class="absolute left-3 top-3">
                                <span class="inline-flex max-w-full rounded-lg border border-white/70 bg-white/95 px-3 py-1.5 text-xs font-semibold text-emerald-800 shadow-sm">
                                    {{ $service->category?->name ?? 'Layanan HomeFix' }}
                                </span>
                            </div>
                        </div>

                        {{-- Informasi --}}
                        <div class="flex flex-1 flex-col p-5">

                            <h3 class="min-h-[3.5rem] text-lg font-bold leading-7 text-gray-900 transition group-hover:text-emerald-800">
                                {{ $service->name }}
                            </h3>

                            <p class="mt-2 min-h-[4.5rem] text-sm leading-6 text-gray-500">
                                {{ \Illuminate\Support\Str::limit(
                                    $service->description ?: 'Layanan perbaikan dan perawatan rumah untuk membantu kebutuhanmu.',
                                    95
                                ) }}
                            </p>

                            {{-- Estimasi --}}
                            <div class="mt-4 flex items-center gap-2.5 border-t border-gray-100 pt-4">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="18" height="18"
                                        viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-400">
                                        Estimasi pengerjaan
                                    </p>
                                    <p class="mt-0.5 text-sm font-semibold text-gray-700">
                                        @if ($service->duration)
                                            {{ $service->duration }} menit
                                        @else
                                            Belum ditentukan
                                        @endif
                                    </p>
                                </div>
                            </div>

                            {{-- Harga dan Tombol --}}
                            <div class="mt-auto pt-5">
                                <div class="mb-4 border-t border-gray-100 pt-4">
                                    <p class="text-xs font-medium text-gray-400">
                                        Harga layanan
                                    </p>

                                    <p class="mt-1 text-xl font-extrabold tracking-tight text-emerald-800">
                                        Rp{{ number_format((float) $service->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <a
                                    href="{{ route('bookings.create', ['service' => $service->id]) }}"
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-700 px-4 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 hover:bg-emerald-800 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-emerald-100"
                                >
                                    Pesan Sekarang
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="17" height="17"
                                        viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"/>
                                        <path d="m12 5 7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>

                        </div>
                    </article>

                @empty

                    <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center sm:col-span-2 xl:col-span-4">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="30" height="30"
                                viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.6"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 10.5 12 3l9 7.5"/>
                                <path d="M5 9v11h14V9"/>
                            </svg>
                        </div>

                        <h3 class="mt-5 text-lg font-bold text-gray-900">
                            Layanan Belum Tersedia
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-gray-500">
                            Belum ada layanan aktif saat ini.
                            Silakan kembali lagi nanti.
                        </p>
                    </div>

                @endforelse

            </div>

            {{-- Informasi Tambahan --}}
            <div class="mt-7 flex flex-col gap-3 rounded-2xl border border-emerald-100 bg-emerald-50/70 p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="21" height="21"
                            viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 11v5M12 8h.01"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-bold text-emerald-900">
                            Butuh bantuan memilih layanan?
                        </p>
                        <p class="mt-1 text-xs leading-5 text-emerald-800/80">
                            Pilih layanan yang sesuai dengan kebutuhan perbaikan rumahmu.
                        </p>
                    </div>
                </div>

                <a href="{{ route('home') }}"
                    class="inline-flex shrink-0 items-center justify-center gap-2 self-start rounded-xl border border-emerald-200 bg-white px-4 py-2.5 text-sm font-semibold text-emerald-800 transition hover:bg-emerald-100 sm:self-center">
                    Jelajahi Beranda
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

        </section>

        {{-- Pesanan Saya --}}
        <section id="pesanan" class="mt-14 scroll-mt-24">
            <div class="flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-gray-900">
                        Pesanan Saya
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Pantau jadwal, rincian biaya, dan status pesananmu.
                    </p>
                </div>

                <span class="rounded-full bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700">
                    {{ auth()->user()->bookings()->count() }} Pesanan
                </span>
            </div>

            <div class="mt-6 space-y-5">
                @forelse (
                    auth()->user()->bookings()
                        ->with(['details.service', 'payment', 'address'])
                        ->latest()
                        ->get() as $booking
                )
                    <article class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

                        {{-- Header Booking --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 bg-gray-50 px-5 py-4">
                            <div>
                                <p class="text-xs text-gray-500">Kode Booking</p>
                                <p class="mt-1 font-bold text-gray-900">
                                    {{ $booking->booking_code }}
                                </p>
                            </div>

                            @php
                                $status = strtolower($booking->status);

                                $statusClass = match ($status) {
                                    'menunggu' => 'bg-amber-50 text-amber-700',
                                    'dikonfirmasi' => 'bg-sky-50 text-sky-700',
                                    'diproses', 'dikerjakan', 'sedang_dikerjakan' => 'bg-blue-50 text-blue-700',
                                    'selesai' => 'bg-emerald-50 text-emerald-700',
                                    'dibatalkan' => 'bg-red-50 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <span class="rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </div>

                        <div class="p-5">

                            {{-- Detail Layanan --}}
                            @forelse ($booking->details as $detail)
                                <div class="flex flex-wrap items-start justify-between gap-3 py-2">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">
                                            {{ $detail->service?->name ?? 'Layanan tidak tersedia' }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $detail->quantity }} unit
                                        </p>
                                        <p class="mt-1 text-sm text-gray-500">
                                            Rp{{ number_format((float) $detail->price, 0, ',', '.') }} / unit
                                        </p>
                                    </div>

                                    <p class="font-semibold text-gray-800">
                                        Rp{{ number_format((float) $detail->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">
                                    Detail layanan belum tersedia.
                                </p>
                            @endforelse

                            {{-- Rincian Biaya Teknisi --}}
                            @if (in_array($booking->price_status, ['menunggu_persetujuan', 'disetujui', 'ditolak'], true))
                                <div class="mt-5 rounded-xl border border-emerald-100 bg-emerald-50/60 p-4">

                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <h4 class="font-bold text-gray-900">
                                            Rincian Biaya Teknisi
                                        </h4>

                                        @if ($booking->price_status === 'menunggu_persetujuan')
                                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                                                Menunggu Persetujuan
                                            </span>
                                        @elseif ($booking->price_status === 'disetujui')
                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                                                Disetujui
                                            </span>
                                        @else
                                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                Ditolak
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Komponen Biaya --}}
                                    <div class="mt-4 space-y-3 text-sm">

                                        <div class="flex justify-between gap-3">
                                            <span class="text-gray-600">
                                                Biaya jasa
                                            </span>
                                            <span class="font-medium text-gray-800">
                                                Rp{{ number_format((float) $booking->service_cost, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="flex justify-between gap-3">
                                            <span class="text-gray-600">
                                                Biaya material
                                            </span>
                                            <span class="font-medium text-gray-800">
                                                Rp{{ number_format((float) $booking->material_cost, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="flex justify-between gap-3">
                                            <span class="text-gray-600">
                                                Biaya tambahan
                                            </span>
                                            <span class="font-medium text-gray-800">
                                                Rp{{ number_format((float) $booking->additional_cost, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <div class="flex justify-between gap-3 border-t border-emerald-100 pt-3">
                                            <span class="font-bold text-gray-800">
                                                Total biaya
                                            </span>
                                            <span class="text-lg font-extrabold text-emerald-800">
                                                Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Catatan Teknisi --}}
                                    @if ($booking->inspection_notes)
                                        <div class="mt-4 rounded-lg bg-white/80 p-3">
                                            <p class="text-xs font-semibold text-gray-500">
                                                Catatan Teknisi
                                            </p>
                                            <p class="mt-1 text-sm leading-6 text-gray-700">
                                                {{ $booking->inspection_notes }}
                                            </p>
                                        </div>
                                    @endif

                                    {{-- Tombol Persetujuan --}}
                                    @if ($booking->price_status === 'menunggu_persetujuan')
                                        <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-3">
                                            <p class="text-sm leading-6 text-amber-800">
                                                Silakan periksa rincian biaya di atas. Setujui jika biaya sudah sesuai atau tolak jika ingin meminta teknisi memperbarui penawaran.
                                            </p>
                                        </div>

                                        <div class="mt-4 flex flex-col gap-2 sm:flex-row">

                                            <form
                                                action="{{ route('pengguna.bookings.approve-price', $booking) }}"
                                                method="POST"
                                                class="flex-1"
                                                onsubmit="return confirm('Apakah kamu yakin ingin menyetujui rincian biaya ini?')"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="w-full rounded-xl bg-emerald-700 px-4 py-3 text-sm font-bold text-white transition hover:bg-emerald-800 focus:outline-none focus:ring-4 focus:ring-emerald-100"
                                                >
                                                    Setujui Biaya
                                                </button>
                                            </form>

                                            <form
                                                action="{{ route('pengguna.bookings.reject-price', $booking) }}"
                                                method="POST"
                                                class="flex-1"
                                                onsubmit="return confirm('Apakah kamu yakin ingin menolak rincian biaya ini?')"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="w-full rounded-xl border border-red-200 bg-white px-4 py-3 text-sm font-bold text-red-700 transition hover:bg-red-50 focus:outline-none focus:ring-4 focus:ring-red-100"
                                                >
                                                    Tolak Biaya
                                                </button>
                                            </form>

                                        </div>

                                    @elseif ($booking->price_status === 'ditolak')
                                        <p class="mt-4 rounded-lg bg-red-50 p-3 text-sm leading-6 text-red-700">
                                            Rincian biaya telah ditolak. Silakan menunggu teknisi mengirimkan penawaran baru.
                                        </p>

                                    @elseif ($booking->price_status === 'disetujui')
                                        <p class="mt-4 rounded-lg bg-white p-3 text-sm leading-6 text-emerald-800">
                                            Rincian biaya telah disetujui. Silakan lanjutkan proses pembayaran.
                                        </p>
                                    @endif

                                </div>
                            @endif

                            <div class="my-4 border-t border-gray-100"></div>

                            {{-- Jadwal dan Pembayaran --}}
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <p class="text-xs text-gray-500">Jadwal Pengerjaan</p>
                                    <p class="mt-2 text-sm font-medium text-gray-800">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ substr((string) $booking->booking_time, 0, 5) }} WIB
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-500">Pembayaran</p>
                                    <p class="mt-2 text-sm font-medium text-gray-800">
                                        {{ $booking->payment?->method
                                            ? strtoupper($booking->payment->method)
                                            : 'Belum dipilih' }}
                                    </p>

                                    @php
                                        $paymentStatus = strtolower($booking->payment?->status ?? 'belum tersedia');

                                        $paymentClass = match ($paymentStatus) {
                                            'paid', 'lunas', 'success', 'berhasil' => 'text-emerald-700',
                                            'pending', 'belum bayar' => 'text-amber-700',
                                            'failed', 'gagal', 'expired' => 'text-red-700',
                                            default => 'text-gray-600',
                                        };
                                    @endphp

                                    <p class="mt-1 text-sm {{ $paymentClass }}">
                                        Status: {{ ucfirst(str_replace('_', ' ', $paymentStatus)) }}
                                    </p>
                                </div>
                            </div>

                            {{-- Total --}}
                            <div class="mt-5 flex flex-wrap items-center justify-between gap-3 rounded-xl bg-emerald-50 p-4">
                                <span class="text-sm font-medium text-gray-700">
                                    Total Pesanan
                                </span>
                                <span class="text-lg font-bold text-emerald-800">
                                    Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- Alamat --}}
                            @if ($booking->address)
                                <div class="mt-4 rounded-xl border border-gray-100 p-4">
                                    <p class="text-xs font-semibold text-gray-500">
                                        Alamat Pengerjaan
                                    </p>
                                    <p class="mt-2 text-sm font-medium text-gray-800">
                                        {{ $booking->address->recipient_name }}
                                        · {{ $booking->address->phone }}
                                    </p>
                                    <p class="mt-1 text-sm leading-relaxed text-gray-600">
                                        {{ $booking->address->address }},
                                        {{ $booking->address->city }}
                                        @if ($booking->address->postal_code)
                                            {{ $booking->address->postal_code }}
                                        @endif
                                    </p>
                                </div>
                            @endif

                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-12 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="17" rx="2"/>
                                <path d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                        </div>

                        <h3 class="mt-4 font-semibold text-gray-900">
                            Belum Ada Pesanan
                        </h3>
                        <p class="mt-2 text-sm text-gray-500">
                            Pesanan layananmu akan muncul di sini setelah berhasil dibuat.
                        </p>

                        <a href="#layanan"
                            class="mt-5 inline-flex items-center gap-2 rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-800">
                            Cari Layanan
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    {{-- Footer --}}
    <footer class="mt-14 border-t border-gray-100 bg-white px-6 py-7 text-center">
        <p class="text-sm font-bold text-emerald-800">HomeFix<span class="text-emerald-500">.</span></p>
        <p class="mt-1 text-xs text-gray-500">
            &copy; {{ date('Y') }} HomeFix. Solusi perawatan rumah yang praktis.
        </p>
    </footer>

</body>
</html>
