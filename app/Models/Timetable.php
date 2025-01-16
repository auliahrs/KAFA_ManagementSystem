<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;

    protected $table = 'timetables';

    protected $fillable = [
        // 'day', // Add day field
        // 'time', // Add time field
        'classroom_id',
        'subject_id',
        'teacher_id',
        'weekday',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime', // Cast start_time to Carbon
        'end_time' => 'datetime', // Cast end_time to Carbon
    ];

    public function timetable() {
        return $this->belongsTo(Timetable::class);
    }

    public function classroom(){
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}