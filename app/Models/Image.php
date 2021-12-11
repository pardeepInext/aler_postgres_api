<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'imageable_type', 'imageable_id'];
    protected $appends = ['image'];

    function imageable()
    {
        return $this->morphTo();
    }
    
    function getImageAttribute()
    {
       return  asset("uploads/$this->name");
    }
}
