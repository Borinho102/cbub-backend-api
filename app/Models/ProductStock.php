<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'type',
        'prev_quantity', 'new_quantity',
        'comment', 'author_id', 'author_type'
    ];

    public function author(): MorphTo
    {
        return $this->morphTo();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
