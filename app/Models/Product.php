<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTranslations;

    public $translatable = ['name', 'description', 'short_description', 'slug'];

    protected $fillable = [
        'name', 'description', 'short_description', 'slug',
        'sku', 'quantity', 'price', 'is_active', 'sku',
        'is_available', 'category_id', 'business_id'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');

        $this->addMediaCollection('preview')
            ->singleFile();
    }

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
