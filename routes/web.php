<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('home'); // 
Route::get('/kamar/{room}', [PublicController::class, 'showRoom'])->name('room.detail'); //

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


    Route::get('admin/payments/{payment}/invoice', [PaymentController::class, 'generateInvoice'])->name('admin.payments.invoice'); // [cite: 195]
    Route::resource('admin/payments', PaymentController::class)->names('admin.payments');

    // Di dalam blok Route::middleware(['auth', 'role:super_admin,owner,admin'])->group(...) :
    Route::resource('admin/expenses', ExpenseController::class)->names('admin.expenses');
    
    Route::middleware('role:super_admin,owner')->group(function () {
    Route::resource('admin/users', UserController::class)->names('admin.users');
    });
});

require __DIR__.'/auth.php';
