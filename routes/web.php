<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\TechnicianController as AdminTechnicianController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

use App\Http\Controllers\Pengguna\DashboardController as PenggunaDashboardController;
use App\Http\Controllers\Teknisi\DashboardController as TeknisiDashboardController;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $categories = Category::all();

    return view('home', compact('categories'));
})->name('home');


/*
|--------------------------------------------------------------------------
| LAYANAN PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/kategori/{category}/layanan', [
    ServiceController::class,
    'index'
])->name('services.index');


/*
|--------------------------------------------------------------------------
| DASHBOARD PENGALIHAN
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [
    DashboardController::class,
    'redirect'
])->middleware('auth')->name('dashboard');


/*
|--------------------------------------------------------------------------
| BOOKING PELANGGAN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pengguna'])->group(function () {

    Route::get('/booking/{service}/buat', [
        BookingController::class,
        'create'
    ])->name('bookings.create');

    Route::post('/booking/{service}', [
        BookingController::class,
        'store'
    ])->name('bookings.store');

    Route::get('/booking', [
        BookingController::class,
        'index'
    ])->name('bookings.index');

});


/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index'
        ])->name('dashboard');

        // Manajemen Pelanggan
        Route::resource('pelanggan', AdminCustomerController::class)
            ->except(['show'])
            ->parameters([
                'pelanggan' => 'customer'
            ])
            ->names('customers');

        // Manajemen Teknisi
        Route::resource('teknisi', AdminTechnicianController::class)
            ->except(['show'])
            ->names('technicians');

        // Manajemen Kategori
        Route::resource('kategori', AdminCategoryController::class)
            ->except(['show'])
            ->parameters([
                'kategori' => 'kategori'
            ])
            ->names('categories');

        // Manajemen Layanan
        Route::resource('layanan', AdminServiceController::class)
            ->except(['show'])
            ->names('services');

        // Manajemen Booking
        Route::get('/booking', [
            AdminBookingController::class,
            'index'
        ])->name('bookings.index');

        Route::delete('/booking/{booking}', [
            AdminBookingController::class,
            'destroy'
        ])->name('bookings.destroy');

        // Manajemen Pembayaran
        Route::get('/pembayaran', [
            AdminPaymentController::class,
            'index'
        ])->name('payments.index');

        Route::patch('/pembayaran/{payment}/status', [
            AdminPaymentController::class,
            'updateStatus'
        ])->name('payments.update-status');

        // Laporan
        Route::get('/laporan', [
            AdminReportController::class,
            'index'
        ])->name('reports.index');

    });


/*
|--------------------------------------------------------------------------
| DASHBOARD PENGGUNA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pengguna'])
    ->prefix('pengguna')
    ->name('pengguna.')
    ->group(function () {

        // Dashboard Pengguna
        Route::get('/dashboard', [
            PenggunaDashboardController::class,
            'index'
        ])->name('dashboard');

        // Setujui rincian biaya dari teknisi
        Route::patch('/booking/{booking}/setujui-biaya', [
            BookingController::class,
            'approvePrice'
        ])->name('bookings.approve-price');

        // Tolak rincian biaya dari teknisi
        Route::patch('/booking/{booking}/tolak-biaya', [
            BookingController::class,
            'rejectPrice'
        ])->name('bookings.reject-price');

    });


/*
|--------------------------------------------------------------------------
| DASHBOARD TEKNISI
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:teknisi'])
    ->prefix('teknisi')
    ->name('teknisi.')
    ->group(function () {

        // Dashboard Teknisi
        Route::get('/dashboard', [
            TeknisiDashboardController::class,
            'index'
        ])->name('dashboard');

        // Daftar Pesanan
        Route::get('/pesanan', [
            TeknisiDashboardController::class,
            'bookings'
        ])->name('pesanan');

        // Terima, tolak, dan perbarui status pesanan
        Route::patch('/pesanan/{booking}/status', [
            TeknisiDashboardController::class,
            'updateBookingStatus'
        ])->name('pesanan.status');

        // Kirim rincian biaya pemeriksaan kepada pelanggan
        Route::patch('/pesanan/{booking}/harga', [
            TeknisiDashboardController::class,
            'submitPrice'
        ])->name('pesanan.harga');

        // Jadwal Teknisi
        Route::get('/jadwal', [
            TeknisiDashboardController::class,
            'schedules'
        ])->name('jadwal');

        Route::put('/jadwal', [
            TeknisiDashboardController::class,
            'updateSchedule'
        ])->name('jadwal.update');

    });


/*
|--------------------------------------------------------------------------
| PROFIL PENGGUNA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
