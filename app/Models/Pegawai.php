<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawai';
    protected $fillable = [
        'uuid',
        'nama',
        'nip',
        'jabatan',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'no_telp',
        'id_unit_kerja',
        'user_insert',
        'user_update'
    ];

    protected $dates = [
        'tanggal_lahir'
    ];

    public function UnitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'id_unit_kerja');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id_pegawai');
    }
}
