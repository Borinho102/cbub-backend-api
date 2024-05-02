<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'product_type', 'type',
        'old_quantity', 'new_quantity',
        'comment', 'author_id', 'author_type'
    ];

    public function author(): MorphTo
    {
        return $this->morphTo();
    }

    public function product(): MorphTo
    {
        return $this->morphTo();
    }
}
