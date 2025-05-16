<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
    public function posts():HasMany
{
    return $this->hasMany(Post::class);
}
public function likes()
{
    return $this->hasMany(Like::class);
}
public function comments()
    {
        return $this->hasMany(Comment::class);
    }

public function likedPosts()
{
    return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')->withTimestamps();
}


public function sentFriendRequests() {
    return $this->hasMany(FriendRequest::class, 'sender_id');
}

public function receivedFriendRequests() {
    return $this->hasMany(FriendRequest::class, 'receiver_id');
}


public function friends()
{
    return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
}
public function currentTeam()
    {
        return $this->belongsTo(Team::class);
    }
}
