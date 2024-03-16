<?php

namespace App\Models;

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
        'country_id', 'city_id', 'address', 'slug',
        'email', 'website', 'facebook', 'initials',
        'twitter', 'instagram', 'linkedin', 'about',
        'youtube', 'initials', 'slug', 'phone_alt'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();

        $this->addMediaCollection('banners');
    }

    public function users(): HasMany
    {
        return $this->hasMany(BusinessUser::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BusinessCategory::class);
    }
}
