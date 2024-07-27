<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Business;
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
        $countries = Country::active()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
                $q->orWhere('code', $query);
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

        if ($country) {
            $cities = $country->cities()
                ->when(isset($search) && !empty($search), function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
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
     * Returns all the product categories
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function searchProductCategories(Request $request): Response|Application|ResponseFactory
    {
        $guard = appGuard();
        $business = request('business');
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
        $business = request('business');
        $shop = request('shop');
        $guard = appGuard();

        $products = Product::select('id', 'name')
            ->search()
            ->where('is_active', 1)
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
        $business = request('business');
        $shop = request('shop');
        $guard = appGuard();

        $promo_codes = PromoCode::select('id', 'title', 'code')
            ->search()
            ->where('is_active', 1)
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
        $guard = appGuard();
        $business = request('business');
        $shop = request('shop');

        $data = User::query()
            ->select('id', 'name')
            ->withoutAppends()
            ->when($query != null, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->when($shop || $business || $guard === 'business', function ($q) use ($shop, $business, $guard) {
                $q->whereHas('orders', function ($q) use ($shop, $business, $guard) {
                    $q->whereHas('items', function ($q) use ($shop, $business, $guard) {
                        if ($guard === 'business') {
                            $q->where('business_id', auth()->user()->business_id);
                        } else if ($business) {
                            $q->where('business_id', $business);
                        }

                        if ($shop) {
                            $q->where('shop_id', $shop);
                        }
                    });
                });
            })
            ->limit(10)
            ->get()
            ->transform(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name
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

        $data = User::query()
            ->select('id', 'name')
            ->whereHas('customers', function ($q) use ($guard, $business) {
                if ($guard === 'business') {
                    $q->where('business_id', auth()->user()->business_id);
                } else {
                    $q->where('business_id', $business);
                }
            })
            ->withoutAppends()
            ->when($query != null, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->limit(10)
            ->get()
            ->transform(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name
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

        $data = Business::query()
            ->select('id', 'name')
            ->when($query != null, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
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
