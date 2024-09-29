<?php

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Order;
use App\Models\OtpCode;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
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

if (!function_exists('appGuard')) {
    /**
     * Returns the active waspito guard
     */
    function appGuard()
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

if (!function_exists('generateShopSlug')) {
    /**
     * @param string $countryCode
     * @param string $name
     * @param string $except
     * @return string
     */
    function generateShopSlug(string $countryCode, string $name, string $except = null): string
    {
        $slug = Str::slug($name) . '-' . Str::lower($countryCode);
        $exists = Shop::when($except, function ($q) use ($except) {
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

if (!function_exists('generateProductCategoryCode')) {
    /**
     * @param string $name
     * @param string $except
     * @return string
     */
    function generateProductCategoryCode(string $name, $except = null): string
    {
        $code = Str::upper(Str::slug(Str::substr($name, 0, 10)));
        $exists = ProductCategory::when($except, function ($q) use ($except) {
            $q->where('code', '!=', $except);
        })->whereCode($code)->exists();

        while ($exists) {
            $code = Str::slug(Str::substr($name, 0, 10)) . Str::random(4);
        }

        return $code;
    }
}

if (!function_exists('generateBusinessCategoryCode')) {
    /**
     * @param string $name
     * @param string $except
     * @return string
     */
    function generateBusinessCategoryCode(string $name, $except = null): string
    {
        $code = Str::upper(Str::slug(Str::substr($name, 0, 10)));
        $exists = BusinessCategory::when($except, function ($q) use ($except) {
            $q->where('code', '!=', $except);
        })->whereCode($code)->exists();

        while ($exists) {
            $code = Str::slug(Str::substr($name, 0, 10)) . Str::random(4);
        }

        return $code;
    }
}

if (!function_exists('generateProductSlugEn')) {
    /**
     * @param string $name
     * @param string $except
     * @return string
     */
    function generateProductSlugEn(string $name, $except = null): string
    {
        $slug = Str::lower(Str::slug(Str::substr($name, 0, 10)));
        $exists = Product::when($except, function ($q) use ($except) {
            $q->where('slug->en', '!=', $except);
        })->whereSlug($slug)->exists();

        while ($exists) {
            $slug = Str::slug(Str::substr($name, 0, 10)) . Str::random(4);
        }

        return $slug;
    }
}

if (!function_exists('generateProductSlugFr')) {
    /**
     * @param string $name
     * @param string $except
     * @return string
     */
    function generateProductSlugFr(string $name, $except = null): string
    {
        $slug = Str::upper(Str::slug(Str::substr($name, 0, 10)));
        $exists = Product::when($except, function ($q) use ($except) {
            $q->where('slug->fr', '!=', $except);
        })->whereSlug($slug)->exists();

        while ($exists) {
            $slug = Str::slug(Str::substr($name, 0, 10)) . Str::random(4);
        }

        return $slug;
    }
}

if (!function_exists('generateOrderID')) {
    /**
     * @param ?string $prefix
     * @param string $except
     * @return string
     */
    function generateOrderID(string $prefix = null, $except = null): string
    {
        $orderID = fake()->unique()->randomNumber(6);
        $exists = Order::when($except, function ($q) use ($except) {
            $q->where('order_id', '!=', $except);
        })->where('order_id', $orderID)->exists();

        while ($exists) {
            return generateOrderID($prefix, $except);
        }

        return $orderID;
    }
}

if (!function_exists('randomBadgeColor')) {
    /**
     * @return string
     */
    function randomBadgeColor(): string
    {
        $colors = [
            'bg-emerald-100 dark:bg-emerald-400/30 text-emerald-600 dark:text-emerald-400',
            'bg-sky-100 dark:bg-sky-400/30 text-sky-600 dark:text-sky-400',
            'bg-stone-100 dark:bg-stone-800 text-stone-500 dark:text-stone-400'
        ];

        shuffle($colors);

        return $colors[random_int(0, count($colors) - 1)];
    }
}

if (!function_exists('generateUsername')) {
    /**
     * @param Illuminate\Foundation\Auth\User $model
     * @param string $username
     * @param string $except
     * @return string
     */
    function generateUsername(Authenticatable $model, $username, $except = null): string
    {
        $exists = $model::when($except, function ($q) use ($except) {
            $q->where('username', '!=', $except);
        })->where('username', $username)->exists();

        while ($exists) {
            return generateUsername($model, $username . random_int(10, 99), $except);
        }

        return $username;
    }
}

if (!function_exists('generateSlug')) {
    /**
     * @param Illuminate\Database\Eloquent\Model $model
     * @param string $name
     * @return string
     */
    function generateSlug(Model $model, $name): string
    {
        $slug = Str::slug($name);

        $exists = $model::where('slug', $slug)->exists();

        while ($exists) {
            return generateSlug($model, $name . random_int(1000, 9999));
        }

        return $slug;
    }
}

if (!function_exists('filterByPeriod')) {
    /**
     * @param $query
     * @param null $period
     * @param string $type
     * @return mixed
     */
    function filterByPeriod($query, $period = null, string $type = 'users')
    {
        $today = Carbon::today();
        switch ($period) {
            case 'this_year':
                $query = $query->whereYear($type.'.created_at', $today->year);
                break;
            case 'last_year':
                $query = $query->whereYear($type.'.created_at', $today->year - 1);
                break;
            case 'this_month':
                $query = $query->whereYear($type.'.created_at', $today->year)
                    ->whereMonth($type.'.created_at', $today->month);
                break;
            case 'last_month':
                $query = $query->whereYear($type.'.created_at', $today->year)
                    ->whereMonth($type.'.created_at', $today->month - 1);
                break;
            case 'this_week':
                $query = $query->whereBetween($type.'.created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;
            case 'last_week':
                $query = $query->whereBetween($type.'.created_at', [
                    Carbon::now()->subWeek()->startOfWeek(),
                    Carbon::now()->subWeek()->endOfWeek()
                ]);
                break;
            case 'today':
                $query = $query->whereDate($type.'.created_at', $today);
                break;
            default:
        }
        return $query;
    }

    if (!function_exists('generateUniqueOtpCode')){
        function generateUniqueOtpCode($user = null) : string
        {
            $digits = '0123456789';

            do {
                $digits = str_shuffle($digits);
                $code = substr($digits, 0, 6);
            } while (OtpCode::where('code', $code)->exists());

            return $code;
        }
    }
}
