<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_id',
        'customer_id',
        'customer_type',
        'amount',
        'curreny',
        'status',
        'description',
        'data',
        'business_id',
        'shop_id',
        'delivery_address_id'
    ];

    public function customer(): MorphTo
    {
        return $this->morphTo();
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function delivery_address(): BelongsTo
    {
        return $this->belongsTo(DeliveryAddress::class);
    }

    public function getFormattedAmountAttribute()
    {
        return currency($this->amount, null, $this->currency);
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
