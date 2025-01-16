<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Nur Dayana',
            'username' => 'dayana',
            'email' => 'dayana@mail.com',
            'password' => bcrypt('dayana@1'),
            'phoneNum' => '0123456789',
            'role' => 'kafa',
            'icNum' => '112233445566',
            'address' => 'null',
            'gender' => 'female',
            'race' => 'null',
            'age' => '22',
            'status' => 'approved',
        ]);
        
        User::create([
            'name' => 'Fafa',
            'username' => 'fafa',
            'email' => 'fafa@mail.com',
            'password' => bcrypt('fafa@1'),
            'phoneNum' => '0123456788',
            'role' => 'muip',
            'icNum' => '112233445567',
            'address' => 'null',
            'gender' => 'female',
            'race' => 'null',
            'age' => '20',
            'status' => 'approved',
        ]);
        
        User::create([
            'name' => 'Petco',
            'username' => 'petco',
            'email' => 'petco@mail.com',
            'password' => bcrypt('petco@1'),
            'phoneNum' => '0123456787',
            'role' => 'guardian',
            'icNum' => '112233445566',
            'address' => 'null',
            'gender' => 'male',
            'race' => 'null',
            'age' => '30',
            'status' => 'approved',
        ]);
        
        //user role => teacher 
        User::create([
            'name' => 'Idris bin Hanafi',
            'username' => 'idris',
            'email' => 'idris@mail.com',
            'password' => bcrypt('idris@1'),
            'phoneNum' => '0123456786',
            'role' => 'teacher',
            'icNum' => '112233445565',
            'address' => 'null',
            'gender' => 'male',
            'race' => 'null',
            'age' => '26',
            'status' => 'approved',
        ]);
        
        User::create([
            'name' => 'Zulaikha Majnun',
            'username' => 'majnun',
            'email' => 'majnun@mail.com',
            'password' => bcrypt('majnun@1'),
            'phoneNum' => '0123426786',
            'role' => 'teacher',
            'icNum' => '112233445502',
            'address' => 'null',
            'gender' => 'female',
            'race' => 'null',
            'age' => '24',
            'status' => 'approved',
        ]);
        
        User::create([
            'name' => 'Al-Amin Asyraf',
            'username' => 'amin',
            'email' => 'amin@mail.com',
            'password' => bcrypt('amin@1'),
            'phoneNum' => '0113456786',
            'role' => 'teacher',
            'icNum' => '112233245565',
            'address' => 'null',
            'gender' => 'male',
            'race' => 'null',
            'age' => '28',
            'status' => 'approved',
        ]);
        
        User::create([
            'name' => 'Dahlia Yusuf',
            'username' => 'dahlia',
            'email' => 'dahlia@mail.com',
            'password' => bcrypt('dahlia@1'),
            'phoneNum' => '0123416786',
            'role' => 'teacher',
            'icNum' => '111233445565',
            'address' => 'null',
            'gender' => 'female',
            'race' => 'null',
            'age' => '25',
            'status' => 'approved',
        ]);
        
        User::create([
            'name' => 'Sofia Ahmad',
            'username' => 'sofia',
            'email' => 'sofia@mail.com',
            'password' => bcrypt('sofia@1'),
            'phoneNum' => '0123056786',
            'role' => 'teacher',
            'icNum' => '112233445595',
            'address' => 'null',
            'gender' => 'female',
            'race' => 'null',
            'age' => '24',
            'status' => 'approved',
        ]);
    }
}