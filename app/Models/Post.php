<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Group;
use App\Models\User;
class Post extends Model
{
    use HasFactory;

    protected $fillable=['post','user_id','group_id'];
    function user()
    {
        return $this->belongsTo(User::class);
    }

    function inGroup()
    {
        return $this->belongsTo(Group::class);
    }
  
}
