<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblTeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_teachers')->insert([
            [
                'user_id' => 1, // Sesuaikan dengan ID user di tabel users
                'subject' => 'Matematika',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'subject' => 'Bahasa Inggris',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'subject' => 'Fisika',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
