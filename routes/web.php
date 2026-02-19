<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 2. TAMBAHKAN BLOK ROUTE ADMIN INI DI SINI
Route::middleware(['auth', 'role:super_admin,owner,admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // TAMBAHKAN BARIS INI:
    Route::resource('admin/rooms', RoomController::class)->names('admin.rooms');

    Route::patch('admin/tenants/{tenant}/alumni', [TenantController::class, 'setAlumni'])->name('admin.tenants.alumni');
    Route::resource('admin/tenants', TenantController::class)->names('admin.tenants');

    Route::middleware('role:super_admin,owner')->group(function () {
    Route::resource('admin/users', UserController::class)->names('admin.users');
    });

     Route::get('admin/payments/{payment}/invoice', [PaymentController::class, 'generateInvoice'])->name('admin.payments.invoice'); // [cite: 195]
    Route::resource('admin/payments', PaymentController::class)->names('admin.payments');
});

require __DIR__.'/auth.php';
