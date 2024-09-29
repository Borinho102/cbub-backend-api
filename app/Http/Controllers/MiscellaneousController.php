<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\PromoCode;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MiscellaneousController extends Controller
{
    /**
     * Returns all countries considering the slug
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function searchCountries(Request $request): Response|Application|ResponseFactory
    {
        $query = $request->get('search');
        $selected = $request->get('selected', []);
        
        $countries = Country::active()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('code', $query);
            })
            ->when(is_array($selected) && !empty($selected), function ($q) use ($selected) {
                $q->whereIn('id', $selected);
            })
            ->get()
            ->transform(function (Country $country) {
                return [
                    'id' => $country->id,
                    'name' => $country->name,
                    'code' => $country->code,
                    'flag' => $country->emoji,
                    'currency' => $country->currency_code,
                    'currency_name' => $country->currency_name,
                    'dial_code' => $country->callingcode,
                ];
            });
        return response($countries);
    }

    /**
     * Returns all cities belonging to a particular country
     * @param Request $request
     * @param string $country
     * @return Application|ResponseFactory|Response
     */
    public function searchCountryCities(Request $request, string $country): Response|Application|ResponseFactory
    {
        $cities = [];
        $search = $request->get('search');
        $country = Country::find($country);
        $selected = $request->get('selected', []);

        if ($country) {
            $cities = $country->cities()
                ->when(isset($search) && !empty($search), function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->when(is_array($selected) && !empty($selected), function ($q) use ($selected) {
                    $q->whereIn('id', $selected);
                })
                ->get()
                ->transform(function ($city) {
                    return [
                        'id' => $city->id,
                        'name' => $city->name,
                        'code' => $city->code,
                    ];
                });
        }

        return response($cities);
    }

    /**
     * Returns all the product categories matching the search query
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function searchProductCategories(Request $request): Response|Application|ResponseFactory
    {
        $guard = appGuard();
        $business = $request->get('business');
        $selected = $request->get('selected', []);

        $categories = ProductCategory::query()
            ->select('id', 'name', 'parent_id', 'code')
            ->search()
            ->where('is_active', 1)
            ->when($business && $guard != 'business', function ($q) use ($business) {
                $q->where('business_id', $business);
            })
            ->when(!$business, function ($q) use ($guard) {
                $q->where(function ($q) use ($guard) {
                    if ($guard === 'business') {
                        $q->where('business_id', auth()->user()->business_id)
                            ->orWhereNull('business_id');
                    } else {
                        $q->whereNull('business_id');
                    }
                });
            })
            ->when(is_array($selected) && !empty($selected), function ($q) use ($selected) {
                $q->whereIn('id', $selected);
            })
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get()
            ->transform(function ($category) {
                return [
                    'id' => $category->id,
                    'code' => $category->code,
                    'name' => $category->name
                ];
            });

        return response($categories);
    }

    /**
     * Returns all the business categories matching the search query
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function searchBusinessCategories(Request $request): Response|Application|ResponseFactory
    {
        $selected = $request->get('selected', []);

        $categories = BusinessCategory::query()
            ->select('id', 'name', 'code')
            ->search()
            ->where('is_active', 1)
            ->when(is_array($selected) && !empty($selected), function ($q) use ($selected) {
                $q->whereIn('id', $selected);
            })
            ->orderBy('name', 'asc')
            ->limit(10)
            ->get()
            ->transform(function ($category) {
                return [
                    'id' => $category->id,
                    'code' => $category->code,
                    'name' => $category->name
                ];
            });

        return response($categories);
    }

    /**
     * Returns all the product categories
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function searchProducts(Request $request): Response|Application|ResponseFactory
    {
        $guard = appGuard();
        $business = $request->get('business');
        $shop = $request->get('shop');
        $selected = $request->get('selected', []);

        $products = Product::select('id', 'name')
            ->search()
            ->where('is_active', 1)
            ->when(is_array($selected) && !empty($selected), function ($q) use ($selected) {
                $q->whereIn('id', $selected);
            })
            ->when($business && $guard != 'business', function ($q) use ($business) {
                $q->where('business_id', $business);
            })
            ->when(!$business && $guard === 'business', function ($q) {
                $q->where(function ($q) {
                    $q->where('business_id', auth()->user()->business_id);
                });
            })
            ->when($shop, function ($q) use ($shop) {
                $q->where('shop_id', $shop);
            })
            ->limit(10)
            ->get()
            ->transform(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'thumbnail' => $product->thumbnail
                ];
            });

        return response($products);
    }

    /**
     * Search promo codes
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function searchPromoCodes(Request $request): Response|Application|ResponseFactory
    {
        $business = $request->get('business');
        $shop = $request->get('shop');
        $selected = $request->get('selected', []);
        $guard = appGuard();

        $promo_codes = PromoCode::select('id', 'title', 'code')
            ->search()
            ->where('is_active', 1)
            ->when(is_array($selected) && !empty($selected), function ($q) use ($selected) {
                $q->whereIn('id', $selected);
            })
            ->when(isset($business) && $guard != 'business', function ($q) use ($business) {
                $q->where('business_id', $business);
            })
            ->when(!isset($business) && $guard === 'business', function ($q) {
                $q->where(function ($q) {
                    $q->where('business_id', auth()->user()->business_id);
                });
            })
            ->when(isset($shop), function ($q) use ($shop) {
                $q->where('shop_id', $shop);
            })
            ->limit(10)
            ->get()
            ->transform(function ($promo_code) {
                return [
                    'id' => $promo_code->id,
                    'name' => $promo_code->title . '(' . $promo_code->code . ')'
                ];
            });

        return response($promo_codes);
    }

    /**
     * Search users
     *
     * @param Request $request
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('search');
        $business = $request->get('business');
        $shop = $request->get('shop');
        $selected = $request->get('selected', []);
        $guard = appGuard();

        $data = User::query()
            ->select('id', 'first_name', 'last_name')
            ->withoutAppends()
            ->when($query != null, function ($q) use ($query) {
                $q->where(function ($q) use ($query) {
                    $q->where('first_name', 'like', "%$query%")
                        ->orWhere('last_name', 'like', "%$query%")
                        ->orWhere('email', 'like', "%$query%")
                        ->orWhere('phone', 'like', "%$query%");
                });
            })
            ->when($shop || $business || $guard === 'business', function ($q) use ($shop, $business, $guard) {
                $q->whereHas('orders', function ($q) use ($business, $shop, $guard) {
                    if ($shop) {
                        $q->where('shop_id', $shop);
                    } else {
                        $q->where('business_id', $business ?: auth($guard)->user()->business_id);
                    }
                });
            })
            ->when(is_array($selected) && !empty($selected), function ($q) use ($selected) {
                $q->whereIn('id', $selected);
            })
            ->limit(10)
            ->get()
            ->transform(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name
                ];
            });

        return response($data);
    }

    /**
     * Search customers
    */
    public function searchCustomers()
    {
        $query = request('search');
        $guard = appGuard();
        $business = request('business');
        $selected = request('selected', []);

        $data = User::query()
            ->select('id', 'first_name', 'last_name')
            ->whereHas('customers', function ($q) use ($guard, $business) {
                if ($guard === 'business') {
                    $q->where('business_id', auth($guard)->user()->business_id);
                } else {
                    $q->where('business_id', $business);
                }
            })
            ->withoutAppends()
            ->when($query != null, function ($q) use ($query) {
                $q->where(function ($q) use ($query) {
                    $q->where('first_name', 'like', "%$query%")
                        ->orWhere('last_name', 'like', "%$query%")
                        ->orWhere('email', 'like', "%$query%")
                        ->orWhere('phone', 'like', "%$query%");
                });
            })
            ->when(is_array($selected) && !empty($selected), function ($q) use ($selected) {
                $q->whereIn('id', $selected);
            })
            ->limit(10)
            ->get()
            ->transform(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name
                ];
            });

        return response($data);
    }

    /**
     * Search businesses
     *
     * @param Request $request
     */
    public function searchBusinesses(Request $request)
    {
        $query = $request->get('search');
        $selected = $request->get('selected', []);

        $data = Business::query()
            ->select('id', 'name')
            ->when($query != null, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->when(is_array($selected) && !empty($selected), function ($q) use ($selected) {
                $q->whereIn('id', $selected);
            })
            ->limit(10)
            ->get()
            ->transform(function ($business) {
                return [
                    'id' => $business->id,
                    'name' => $business->name,
                    'logo' => $business->logo
                ];
            });
        return response($data);
    }

    /**
     * Search shops
     *
     * @param Request $request
     */
    public function searchShops(Request $request)
    {
        $query = $request->get('search');
        $business = request('business');
        $shop = request('shop');
        $guard = appGuard();

        $data = Shop::query()
            ->select('id', 'name')
            ->when($query != null, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->when(true, function ($q) use ($guard, $business, $shop) {
                if ($guard === 'business') {
                    $q->where('business_id', auth()->user()->business_id);
                } else if ($business) {
                    $q->where('business_id', $business);
                }

                if ($shop) {
                    $q->where('id', $shop);
                }
            })
            ->limit(10)
            ->get()
            ->transform(function ($business) {
                return [
                    'id' => $business->id,
                    'name' => $business->name,
                    'logo' => $business->logo
                ];
            });
        return response($data);
    }
}
