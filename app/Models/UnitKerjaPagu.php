<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerjaPagu extends Model
{

    protected $table = 'unit_kerja_pagu';
    protected $fillable = [
        'id_unit_kerja',
        'tahun',
        'max_pagu_tahun'
    ];

    public function UnitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'id_unit_kerja');
    }
}
