<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenstraRealisasiSubKegiatan extends Model
{

    protected $table = 'renstra_realisasi_sub_kegiatan';
    protected $fillable = [
        'uuid',
        'realisasi_keuangan',
        'volume',
        'satuan',
        'id_renstra_sub_kegiatan',
        'id_unit_kerja',
        'tahun',
        'user_insert',
        'user_update'
    ];

    public function RenstraSubKegiatan()
    {
        return $this->belongsTo(RenstraSubKegiatan::class, 'id_renstra_sub_kegiatan');
    }
}
