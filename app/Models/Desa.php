<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table = 'desa';
    protected $fillable = [
        'uuid',
        'id_kecamatan',
        'nama',
        'user_insert',
        'user_update'
    ];
}
