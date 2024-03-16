<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'is_available', 'category_id', 'business_ipartner_d'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');

        $this->addMediaCollection('preview')
            ->singleFile();
    }
}
