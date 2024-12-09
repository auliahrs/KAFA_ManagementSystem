<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'classroom_id', // Add classroom id field
        'staff_id', // Add staff id field
        'kafaName', // Add Name of Kafa field
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function classroom(){

        return $this->belongsTo(Classroom::class);
    }
}
