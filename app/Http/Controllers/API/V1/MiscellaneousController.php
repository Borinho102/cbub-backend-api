<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Country;
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
        $query = $request->get('q');
        $countries = Country::active()->when($query, function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%');
            $q->orWhere('code', $query);
        })->get();

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
        $query = $request->has('q');
        $country = Country::find($country);

        if ($country) {
            $cities = $country->children();
            if ($query) {
                $cities = $cities->where('name', $query);
            }
        }

        if (sizeof($cities) > 0) {
            $cities = $cities->transform(function ($city) {
                return [
                    'id' => $city->id,
                    'name' => $city->name,
                    'code' => $city->code,
                ];
            });
        }

        return response($cities);
    }
}
