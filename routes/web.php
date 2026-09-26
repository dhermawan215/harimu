<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MusicController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\User\DashboardController;
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
    Route::post('/logout', [AuthenticateController::class, 'signOut'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        //route music management
        Route::controller(MusicController::class)->prefix('music')->group(function () {
            Route::get('/', 'index')->name('admin.music');
            Route::post('/list', 'listData');
            Route::post('/save', 'store');
            Route::post('/edit', 'edit');
            Route::post('/update', 'update');
            Route::delete('/delete', 'destroy');
            Route::post('/restore', 'restore');
            Route::post('/toggle-active', 'toggleActive');
            Route::get('/stream/{xvalue}', 'stream')->name('admin.music.stream');
        });
        //route package management
        Route::controller(PackageController::class)->prefix('package')->group(function () {
            Route::get('/', 'index')->name('admin.package');
            Route::post('/list', 'listData');
            Route::post('/save', 'store');
            Route::post('/edit', 'edit');
            Route::post('/update', 'update');
            Route::post('/change-status', 'changeStatus');
        });
    });
});
