<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('tbl_roles')->insert([
            [
                'name' => 'Admin',
                'description' => 'Administrator with full access to the system.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Teacher',
                'description' => 'Teacher who manages classes and students.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Student',
                'description' => 'Student who accesses learning materials and submits assignments.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Parent',
                'description' => 'Parent who monitors student progress.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
