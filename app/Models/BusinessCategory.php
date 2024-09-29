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
