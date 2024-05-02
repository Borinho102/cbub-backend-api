<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProductDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'old_price', 'new_price', 'product_type',
        'is_active', 'end_date', 'discount_percentage',
        'user_type', 'user_id', 'start_date'
    ];

    protected $casts = [
        'end_date' => 'datetime',
        'start_date' => 'datetime'
    ];

    public function product(): MorphTo
    {
        return $this->morphTo();
    }

    public function getRemainingHoursAttribute()
    {
        return Carbon::parse($this->start_date)->diffInHours($this->end_date);
    }
}
