<?php

namespace App\Models;

use App\Services\Utils\Initials;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Business extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name', 'phone', 'category_id',
        'country_id', 'address', 'slug',
        'email', 'slug', 'phone_alt', 'about',
        'owner_id', 'max_shops', 'number_of_shops'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();

        $this->addMediaCollection('banners');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(BusinessUser::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(BusinessUser::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BusinessCategory::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function getLogoAttribute()
    {
        $logo = $this->getFirstMediaUrl('logo');
        return !empty($logo) ? $logo : asset('images/business_placeholder.png');
    }

    public function getInitialsAttribute()
    {
        return Initials::generate($this->name);
    }
}
