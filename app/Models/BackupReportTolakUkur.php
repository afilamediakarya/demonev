<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupReportTolakUkur extends Model
{
    protected $table = 'backup_report_tolak_ukur';
    protected $primaryKey = 'key';
    protected $fillable = [
        'id',
        'triwulan',
        'uuid',
        'id_dpa',
        'tolak_ukur',
        'volume',
        'satuan',
        'tahun',
        'user_insert',
        'user_update',
        'id_dpa_backup'
    ];

    public function Dpa()
    {
        return $this->belongsTo(BackupReportDpa::class, 'id_dpa_backup','key');
    }
}
