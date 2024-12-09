<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Muip extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id', // Add staff id field
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }
}
