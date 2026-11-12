<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $startDate = $validated['start_date'] ?? now()->startOfMonth()->toDateString();
        $endDate = $validated['end_date'] ?? now()->toDateString();

        $paymentsQuery = Payment::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        $bookingsQuery = Booking::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        $jumlahBooking = (clone $bookingsQuery)->count();

        $totalTagihan = (clone $paymentsQuery)->sum('amount');

        $pembayaranLunas = (clone $paymentsQuery)
            ->where('status', 'paid')
            ->count();

        $menungguVerifikasi = (clone $paymentsQuery)
            ->where('status', 'pending')
            ->count();

        $totalPendapatan = (clone $paymentsQuery)
            ->where('status', 'paid')
            ->sum('amount');

        $jumlahDitolak = (clone $paymentsQuery)
            ->where('status', 'rejected')
            ->count();

        $payments = (clone $paymentsQuery)
            ->with(['booking.user'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'jumlahBooking',
            'totalTagihan',
            'pembayaranLunas',
            'menungguVerifikasi',
            'totalPendapatan',
            'jumlahDitolak',
            'payments'
        ));
    }
}
