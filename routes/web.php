<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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

    Route::prefix('thong-tin-ca-nhan')->as('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/', [ProfileController::class, 'update'])->name('update');

        Route::get('/doi-mat-khau', [ProfileController::class, 'changePasswordForm'])->name('change.password.form');
        Route::put('/doi-mat-khau', [ProfileController::class, 'changePassword'])->name('change.password');

        Route::get('/don-hang', [ProfileController::class, 'orders'])->name('orders');
        Route::get('/don-hang/{order_code}', [ProfileController::class, 'orderDetail'])->name('order.detail');
        Route::get('/don-hang/{order_code}/huy', [ProfileController::class, 'cancelOrder'])->name('order.cancel');

        Route::get('/ma-giam-gia', [ProfileController::class, 'discounts'])->name('discounts');
    });
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

Route:: as('checkout.')->group(function () {
    Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('index');
    Route::post('/thanh-toan', [CheckoutController::class, 'store'])->name('store');
    Route::get('/thanh-toan/{order_code}', [CheckoutController::class, 'review'])->name('review');

    Route::get('/vnpay/callback', [CheckoutController::class, 'vnpayCallback'])->name('vnpay.callback');
    Route::get('/momo/callback', [CheckoutController::class, 'momoCallback'])->name('momo.callback');
    Route::get('/payos/callback', [CheckoutController::class, 'payosCallback'])->name('payos.callback');
});

Route:: as('brand.')->group(function () {
    Route::get('/thuong-hieu/{slug}', [BrandController::class, 'index'])->name('index');
});

Route:: as('category.')->group(function () {
    Route::get('/danh-muc/{slug}', [CategoryController::class, 'index'])->name('index');
});