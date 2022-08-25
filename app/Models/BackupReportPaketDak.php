<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupReportPaketDak extends Model
{
    protected $table = 'backup_report_paket_dak';
    protected $primaryKey = 'key';
    protected $fillable = [
        'id',
        'triwulan',
        'id_dpa_backup',
        'uuid',
        'nama_paket',
        'volume',
        'satuan',
        'penerima_manfaat',
        'anggaran_dak',
        'pendampingan',
        'total_biaya',
        'swakelola',
        'kontrak',
        'tahun',
        'id_dpa',
        'kesesuaian_rkpd',
        'kesesuaian_dpa_skpd',
        'id_sumber_dana_dpa',
        'user_insert',
        'user_update'
    ];

    public function SumberDanaDpa()
    {
        return $this->belongsTo(BackupReportSumberDanaDpa::class, 'id');
    }

    public function RealisasiDak(){
        return $this->hasMany(BackupReportRealisasiDak::class,'id_paket_dak');
    }
}
