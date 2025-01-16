<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroomName', 
        'classroomYear', 
    ];


    public function teacher(){

        return $this->hasOne(Teacher::class);
    }

    public function timetable(){

        return $this->hasOne(Timetable::class);
    }

    public function student(){

        return $this->hasMany(Student::class);
    }
}