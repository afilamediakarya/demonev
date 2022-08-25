<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupReportTarget extends Model
{
    protected $table = 'backup_report_target';
    protected $primaryKey = 'key';
    protected $fillable = [
        'id',
        'triwulan',
        'id_dpa_backup',
        'uuid',
        'periode',
        'target_keuangan',
        'target_fisik',
        'persentase',
        'id_dpa',
        'tahun',
        'user_insert',
        'user_update'
    ];

    public function Dpa()
    {
        return $this->belongsTo(BackupReportDpa::class, 'id_dpa_backup','key');
    }
}
