<?php

namespace App\Models;

use App\Services\Utils\Initials;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'is_active', 'parent_id', 'tags', 'business_id'
    ];

    protected $casts = [
        'tags' => 'array'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile();
    }

    public function products() : HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function business() : BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_id');
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

    public function getImageAttribute()
    {
        $image = $this->getFirstMediaUrl('image');
        return !empty($image) ? $image : null;
    }

    public function getInitialsAttribute()
    {
        return Initials::generate($this->name);
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
