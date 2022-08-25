<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akses extends Model
{
    protected $table = 'akses';
    protected $fillable = [
        'uuid',
        'nama_akses',
        'route',
        'user_insert',
        'user_update'
    ];

    public function Role()
    {
        return $this->belongsToMany(Role::class, 'akses_role', 'id_akses', 'id_role');
    }
}
