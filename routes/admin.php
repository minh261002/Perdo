<?php

use Illuminate\Support\Facades\Route;

use App\Admin\Http\Controllers\Auth\AuthController;
use App\Admin\Http\Controllers\Dashboard\DashboardController;
use App\Admin\Http\Controllers\Module\ModuleController;
use App\Admin\Http\Controllers\Permission\PermissionController;
use App\Admin\Http\Controllers\Role\RoleController;
use App\Admin\Http\Controllers\Admin\AdminController;
use App\Admin\Http\Controllers\User\UserController;

Route::prefix('admin')->as('admin.')->group(function () {

    Route::middleware('admin.login')->group(function () {
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');

        Route::get('/password/forgot', [AuthController::class, 'forgotPassword'])->name('password.forgot');
    });

    Route::middleware('admin.auth')->group(function () {
        Route::get('/dasboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Module
        Route::prefix('module')->as('module.')->group(function () {
            Route::middleware(['permission:viewModule'])->group(function () {
                Route::get('/', [ModuleController::class, 'index'])->name('index');
            });

            Route::middleware(['permission:createModule'])->group(function () {
                Route::get('/create', [ModuleController::class, 'create'])->name('create');
                Route::post('/store', [ModuleController::class, 'store'])->name('store');
            });

            Route::middleware(['permission:editModule'])->group(function () {
                Route::get('/edit/{id}', [ModuleController::class, 'edit'])->name('edit');
                Route::put('/update', [ModuleController::class, 'update'])->name('update');
            });

            Route::middleware(['permission:deleteModule'])->group(function () {
                Route::delete('/delete/{id}', [ModuleController::class, 'delete'])->name('delete');
            });
        });

        // Permission
        Route::prefix('permission')->as('permission.')->group(function () {
            Route::middleware(['permission:viewPermission'])->group(function () {
                Route::get('/', [PermissionController::class, 'index'])->name('index');
            });

            Route::middleware(['permission:createPermission'])->group(function () {
                Route::get('/create', [PermissionController::class, 'create'])->name('create');
                Route::post('create', [PermissionController::class, 'store'])->name('store');
            });

            Route::middleware(['permission:editPermission'])->group(function () {
                Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('edit');
                Route::put('/update', [PermissionController::class, 'update'])->name('update');
            });

            Route::middleware(['permission:deletePermission'])->group(function () {
                Route::delete('/{id}', [PermissionController::class, 'delete'])->name('delete');
            });
        });

        //Role
        Route::prefix('role')->as('role.')->group(function () {
            Route::middleware(['permission:viewRole'])->group(function () {
                Route::get('/', [RoleController::class, 'index'])->name('index');
            });

            Route::middleware(['permission:createRole'])->group(function () {
                Route::get('/create', [RoleController::class, 'create'])->name('create');
                Route::post('create', [RoleController::class, 'store'])->name('store');
            });

            Route::middleware(['permission:editRole'])->group(function () {
                Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
                Route::put('/update', [RoleController::class, 'update'])->name('update');
            });

            Route::middleware(['permission:deleteRole'])->group(function () {
                Route::delete('/{id}', [RoleController::class, 'delete'])->name('delete');
            });
        });

        //Admin
        Route::prefix('admin')->as('admin.')->group(function () {
            Route::middleware(['permission:viewAdmin'])->group(function () {
                Route::get('/', [AdminController::class, 'index'])->name('index');
            });

            Route::middleware(['permission:createAdmin'])->group(function () {
                Route::get('create', [AdminController::class, 'create'])->name('create');
                Route::post('create', [AdminController::class, 'store'])->name('store');
            });

            Route::middleware(['permission:editAdmin'])->group(function () {
                Route::get('edit/{id}', [AdminController::class, 'edit'])->name('edit');
                Route::put('/update', [AdminController::class, 'update'])->name('update');
            });

            Route::middleware(['permission:deleteAdmin'])->group(function () {
                Route::delete('/{id}', [AdminController::class, 'delete'])->name('delete');
            });
        });

        //User
        Route::prefix('user')->as('user.')->group(function () {
            Route::middleware(['permission:viewCustomer'])->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
            });

            Route::middleware(['permission:createCustomer'])->group(function () {
                Route::get('create', [UserController::class, 'create'])->name('create');
                Route::post('create', [UserController::class, 'store'])->name('store');
            });

            Route::middleware(['permission:editCustomer'])->group(function () {
                Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
                Route::put('/update', [UserController::class, 'update'])->name('update');
                Route::patch('/update-status', [UserController::class, 'updateStatus'])->name('update.status');
            });

            Route::middleware(['permission:deleteCustomer'])->group(function () {
                Route::delete('/{id}', [UserController::class, 'delete'])->name('delete');
            });
        });
    });
});