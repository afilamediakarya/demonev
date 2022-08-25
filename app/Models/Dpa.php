<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dpa extends Model
{
    protected $table = 'dpa';
    protected $fillable = [
        'uuid',
        'is_non_urusan',
        'id_program',
        'id_kegiatan',
        'id_sub_kegiatan',
        'id_pegawai_penanggung_jawab',
        'nilai_pagu_dpa',
        'tahun',
        'id_unit_kerja',
        'user_insert',
        'user_update'
    ];

    protected $casts = [
        'id_non_urusan' => 'boolean'
    ];

    public function UnitKerja(){
        return $this->belongsTo(UnitKerja::class,'id_unit_kerja');
    }

    public function Program(){
        return $this->belongsTo(Program::class,'id_program');
    }

    public function Kegiatan(){
        return $this->belongsTo(Kegiatan::class,'id_kegiatan');
    }

    public function SubKegiatan()
    {
        return $this->belongsTo(SubKegiatan::class, 'id_sub_kegiatan')->orderBy('kode_sub_kegiatan','ASC');
    }

    public function PegawaiPenanggungJawab(){
        return $this->belongsTo(PegawaiPenanggungJawab::class,'id_pegawai_penanggung_jawab');
    }

    public function Target(){
        return $this->hasMany(Target::class,'id_dpa');
    }

    public function Realisasi(){
        return $this->hasMany(Realisasi::class,'id_dpa');
    }
    public function RealisasiDak(){
        return $this->hasMany(RealisasiDak::class,'id_dpa');
    }
    public function PaketDak(){
        return $this->hasMany(PaketDak::class,'id_dpa');
    }
    
    public function LokasiPaketDau(){
        return $this->hasMany(LokasiPaketDau::class,'id_dpa');
    }
    public function PaketDau(){
        return $this->hasMany(PaketDau::class,'id_dpa');
    }

    public function TolakUkur(){
        return $this->hasMany(TolakUkur::class,'id_dpa');
    }

    public function SumberDanaDpa(){
        return $this->hasMany(SumberDanaDpa::class,'id_dpa');
    }
    

    public function DetailRealisasi(){
        return $this->hasMany(DetailRealisasi::class,'id_dpa');
    }

    public function getNilaiPaguRpAttribute(){
        if ($this->nilai_pagu_dpa)
        return number_format($this->nilai_pagu_dpa,2,',','.');
    }
}
