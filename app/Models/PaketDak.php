<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketDak extends Model
{
    protected $table = 'paket_dak';
    // protected $with = ['RincianDak'];
    protected $fillable = [
        'uuid',
        'nama_paket',
        'volume',
        'satuan',
        'penerima_manfaat',
        'anggaran_dak',
        'pendampingan',
        'total_biaya',
        'swakelola',
        'kontrak',
        'tahun',
        'id_dpa',
        'kesesuaian_rkpd',
        'kesesuaian_dpa_skpd',
        'id_sumber_dana_dpa',
        'kecamatan',
        'desa',
        'user_insert',
        'user_update',
        'metode_pembayaran',
        'volume_swakelola',
        'volume_kontrak',
        'permasalahan',
        'id_rincian'
    ];

    public function SumberDanaDpa()
    {
        return $this->belongsTo(SumberDanaDpa::class, 'id');
    }

    public function RincianDak(){
        return $this->belongsTo(RincianDak::class,'id_rincian');
    }

    public function RealisasiDak(){
        return $this->hasMany(RealisasiDak::class,'id_paket_dak');
    }

    public function PaketDakLokasi(){
        return $this->hasMany(PaketDakLokasi::class,'id_paket_dak');
    }
}
