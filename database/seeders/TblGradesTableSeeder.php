<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblGradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_grades')->insert([
            [
                'student_id' => 1, // Sesuaikan dengan ID student di tabel tbl_students
                'class_id' => 1, // Sesuaikan dengan ID class di tabel tbl_classes
                'subject' => 'Matematika',
                'grade' => 'A',
                'term' => 'Semester 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 2,
                'class_id' => 1,
                'subject' => 'Fisika',
                'grade' => 'B+',
                'term' => 'Semester 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 3,
                'class_id' => 2,
                'subject' => 'Kimia',
                'grade' => 'A-',
                'term' => 'Semester 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
