<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    //public function __construct()
    //{
    //    session(['tahun_penganggaran' => request('tahun', date('Y'))]);
    //}

    protected $table = 'unit_kerja';
    protected $fillable = [
        'uuid',
        'nama_unit_kerja',
        'kode_unit_kerja',
        'max_pagu',
        'user_insert',
        'user_update',
        'nama_kepala',
        'nama_jabatan_kepala',
        'nip_kepala',
        'pangkat_kepala',
        'status_kepala'
    ];

    public function BidangUrusan()
    {
        return $this->belongsToMany(BidangUrusan::class, 'unit_kerja_bidang_urusan', 'id_unit_kerja', 'id_bidang_urusan');
    }
    
    public function UnitKerjaPagu()
    {
        
        return $this->hasMany(UnitKerjaPagu::class, 'id_unit_kerja')->where('unit_kerja_pagu.tahun', request('tahun'));
    }

//    public function Pegawai()
//    {
//        return $this->hasMany(Pegawai::class, 'id_unit_kerja');
//    }

    public function User(){
        return $this->hasMany(User::class,'id_unit_kerja');
    }

    public function Dpa(){
        return $this->hasMany(Dpa::class,'id_unit_kerja');
    }
    public function BackupReportDpa(){
        return $this->hasMany(BackupReportDpa::class,'id_unit_kerja');
    }
}
