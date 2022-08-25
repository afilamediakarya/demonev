<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupReportDpa extends Model
{
    protected $table = 'backup_report_dpa';
    protected $primaryKey = 'key';
    protected $fillable = [
        'id',
        'triwulan',
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
        return $this->hasMany(BackupReportTarget::class,'id_dpa_backup','key');
    }

    public function Realisasi(){
        return $this->hasMany(BackupReportRealisasi::class,'id_dpa_backup','key');
    }
    public function RealisasiDak(){
        return $this->hasMany(BackupReportRealisasiDak::class,'id_dpa_backup','key');
    }
    public function PaketDak(){
        return $this->hasMany(BackupReportPaketDak::class,'id_dpa_backup','key');
    }

    public function TolakUkur(){
        return $this->hasMany(BackupReportTolakUkur::class,'id_dpa_backup','key');
    }

    public function SumberDanaDpa(){
        return $this->hasMany(BackupReportSumberDanaDpa::class,'id_dpa_backup','key');
    }


    public function DetailRealisasi(){
        return $this->hasMany(BackupReportDetailRealisasi::class,'id_dpa_backup','key');
    }

    public function getNilaiPaguRpAttribute(){
        if ($this->nilai_pagu_dpa)
        return number_format($this->nilai_pagu_dpa,2,',','.');
    }
}
