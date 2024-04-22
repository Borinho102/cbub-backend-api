<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

class UserLocation extends Model
{
    use HasFactory;
    use HasSpatial;

    protected $fillable = [
        'name',
        'location',
        'area',
        'current',
        'user_id'
    ];

    protected $casts = [
        'location' => Point::class,
        'area' => Polygon::class,
    ];
}
