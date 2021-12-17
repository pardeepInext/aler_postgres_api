<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'type', 'status', 'price', 'size', 'year', 'bedrooms', 'bathroom', 'garages'];

    function propertyFeatureds()
    {
        return $this->hasMany(PropertyFeatured::class);
    }

    function propertyLocation()
    {
        return $this->hasOne(PropertyLocation::class);
    }

    function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function likes(){
        return $this->hasMany(PropertyLike::class);
    }
}
