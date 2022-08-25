<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KegiatanDak extends Model
{
    const ID_NON_SUB_BIDANG_DAK = 1;
    // public $appends = [
    //     'kode_kegiatan'
    // ];
    protected $table = 'kegiatan_dak';
    // protected $with = ['RincianDak'];
    protected $fillable = [
        'uuid',
        'kode_kegiatan',
        'kegiatan',
        'id_sub_bidang',
        'user_insert',
        'user_update'
    ];

    public function SubBidangDak()
    {
        return $this->belongsTo(SubBidangDak::class, 'id_sub_bidang');
    }

    public function RincianDak()
    {
        return $this->hasMany(RincianDak::class, 'id_kegiatan');
    }

    // public function getKodeKegiatanAttribute()
    // {
    //     return optional($this->SubBidangDak)->kode_sub_bidang_dak;
    // }
}
