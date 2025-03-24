<?php

use App\Admin\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->as('admin.')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');

    Route::get('/password/forgot', [AuthController::class, 'forgotPassword'])->name('password.forgot');

});