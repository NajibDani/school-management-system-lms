<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_modules')->insert([
            [
                'course_id' => 1, // Sesuaikan dengan ID course di tabel tbl_courses
                'title' => 'Dasar HTML & CSS',
                'content' => 'Materi mengenai dasar-dasar HTML dan CSS untuk pengembangan web.',
                'video_url' => 'https://example.com/html-css-video',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 2,
                'title' => 'Konfigurasi Jaringan Dasar',
                'content' => 'Materi tentang konfigurasi jaringan dasar menggunakan perangkat keras dan lunak.',
                'video_url' => 'https://example.com/networking-basics',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 3,
                'title' => 'Keamanan Web',
                'content' => 'Materi tentang cara mengamankan aplikasi web dari serangan umum.',
                'video_url' => 'https://example.com/cybersecurity-web',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
