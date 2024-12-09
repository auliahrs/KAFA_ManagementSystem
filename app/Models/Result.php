<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'subject_id', 
        'student_id', 
        'year', 
        'typeOfExamination', 
        'marks', 
        'grade', 
        'comment'
    ];
    
    use HasFactory;
}
