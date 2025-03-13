<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblReportCardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_report_cards')->insert([
            [
                'student_id' => 1, // Sesuaikan dengan ID siswa
                'academic_year' => '2023/2024',
                'term' => 'Semester 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 2,
                'academic_year' => '2023/2024',
                'term' => 'Semester 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'student_id' => 3,
                'academic_year' => '2023/2024',
                'term' => 'Semester 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
