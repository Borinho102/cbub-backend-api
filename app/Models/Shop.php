<?php

namespace App\Models;

use App\Services\Utils\Initials;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Shop extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name', 'phone', 'country_id', 'city_id', 'business_id',
        'address', 'slug', 'email', 'website', 'facebook',
        'twitter', 'instagram', 'linkedin', 'schedule',
        'about', 'youtube', 'slug', 'phone_alt', 'owner_id'
    ];

    protected $casts = [
        'schedule' => 'array'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
        $this->addMediaCollection('image')
            ->singleFile();
        $this->addMediaCollection('banners');
    }

    /**
     * Get the doctor's working days
     */
    protected function getWorkingDaysAttribute()
    {
        if (!$this->schedule) return [];
        if (!isset($this->schedule['working_days'])) return [];

        return $this->schedule['working_days'];
    }

    /**
     * Get the doctor's working hours
     */
    protected function getWorkingHoursAttribute()
    {
        if (!$this->schedule) return [];
        if (!isset($this->schedule['working_hours'])) return [];

        return $this->schedule['working_hours'];
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'owner_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(BusinessUser::class, 'owner_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function product_sold(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'shop_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function scopeWithAverageRating(Builder $q)
    {
        return $q->addSelect(['rating_avg' => function ($q) {
            $q->selectRaw('avg(rating)')
                ->from('reviews')
                ->where('reviewable_type', Shop::class)
                ->whereColumn('reviewable_id', 'shops.id');
        }]);
    }

    public function scopeWithOrdersCount(Builder $q)
    {
        return $q->addSelect(['orders_count' => function ($q) {
            $q->selectRaw('count(distinct(order_id))')
                ->from('order_items')
                ->whereColumn('shops.id', 'order_items.shop_id');
        }]);
    }

    public function getLogoAttribute()
    {
        $logo = $this->getFirstMediaUrl('logo');
        return !empty($logo) ? $logo : asset('images/shop_placeholder.png');
    }

    public function getImageAttribute()
    {
        $image = $this->getFirstMediaUrl('image');
        return !empty($image) ? $image : asset('images/shop_placeholder.png');
    }

    public function getInitialsAttribute()
    {
        return Initials::generate($this->name);
    }
}
