<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GiftCardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\PasswordResetController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RedeemController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\RoleUserController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')
    ->name('website.')
    ->middleware(['auth.register','auth.redirect-super-admin'])
    ->group(function () {
        Route::get('', [HomeController::class, 'index'])->name('index');
        Route::get('faqs', [HomeController::class, 'faqs'])->name('faqs');
        Route::get('wallet', [HomeController::class, 'wallet'])->name('wallet');
        Route::get('gift-cards', [HomeController::class, 'giftCards'])->name('gift-cards.list');
        Route::get('tasks', [HomeController::class, 'tasks'])->name('tasks.list');
        Route::get('task/{id}', [HomeController::class, 'taskDetail'])->name('task.detail');
        Route::post('task/submit', [HomeController::class, 'submitTask'])->name('tasks.submit');
        Route::get('earning-points', [HomeController::class, 'earningPoints'])->name('earning-points');
        Route::get('notifications', [NotificationController::class, 'userNotifications'])->name('notifications');

        Route::get('user/profile', [HomeController::class, 'getUserProfile'])->name('user.profile');
        Route::post('user/profile/update', [HomeController::class, 'updateUserProfile'])->name('user.profile.update');
        Route::post('user/profile/delete', [HomeController::class, 'deleteUserProfile'])->name('user.profile.delete');

        Route::post('redeem/request', [HomeController::class, 'redeemRequest'])->name('redeem.request');
    });

Route::post('password-reset/request', [HomeController::class,'passwordRequest'])->name('password-reset.request');

Route::get('terms-conditions', [HomeController::class, 'termsConditions'])->name('terms-conditions');
Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');

Route::middleware(['auth', 'auth.session'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::resource('profile', ProfileController::class)->only(['index', 'store']);
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('tasks', BranchController::class);
        Route::resource('types', TypeController::class);
        Route::resource('gift-cards', GiftCardController::class);
        Route::resource('inventories', InventoryController::class);

        Route::resource('role-users', RoleUserController::class, ['names' => 'role-users'])->only(['index', 'store']);
        Route::resource('role-permissions', RolePermissionController::class, ['names' => 'role-permissions'])->only(['index', 'store']);

        Route::get('submissions/{taskId?}', [SubmissionController::class, 'index'])->name('submissions.index');
        Route::post('submissions/update', [SubmissionController::class, 'update'])->name('submissions.update');
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');

        Route::get('redeems', [RedeemController::class, 'index'])->name('redeems.index');
        Route::post('redeems/approved', [RedeemController::class, 'approved'])->name('redeems.approved');

        Route::get('password-resets', [PasswordResetController::class, 'index'])->name('password.resets');
        Route::get('password-change/{id}', [PasswordResetController::class, 'change'])->name('password.change');
        Route::post('password-update/{id}', [PasswordResetController::class, 'update'])->name('password.update');
    });

Route::post('read-notification', [NotificationController::class, 'read'])->name('read-notification');
Route::post('/update-theme', [UserController::class, 'updateTheme'])->name('update-theme');
Route::get('inventories-by-gift-card/{gcId}', [ApiController::class, 'inventoriesByGiftCard'])->name('inventories-by-gift-card');
require __DIR__ . '/auth.php';
