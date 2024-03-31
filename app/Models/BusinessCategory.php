<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class BusinessCategory extends Model implements HasMedia
{
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    public $translatable = ['name', 'description'];

    protected $fillable = [
        'name', 'code', 'description',
    ];

    public function businesses() : HasMany
    {
        return $this->hasMany(Business::class, 'category_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }

    public function getLogoAttribute()
    {
        $logo = $this->getFirstMediaUrl('logo');
        return !empty($logo) ? $logo : asset('images/category_placeholder.jpg');
    }
}
