<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessPartnerUser extends Model
{
    use HasFactory;

    /**
     * Get the business partner of the user.
     */
    public function business_partner() : BelongsTo
    {
        return $this->belongsTo(BusinessPartner::class);
    }
}
