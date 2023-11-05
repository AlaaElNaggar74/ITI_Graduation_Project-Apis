<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Lawyer;

class Specialization extends Model
{
    use HasFactory;
    // protected $table = 'specialization';
    protected $fillable = [
        'name',
        'description',
        'image',
    ];


    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
    ];

    function lawyer()
    {
        return $this->belongsToMany(Lawyer::class, 'lawyer_specialization', 'lawyer_id', 'specialization_id');
    }
}
