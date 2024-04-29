<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function friends()
{
    return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                ->wherePivot('is_confirmed', true);
}

public function friendRequests()
{
    return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
                ->wherePivot('is_confirmed', false);
}

public function sentRequests()
{
    return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                ->wherePivot('is_confirmed', false);
}

}
