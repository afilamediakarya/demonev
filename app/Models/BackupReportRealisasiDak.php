<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupReportRealisasiDak extends Model
{
    protected $table = 'backup_report_realisasi_dak';
    protected $primaryKey = 'key';
    protected $fillable = [
        'id',
        'triwulan',
        'id_dpa_backup',
        'uuid',
        'periode',
        'id_paket_dak',
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

    public function PaketDak()
    {
        return $this->belongsTo(BackupReportPaketDak::class, 'id_paket_dak');
    }

    public function Detail(){
        return $this->hasMany(BackupReportDetailRealisasiDak::class,'id_realisasi_dak');
    }
}
