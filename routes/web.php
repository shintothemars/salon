<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\EmployeeController;

use App\Http\Controllers\AuthController;

// ===== AUTH ROUTES =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== FRONTEND ROUTES =====

// a. Halaman Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// b. Halaman List Layanan (dengan tombol tambah, edit, hapus)
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

// c. Halaman Tambah Layanan
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
Route::post('/services', [ServiceController::class, 'store'])->name('services.store');

// Edit & Hapus Layanan
Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
Route::put('/services/{id}', [ServiceController::class, 'update'])->name('services.update');
Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

// d. Halaman Reservasi (form biodata, tanggal, waktu)
Route::get('/booking', fn() => redirect('/services'));
Route::get('/booking/{id}', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// e. Halaman Konfirmasi Pemesanan
Route::get('/booking/{id}/confirmation', [BookingController::class, 'confirmation'])->name('booking.confirmation');
Route::post('/booking/{id}/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');

// f. Halaman Berhasil Reservasi (tiket / struk)
Route::get('/success/{id}', [BookingController::class, 'success'])->name('booking.success');

// ===== ADMIN ROUTES =====
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
    
    // Kelola Stylist
    Route::get('/admin/employees', [EmployeeController::class, 'index'])->name('admin.employees.index');
    Route::get('/admin/employees/create', [EmployeeController::class, 'create'])->name('admin.employees.create');
    Route::post('/admin/employees', [EmployeeController::class, 'store'])->name('admin.employees.store');
    Route::get('/admin/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('admin.employees.edit');
    Route::put('/admin/employees/{id}', [EmployeeController::class, 'update'])->name('admin.employees.update');
    Route::delete('/admin/employees/{id}', [EmployeeController::class, 'destroy'])->name('admin.employees.destroy');
});

// ===== KARYAWAN ROUTES =====
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/karyawan-dashboard', [KaryawanController::class, 'index'])->name('karyawan.dashboard');
});