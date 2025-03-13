<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin1234'),
                'role_id' => 1, // Sesuaikan dengan id role yang tersedia
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Teacher',
                'email' => 'teacher@example.com',
                'password' => Hash::make('teacher1234'),
                'role_id' => 2, // Sesuaikan dengan id role yang tersedia
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Student',
                'email' => 'student@example.com',
                'password' => Hash::make('student1234'),
                'role_id' => 2, // Sesuaikan dengan id role yang tersedia
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
