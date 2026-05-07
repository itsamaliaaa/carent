<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer;
use App\Http\Controllers\AdminRental;
use App\Http\Controllers\SuperAdmin;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// PUBLIC ROUTES
Route::get('/', [Customer\CatalogController::class, 'beranda'])->name('beranda');
Route::get('/katalog', [Customer\CatalogController::class, 'index'])->name('katalog');
Route::get('/mobil/{id}', [Customer\CatalogController::class, 'detail'])->name('mobil.detail');
Route::get('/rental/{id}', [Customer\CatalogController::class, 'profileRental'])->name('rental.profil');

// CUSTOMER AUTH
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showUserLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);


// ADMIN & SUPERADMIN AUTH
Route::get('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'loginAdmin']);

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// CUSTOMER ROUTES
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/booking/{mobil_id}', [Customer\BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [Customer\BookingController::class, 'store'])->name('booking.store');
    Route::get('/riwayat', [Customer\BookingController::class, 'riwayat'])->name('booking.riwayat');
    Route::get('/booking/{id}', [Customer\BookingController::class, 'detail'])->name('booking.detail');
    Route::post('/booking/{id}/batal', [Customer\BookingController::class, 'batalkan'])->name('booking.batal');
    Route::post('/booking/{id}/review', [Customer\ReviewController::class, 'store'])->name('review.store');
    Route::get('/profil', [Customer\ProfileController::class, 'index'])->name('profil');
    Route::put('/profil', [Customer\ProfileController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [Customer\ProfileController::class, 'updatePassword'])->name('profil.password');
    Route::get('/notifikasi', [Customer\NotifikasiController::class, 'index'])->name('notifikasi');
    Route::post('/notifikasi/read-all', [Customer\NotifikasiController::class, 'readAll'])->name('notifikasi.readAll');
});

// ADMIN RENTAL ROUTES
Route::middleware(['auth', 'role:admin_rental'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminRental\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/mobil', AdminRental\MobilController::class);
    Route::resource('/driver', AdminRental\DriverController::class);
    Route::get('/booking', [AdminRental\BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/{id}', [AdminRental\BookingController::class, 'detail'])->name('booking.detail');
    Route::put('/booking/{id}/status', [AdminRental\BookingController::class, 'updateStatus'])->name('booking.status');
    Route::delete('/booking/{id}', [AdminRental\BookingController::class, 'destroy'])->name('booking.destroy');
    Route::get('/review', [AdminRental\ReviewController::class, 'index'])->name('review.index');
    Route::post('/review/{id}/reply', [AdminRental\ReviewController::class, 'reply'])->name('review.reply');
    Route::get('/laporan', [AdminRental\LaporanController::class, 'index'])->name('laporan');
    Route::get('/profil', [AdminRental\ProfilController::class, 'index'])->name('profil');
    Route::put('/profil', [AdminRental\ProfilController::class, 'update'])->name('profil.update');
});

// SUPER ADMIN ROUTES
Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/rental', SuperAdmin\RentalController::class);
    Route::put('/rental/{id}/status', [SuperAdmin\RentalController::class, 'toggleStatus'])->name('rental.status');
    Route::get('/review', [SuperAdmin\ReviewController::class, 'index'])->name('review.index');
    Route::put('/review/{id}/toggle', [SuperAdmin\ReviewController::class, 'toggle'])->name('review.toggle');
    Route::resource('/kebijakan', SuperAdmin\KebijakanController::class);
    Route::get('/laporan', [SuperAdmin\LaporanController::class, 'index'])->name('laporan');
    Route::get('/profil', [SuperAdmin\ProfilController::class, 'index'])->name('profil');
    Route::put('/profil', [SuperAdmin\ProfilController::class, 'update'])->name('profil.update');
});

// API NOTIFIKASI (Polling)
Route::middleware('auth')->prefix('api')->group(function () {
    Route::get('/notifikasi/unread', function () {
        $notifs = auth()->user()->unreadNotifications->take(10);
        return response()->json([
            'total' => auth()->user()->unreadNotifications->count(),
            'data'  => $notifs,
        ]);
    });
});

// Route::get('/tes-admin', function () {
//     return view('admin.dashboard');
// });
