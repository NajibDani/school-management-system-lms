<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassHistory extends Model
{
    use HasFactory;

    protected $table = 'tbl_class_histories';

    protected $fillable = [
        'student_id',
        'class_id',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];
}
