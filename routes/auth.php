<?php

use App\Http\Controllers\Auth\Business\AuthenticatedSessionController;
use App\Http\Controllers\Auth\Business\ConfirmablePasswordController;
use App\Http\Controllers\Auth\Business\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\Business\EmailVerificationPromptController;
use App\Http\Controllers\Auth\Business\NewPasswordController;
use App\Http\Controllers\Auth\Business\PasswordController;
use App\Http\Controllers\Auth\Business\PasswordResetLinkController;
use App\Http\Controllers\Auth\Business\VerifyEmailController;

use App\Http\Controllers\Auth\Admin\AuthenticatedSessionController as AdminAuthenticatedSessionController;
use App\Http\Controllers\Auth\Admin\ConfirmablePasswordController as AdminConfirmablePasswordController;
use App\Http\Controllers\Auth\Admin\EmailVerificationNotificationController as AdminEmailVerificationNotificationController;
use App\Http\Controllers\Auth\Admin\EmailVerificationPromptController as AdminEmailVerificationPromptController;
use App\Http\Controllers\Auth\Admin\NewPasswordController as AdminNewPasswordController;
use App\Http\Controllers\Auth\Admin\PasswordController as AdminPasswordController;
use App\Http\Controllers\Auth\Admin\PasswordResetLinkController as AdminPasswordResetLinkController;
use App\Http\Controllers\Auth\Admin\VerifyEmailController as AdminVerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['web', 'localization']
], function () {
    Route::group([
        'as' => 'guest.',
        'middleware' => 'guest:business,admins',
    ], function () {
        // login & password reset routes for business user
        Route::group([
            'prefix' => 'business.portal.66/console',
            'as' => 'business.',
            'middleware' => 'guest:business',
        ], function () {
            Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
            Route::post('login', [AuthenticatedSessionController::class, 'store']);
            Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');
            Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');
            Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');
            Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
        });

        // login & password reset routes for admin user
        Route::group([
            'prefix' => 'secure.portal.99/console',
            'as' => 'admin.',
            'middleware' => 'guest:admins',
        ], function () {
            Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])
                ->name('login');
            Route::post('login', [AdminAuthenticatedSessionController::class, 'store']);
            Route::get('forgot-password', [AdminPasswordResetLinkController::class, 'create'])
                ->name('password.request');
            Route::post('forgot-password', [AdminPasswordResetLinkController::class, 'store'])
                ->name('password.email');
            Route::get('reset-password/{token}', [AdminNewPasswordController::class, 'create'])
                ->name('password.reset');
            Route::post('reset-password', [AdminNewPasswordController::class, 'store'])
                ->name('password.store');
        });
    });

    Route::group([
        'prefix' => 'business.portal.66/console',
        'as' => 'business.',
        'middleware' => 'auth:business'
    ], function () {
        Route::get('verify-email', EmailVerificationPromptController::class)
            ->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');
        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
        Route::put('password', [PasswordController::class, 'update'])
            ->name('password.update');
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });

    Route::group([
        'prefix' => 'secure.portal.99/console',
        'as' => 'admin.',
        'middleware' => 'auth:admins'
    ], function () {
        Route::get('verify-email', AdminEmailVerificationPromptController::class)
            ->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', AdminVerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
        Route::post('email/verification-notification', [AdminEmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');
        Route::get('confirm-password', [AdminConfirmablePasswordController::class, 'show'])
            ->name('password.confirm');
        Route::post('confirm-password', [AdminConfirmablePasswordController::class, 'store']);
        Route::put('password', [AdminPasswordController::class, 'update'])
            ->name('password.update');
        Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
    });
});

