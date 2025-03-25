<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('user.login')->group(function () {
    Route::get('/dang-nhap', [AuthController::class, 'login'])->name('login');
    Route::post('/dang-nhap', [AuthController::class, 'authenticate'])->name('authenticate');

    Route::get('/dang-ky', [AuthController::class, 'register'])->name('register');
    Route::post('/dang-ky', [AuthController::class, 'store'])->name('store');

    Route::get('/quen-mat-khau', [AuthController::class, 'forgotPassword'])->name('password.forgot');
    Route::post('/quen-mat-khau', [AuthController::class, 'sendPasswordResetLink'])->name('password.email');

    Route::get('/dat-lai-mat-khau', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::post('/dat-lai-mat-khau', [AuthController::class, 'updatePassword'])->name('password.update');

    Route::get('/dang-nhap/facebook', [AuthController::class, 'redirectToFacebook'])->name('login.facebook');
    Route::get('/dang-nhap/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

    Route::get('/dang-nhap/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/dang-nhap/google/callback', [AuthController::class, 'handleGoogleCallback']);
});