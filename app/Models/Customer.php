<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'business_id', 'favorite'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id', 'user_id')
            ->where('customer_type', User::class);
    }

    public function last_order(): HasOne
    {
        return $this->hasOne(Order::class, 'customer_id', 'user_id')->latest();
    }
}
