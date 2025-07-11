<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Tymon\JWTAuth\Contracts\JWTSubject;



class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
  
     protected $fillable = [
        'name', 'email', 'phone', 'datebirthday', 'picture',
        'description', 'role', 'address', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

       public function followings()
{
    return $this->hasMany(Follower::class, 'follower_id');
}
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function favorites()
    {
     return $this->hasMany(Favorite::class);
    }
    public function stories()
    {
      return $this->hasMany(Story::class);
    }   


    public function followers()
    {
        return $this->hasMany(Follower::class, 'followed_id');
    }

    public function following()
    {
        return $this->hasMany(Follower::class, 'follower_id');
    }

    public function reel_comment()
    {
     return $this->hasMany(reel_comments::class);
    }
        public function reels()
    {
     return $this->hasMany(reels::class);
    }
        public function sessions()
    {
        return $this->hasMany(UserSession::class);
    }

    // دالة لحساب متوسط وقت الجلسة
    public function averageSessionDuration()
    {
        return $this->sessions()
            ->whereNotNull('ended_at')
            ->avg('duration');
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

