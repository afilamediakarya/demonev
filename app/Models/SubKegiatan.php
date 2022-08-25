<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKegiatan extends Model
{
    public $appends = [
        'id_program', 'id_bidang_urusan', 'id_urusan'
    ];
    protected $table = 'sub_kegiatan';
    protected $fillable = [
        'uuid',
        'kode_sub_kegiatan',
        'nama_sub_kegiatan',
        'id_kegiatan',
        'tahun',
        'user_insert',
        'user_update',
        'indikator',
        'kinerja',
        'satuan'
    ];

    public function Kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan');
    }

    public function Dpa()
    {
        return $this->hasMany(Dpa::class, 'id_sub_kegiatan');
    }
    public function BackupReportDpa()
    {
        return $this->hasMany(BackupReportDpa::class, 'id_sub_kegiatan');
    }

    public function getIdProgramAttribute()
    {
        return optional($this->Kegiatan)->id_program;
    }

    public function getIdBidangUrusanAttribute()
    {
        return optional(optional($this->Kegiatan)->Program)->id_bidang_urusan;
    }

    public function getIdUrusanAttribute()
    {
        return optional(optional(optional($this->Kegiatan)->Program)->BidangUrusan)->id_urusan;
    }
}
