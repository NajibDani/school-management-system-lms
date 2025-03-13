<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblAttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_attendance')->insert([
            [
                'student_id' => 1, // Sesuaikan dengan ID student di tabel tbl_students
                'class_id' => 1, // Sesuaikan dengan ID class di tabel tbl_classes
                'date' => now()->format('Y-m-d'),
                'status' => 'Present',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 2,
                'class_id' => 1,
                'date' => now()->format('Y-m-d'),
                'status' => 'Absent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 3,
                'class_id' => 2,
                'date' => now()->format('Y-m-d'),
                'status' => 'Late',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
