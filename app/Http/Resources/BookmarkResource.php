<?php

namespace App\Http\Resources;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookmarkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->item instanceof Shop) {
            return [
                'id' => $this->id,
                'name' => $this->item->name,
                'image' => $this->item->logo,
                'description' => $this->item->about,
                'address' => $this->item->address,
                'item_id' => $this->item_id,
                'created_at' => $this->created_at->format('d/m/Y'),
                'type' => 'shop'
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->item->name,
            'image' => $this->item->thumbnail,
            'price' => (float) $this->item->price,
            'description' => $this->item->description,
            'item_id' => $this->item_id,
            'created_at' => $this->created_at->format('d/m/Y'),
            'type' => 'product'
        ];
    }
}
