<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $fillable = [
        'uuid',
        'jabatan',
        'user_insert',
        'user_update'
    ];
}
