<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblMessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_messages')->insert([
            [
                'sender_id' => 1, // Sesuaikan dengan ID user pengirim
                'receiver_id' => 2, // Sesuaikan dengan ID user penerima
                'content' => 'Halo, bagaimana kabarmu?',
                'sent_at' => now(),
            ],
            [
                'sender_id' => 2,
                'receiver_id' => 1,
                'content' => 'Saya baik, terima kasih! Bagaimana denganmu?',
                'sent_at' => now()->subMinutes(5),
            ],
            [
                'sender_id' => 3,
                'receiver_id' => 1,
                'content' => 'Bisakah kita berdiskusi tentang tugas?',
                'sent_at' => now()->subHours(1),
            ],
        ]);
    }
}