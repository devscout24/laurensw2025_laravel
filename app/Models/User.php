<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable implements JWTSubject
{

    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'status',
        'is_admin',
        'date_of_birth',
        'phone',
        'address',
        'city',
        'zipcode',
        'country',
        'otp',
        'otp_expired_at',
        'otp_verified_at',
        'password_reset_token',
        'password_reset_token_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Implement JWTSubject methods
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Typically the user ID
    }

    public function getJWTCustomClaims()
    {
        return []; // Add any custom claims here
    }

    public function bookingsTwo()
    {
        return $this->hasMany(BookingTwo::class, 'user_id');
    }
}
