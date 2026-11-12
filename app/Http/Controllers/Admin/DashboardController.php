<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Technician;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = User::where('role', 'pengguna')->count();
        $totalTeknisi = Technician::count();
        $totalBooking = Booking::count();
        $totalLayanan = Service::where('is_active', true)->count();

        $statusSelesai = ['selesai', 'completed'];
        $statusAktif = ['diterima', 'accepted', 'menuju_lokasi', 'on_the_way', 'sedang_dikerjakan', 'working', 'berlangsung'];
        $statusMenunggu = ['menunggu', 'pending', 'menunggu_teknisi'];
        $statusDibatalkan = ['dibatalkan', 'cancelled', 'canceled'];

        $bookingSelesai = Booking::whereIn('status', $statusSelesai)->count();
        $bookingAktif = Booking::whereIn('status', $statusAktif)->count();
        $bookingMenunggu = Booking::whereIn('status', $statusMenunggu)->count();
        $bookingDibatalkan = Booking::whereIn('status', $statusDibatalkan)->count();

        $statusPembayaranLunas = ['paid', 'success', 'lunas', 'berhasil', 'completed'];
        $totalPendapatan = Payment::whereIn('status', $statusPembayaranLunas)->sum('amount');

        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $pendapatanBulanan = [];
        $tahun = now()->year;

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $pendapatanBulanan[] = (float) Payment::whereIn('status', $statusPembayaranLunas)
                ->whereYear('paid_at', $tahun)
                ->whereMonth('paid_at', $bulan)
                ->sum('amount');
        }

        $nilaiMaksimumGrafik = max($pendapatanBulanan) ?: 1;
        $pesananTerbaru = Booking::with(['user', 'technician.user', 'details.service'])
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalPelanggan',
            'totalTeknisi',
            'totalBooking',
            'totalLayanan',
            'bookingSelesai',
            'bookingAktif',
            'bookingMenunggu',
            'bookingDibatalkan',
            'totalPendapatan',
            'bulanLabels',
            'pendapatanBulanan',
            'nilaiMaksimumGrafik',
            'pesananTerbaru'
        ));
    }
}
