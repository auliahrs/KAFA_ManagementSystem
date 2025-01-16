<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create([
            'subjectName' => 'Lughatul Al-Quran',
        ]);
        
        Subject::create([
            'subjectName' => 'Ibadah',
        ]);
        
        Subject::create([
            'subjectName' => 'Aqidah',
        ]);
        
        Subject::create([
            'subjectName' => 'Bahasa Arab',
        ]);
        
        Subject::create([
            'subjectName' => 'Sirah',
        ]);
        
        Subject::create([
            'subjectName' => 'Adab & Akhlak',
        ]);
        
        Subject::create([
            'subjectName' => 'Jawi & Khat',
        ]);
        
    }
}