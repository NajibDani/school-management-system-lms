<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Nama tabel dalam database
    protected $table = 'tbl_students';

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

    /**
     * Relasi ke model Class (kelas saat ini).
     * Siswa dapat terhubung ke satu kelas saat ini.
     */
    public function currentClass()
    {
        return $this->belongsTo(Classes::class, 'current_class_id');
    }


    /**
     * Relasi ke model User (wali siswa).
     * Setiap siswa dapat memiliki satu wali.
     */
    // public function guardian()
    // {
    //     return $this->belongsTo(User::class, 'guardian_id');
    // }
}
