<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBelanja extends Model
{
    protected $table = 'jenis_belanja';
    protected $fillable = [
        'uuid',
        'nama_jenis_belanja',
        'kode',
        'status',
        'user_insert',
        'user_update'
    ];
}
