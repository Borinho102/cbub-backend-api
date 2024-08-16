<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\BusinessUser;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function ($user, string $token) {
            if ($user instanceof BusinessUser)
                return route('guest.business.password.reset', ['token' => $token]);
            else if ($user instanceof Admin)
                return route('guest.admin.password.reset', ['token' => $token]);
        });

        VerifyEmail::createUrlUsing(function ($notifiable) {
            if ($notifiable instanceof BusinessUser)
                return URL::temporarySignedRoute(
                    'business.verification.verify',
                    Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                    [
                        'id' => $notifiable->getKey(),
                        'hash' => sha1($notifiable->getEmailForVerification()),
                    ]
                );
            else if ($notifiable instanceof Admin)
                return URL::temporarySignedRoute(
                    'admin.verification.verify',
                    Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                    [
                        'id' => $notifiable->getKey(),
                        'hash' => sha1($notifiable->getEmailForVerification()),
                    ]
                );
        });
    }
}
