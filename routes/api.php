<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\NotificationController;
use App\Http\Controllers\API\V1\MiscellaneousController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ======================================
// API Routes
// ======================================

Route::group([
    'prefix' => 'v1',
    'namespace' => 'API',
    'as' => 'api.',
    'middleware' => ['json.response']
], function () {
    // ======================================
    // Auth Routes
    // ======================================
    Route::post('auth/login', [AuthController::class, 'login'])->name('login');
    Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.request.send');

    // ======================================
    // Miscellaneous Routes
    // ======================================
    Route::group([
        'prefix' => 'misc',
        'as' => 'misc.',
        'middleware' => ['api.basic.access']
    ], function () {
        Route::get('countries/load', [MiscellaneousController::class, 'loadCountries'])
            ->name('countries.load');
        Route::get('cities/{country}/load', [MiscellaneousController::class, 'loadCities'])
            ->name('cities.load');
    });

    // ======================================
    // API FOR USERS
    // ======================================
    Route::group([
        'prefix' => 'users.console98',
        'middleware' => ['auth:sanctum']
    ], function () {
        Route::post('auth/logout', [AuthController::class, 'logout'])
            ->name('auth.logout');
        Route::get('auth/user/data', [AuthController::class, 'getAuthenticatedUserData'])
            ->name('auth.user.data');

        # ============== NOTIFICATIONS ROUTES ==============
        Route::get('notifications/data/load', [NotificationController::class, 'index'])
            ->name('notifications.data');
        Route::get('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.read');
    });

});
