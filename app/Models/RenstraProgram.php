<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenstraProgram extends Model
{
    protected $table = 'renstra_program';
    protected $fillable = [
        'uuid',
        'id_tujuan',
        'id_sasaran',
        'id_urusan',
        'id_bidang_urusan',
        'id_program',
        'kode_program',
        'id_unit_kerja',
        'periode',
        'user_insert',
        'user_update'
    ];

    public function RenstraProgramOutcome()
    {
        return $this->hasMany(RenstraProgramOutcome::class, 'id_renstra_program');
    }

    public function Tujuan()
    {
        return $this->belongsTo(Tujuan::class, 'id_tujuan');
    }
    
    public function Sasaran()
    {
        return $this->belongsTo(Sasaran::class, 'id_sasaran');
    }
    
    public function Urusan()
    {
        return $this->belongsTo(Urusan::class, 'id_urusan');
    }
    
    public function BidangUrusan()
    {
        return $this->belongsTo(BidangUrusan::class, 'id_bidang_urusan');
    }
    
    public function Program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }
    
    public function UnitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'id_unit_kerja');
    }
}
