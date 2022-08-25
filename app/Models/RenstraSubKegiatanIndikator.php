<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenstraSubKegiatanIndikator extends Model
{

    protected $table = 'renstra_sub_kegiatan_indikator';
    protected $fillable = [
        'uuid',
        'indikator',
        'volume',
        'satuan',
        'capaian_awal',
        'id_renstra_sub_kegiatan',
        'user_insert',
        'user_update'
    ];

    public function RenstraSubKegiatan()
    {
        return $this->belongsTo(RenstraSubKegiatan::class, 'id_renstra_sub_kegiatan');
    }
}
