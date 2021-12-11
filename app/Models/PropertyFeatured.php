<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyFeatured extends Model
{
    use HasFactory;
    protected $fillable = ['name','property_id'];
}
