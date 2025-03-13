<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TblStudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_students')->insert([
            [
                'user_id' => 1, // Sesuaikan dengan ID user yang ada di tabel users
                'current_class_id' => 1, // Sesuaikan dengan ID kelas yang ada di tabel tbl_classes
                'enrollment_number' => Str::random(10),
                'guardian_id' => null, // Sesuaikan dengan ID wali yang ada di tabel users
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'current_class_id' => 2,
                'enrollment_number' => Str::random(10),
                'guardian_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'current_class_id' => null, // Siswa belum memiliki kelas
                'enrollment_number' => Str::random(10),
                'guardian_id' => null, // Tidak memiliki wali
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

    }
}