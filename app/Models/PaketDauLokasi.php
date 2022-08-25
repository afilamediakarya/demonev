<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketDauLokasi extends Model
{

    protected $table = 'paket_dau_lokasi';
    protected $fillable = [
        'uuid',
        'id_paket_dau',
        'id_desa',
        'id_kecamatan',
        'user_insert',
        'user_update'
    ];

    public function PaketDau()
    {
        return $this->belongsTo(PaketDau::class, 'id_paket_dau');
    }
}
