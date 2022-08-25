<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubBidangDak extends Model
{
    const ID_NON_BIDANG_DAK = 1;
    // public $appends = [
    //     'kode_sub_bidang_dak'
    // ];
    protected $table = 'sub_bidang_dak';
    protected $fillable = [
        'uuid',
        'kode_sub_bidang_dak',
        'sub_bidang',
        'id_bidang_dak',
        'user_insert',
        'user_update'
    ];

    public function KegiatanDak()
    {
        return $this->hasMany(KegiatanDak::class, 'id_sub_bidang');
    }


    public function BidangDak()
    {
        return $this->belongsTo(BidangDak::class, 'id_bidang_dak');
    }

    // public function getKodeSubBidangDakAttribute()
    // {
    //     return optional($this->BidangDak)->kode_bidang_dak;
    // }

}
