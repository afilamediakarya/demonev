<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenstraSubKegiatan extends Model
{
    protected $table = 'renstra_sub_kegiatan';
    protected $fillable = [
        'uuid',
        'id_tujuan',
        'id_sasaran',
        'id_urusan',
        'id_bidang_urusan',
        'id_program',
        'kode_program',
        'id_renstra_kegiatan',
        'id_kegiatan',
        'id_sub_kegiatan',
        'total_pagu_renstra',
        'total_volume',
        'id_unit_kerja',
        'periode',
        'user_insert',
        'user_update'
    ];

    public function RenstraSubKegiatanTarget()
    {
        return $this->hasMany(RenstraSubKegiatanTarget::class, 'id_renstra_sub_kegiatan');
    }
    
    public function RenstraSubKegiatanIndikator()
    {
        return $this->hasMany(RenstraSubKegiatanIndikator::class, 'id_renstra_sub_kegiatan');
    }
    
    public function RenstraRealisasiSubKegiatan()
    {
        return $this->hasMany(RenstraRealisasiSubKegiatan::class, 'id_renstra_sub_kegiatan');
    }

    public function Tujuan()
    {
        return $this->belongsTo(Tujuan::class, 'id_tujuan');
    }
    
    public function Sasaran()
    {
        return $this->belongsTo(Sasaran::class, 'id_sasaran');
    }
    
    public function Urusan()
    {
        return $this->belongsTo(Urusan::class, 'id_urusan');
    }
    
    public function BidangUrusan()
    {
        return $this->belongsTo(BidangUrusan::class, 'id_bidang_urusan');
    }
    
    public function Program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }

    public function Kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan');
    }
    
    public function UnitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'id_unit_kerja');
    }
}
