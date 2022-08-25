<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $table = 'target';
    protected $fillable = [
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
        return $this->belongsTo(Dpa::class, 'id_dpa');
    }
}
