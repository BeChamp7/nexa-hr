<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Language switcher (available to everyone)
Route::get('/locale/{locale}', [LocaleController::class, 'update'])->name('locale.update');

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('employees', EmployeeController::class);

    Route::resource('departments', DepartmentController::class)->except('show');

    Route::get('/leaves', [LeaveRequestController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/create', [LeaveRequestController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [LeaveRequestController::class, 'store'])->name('leaves.store');
    Route::get('/leaves/{leave}', [LeaveRequestController::class, 'show'])->name('leaves.show');
    Route::patch('/leaves/{leave}/approve', [LeaveRequestController::class, 'approve'])->name('leaves.approve');
    Route::patch('/leaves/{leave}/reject', [LeaveRequestController::class, 'reject'])->name('leaves.reject');
    Route::delete('/leaves/{leave}', [LeaveRequestController::class, 'destroy'])->name('leaves.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
