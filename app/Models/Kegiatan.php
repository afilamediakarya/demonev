<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    CONST KODE_KABUPATEN = 2;
    public $appends = [
        'id_bidang_urusan', 'id_urusan'
    ];
    protected $table = 'kegiatan';
    protected $fillable = [
        'uuid',
        'kode_kegiatan',
        'nama_kegiatan',
        'id_program',
        'hasil_kegiatan',
        'tahun',
        'user_insert',
        'user_update'
    ];

    public function Program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }

    public function SubKegiatan()
    {
        return $this->hasMany(SubKegiatan::class, 'id_kegiatan')->orderBy('kode_sub_kegiatan','ASC');
    }

    public function Dpa(){
        return $this->hasMany(Dpa::class,'id_kegiatan');
    }

    public function BackupReportDpa(){
        return $this->hasMany(BackupReportDpa::class,'id_kegiatan');
    }

    public function getIdBidangUrusanAttribute()
    {
        return optional($this->Program)->id_bidang_urusan;
    }

    public function getIdUrusanAttribute()
    {
        return optional(optional($this->Program)->BidangUrusan)->id_urusan;
    }

    public function setKodeKegiatanAttribute($value){
        $this->attributes['kode_kegiatan'] = self::KODE_KABUPATEN.'.'.$value;
    }
}
