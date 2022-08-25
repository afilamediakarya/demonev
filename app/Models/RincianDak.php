<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RincianDak extends Model
{
    const ID_NON_BIDANG_DAK = 1;
    public $appends = [
        'kode_rincian'
    ];
    protected $table = 'rincian_dak';
    protected $with = ['TematikDak'];
    protected $fillable = [
        'uuid',
        'kode_rincian',
        'rincian',
        'jenis',
        'id_tematik',
        'id_kegiatan',
        'user_insert',
        'user_update'
    ];

    public function KegiatanDak()
    {
        return $this->belongsTo(KegiatanDak::class, 'id_kegiatan');
    }

    public function PaketDak()
    {
        return $this->hasMany(PaketDak::class, 'id_rincian');
    }

    public function TematikDak()
    {
        return $this->belongsTo(TematikDak::class, 'id_tematik');
    }



    public function getKodeRincianAttribute()
    {
        return optional($this->KegiatanDak)->kode_kegiatan;
    }
}
