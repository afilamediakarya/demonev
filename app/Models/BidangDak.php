<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidangDak extends Model
{
    protected $table = 'bidang_dak';
    protected $fillable = [
        'uuid',
        'kode_bidang_dak',
        'bidang',
        'user_insert',
        'user_update'
    ];

    public function SubBidangDak()
    {
        return $this->hasMany(SubBidangDak::class, 'id_bidang_dak');
    }
}
