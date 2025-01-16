<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $fillable = [
        'occupation', // Add occupation field
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function children(){
        
        return $this->hasMany(Student::class, 'guardian_id');
    }
}