<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidangUrusan extends Model
{
    const ID_NON_URUSAN = 1;
    public $appends = [
        'kode_urusan'
    ];
    protected $table = 'bidang_urusan';
    protected $fillable = [
        'uuid',
        'kode_bidang_urusan',
        'nama_bidang_urusan',
        'id_urusan',
        'tahun',
        'user_insert',
        'user_update'
    ];

    public function Urusan()
    {
        return $this->belongsTo(Urusan::class, 'id_urusan');
    }

    public function Program()
    {
        return $this->hasMany(Program::class,'id_bidang_urusan');
    }

    public function UnitKerja()
    {
        return $this->belongsToMany(UnitKerja::class, 'unit_kerja_bidang_urusan', 'id_bidang_urusan', 'id_unit_kerja');
    }

    public function getKodeUrusanAttribute()
    {
        return optional($this->Urusan)->kode_urusan;
    }
}
