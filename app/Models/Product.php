<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;

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

    public function getPreviewImageAttribute()
    {
        return $this->getFirstMediaUrl('preview');
    }

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function discount_prices(): HasMany
    {
        return $this->hasMany(ProductDiscountPrice::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(ProductStock::class, 'product_id');
    }

    public function active_discount_price(): HasOne
    {
        return $this->hasOne(ProductDiscountPrice::class)
            ->latest()
            ->where('is_active', 1)
            ->where(function ($q) {
                $q->whereDate('end_date', '>', now())
                    ->orWhereNull('end_date');
            });
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function scopeWithAverageRating(Builder $q)
    {
        return $q->addSelect(['rating_avg' => function ($q) {
            $q->selectRaw('avg(rating)')
                ->from('product_reviews')
                ->whereColumn('product_id', 'products.id');
        }]);
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

    public function scopeSearch($q)
    {
        if ($search = request('q', request('search', request('query')))) {
            $q->where(function ($q) use ($search) {
                $parts = explode(' ', $search);
                foreach ($parts as $part) {
                    // $q->whereRaw("CONVERT(name->>'$.en' USING utf8mb4) LIKE ?", ['%' . Str::lower($part) . '%'])
                    //     ->orWhereRaw("CONVERT(name->>'$.fr' USING utf8mb4) LIKE ?", ['%' . Str::lower($part) . '%']);
                   $q->whereRaw("LOWER(JSON_EXTRACT(name, '$.en')) LIKE ?", ['%' . strtolower($part) . '%'])
                       ->orWhereRaw("LOWER(JSON_EXTRACT(name, '$.fr')) LIKE ?", ['%' . strtolower($part) . '%'])
                       ->orWhere('sku', 'like', '%' . $part . '%s');
                }
            });
        }
    }
}
