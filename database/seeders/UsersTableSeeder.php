<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'), // Use a secure hash for the password
            'remember_token' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'gender' => 'Male', // Adjust as needed
            'mobile' => '1234567890', // Adjust as needed
            'father_name' => 'Father Name', // Adjust as needed
            'date_of_birth' => '1990-01-01', // Adjust as needed
            'photo' => 'photo_url', // Adjust as needed
            'role_id' => 1, // Admin role ID
        ]);
    }
}
