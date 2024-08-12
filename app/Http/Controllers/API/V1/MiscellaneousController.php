<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ShopCategoryResource;
use App\Models\BusinessCategory;
use App\Models\Country;
use App\Models\ProductCategory;
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
    public function getCountries(Request $request): Response|Application|ResponseFactory
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
    public function getCountryCities(Request $request, string $country): Response|Application|ResponseFactory
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
     * Returns all shop/business categories
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function getShopCategories(Request $request): Response|Application|ResponseFactory
    {
        $query = $request->get('q');
        $categories = BusinessCategory::select('id', 'name', 'code')
            ->where('is_active', 1)
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('code', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            })->get()
            ->transform(function ($category) {
                return ShopCategoryResource::make($category);
            });

        return response($categories);
    }

    /**
     * Returns all products categories
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function getProductCategories(Request $request): Response|Application|ResponseFactory
    {
        $query = $request->get('q');
        $categories = ProductCategory::select('id', 'name', 'description', 'code')
            ->where('is_active', 1)
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('code', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            })->get()
            ->transform(function ($category) {
                return ProductCategoryResource::make($category);
            });

        return response($categories);
    }
}
