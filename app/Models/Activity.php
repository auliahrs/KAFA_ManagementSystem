<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activityName', // Add name of activityName field
        'dateStart', // Add dateStart field
        'dateEnd', // Add dateEnd field
        'timeStart', // Add timeStart field
        'timeEnd', // Add timeEnd field
        'venue', // Add venue field
        'organizerName', // Add organizerName field
        'attendees', // Add attendees field
        'description', // Add description field
        'status', // Add status field
        'feedback', // Add feedback field
        'kafa_id', // Add kafa_id field
    ]; 

    public function kafa()
    {
        return $this->belongsTo(Kafa::class);
    }
}

