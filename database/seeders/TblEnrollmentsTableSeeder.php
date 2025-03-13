<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblEnrollmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_enrollments')->insert([
            [
                'student_id' => 1, // Sesuaikan dengan ID student di tabel tbl_students
                'course_id' => 1, // Sesuaikan dengan ID course di tabel tbl_courses
                'status' => 'active',
                'enrolled_at' => now(),
            ],
            [
                'student_id' => 2,
                'course_id' => 2,
                'status' => 'active',
                'enrolled_at' => now(),
            ],
            [
                'student_id' => 3,
                'course_id' => 3,
                'status' => 'inactive',
                'enrolled_at' => now(),
            ],
        ]);
    }
}
