<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Country;
use App\Models\User;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id',
    ];

    protected $hidden = [
        'country_id',
        'created_at',
        'updated_at',
    ];

    function country()
    {
        return $this->belongsTo(Country::class);
    }

    function users()
    {
        return $this->hasMany(User::class, 'city_id');
    }
}
