<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    use Prunable;

    public function scopeFilterByPeriod($query, $period = null)
    {
        return filterByPeriod($query, $period);
    }

    /**
     * Get the prunable model query.
     */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subMonth());
    }
}
