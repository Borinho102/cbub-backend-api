<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PromoCodeService extends Pivot
{
    public function service() : MorphTo
    {
        return $this->morphTo();
    }
}
