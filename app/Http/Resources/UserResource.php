<?php

namespace App\Http\Resources;

use App\Services\Utils\Initials;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'initials' => Initials::generate($this->first_name . ' ' . $this->last_name),
            'image' => $this->image,
            'email' => $this->email,
            'phone' => $this->phone,
            'dail_code' => $this->dail_code,
            'language' => $this->language,
            'country' => $this->whenLoaded('country', fn () => CountryResource::make($this->country)),
            'city' => $this->whenLoaded('city', fn () => CityResource::make($this->city)),
            'email_verified_at' => $this->email_verified_at,
            'phone_verified_at' => $this->phone_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
