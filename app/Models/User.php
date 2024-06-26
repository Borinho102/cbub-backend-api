<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia, LaratrustUser
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'device_type',
        'device_token',
        'language'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'device_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static $withoutAppends = false;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    protected function getArrayableAppends()
    {
        if (self::$withoutAppends){
            return [];
        }

        return parent::getArrayableAppends();
    }

    public function scopeWithoutAppends($query)
    {
        self::$withoutAppends = true;

        return $query;
    }

    /**
     * Route notifications for the Firebase channel.
     */
    public function routeNotificationForFirebase(Notification $notification): string
    {
        return $this->device_token;
    }

    /**
     * Route notifications for the Sms channel.
     */
    public function routeNotificationForSms(Notification $notification): string
    {
        return $this->phone;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile();;
    }

    public function getImageAttribute()
    {
        $avatar = $this->getFirstMediaUrl('avatar');
        return !empty($avatar) ? $avatar : asset('images/default_avatar.png');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function promo_codes()
    {
        return $this->belongsToMany(PromoCode::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(UserLocation::class, 'user_id');
    }

    public function current_location(): HasOne
    {
        return $this->hasOne(UserLocation::class, 'user_id')
            ->where('current', 1)->latest();
    }

    public function orders(): MorphMany
    {
        return $this->morphMany(Order::class, 'customer');
    }

    public function last_order(): MorphOne
    {
        return $this->morphOne(Order::class, 'customer')->latest();
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'user_id');
    }
}
