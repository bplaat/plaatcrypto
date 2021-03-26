<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminCoinsController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Home page
Route::view('/', 'home')->name('home');

// Normal routes
Route::middleware('auth')->group(function () {
    // Transaction routes
    Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionsController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionsController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/edit', [TransactionsController::class, 'edit'])
        ->name('transactions.edit')->middleware('can:update,transaction');
    Route::get('/transactions/{transaction}/delete', [TransactionsController::class, 'delete'])
        ->name('transactions.delete')->middleware('can:delete,transaction');
    Route::get('/transactions/{transaction}', [TransactionsController::class, 'show'])
        ->name('transactions.show')->middleware('can:view,transaction');
    Route::post('/transactions/{transaction}', [TransactionsController::class, 'update'])
        ->name('transactions.update')->middleware('can:update,transaction');

    // Settings routes
    Route::view('/settings', 'settings')->name('settings');
    Route::post('/settings/change_details', [SettingsController::class, 'changeDetails'])->name('settings.change_details');
    Route::post('/settings/change_password', [SettingsController::class, 'changePassword'])->name('settings.change_password');

    // Auth routes
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// Admin routes
Route::middleware('admin')->group(function () {
    // Admin home page
    Route::view('/admin', 'admin.home')->name('admin.home');

    // Admin users routes
    Route::get('/admin/users', [AdminUsersController::class, 'index'])->name('admin.users.index');
    Route::view('/admin/users/create', 'admin.users.create')->name('admin.users.create');
    Route::post('/admin/users', [AdminUsersController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/hijack', [AdminUsersController::class, 'hijack'])->name('admin.users.hijack');
    Route::get('/admin/users/{user}/edit', [AdminUsersController::class, 'edit'])->name('admin.users.edit');
    Route::get('/admin/users/{user}/delete', [AdminUsersController::class, 'delete'])->name('admin.users.delete');
    Route::get('/admin/users/{user}', [AdminUsersController::class, 'show'])->name('admin.users.show');
    Route::post('/admin/users/{user}', [AdminUsersController::class, 'update'])->name('admin.users.update');

    // Admin coins routes
    Route::get('/admin/coins', [AdmincoinsController::class, 'index'])->name('admin.coins.index');
    Route::view('/admin/coins/create', 'admin.coins.create')->name('admin.coins.create');
    Route::post('/admin/coins', [AdmincoinsController::class, 'store'])->name('admin.coins.store');
    Route::get('/admin/coins/{coin}/edit', [AdmincoinsController::class, 'edit'])->name('admin.coins.edit');
    Route::get('/admin/coins/{coin}/delete', [AdmincoinsController::class, 'delete'])->name('admin.coins.delete');
    Route::get('/admin/coins/{coin}', [AdmincoinsController::class, 'show'])->name('admin.coins.show');
    Route::post('/admin/coins/{coin}', [AdmincoinsController::class, 'update'])->name('admin.coins.update');
});

// Guest routes
Route::middleware('guest')->group(function () {
    // Auth routes
    Route::view('/auth/login', 'auth.login')->name('auth.login');
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::view('/auth/register', 'auth.register')->name('auth.register');
    Route::post('/auth/register', [AuthController::class, 'register']);
});
