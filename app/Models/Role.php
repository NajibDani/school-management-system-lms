<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'tbl_roles'; // Sesuaikan dengan nama tabel di database
    protected $fillable = ['name'];
    /**
     * Relationship with User.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
