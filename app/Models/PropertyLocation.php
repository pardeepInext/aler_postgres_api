<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyLocation extends Model
{
    use HasFactory;
    protected $fillable = ['property_id', 'country_id', 'state_id', 'city_id', 'address'];

    function country()
    {
      return $this->belongsTo(Country::class);
    }
    
    function state()
    {
      return $this->belongsTo(State::class);
    }

    function city()
    {
      return $this->belongsTo(City::class);
    }
}
