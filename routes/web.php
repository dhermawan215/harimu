<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticateController::class, 'login'])->name('login');
    Route::post('/login', [AuthenticateController::class, 'signIning']);
    Route::get('/register', [AuthenticateController::class, 'register'])->name('register');
    Route::post('/register', [AuthenticateController::class, 'signUp']);
    Route::get('/forgot-password', [AuthenticateController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthenticateController::class, 'sendResetLink'])
        ->middleware('throttle:5,1')
        ->name('password.email');
    Route::get('/reset-password/{token}', [AuthenticateController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthenticateController::class, 'resetPassword'])->name('password.update');
});

Route::get('/email/verify', [AuthenticateController::class, 'verificationNotice'])->name('verification.notice');
Route::get('/email/verify/{token}', [AuthenticateController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/email/resend', [AuthenticateController::class, 'resendVerification'])
    ->middleware('throttle:5,1')
    ->name('verification.resend');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return 'dashboard';
    })->name('dashboard');
    Route::post('/logout', [AuthenticateController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});
