<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'body', 'rating', 'reviewable_type',
        'reviewable_id', 'user_id', 'published'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewable() : MorphTo
    {
        return $this->morphTo();
    }
}
