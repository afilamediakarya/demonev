<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupReportRealisasi extends Model
{
    protected $table = 'backup_report_realisasi';
    protected $primaryKey = 'key';
    protected $fillable = [
        'id',
        'triwulan',
        'id_dpa_backup',
        'uuid',
        'periode',
        'realisasi_keuangan',
        'realisasi_fisik',
        'tahun',
        'id_dpa',
        'permasalahan',
        'user_insert',
        'user_update'
    ];

    public function Dpa()
    {
        return $this->belongsTo(BackupReportDpa::class, 'id_dpa_backup','key');
    }

    public function Detail(){
        return $this->hasMany(BackupReportDetailRealisasi::class,'id_realisasi');
    }
}
