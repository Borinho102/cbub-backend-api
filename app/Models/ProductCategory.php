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
        'is_active', 'parent_id', 'tags'
    ];

    protected $casts = [
        'tags' => 'array'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icon_image')
            ->singleFile();

        $this->addMediaCollection('banner_image')
            ->singleFile();

        $this->addMediaCollection('cover_image')
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

    public function getIconAttribute()
    {
        $icon = $this->getFirstMediaUrl('icon');
        return !empty($icon) ? $icon : null;
    }

    public function getBannerAttribute()
    {
        $banner = $this->getFirstMediaUrl('banner');
        return !empty($banner) ? $banner : null;
    }

    public function getCoverImageAttribute()
    {
        $cover_image = $this->getFirstMediaUrl('cover_image');
        return !empty($cover_image) ? $cover_image : null;
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
                       ->orWhere('code', 'like', '%' . $search . '%s');
                }
            });
        }
    }
}
