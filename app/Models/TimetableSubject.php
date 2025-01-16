<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimetableSubject extends Model
{
    use HasFactory;

    protected $table = 'timetable_subjects';
    
    protected $fillable = [
        'timetable_id',
        'subject_id',
        'day',
        'time_slot' 
    ];
}