<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuan';
    protected $fillable = [
        'uuid',
        'nama_satuan',
        'kode',
        'status',
        'user_insert',
        'user_update'
    ];
}
