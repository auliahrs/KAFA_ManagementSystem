<?php

namespace Database\Seeders;

use App\Models\Guardian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all users with the role 'guardian'
        $guardians = DB::table('users')->where('role', 'guardian')->get();

        foreach ($guardians as $guardian) {
            DB::table('guardians')->insert([
                'user_id' => $guardian->id, // Associate with the guardian user
                'occupation' => $faker->jobTitle,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
    }
}