<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'tbl_modules'; // Nama tabel sesuai dengan database
    protected $fillable = ['course_id', 'title', 'content', 'video_url'];

    // Relasi ke Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
