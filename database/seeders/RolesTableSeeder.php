<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('tbl_roles')->insert([
            [
                'name' => 'admin',
                'description' => 'Administrator with full access to the system.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'teacher',
                'description' => 'Teacher who manages classes and students.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'student',
                'description' => 'Student who accesses learning materials and submits assignments.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'parent',
                'description' => 'Parent who monitors student progress.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
