<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'items_count' => $this->whenCounted('items_count'),
            'user_id' => $this->customer_id,
            'user_type' => $this->customer_type,
            'status' => $this->status,
            'currency' => $this->currency,
            'amount' => (float) $this->amount,
            'shop_id' => $this->shop_id,
            'statuses' => $this->whenLoaded('statuses', fn () => OrderStatusResource::collection($this->statuses)),
            'shop' => $this->whenLoaded('shop', fn () => ShopResource::make($this->shop)),
            'items' => $this->whenLoaded('items', fn () => OrderItemResource::collection($this->items)),
            'description' => $this->whenHas('description'),
            'delivery_address' => null,
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}
