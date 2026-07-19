<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\LandingPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

*/

// Root redirect to admin login
Route::get('/', function () {
    return redirect()->route('admin.login');
});

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
        Route::get('/view',   [LandingPageController::class, 'view'])   ->name('view');
        Route::get('/edit',   [LandingPageController::class, 'edit'])   ->name('edit');
        Route::post('/update',[LandingPageController::class, 'update']) ->name('update');
        Route::get('/serve',  [LandingPageController::class, 'serve'])  ->name('serve');
    });
});
