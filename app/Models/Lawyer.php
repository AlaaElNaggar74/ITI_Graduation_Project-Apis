<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Specialization;
use App\Models\LawyerTime;

class Lawyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'span',
        'about',
        'location',
        'idImage',
        'user_id',
    ];

    protected $hidden = [
     
        'created_at',
        'updated_at',
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function followers()
    {
        return $this->belongsToMany(User::class,'user_follow_lawyer','lawyer_id', 'user_id');
    }

    function chat()
    {
        return $this->belongsToMany(User::class);
    }


    function specialization()
    {
        return $this->belongsToMany(Specialization::class, 'lawyer_specialization', 'lawyer_id', 'specialization_id');
    }

    function lawyer_time()
    {
        return $this->hasMany(LawyerTime::class);
    }
}
