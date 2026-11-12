@extends('layouts.admin')

@section('title', 'Pembayaran - HomeFix')

@section('content')
    <div class="flex min-h-screen bg-slate-50">
        {{-- Sidebar Admin --}}
        @include('admin.partials.sidebar', ['active' => 'payments'])

        {{-- Konten Utama --}}
        <main class="hf-admin-content min-w-0 flex-1">
            <div class="p-4 md:p-6 lg:p-8">

                {{-- Header --}}
                <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">
                            Pembayaran
                        </h1>
                        <p class="mt-1 text-sm text-slate-500">
                            Kelola dan verifikasi pembayaran booking HomeFix.
                        </p>
                    </div>
                </div>

                {{-- Notifikasi Berhasil --}}
                @if (session('success'))
                    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Notifikasi Error --}}
                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Statistik Pembayaran --}}
                <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-sm text-slate-500">Total Pembayaran</p>
                        <p class="mt-2 text-3xl font-bold text-slate-800">
                            {{ $totalPembayaran }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-amber-100 bg-white p-5 shadow-sm">
                        <p class="text-sm text-slate-500">Menunggu Verifikasi</p>
                        <p class="mt-2 text-3xl font-bold text-amber-600">
                            {{ $menunggu }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-green-100 bg-white p-5 shadow-sm">
                        <p class="text-sm text-slate-500">Pembayaran Lunas</p>
                        <p class="mt-2 text-3xl font-bold text-green-700">
                            {{ $lunas }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-red-100 bg-white p-5 shadow-sm">
                        <p class="text-sm text-slate-500">Pembayaran Ditolak</p>
                        <p class="mt-2 text-3xl font-bold text-red-600">
                            {{ $ditolak }}
                        </p>
                    </div>
                </div>

                {{-- Tabel dan Filter --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    {{-- Pencarian --}}
                    <div class="border-b border-slate-100 p-5">
                        <form
                            method="GET"
                            action="{{ route('admin.payments.index') }}"
                            class="flex flex-col gap-3 md:flex-row"
                        >
                            <input
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Cari kode pembayaran, booking, atau pelanggan..."
                                class="min-w-0 flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-green-600 focus:outline-none focus:ring-2 focus:ring-green-100"
                            >

                            <select
                                name="status"
                                class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-green-600 focus:outline-none focus:ring-2 focus:ring-green-100"
                            >
                                <option value="">Semua Status</option>
                                <option value="pending" @selected($status === 'pending')>
                                    Menunggu
                                </option>
                                <option value="paid" @selected($status === 'paid')>
                                    Lunas
                                </option>
                                <option value="rejected" @selected($status === 'rejected')>
                                    Ditolak
                                </option>
                            </select>

                            <button
                                type="submit"
                                class="rounded-xl bg-green-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-800"
                            >
                                Cari
                            </button>

                            <a
                                href="{{ route('admin.payments.index') }}"
                                class="rounded-xl border border-slate-200 px-5 py-2.5 text-center text-sm text-slate-600 transition hover:bg-slate-50"
                            >
                                Reset
                            </a>
                        </form>
                    </div>

                    {{-- Tabel Pembayaran --}}
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[900px] text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-5 py-4 font-semibold">Pembayaran</th>
                                    <th class="px-5 py-4 font-semibold">Pelanggan</th>
                                    <th class="px-5 py-4 font-semibold">Booking</th>
                                    <th class="px-5 py-4 font-semibold">Metode</th>
                                    <th class="px-5 py-4 font-semibold">Nominal</th>
                                    <th class="px-5 py-4 font-semibold">Status</th>
                                    <th class="px-5 py-4 font-semibold">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($payments as $payment)
                                    <tr class="transition hover:bg-slate-50">

                                        {{-- Informasi Pembayaran --}}
                                        <td class="px-5 py-4 font-semibold text-slate-800">
                                            {{ $payment->payment_code }}

                                            <p class="mt-1 text-xs font-normal text-slate-400">
                                                {{ $payment->created_at?->format('d/m/Y H:i') }}
                                            </p>
                                        </td>

                                        {{-- Pelanggan --}}
                                        <td class="px-5 py-4 text-slate-600">
                                            {{ $payment->booking?->user?->name ?? 'Pengguna tidak tersedia' }}
                                        </td>

                                        {{-- Kode Booking --}}
                                        <td class="px-5 py-4 text-slate-600">
                                            {{ $payment->booking?->booking_code ?? '-' }}
                                        </td>

                                        {{-- Metode Pembayaran --}}
                                        <td class="px-5 py-4 text-slate-600">
                                            {{ $payment->method ?: 'Belum ditentukan' }}
                                        </td>

                                        {{-- Nominal --}}
                                        <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-800">
                                            Rp{{ number_format((float) $payment->amount, 0, ',', '.') }}
                                        </td>

                                        {{-- Status --}}
                                        <td class="px-5 py-4">
                                            @if ($payment->status === 'paid')
                                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                    Lunas
                                                </span>
                                            @elseif ($payment->status === 'rejected')
                                                <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                                    Menunggu
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="px-5 py-4">
                                            @if ($payment->status === 'pending')
                                                <div class="flex flex-wrap gap-2">

                                                    {{-- Setujui Pembayaran --}}
                                                    <form
                                                        action="{{ route('admin.payments.update-status', $payment) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Setujui pembayaran ini?')"
                                                    >
                                                        @csrf
                                                        @method('PATCH')

                                                        <input
                                                            type="hidden"
                                                            name="status"
                                                            value="paid"
                                                        >

                                                        <button
                                                            type="submit"
                                                            class="rounded-lg bg-green-700 px-3 py-2 text-xs font-semibold text-white transition hover:bg-green-800"
                                                        >
                                                            Setujui
                                                        </button>
                                                    </form>

                                                    {{-- Tolak Pembayaran --}}
                                                    <form
                                                        action="{{ route('admin.payments.update-status', $payment) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Tolak pembayaran ini?')"
                                                    >
                                                        @csrf
                                                        @method('PATCH')

                                                        <input
                                                            type="hidden"
                                                            name="status"
                                                            value="rejected"
                                                        >

                                                        <button
                                                            type="submit"
                                                            class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50"
                                                        >
                                                            Tolak
                                                        </button>
                                                    </form>

                                                </div>
                                            @else
                                                <span class="text-xs text-slate-400">
                                                    Sudah diproses
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-5 py-12 text-center">
                                            <div class="mx-auto flex max-w-sm flex-col items-center">
                                                <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                                    <svg
                                                        class="h-6 w-6"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                    >
                                                        <rect x="2" y="5" width="20" height="14" rx="2"/>
                                                        <path d="M2 10h20"/>
                                                    </svg>
                                                </div>

                                                <p class="font-semibold text-slate-700">
                                                    Belum ada data pembayaran
                                                </p>

                                                <p class="mt-1 text-xs text-slate-500">
                                                    Data pembayaran akan muncul setelah pembayaran dibuat untuk booking.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if ($payments->hasPages())
                        <div class="border-t border-slate-100 p-5">
                            {{ $payments->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </main>
    </div>
@endsection
