<?php

use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DataController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\RoleUserController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::middleware(['auth', 'auth.session'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('profile', ProfileController::class)->only(['index', 'store']);
        Route::resource('users', UserController::class);
        Route::resource('data', DataController::class);
        Route::resource('branches', BranchController::class);
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::get('password-resets', [PasswordResetController::class, 'index'])->name('password.resets');
        Route::get('password-change/{id}', [PasswordResetController::class, 'change'])->name('password.change');
        Route::post('password-update/{id}', [PasswordResetController::class, 'update'])->name('password.update');
    });
Route::post('/update-theme', [UserController::class, 'updateTheme'])->name('update-theme');
require __DIR__ . '/auth.php';
