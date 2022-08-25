<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePelaksanaan extends Model
{
    protected $table = 'metode_pelaksanaan';
    protected $fillable = [
        'uuid',
        'nama_metode_pelaksanaan',
        'kode',
        'status',
        'user_insert',
        'user_update'
    ];
}
