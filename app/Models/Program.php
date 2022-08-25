<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public $appends = [
        'id_urusan'
    ];
    protected $table = 'program';
    protected $fillable = [
        'uuid',
        'kode_program',
        'nama_program',
        'id_bidang_urusan',
        'capaian_program',
        'tahun',
        'user_insert',
        'user_update'
    ];

    public function BidangUrusan()
    {
        return $this->belongsTo(BidangUrusan::class, 'id_bidang_urusan');
    }

    public function Kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'id_program');
    }

    public function Dpa(){
        return $this->hasMany(Dpa::class,'id_program');
    }
    
    public function BackupReportDpa(){
        return $this->hasMany(BackupReportDpa::class,'id_program');
    }

    public function getIdUrusanAttribute()
    {
        return optional($this->BidangUrusan)->id_urusan;
    }
}
