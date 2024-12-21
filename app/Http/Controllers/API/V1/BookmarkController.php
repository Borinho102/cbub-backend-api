<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\BookmarkResource;
use App\Models\Bookmark;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class BookmarkController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bookmarks = Bookmark::query()
            ->with('item.media')
            ->where('user_id', auth('api')->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(request('page_size', 10))
            ->through(function ($bookmark) {
                return BookmarkResource::make($bookmark);
            });

        return $this->successfulResponse(
            $bookmarks,
            'BOOKMARKS_RETRIEVED',
            'Bookmarks successfully retrieved'
        );
    }

     /**
     * Add or remove the specified resource from the bookmark list
     */
    public function bookmarkProduct(string $id)
    {
        $product = Product::findOrFail($id);

        $bookmark = Bookmark::firstOrCreate([
            'item_id' => $product->id,
            'item_type' => Product::class,
            'user_id' => auth('api')->user()->id
        ], []);

        if (!$bookmark->wasRecentlyCreated) {
            $bookmark->delete();
            return response([
                'data' => true,
                'code' => 'BOOKMARK_REMOVED',
                'message' => 'Product successfully remove from bookmark!'
            ]);
        }

        return response([
            'data' => BookmarkResource::make($bookmark),
            'code' => 'BOOKMARK_ADDED',
            'message' => 'Product successfully bookmarked!'
        ]);
    }

      /**
     * Add or remove the specified resource from the bookmark list
     */
    public function bookmarkShop(string $id)
    {
        $shop = Shop::findOrFail($id);

        $bookmark = Bookmark::firstOrCreate([
            'item_id' => $shop->id,
            'item_type' => Shop::class,
            'user_id' => auth('api')->user()->id
        ], []);

        if (!$bookmark->wasRecentlyCreated) {
            $bookmark->delete();
            return $this->successfulResponse(
                true,
                'BOOKMARK_REMOVED',
                'Shop successfully remove from bookmark!'
            );
        }

        return $this->successfulResponse(
            BookmarkResource::make($bookmark),
            'BOOKMARK_ADDED',
            'Shop successfully bookmarked!'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bookmark = Bookmark::where('user_id', auth('api')->user()->id)
            ->findOrFail($id);

        $bookmark->delete();

        return $this->successfulResponse(
            true,
            'BOOKMARK_REMOVED',
            'Favorite successfully removed!'
        );
    }
}
