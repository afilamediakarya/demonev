<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SumberDana extends Model
{
    protected $table = 'sumber_dana';
    const TIPE_SWAKELOLA = ['Swakelola'];
    const TIPE_KONTRAK = ['Lelang','Pengadaan Langsung'];
    protected $fillable = [
        'uuid',
        'nama_sumber_dana',
        'kode',
        'status',
        'user_insert',
        'user_update'
    ];
}
