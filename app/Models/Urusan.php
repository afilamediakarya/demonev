<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Urusan extends Model
{
    protected $table = 'urusan';
    protected $fillable = [
        'uuid',
        'kode_urusan',
        'nama_urusan',
        'tahun',
        'user_insert',
        'user_update'
    ];

    public function BidangUrusan()
    {
        return $this->hasMany(BidangUrusan::class, 'id_urusan');
    }
}
