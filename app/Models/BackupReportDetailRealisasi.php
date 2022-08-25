<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupReportDetailRealisasi extends Model
{
    protected $table = 'backup_report_detail_realisasi';
    protected $primaryKey = 'key';
    protected $fillable = [
        'id',
        'triwulan',
        'id_dpa_backup',
        'uuid',
        'id_realisasi',
        'tahun',
        'id_dpa',
        'id_sumber_dana_dpa',
        'realisasi_keuangan',
        'realisasi_fisik',
        'periode',
        'user_insert',
        'user_update',
        'id_sumber_dana_dpa_backup'
    ];

    public function Dpa()
    {
        return $this->belongsTo(BackupReportDpa::class, 'id_dpa_backup','key');
    }

    public function Realisasi(){
        return $this->belongsTo(BackupReportRealisasi::class,'id_realisasi');
    }

    public function SumberDanaDpa(){
        return $this->belongsTo(BackupReportSumberDanaDpa::class,'id_sumber_dana_dpa_backup','key');
    }
}
