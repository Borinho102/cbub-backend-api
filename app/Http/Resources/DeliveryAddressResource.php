<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryAddressResource extends JsonResource
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
            'name' => $this->full_name,
            'address' => $this->address,
            'phone' => $this->phone,
            'default' => (bool) $this->use_as_default,
            'user_id' => $this->user_id,
            'country_id' => $this->country_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'city_id' => $this->city_id,
            'country' => $this->whenLoaded('country', fn () => CountryResource::make($this->country)),
            'city' => $this->whenLoaded('city', fn () => CityResource::make($this->city)),
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
