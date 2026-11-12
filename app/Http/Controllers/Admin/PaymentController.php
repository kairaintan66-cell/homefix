<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $payments = Payment::with(['booking.user'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('payment_code', 'ilike', "%{$search}%")
                        ->orWhereHas('booking', function ($bookingQuery) use ($search) {
                            $bookingQuery->where('booking_code', 'ilike', "%{$search}%")
                                ->orWhereHas('user', function ($userQuery) use ($search) {
                                    $userQuery->where('name', 'ilike', "%{$search}%");
                                });
                        });
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalPembayaran = Payment::count();
        $menunggu = Payment::where('status', 'pending')->count();
        $lunas = Payment::where('status', 'paid')->count();
        $ditolak = Payment::where('status', 'rejected')->count();

        return view('admin.payments.index', compact(
            'payments',
            'totalPembayaran',
            'menunggu',
            'lunas',
            'ditolak',
            'search',
            'status'
        ));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:paid,rejected'],
        ]);

        $payment->status = $validated['status'];
        $payment->paid_at = $validated['status'] === 'paid'
            ? now()
            : null;

        $payment->save();

        return redirect()
            ->route('admin.payments.index')
            ->with(
                'success',
                $validated['status'] === 'paid'
                    ? 'Pembayaran berhasil disetujui.'
                    : 'Pembayaran berhasil ditolak.'
            );
    }
}
