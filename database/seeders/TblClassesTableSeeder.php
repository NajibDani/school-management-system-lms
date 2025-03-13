<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TblClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_classes')->insert([
            [
                'name' => 'Class A',
                'teacher_id' => 1, // Sesuaikan dengan ID guru yang ada di tabel users
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Class B',
                'teacher_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Class C',
                'teacher_id' => null, // Tidak memiliki guru
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}