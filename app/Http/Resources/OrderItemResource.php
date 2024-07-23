<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'order_id' => $this->order_id,
            'quantity' => $this->quantity,
            'unit_amount' => (float) $this->unit_amount,
            'total_amount' => (float) $this->total_amount,
            'description' => $this->whenHas('description'),
            'shop_id' => $this->shop_id,
            'shop' => $this->whenLoaded('shop', fn () => ShopResource::make($this->shop)),
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
