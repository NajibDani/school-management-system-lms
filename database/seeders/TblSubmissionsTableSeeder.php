<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblSubmissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_submissions')->insert([
            [
                'assignment_id' => 1, // Sesuaikan dengan ID assignment di tabel tbl_assignments
                'student_id' => 1, // Sesuaikan dengan ID student di tabel tbl_students
                'file_url' => 'submissions/assignment1_student1.pdf',
                'grade' => 85.5,
                'feedback' => 'Good job, but improve the formatting.',
                'submitted_at' => now(),
            ],
            [
                'assignment_id' => 2,
                'student_id' => 2,
                'file_url' => 'submissions/assignment2_student2.docx',
                'grade' => 90.0,
                'feedback' => 'Excellent work!',
                'submitted_at' => now()->subDays(1),
            ],
            [
                'assignment_id' => 3,
                'student_id' => 3,
                'file_url' => 'submissions/assignment3_student3.zip',
                'grade' => 78.0,
                'feedback' => 'Needs more details in explanation.',
                'submitted_at' => now()->subDays(2),
            ],
        ]);
    }
}
