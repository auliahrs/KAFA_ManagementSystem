<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::create([
            'user_id' => '4',
            'classroom_id' => '1',
        ]);
        
        Teacher::create([
            'user_id' => '5',
            'classroom_id' => '2',
        ]);
        
        Teacher::create([
            'user_id' => '6',
            'classroom_id' => '1',
        ]);
        
        Teacher::create([
            'user_id' => '7',
            'classroom_id' => '2',
        ]);
        
        Teacher::create([
            'user_id' => '8',
            'classroom_id' => '1',
        ]);

    }
}