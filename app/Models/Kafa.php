<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kafa extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id', // Add staff id field
        'kafaName', // Add Name of Kafa field
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function activity(){

        return $this->hasMany(Activity::class);
    }
}
