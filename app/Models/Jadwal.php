<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = [
        'uuid',
        'tahapan',
        'sub_tahapan',
        'jadwal_mulai',
        'jadwal_selesai',
        'tahun',
        'status',
        'user_insert',
        'user_update'
    ];

    protected $dates = [
        'jadwal_mulai', 'jadwal_selesai'
    ];
}
