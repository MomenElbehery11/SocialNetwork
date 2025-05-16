<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
class Post extends Model
{
    use HasFactory;
    protected $fillable = ['body','user_id','image',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
{
    return $this->hasMany(Like::class);
}
public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    // Post.php

public function likedBy()
{
    return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')->withTimestamps();
}

}
