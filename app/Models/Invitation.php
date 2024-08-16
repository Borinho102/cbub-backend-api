<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitor_id', 'invitor_type',
        'invitee_id', 'invitee_type',
        'token', 'expires_at', 'accepted_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'accepted_at' => 'datetime'
    ];

    public function invitor(): MorphTo
    {
        return $this->morphTo();
    }

    public function invitee(): MorphTo
    {
        return $this->morphTo();
    }
}
