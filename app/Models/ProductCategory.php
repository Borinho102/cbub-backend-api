<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class ProductCategory extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTranslations;

    public $translatable = ['name', 'description', 'hint'];

    protected $fillable = [
        'name', 'code', 'hint', 'description',
        'is_active', 'parent_id'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }

    public function products() : HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Many-to-Many relations with Promo Codes.
     */
    public function promo_codes() : MorphToMany
    {
        return $this->morphToMany(
            PromoCode::class,
            'service',
            'promo_code_service',
            'service_id',
            'promo_code_id'
        );
    }

    public function getLogoAttribute()
    {
        $logo = $this->getFirstMediaUrl('logo');
        return !empty($logo) ? $logo : asset('images/category_placeholder.jpg');
    }
}
