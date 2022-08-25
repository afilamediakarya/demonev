<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileDaerah extends Model
{
    protected $table = 'profile_daerah';
    protected $fillable = [
        'uuid',
        'nama_daerah',
        'pimpinan_daerah',
        'alamat',
        'email',
        'no_telp',
        'visi_daerah',
        'misi_daerah',
        'user_insert',
        'user_update'
    ];
}
