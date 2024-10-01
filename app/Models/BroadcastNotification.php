<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class BroadcastNotification extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = [
        'title',
        'body',
        'image'
    ];

    protected $fillable = [
        'broadcaster_id', 'broadcaster_type',
        'business_id', 'title', 'body', 'data',
        'broadcast_at', 'image', 'shop_id', 'type'
    ];

    protected $casts = [
        'data' => 'array',
        'broadcast_at' => 'datetime'
    ];

    public function broadcaster(): MorphTo
    {
        return $this->morphTo();
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
