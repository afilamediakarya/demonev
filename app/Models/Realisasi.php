<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Realisasi extends Model
{
    protected $table = 'realisasi';
    protected $fillable = [
        'uuid',
        'periode',
        'realisasi_keuangan',
        'realisasi_fisik',
        'realisasi_kinerja',
        'tahun',
        'id_dpa',
        'permasalahan',
        'user_insert',
        'user_update'
    ];

    public function Dpa()
    {
        return $this->belongsTo(Dpa::class, 'id_dpa');
    }

    public function Detail(){
        return $this->hasMany(DetailRealisasi::class,'id_realisasi');
    }
}
