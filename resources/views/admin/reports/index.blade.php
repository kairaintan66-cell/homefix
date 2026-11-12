@extends('layouts.admin')

@section('title', 'Laporan - HomeFix')

@section('content')
<div class="hf-admin-content">
    @include('admin.partials.sidebar', ['active' => 'reports'])

    <div class="p-4 md:p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">Laporan HomeFix</h1>
            <p class="mt-1 text-sm text-slate-500">
                Ringkasan booking, pembayaran, dan pendapatan.
            </p>
        </div>

        <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route('admin.reports.index') }}"
                  class="grid grid-cols-1 items-end gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label for="start_date" class="mb-2 block text-sm font-medium text-slate-700">
                        Dari Tanggal
                    </label>
                    <input type="date" id="start_date" name="start_date"
                           value="{{ $startDate }}"
                           class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm">
                </div>

                <div>
                    <label for="end_date" class="mb-2 block text-sm font-medium text-slate-700">
                        Sampai Tanggal
                    </label>
                    <input type="date" id="end_date" name="end_date"
                           value="{{ $endDate }}"
                           class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm">
                </div>

                <button class="rounded-xl bg-green-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-800">
                    Terapkan Filter
                </button>

                <a href="{{ route('admin.reports.index') }}"
                   class="rounded-xl border border-slate-200 px-5 py-2.5 text-center text-sm text-slate-600">
                    Reset
                </a>
            </form>
        </div>

        <p class="mb-4 text-sm text-slate-500">
            Periode {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
            – {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        </p>

        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Jumlah Booking</p>
                <p class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($jumlahBooking) }}</p>
                <p class="mt-1 text-xs text-slate-400">Booking dibuat pada periode terpilih</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total Tagihan</p>
                <p class="mt-2 text-2xl font-bold text-slate-800">
                    Rp{{ number_format((float) $totalTagihan, 0, ',', '.') }}
                </p>
                <p class="mt-1 text-xs text-slate-400">Semua status pembayaran</p>
            </div>

            <div class="rounded-2xl border border-green-100 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Total Pendapatan</p>
                <p class="mt-2 text-2xl font-bold text-green-700">
                    Rp{{ number_format((float) $totalPendapatan, 0, ',', '.') }}
                </p>
                <p class="mt-1 text-xs text-slate-400">Pembayaran berstatus lunas</p>
            </div>

            <div class="rounded-2xl border border-green-100 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Pembayaran Lunas</p>
                <p class="mt-2 text-3xl font-bold text-green-700">{{ number_format($pembayaranLunas) }}</p>
            </div>

            <div class="rounded-2xl border border-amber-100 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Menunggu Verifikasi</p>
                <p class="mt-2 text-3xl font-bold text-amber-600">{{ number_format($menungguVerifikasi) }}</p>
            </div>

            <div class="rounded-2xl border border-red-100 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Pembayaran Ditolak</p>
                <p class="mt-2 text-3xl font-bold text-red-600">{{ number_format($jumlahDitolak) }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 p-5">
                <h2 class="font-bold text-slate-800">Rincian Pembayaran</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Data pembayaran yang dibuat pada periode terpilih.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[650px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-4">Tanggal</th>
                            <th class="px-5 py-4">Kode Pembayaran</th>
                            <th class="px-5 py-4">Kode Booking</th>
                            <th class="px-5 py-4">Nominal</th>
                            <th class="px-5 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($payments as $payment)
                            <tr>
                                <td class="px-5 py-4 text-slate-600">
                                    {{ $payment->created_at?->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-4 font-medium text-slate-800">
                                    {{ $payment->payment_code }}
                                </td>
                                <td class="px-5 py-4 text-slate-600">
                                    {{ $payment->booking?->booking_code ?? '-' }}
                                </td>
                                <td class="px-5 py-4 font-semibold text-slate-800">
                                    Rp{{ number_format((float) $payment->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4">
                                    @if ($payment->status === 'paid')
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Lunas</span>
                                    @elseif ($payment->status === 'rejected')
                                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Ditolak</span>
                                    @else
                                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-slate-500">
                                    Tidak ada pembayaran pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-100 p-5">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
