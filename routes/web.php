<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('', HomeController::class)->name('index');

Route::group([
    'prefix' => 'secure.portal.99/console',
    'middleware' => 'auth:admins',
    'as' => 'admin.',
], function () {
    Route::get('', AdminDashboardController::class)
        ->middleware(['verified'])->name('dashboard');

    Route::get('/profile', [AdminProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [AdminProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::group([
    'prefix' => 'business.portal.66/console',
    'middleware' => 'auth:users',
    'as' => 'user.',
], function () {
    Route::get('', DashboardController::class)
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
