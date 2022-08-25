<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rkpd extends Model
{
    protected $table = 'rkpd';
    protected $fillable = [
        'uuid',
        'target_rpjmd_keuangan',
        'target_rpjmd_kinerja',
        'realisasi_rkpd_lalu_keuangan',
        'realisasi_rkpd_lalu_kinerja',
        'target_rkpd_sekarang_keuangan',
        'target_rkpd_sekarang_kinerja',
        'semester',
        'user_insert',
        'user_update'
    ];
}
