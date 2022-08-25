<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $fillable = [
        'uuid',
        'nama_role',
        'deskripsi',
        'user_insert',
        'user_update'
    ];

    public function User()
    {
        return $this->hasMany(User::class, 'id_role');
    }

    public function hasAkses($akses)
    {
        return $this->Akses()->where('nama_akses', $akses)->first() !== null;
    }

    public function Akses()
    {
        return $this->belongsToMany(Akses::class, 'akses_role', 'id_role', 'id_akses');
    }
}
