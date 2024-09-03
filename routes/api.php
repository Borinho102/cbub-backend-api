<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\BookmarkController;
use App\Http\Controllers\API\V1\DeliveryAddressController;
use App\Http\Controllers\API\V1\NotificationController;
use App\Http\Controllers\API\V1\MiscellaneousController;
use App\Http\Controllers\API\V1\OrderController;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\API\V1\ShopController;
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
    'as' => 'api.',
    'middleware' => ['json.response']
], function () {
    // ======================================
    // Auth Routes
    // ======================================
    Route::post('auth/login', [AuthController::class, 'login'])->name('login');
    Route::post('auth/register', [AuthController::class, 'register'])->name('register');
    Route::post('auth/send-otp-code', [AuthController::class, 'sendOtpCode'])->name('otp_code.send');
    Route::post('auth/verify-otp-code', [AuthController::class, 'verifyOtpCode'])->name('otp_code.verify');
    Route::post('auth/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

    // ======================================
    // Miscellaneous Routes
    // ======================================
    Route::group([
        'prefix' => 'misc',
        'as' => 'misc.',
    ], function () {
        Route::group([
            //'middleware' => ['api.basic.access']
        ], function () {
            Route::get('countries', [MiscellaneousController::class, 'getCountries'])
                ->name('countries');
            Route::get('cities/{country}', [MiscellaneousController::class, 'getCountryCities'])
                ->name('cities');
        });

        Route::group([
            'middleware' => ['auth:sanctum']
        ], function () {
            Route::get('shop-categories', [MiscellaneousController::class, 'getShopCategories'])
                ->name('shop_categories');
            Route::get('product-categories', [MiscellaneousController::class, 'getProductCategories'])
                ->name('product_categories');
        });
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
        Route::delete('auth/delete-account', [AuthController::class, 'deleteAccount'])
            ->name('auth.delete_account');
        Route::get('profile', [AuthController::class, 'getUserProfile'])
            ->name('auth.profile');
        Route::post('profile', [AuthController::class, 'updateUserProfile'])
            ->name('auth.profile.update');

        # ============== NOTIFICATIONS ROUTES ==============
        Route::get('notifications', [NotificationController::class, 'index'])
            ->name('notifications');
        Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.read');

        # ============== SHOPS ROUTES ==============
        Route::get('shops', [ShopController::class, 'index'])
            ->name('shops.index');
        Route::get('shops/{id}', [ShopController::class, 'show'])
            ->name('shops.show');
        Route::post('shops/{id}/bookmark', [BookmarkController::class, 'bookmarkShop'])
            ->name('shops.bookmark');

        # ============== PRODUCTS ROUTES ==============
        Route::get('products', [ProductController::class, 'index'])
            ->name('products.index');
        Route::get('products/{id}', [ProductController::class, 'show'])
            ->name('products.show');
        Route::post('products/{id}/bookmark', [BookmarkController::class, 'bookmarkProduct'])
            ->name('products.bookmark');

        # ============== ORDERS ROUTES ==============
        Route::get('orders', [OrderController::class, 'index'])
            ->name('orders.index');
        Route::get('orders/{id}', [OrderController::class, 'show'])
            ->name('orders.show');
        Route::post('orders', [OrderController::class, 'store'])
            ->name('orders.store');
        Route::put('orders/{id}', [OrderController::class, 'update'])
            ->name('orders.update');

        # ============== BOOKMARKS ROUTES ==============
        Route::get('bookmarks', [BookmarkController::class, 'index'])
            ->name('bookmarks.index');
        Route::delete('bookmarks/{id}', [BookmarkController::class, 'destroy'])
            ->name('bookmarks.delete');

        # ============== BOOKMARKS ROUTES ==============
        Route::get('delivery-addresses', [DeliveryAddressController::class, 'index'])
            ->name('delivery_addresses.index');
        Route::post('delivery-addresses', [DeliveryAddressController::class, 'store'])
            ->name('delivery_addresses.store');
        Route::put('delivery-addresses/{id}', [DeliveryAddressController::class, 'update'])
            ->name('delivery_addresses.update');
        Route::delete('delivery-addresses/{id}', [DeliveryAddressController::class, 'destroy'])
            ->name('delivery_addresses.delete');
    });
 });
