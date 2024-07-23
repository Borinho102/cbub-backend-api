<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDiscountResource extends JsonResource
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
            'percentage' => (float) $this->discount_percentage,
            'old_price' => (float) $this->old_price,
            'new_price' => (float) $this->new_price,
            'diff_in_hours' => isset($this->end_date) && isset($this->start_date) ? Carbon::parse($this->start_date)
                ->diffInHours(Carbon::parse($this->end_date)) : null,
            'diff_in_minutes' => isset($this->end_date) && isset($this->start_date) ? Carbon::parse($this->start_date)
                ->diffInMinutes(Carbon::parse($this->end_date)) : null,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date
        ];
    }
}
