<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductCategory;
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
    public function loadCountries(Request $request): Response|Application|ResponseFactory
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
    public function loadCities(Request $request, string $country): Response|Application|ResponseFactory
    {
        $cities = [];
        $search = $request->has('search');
        $country = Country::find($country);
        if ($country) {
            $cities = $country->cities()->when($search, function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' .$search . '%');
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
        $categories = ProductCategory::query()
            ->select('id', 'name', 'parent_id', 'code')
            ->search()
            ->where('is_active', 1)
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
        $products = Product::select('id', 'name')
            ->search()
            ->where('is_active', 1)
            ->limit(10)
            ->get()
            ->transform(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->preview_image
                ];
            });

        return response($products);
    }

    /**
     * Search users
     *
     * @param Request $request
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('search');

        $data = User::query()
            ->select('id', 'name')
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
}
