<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Only Routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::resource('departments', DepartmentController::class);
        Route::patch('/leaves/{leave}/status', [LeaveController::class, 'updateStatus'])->name('leaves.updateStatus');
        Route::resource('payroll', PayrollController::class)->except(['index', 'show']); // Admin manages payroll
        Route::get('/payroll/create', [PayrollController::class, 'create'])->name('payroll.create');
        Route::post('/payroll', [PayrollController::class, 'store'])->name('payroll.store');
        Route::patch('/payroll/{payroll}/pay', [PayrollController::class, 'markAsPaid'])->name('payroll.markAsPaid');
        Route::delete('/payroll/{payroll}', [PayrollController::class, 'destroy'])->name('payroll.destroy');
        
        Route::resource('announcements', AnnouncementController::class)->except(['index', 'show']); // Admin creates announcements
    });

    // Employee & Admin Access (Shared but data filtered in controller)
    Route::resource('attendance', AttendanceController::class);
    Route::resource('leaves', LeaveController::class)->except(['updateStatus']);
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index'); // View own payroll
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index'); // View announcements
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
});

require __DIR__.'/auth.php';
