<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

const ACTIVE_COUNTRIES = ['cm'];

class Country extends \Khsing\World\Models\Country
{
    /**
     * All cities that belongs to country.
     * @return HasMany
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('code', ACTIVE_COUNTRIES);
    }
}
