<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Admin extends Authenticatable implements MustVerifyEmail, HasMedia, LaratrustUser
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasRolesAndPermissions;

    protected $table = 'admins';

    protected $fillable = [
        'username',
        'name',
        'email',
        'phone',
        'password',
        'country_id',
        'city_id',
        'address',
        'two_factor_auth',
        'email_verified_at',
        'currency_id',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Gets user's country
     * @return BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Gets user's city
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Gets user's currency (default XAF)
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Route notifications for the sms channel.
     * @param $notification
     * @return string
     */
    public function routeNotificationForSms($notification): string
    {
        return $this->phone;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile();
    }

    public function getProfilePictureAttribute()
    {
        $avatar = $this->getFirstMediaUrl('avatar');
        return !is_null($avatar) && !empty($avatar) ? $avatar : asset('images/default_avatar.png');
    }
}
