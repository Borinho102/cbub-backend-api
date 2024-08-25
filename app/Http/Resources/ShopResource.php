<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\OpeningHours\OpeningHours;

class ShopResource extends JsonResource
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
            'slug' => $this->slug,
            'image' => $this->logo,
            'images' => [
                $this->logo
            ],
            'address' => $this->address,
            'lng' => $this->whenHas('location', fn () => $this->location?->latitude),
            'lat' => $this->whenHas('location', fn () => $this->location?->longitude),
            'phone' => $this->phone,
            'email' => $this->email,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'currency' => $this->currency?->code,
            'about' => $this->whenHas('about', fn () => $this->about),
            'schedule' => $this->whenHas('schedule', fn () => $this->schedule),
            'distance' => $this->whenHas('distance', function () {
                return (int) ($this->distance / 1000);
            }),
            'is_open' => isset($this->schedule) ?
                OpeningHours::create($this->schedule)->isOpen() : true,
            'bookmarked' => $this->whenHas('bookmarked', fn() => (bool) $this->bookmarked),
            'reviews_count' => $this->whenCounted('reviews'),
            'rating_average' => $this->when(isset($this->rating_avg), fn () => (int) $this->rating_avg),
            'website' => $this->website,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'youtube' => $this->youtube,
            'products' => $this->whenLoaded('products', fn () => ProductResource::collection($this->products)),
            'products' => $this->whenLoaded('popularProducts', fn () => ProductResource::collection($this->popularProducts)),
        ];
    }
}
