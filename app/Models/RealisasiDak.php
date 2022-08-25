<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiDak extends Model
{
    protected $table = 'realisasi_dak';
    protected $fillable = [
        'uuid',
        'periode',
        'id_paket_dak',
        'realisasi_keuangan',
        'realisasi_fisik',
        'tahun',
        'id_dpa',
        'permasalahan',
        'user_insert',
        'user_update',
        'realisasi_kinerja',
        'total_kinerja'
    ];

    public function Dpa()
    {
        return $this->belongsTo(Dpa::class, 'id_dpa');
    }

    public function PaketDak()
    {
        return $this->belongsTo(PaketDak::class, 'id_paket_dak');
    }

    public function Detail(){
        return $this->hasMany(DetailRealisasiDak::class,'id_realisasi_dak');
    }
}
