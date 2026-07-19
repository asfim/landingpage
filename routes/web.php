<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\OrderSubmitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Root: show landing page to visitors
Route::get('/', [LandingPageController::class, 'serve'])->name('home');

// Public: order submission from landing page
Route::post('/order/submit', [OrderSubmitController::class, 'store'])->name('order.submit');

// Admin Auth Routes (guests only)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])
        ->name('admin.login');

    Route::post('/admin/login', [AdminLoginController::class, 'login'])
        ->name('admin.login.post');
});

// Admin Protected Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminLoginController::class, 'dashboard'])
        ->name('dashboard');

    Route::post('/logout', [AdminLoginController::class, 'logout'])
        ->name('logout');

    // Landing Page Management
    Route::prefix('landing-page')->name('landing-page.')->group(function () {
        Route::get('/view',           [LandingPageController::class, 'view'])          ->name('view');
        Route::get('/edit',           [LandingPageController::class, 'edit'])          ->name('edit');
        Route::post('/update',        [LandingPageController::class, 'update'])        ->name('update');
        Route::get('/serve',          [LandingPageController::class, 'serve'])         ->name('serve');
        Route::get('/serve-editable', [LandingPageController::class, 'serveEditable'])->name('serve-editable');
        Route::post('/upload-image',  [LandingPageController::class, 'uploadImage'])->name('upload-image');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/',                              [OrderController::class, 'index'])       ->name('index');
        Route::get('/{order}',                      [OrderController::class, 'show'])        ->name('show');
        Route::patch('/{order}/status',             [OrderController::class, 'updateStatus'])->name('status');
    });
});
