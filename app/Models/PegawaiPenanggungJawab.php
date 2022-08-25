<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiPenanggungJawab extends Model
{
    protected $table = 'pegawai_penanggung_jawab';
    protected $fillable = [
        'uuid',
//        'id_pegawai',
        'nip',
        'nama_lengkap',
        'jabatan',
        'no_telp',
        'id_unit_kerja',
        'status',
        'user_insert',
        'user_update'
    ];

//    public function Pegawai()
//    {
//        return $this->belongsTo(Pegawai::class, 'id_pegawai');
//    }

    public function Realisasi()
    {
        return $this->hasMany(Realisasi::class, 'id_pegawai_penanggung_jawab');
    }
    
    public function BackupReportRealisasi()
    {
        return $this->hasMany(BackupReportRealisasi::class, 'id_pegawai_penanggung_jawab');
    }

    public function UnitKerja(){
        return $this->belongsTo(UnitKerja::class,'id_unit_kerja');
    }
}
