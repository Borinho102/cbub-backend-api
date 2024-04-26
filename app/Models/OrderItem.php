<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    use HasFactory;

    public function item(): MorphTo
    {
        return $this->morphTo();
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
