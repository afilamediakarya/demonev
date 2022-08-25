<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketDau extends Model
{
    protected $table = 'paket_dau';
    protected $fillable = [
        'uuid',
        'nama_paket',
        'volume',
        'satuan',
        'pagu',
        'tahun',
        'id_dpa',
        'id_sumber_dana_dpa',
        'user_insert',
        'keterangan',
        'user_update'
    ];

    public function SumberDanaDpa()
    {
        return $this->belongsTo(SumberDanaDpa::class, 'id');
    }

    
    public function PaketDauLokasi(){
        return $this->hasMany(PaketDauLokasi::class,'id_paket_dau');
    }
}
