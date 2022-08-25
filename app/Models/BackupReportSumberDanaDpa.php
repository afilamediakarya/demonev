<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupReportSumberDanaDpa extends Model
{
    protected $table = 'backup_report_sumber_dana_dpa';
    protected $primaryKey = 'key';
    protected $fillable = [
        'id',
        'triwulan',
        'uuid',
        'jenis_belanja',
        'sumber_dana',
        'metode_pelaksanaan',
        'nilai_pagu',
        'tahun',
        'id_dpa',
        'user_insert',
        'user_update',
        'id_dpa_backup'
    ];

    public function Dpa()
    {
        return $this->belongsTo(BackupReportDpa::class, 'id_dpa_backup','key');
    }

    public function DetailRealisasi(){
        return $this->hasMany(BackupReportDetailRealisasi::class,'id_sumber_dana_dpa_backup','key');
    }

    public function getNilaiPaguRpAttribute(){
        if ($this->nilai_pagu)
            return number_format($this->nilai_pagu,2,',','.');
    }

    public function PaketDak(){
        return $this->hasMany(BackupReportPaketDak::class,'id_sumber_dana_dpa');
    }
}
