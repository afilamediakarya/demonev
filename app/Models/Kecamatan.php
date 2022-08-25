<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $fillable = [
        'uuid',
        'nama',
        'user_insert',
        'user_update'
    ];
}
