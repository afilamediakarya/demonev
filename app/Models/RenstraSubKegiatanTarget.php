<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenstraSubKegiatanTarget extends Model
{

    protected $table = 'renstra_sub_kegiatan_target';
    protected $fillable = [
        'uuid',
        'volume',
        'satuan',
        'pagu',
        'tahun',
        'id_renstra_sub_kegiatan',
        'user_insert',
        'user_update'
    ];

    public function RenstraSubKegiatan()
    {
        return $this->belongsTo(RenstraSubKegiatan::class, 'id_renstra_sub_kegiatan');
    }
}
