<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AccountController;

Route::middleware(['guest'])->group(function () { //ziyaretçiler
Route::get('/login', [AuthController::class, 'login_index'])->name('admin.login');
Route::post('/login', action: [AuthController::class, 'login'])->name('admin.login.post');
});

Route::prefix('admin')->middleware('auth')->group(function () { //panel kullanıcıları
    Route::get('/', [IndexController::class, 'index'])->name('admin.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name(name: 'admin.logout');

    //Account Routes
    Route::get('/account', action: [AccountController::class, 'index'])->name('admin.account');
    Route::post('/account-update', action: [AccountController::class, 'update'])->name('admin.account.update');
    Route::get('/account-security', action: [AccountController::class, 'security_index'])->name('admin.account_security');
    Route::post('/account-security-update', action: [AccountController::class, 'security_update'])->name('admin.account.security_update');
});