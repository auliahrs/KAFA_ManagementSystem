<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'classroom_id', // Add classroom id field
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function classroom(){

        return $this->belongsTo(Classroom::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }   
}