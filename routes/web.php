<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');
    Route::post('/switch-user', [LoginController::class, 'switchUser'])->name('login.switch_user');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/show', [DashboardController::class, 'show'])->name('dashboard.show');
    Route::get('/dashboard/edit', [DashboardController::class, 'edit'])->name('dashboard.edit');
    Route::put('/dashboard/update', [DashboardController::class, 'update'])->name('dashboard.update');

    Route::resource('/user', UserController::class)->middleware('role:Superadmin');
    
    Route::resource('/menu', \App\Http\Controllers\MenuController::class)->middleware('role:Superadmin,Admin');
    Route::resource('/package', \App\Http\Controllers\PackageController::class)->middleware('role:Superadmin,Admin');
    
    Route::resource('/order', \App\Http\Controllers\OrderController::class)->only(['index', 'show'])->middleware('role:Superadmin,Admin,Staff');
    Route::patch('/order/{order}/status', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('order.status')->middleware('role:Superadmin,Admin');

    Route::get('/delivery', [\App\Http\Controllers\DeliveryScheduleController::class, 'index'])->name('delivery.index')->middleware('role:Superadmin,Admin,Staff');
    Route::patch('/delivery/{delivery}/status', [\App\Http\Controllers\DeliveryScheduleController::class, 'updateStatus'])->name('delivery.status')->middleware('role:Superadmin,Admin,Staff');

    Route::get('/katalog', [\App\Http\Controllers\KatalogController::class, 'index'])->name('katalog.index');
    Route::resource('/myorder', \App\Http\Controllers\MyOrderController::class)->only(['index', 'show'])->middleware('role:Customer');
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/{setting}/update', [SettingController::class, 'update'])->name('setting.update');
});
