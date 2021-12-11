<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['heading', 'content', 'user_id'];

    function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
