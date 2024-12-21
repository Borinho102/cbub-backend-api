<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()
            ->withCount('reviews')
            ->with(['active_discount', 'category', 'media'])
            ->withAverageRating()
            ->withBookmarkedColumn()
            ->search()
            ->when($shop = request('shop'), function ($q) use ($shop) {
                $q->where('shop_id', $shop);
            })
            ->when($category = request('category'), function ($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->paginate(request('page_size', 10))
            ->through(function ($product) {
                return ProductResource::make($product);
            });

        return $this->successfulResponse(
            $products,
            'PRODUCTS_RETRIEVED',
            'Products successfully retrieved'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::query()
            ->withCount('reviews')
            ->withBookmarkedColumn()
            ->with([
                'active_discount', 'category',
                'media', 'shop.media'
            ])
            ->withAverageRating()
            ->findOrFail($id);

        return $this->successfulResponse(
            ProductResource::make($product),
            'PRODUCT_RETRIEVED',
            'Product details successfully retrieved'
        );
    }
}
