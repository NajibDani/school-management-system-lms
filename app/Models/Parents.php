<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    // Nama tabel dalam database
    protected $table = 'tbl_parents';

    // Kolom yang dapat diisi (fillable)
    protected $fillable = [
        'user_id',
        'current_class_id',
        'enrollment_number',
        'guardian_id',
    ];

    /**
     * Relasi ke model User (siswa).
     * Setiap siswa memiliki satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
