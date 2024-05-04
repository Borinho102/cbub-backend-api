<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ModelAccessLog extends Model
{
    use HasFactory;

    public $fillable = [
        'model_id', 'model_type',
        'user_id', 'user_type',
        'action', 'data'
    ];

    public $casts = [
        'data' => 'array'
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): MorphTo
    {
        return $this->morphTo();
    }
}
