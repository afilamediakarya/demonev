<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketDakLokasi extends Model
{

    protected $table = 'paket_dak_lokasi';
    protected $fillable = [
        'uuid',
        'id_paket_dak',
        'id_desa',
        'id_kecamatan',
        'user_insert',
        'user_update'
    ];

    public function PaketDak()
    {
        return $this->belongsTo(PaketDak::class, 'id_paket_dak');
    }
}
