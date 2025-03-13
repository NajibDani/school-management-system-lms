<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblClassHistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_class_histories')->insert([
            [
                'student_id' => 1, // Sesuaikan dengan ID siswa di tbl_students
                'class_id' => 1, // Sesuaikan dengan ID kelas di tbl_classes
                'start_date' => '2023-07-10',
                'end_date' => '2024-06-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 2,
                'class_id' => 2,
                'start_date' => '2023-07-10',
                'end_date' => null, // Masih aktif di kelas ini
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 3,
                'class_id' => 1,
                'start_date' => '2022-07-10',
                'end_date' => '2023-06-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
