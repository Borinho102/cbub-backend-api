<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'from_status', 'to_status',
        'description', 'user_id', 'user_type'
    ];

    public function user(): MorphTo
    {
        return $this->morphTo();
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
