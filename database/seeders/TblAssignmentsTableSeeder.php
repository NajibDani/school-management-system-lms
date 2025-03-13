<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblAssignmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_assignments')->insert([
            [
                'module_id' => 1, // Sesuaikan dengan ID module di tabel tbl_modules
                'title' => 'Introduction to Laravel',
                'description' => 'Complete the Laravel setup and create a basic route.',
                'due_date' => now()->addDays(7),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module_id' => 2,
                'title' => 'Database Migrations',
                'description' => 'Create and migrate a database schema for a blog application.',
                'due_date' => now()->addDays(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'module_id' => 3,
                'title' => 'Eloquent Relationships',
                'description' => 'Define and implement one-to-many relationships in Laravel.',
                'due_date' => now()->addDays(14),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
