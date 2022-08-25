<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailRealisasiDak extends Model
{
    protected $table = 'detail_realisasi_dak';
    protected $fillable = [
        'uuid',
        'id_realisasi_dak',
        'tahun',
        'id_dpa',
        'id_sumber_dana_dpa',
        'realisasi_keuangan',
        'realisasi_fisik',
        'periode',
        'user_insert',
        'user_update'
    ];

    public function Dpa()
    {
        return $this->belongsTo(Dpa::class, 'id_dpa');
    }

    public function Realisasi(){
        return $this->belongsTo(RealisasiDak::class,'id_realisasi_dak');
    }

    public function SumberDanaDpa(){
        return $this->belongsTo(SumberDanaDpa::class,'id_sumber_dana_dpa');
    }

   
}
