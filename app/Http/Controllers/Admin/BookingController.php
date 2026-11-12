<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Menampilkan seluruh data booking.
     */
    public function index(): View
    {
        $bookings = Booking::with([
            'user',
            'technician.user',
            'address',
            'details.service',
            'payment',
        ])
            ->latest()
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Menghapus data booking.
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        DB::transaction(function () use ($booking) {

            // Hapus detail booking terlebih dahulu.
            $booking->details()->delete();

            // Hapus pembayaran jika ada.
            $booking->payment()->delete();

            // Hapus booking utama.
            $booking->delete();
        });

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Data booking berhasil dihapus.');
    }
}
