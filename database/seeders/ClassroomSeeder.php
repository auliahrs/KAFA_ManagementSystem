<?php

namespace Database\Seeders;

use App\Models\Classroom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classroom::create([
            'classroomName' => 'Abu Bakar As-Siddiq',
            'classroomYear' => '1',
        ]);
        
        Classroom::create([
            'classroomName' => 'Ali Abi Talib',
            'classroomYear' => '1',
        ]);
        
        Classroom::create([
            'classroomName' => 'Bilal Rabah',
            'classroomYear' => '2',
        ]);
        
        Classroom::create([
            'classroomName' => 'Umar Al-Khattab',
            'classroomYear' => '3',
        ]);
    }
}