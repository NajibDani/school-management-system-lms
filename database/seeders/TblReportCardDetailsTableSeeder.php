<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblReportCardDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_report_card_details')->insert([
            [
                'report_card_id' => 1, // Sesuaikan dengan ID raport
                'subject' => 'Matematika',
                'grade' => 'A',
                'teacher_id' => 1, // Sesuaikan dengan ID guru
                'comment' => 'Sangat baik dalam memahami konsep.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'report_card_id' => 2,
                'subject' => 'Bahasa Indonesia',
                'grade' => 'B+',
                'teacher_id' => 2,
                'comment' => 'Perlu meningkatkan keterampilan menulis.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'report_card_id' => 3,
                'subject' => 'Fisika',
                'grade' => 'A-',
                'teacher_id' => 3,
                'comment' => 'Aktif dalam praktikum.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
