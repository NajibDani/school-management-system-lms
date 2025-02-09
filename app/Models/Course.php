<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'tbl_courses'; // Nama tabel sesuai dengan database
    protected $fillable = ['name', 'description', 'teacher_id'];

    // Relasi ke Teacher (User)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Relasi ke Module
    public function modules()
    {
        return $this->hasMany(Module::class, 'course_id');
    }
}
