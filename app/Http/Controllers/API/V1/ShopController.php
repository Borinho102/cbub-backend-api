<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use MatanYadaev\EloquentSpatial\Objects\Point;

class ShopController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lat = request('lat');
        $lng = request('lng');

        $shops = Shop::query()
            ->withCount('reviews')
            ->with('media')
            ->withAverageRating()
            ->withBookmarkedColumn()
            ->when($search = request('search'), function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('address', 'like', '%' . $search . '%');
                });
            })
            ->when($categories = request('categories'), function ($q) use ($categories) {
                $q->whereHas('business', function ($q) use ($categories) {
                    $q->whereIn('category_id', explode(',', $categories));
                });
            })
            ->when(isset($lat) && isset($lng), function ($q) use ($lat, $lng) {
                $q->withDistance('location', new Point((float) $lat, (float) $lng, 4326), 'distance')
                    ->orderByDistance('location', new Point((float) $lat, (float) $lng, 4326), 'asc');
            })
            ->paginate(request('page_size', 10))
            ->through(function ($shop) {
                return ShopResource::make($shop);
            });

        return $this->successfulResponse(
            $shops,
            'SHOPS_RETRIEVED',
            'Shops successfully retrieved'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $shop = Shop::query()
            ->with('media')
            ->when($with = request('with'), function ($q) use ($with) {
                foreach (explode(',', $with) as $relationship) {
                    if ($relationship == 'popularProducts') {
                        $q->with('popularProducts.active_discount');
                    } else {
                        $q->with($relationship);
                    }
                }
            })
            ->withCount('reviews')
            ->withBookmarkedColumn()
            ->withAverageRating()
            ->findOrFail($id);

        return $this->successfulResponse(
            ShopResource::make($shop),
            'SHOP_RETRIEVED',
            'Shop details successfully retrieved'
        );
    }
}
