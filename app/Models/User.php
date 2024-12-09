<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', // Add name field
        'username', // Add username field
        'email', // Add email field
        'password', // Add password field
        'role', // Add role field
        'phoneNum', // Add phone field
        'icNum', // Add ic_number field
        'address', // Add address field
        'gender', // Add gender field
        'race', // Add race field
        'age', // Add age field
        'status', // Add status field
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function guardian(){

        return $this->hasOne(Guardian::class);
    }

    public function kafa(){

        return $this->hasOne(Kafa::class);
    }

    public function muip(){

        return $this->hasOne(Muip::class);
    }

    public function teacher(){

        return $this->hasOne(Teacher::class);
    }
}
