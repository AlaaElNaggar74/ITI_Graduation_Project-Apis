<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LawyerTime;
use App\Models\User;
use App\Models\Review;
class Appointment extends Model
{
    use HasFactory;


    function lawyer_time()
    {
        return $this->belongsTo(LawyerTime::class);
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }

    function review()
    {
        return $this->belongsTo(Review::class);
    }
}
