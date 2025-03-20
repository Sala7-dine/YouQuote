<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'author', 'source', 'view_count', 'user_id'];
    protected $appends = ['likes_count', 'is_liked', 'is_favorited'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'quote_likes')->withTimestamps();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'quote_favorites')->withTimestamps();
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function isFavoritedBy(User $user)
    {
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getIsLikedAttribute()
    {
        if (Auth::check()) {
            return $this->isLikedBy(Auth::user());
        }
        return false;
    }

    public function getIsFavoritedAttribute()
    {
        if (Auth::check()) {
            return $this->isFavoritedBy(Auth::user());
        }
        return false;
    }
}
