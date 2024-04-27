<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
    protected $fillable = ['id', 'title', 'author', 'description', 'published_date', 'isbn', 'thumbnail'];
    public $incrementing = false;  // Important if you are using non-auto-increment IDs
    protected $keyType = 'string';  // Use 'string' if IDs can include characters not just numbers

    protected $appends = ['is_favorited'];  // Appends 'is_favorited' to the JSON form of the model

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Method to check if the book is favorited by the current user
    public function isFavorited()
    {
        return $this->favorites()->where('user_id', Auth::id())->exists();
    }

    // Getter for the 'is_favorited' attribute to use with $appends
    public function getIsFavoritedAttribute()
    {
        if (!Auth::check()) {
            return false;
        }
        return $this->isFavorited();
    }
}
