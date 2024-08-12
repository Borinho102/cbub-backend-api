<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'type' => isset($this->data['notification_type']) ?
                $this->data['notification_type'] : $this->type,
            'title' => $this->data['title'],
            'body' => $this->data['body'],
            'image' => isset($this->data['image']) ? $this->data['image'] : null,
            'redirect_to' => $this->getAppRedirectToPage(),
            'data' => $this->data,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at
        ];
    }

    private function getAppRedirectToPage()
    {
        if (isset($this->data['order_id'])) {
            return '/orders/' . $this->data['order_id'];
        } else if (isset($this->data['product_id'])) {
            return '/products/' . $this->data['product_id'];
        } else if (isset($this->data['shop_id'])) {
            return '/shops/' . $this->data['shop_id'];
        }
        return null;
    }
}
