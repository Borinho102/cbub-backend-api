<?php

use App\Models\Business;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;


if (!function_exists('page_direction')) {
    /**
     * Gets application page direction either rtl or ltr
     * Default is ltr.
     *
     * @return string
     */
    function page_direction(): string
    {
        $rtl_locales = config('app.rtl_locales', ['ae', 'he']);
        return in_array(app()->getLocale(), $rtl_locales) ? "rtl" : "ltr";
    }
}

if (!function_exists('redirectWithoutInertia')) {
    /**
     * Redirects without inertia
     * @param string $url
     * @return string
     */
    function redirectWithoutInertia(string $url): string
    {
        return response('', Response::HTTP_CONFLICT)
            ->header('x-inertia-location', $url);
    }
}

if (!function_exists('cbubGuard')) {
    /**
     * Returns the active waspito guard
     */
    function cbubGuard()
    {
        foreach (array_keys(config('auth.guards')) as $guard) {
            if (auth()->guard($guard)->check()) return $guard;
        }
        return null;
    }
}

if (!function_exists('generateBusinessSlug')) {
    /**
     * @param string $countryCode
     * @param string $name
     * @param string $except
     * @return string
     */
    function generateBusinessSlug(string $countryCode, string $name, string $except = null): string
    {
        $slug = Str::slug($name) . '-' . Str::lower($countryCode);
        $exists = Business::when($except, function ($q) use ($except) {
            $q->where('slug', '!=', $except);
        })->whereSlug($slug)->exists();

        while ($exists) {
            $slug = Str::slug($name) . '-' . Str::random(4) . '-' . Str::lower($countryCode);
        }

        return $slug;
    }
}

if (!function_exists('supportedLocales')) {
    /**
     *
     * Returns all supported locales of the application
     * @return Illuminate\Support\Collection
     */
    function supportedLocales() : Collection
    {
        $locales = collect(array_keys(config('app.supported_locales')))
            ->transform(function ($key) {
                return [
                    'name' => __('general.'.$key),
                    'code' => $key,
                    'flag' => asset('flags/'. $key .'.svg')
                ];
            });

        return $locales;
    }
}

if (!function_exists('generateUserCode')) {
    /**
     * Generate user client ID.
     * @return string
     */
    function generateUserCode (): string
    {
        return Str::upper(uniqid("CB"));
    }
}


if (!function_exists('getPhoneNumberProvider'))
{
    function getPhoneNumberProvider($phone_number) : string
    {
        $mtn_regx = '/^(65[0-4]{1}\d{6}|68[0-4]{1}\d{6}|67\d{7})$/';
        $orange_regx = '/^(65[5-9]\d{6}|69\d{7})$/';

        if (preg_match($mtn_regx, $phone_number)) {
            return 'mtn';
        }

        if (preg_match($orange_regx, $phone_number)) {
            return 'orange';
        }

        return 'unknown provider';
    }
}

if (!function_exists('generateUniqueOtpCode'))
{
    function generateUniqueOtpCode($partner = null) : int
    {
        // do {
        //     $code = rand(100000, 999999);
        // } while (TRUE);

        return rand(100000, 999999);
    }
}

