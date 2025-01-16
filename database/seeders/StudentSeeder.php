<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Fetch guardian IDs and classroom IDs
        $guardianIds = DB::table('guardians')->pluck('id')->toArray();
        $classroomIds = DB::table('classrooms')->pluck('id')->toArray();

        foreach (range(1, 50) as $index) { // Generate 50 students
            DB::table('students')->insert([
                'guardian_id' => $faker->randomElement($guardianIds), // Associate with random guardian
                'classroom_id' => $faker->randomElement($classroomIds), // Associate with random classroom
                'icNum' => $faker->regexify('[0-9]{6}-[0-9]{2}-[0-9]{4}'), // Example IC number
                'studentName' => $faker->name,
                'gender' => $faker->randomElement(['male', 'female']),
                'race' => $faker->randomElement(['Malay', 'Chinese', 'Indian', 'Others']),
                'age' => $faker->numberBetween(7, 11),
                'birthDate' => $faker->dateTimeBetween('-18 years', '-6 years')->format('Y-m-d'),
                'status' => $faker->randomElement(['active', 'inactive', 'graduated']),
                'averageResult' => $faker->randomFloat(2, 40, 100), // Random percentage (e.g., 40.00 to 100.00)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}