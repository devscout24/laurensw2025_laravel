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

    use HasFactory, Notifiable , SoftDeletes, HasRoles;

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

    // Relationships With Interests
    public function interests()
    {
        return $this->belongsToMany(Topic::class, 'user_interests', 'user_id', 'interest_id')
            ->whereNull('topics.deleted_at')
            ->withTimestamps();
    }
    // Bookmarks Articles
    public function bookmarks()
    {
        return $this->hasMany(BookmarkArticle::class);
    }
    // Bookmarks Communities
    public function bookmarksCommunities()
    {
        return $this->hasMany(CommunityBookmark::class);
    }
    // Comments
    public function communityComments()
    {
        return $this->hasMany(CommunityComment::class);
    }
    // Behaviour
    public function behaviour()
    {
        return $this->hasMany(UserBehaviour::class);
    }
}
