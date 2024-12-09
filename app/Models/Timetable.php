<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $fillable = [
        'day', // Add day field
        'time', // Add time field
    ];

    public function classroom(){

        return $this->belongsTo(Classroom::class);
    }
}
