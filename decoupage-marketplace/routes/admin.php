<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RecycleRequestController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', 'verified', 'role.guard:admin,super_admin'])
    ->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::post('users/{user}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::post('users/{user}/unban', [UserController::class, 'unban'])->name('users.unban');
        Route::post('users/{user}/roles', [UserController::class, 'syncRoles'])->name('users.roles');
        Route::resource('users', UserController::class);

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);

        Route::get('orders/{order}/status', [OrderController::class, 'editStatus'])->name('orders.status.edit');
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status.update');
        Route::resource('orders', OrderController::class)->only(['index', 'show', 'destroy']);

        Route::resource('recycle-requests', RecycleRequestController::class)->parameters([
            'recycle-requests' => 'recycleRequest',
        ]);

        Route::resource('wallets', WalletController::class);

        Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'show']);

        Route::post('reviews/{review}/toggle', [ReviewController::class, 'toggleVisibility'])->name('reviews.toggle');
        Route::resource('reviews', ReviewController::class)->only(['index', 'edit', 'update', 'destroy']);

        Route::resource('activity-logs', ActivityLogController::class)->only(['index', 'show']);
    });
