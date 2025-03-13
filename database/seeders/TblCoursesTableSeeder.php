<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblCoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_courses')->insert([
            [
                'name' => 'Pemrograman Web',
                'description' => 'Kursus tentang pengembangan aplikasi web menggunakan berbagai teknologi.',
                'teacher_id' => 1, // Sesuaikan dengan ID teacher di tabel users
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jaringan Komputer',
                'description' => 'Dasar-dasar jaringan komputer dan konfigurasi perangkat jaringan.',
                'teacher_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Keamanan Cyber',
                'description' => 'Memahami ancaman keamanan siber dan cara mitigasinya.',
                'teacher_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
