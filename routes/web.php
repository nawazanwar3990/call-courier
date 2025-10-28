<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\RoleUserController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('password-reset/request', [HomeController::class,'passwordRequest'])->name('password-reset.request');
Route::get('terms-conditions', [HomeController::class, 'termsConditions'])->name('terms-conditions');
Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::middleware(['auth', 'auth.session'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::resource('profile', ProfileController::class)->only(['index', 'store']);
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('branches', BranchController::class);
        Route::resource('role-users', RoleUserController::class, ['names' => 'role-users'])->only(['index', 'store']);
        Route::resource('role-permissions', RolePermissionController::class, ['names' => 'role-permissions'])->only(['index', 'store']);
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::get('password-resets', [PasswordResetController::class, 'index'])->name('password.resets');
        Route::get('password-change/{id}', [PasswordResetController::class, 'change'])->name('password.change');
        Route::post('password-update/{id}', [PasswordResetController::class, 'update'])->name('password.update');
    });
Route::post('/update-theme', [UserController::class, 'updateTheme'])->name('update-theme');
require __DIR__ . '/auth.php';
