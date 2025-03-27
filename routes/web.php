<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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

    Route::get('/login/facebook', [AuthController::class, 'redirectToFacebook'])->name('login.facebook');
    Route::get('/login/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

    Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

Route::middleware('user.auth')->group(function () {
    Route::post('/dang-xuat', [AuthController::class, 'logout'])->name('logout');
});

Route:: as('product.')->group(function () {
    Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('show');
});

Route:: as('cart.')->group(function () {
    Route::get('/gio-hang', [CartController::class, 'index'])->name('index');
    Route::post('/gio-hang', [CartController::class, 'addToCart'])->name('add');
    Route::put('/gio-hang/cap-nhat', [CartController::class, 'update'])->name('update');
    Route::delete('/gio-hang/xoa', [CartController::class, 'remove'])->name('remove');
    Route::get('/gio-hang/lam-moi', [CartController::class, 'refresh'])->name('refresh');
});