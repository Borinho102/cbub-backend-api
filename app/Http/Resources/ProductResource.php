<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'slug' => $this->slug,
            'weight' => $this->weight,
            'short_description' => $this->whenHas('short_description'),
            'description' => $this->whenHas('description'),
            'thumbnail' => $this->thumbnail,
            'images' => $this->images,
            'price' => (float) $this->price,
            'quantity' => (int) $this->quantity,
            'min_purchase_quantity' => (int) $this->min_purchase_quantity,
            'video_link' => $this->video_link,
            'video_provider' => $this->video_provider,
            'tags' => $this->tags,
            'refundable' => (bool) $this->refundable,
            'free_shipping' => (bool) $this->free_shipping,
            'category_id' => $this->category_id,
            'shop_id' => $this->shop_id,
            'discount' => $this->whenLoaded('active_discount', fn () => ProductDiscountResource::make($this->active_discount)),
            'type' => $this->type,
            'shop' => $this->whenLoaded('shop', fn () => ShopResource::make($this->shop)),
            'category' => $this->whenLoaded('category', fn () => ProductCategoryResource::make($this->category)),
            'bookmarked' => $this->whenHas('bookmarked', fn() => (bool) $this->bookmarked),
        ];
    }
}
