<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    const ROLES = ['1' => 'admin', '2' => 'user', '3' => 'agent'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'image_name'
    ];

    protected $appends = ['image'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function getImageAttribute()
    {
        return  $this->image_name != "" ? asset("uploads/$this->image_name") : asset("uploads/user.png");
    }

    function role()
    {
        return $this->belongsTo(Role::class);
    }

    function properties()
    {
        return $this->hasMany(Property::class);
    }
}
