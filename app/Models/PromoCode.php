<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PromoCode extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    const DISCOUNT_TYPES = [
        'fixed_price' => 'Fixed Price',
        'percentage' => 'Percentage'
    ];

    protected $fillable = [
        'title', 'code', 'tags', 'start_date', 'end_date',
        'business_id', 'max_usage', 'data', 'is_active',
        'max_usage_per_user', 'minimum_spend','maximum_spend',
        'discount_value', 'free_delivery'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'data' => 'json'
    ];

    /**
     * The users that belong to the promo code.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'promo_code_user'
        );
    }

    /**
     * Get all the product categories that are assigned this promo code.
     */
    public function categories(): MorphToMany
    {
        return $this->morphedByMany(
            ProductCategory::class,
            'service',
            'promo_code_service'
        );
    }

    /**
     * Get all the products that are assigned this promo code.
     */
    public function products(): MorphToMany
    {
        return $this->morphedByMany(
            Product::class,
            'service',
            'promo_code_service'
        );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner')
            ->singleFile();
    }

    public function getBannerAttribute()
    {
        $banner = $this->getFirstMediaUrl('banner');
        return !empty($banner) ? $banner : null;
    }
}
