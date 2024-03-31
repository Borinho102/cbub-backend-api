<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscountPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'old_price', 'new_price',
        'is_active', 'end_date', 'discount_percentage',
        'user_type', 'user_id'
    ];
}
