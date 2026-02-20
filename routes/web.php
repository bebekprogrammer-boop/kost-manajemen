<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReminderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\SettingController;
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

    Route::get('admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');

    Route::resource('admin/expenses', ExpenseController::class)->names('admin.expenses');

    Route::get('admin/reminders', [ReminderController::class, 'index'])->name('admin.reminders.index');
    Route::post('admin/reminders/log', [ReminderController::class, 'log'])->name('admin.reminders.log');

    Route::middleware('role:super_admin,owner')->group(function () {
    Route::resource('admin/users', UserController::class)->names('admin.users');

        Route::get('admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::post('admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');
    });
    Route::middleware('role:super_admin')->group(function () {
        Route::get('admin/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
    });
});

require __DIR__.'/auth.php';
