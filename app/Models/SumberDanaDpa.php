<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SumberDanaDpa extends Model
{
    protected $table = 'sumber_dana_dpa';
    protected $with = ['PaketDak'];
    protected $fillable = [
        'uuid',
        'jenis_belanja',
        'sumber_dana',
        'metode_pelaksanaan',
        'nilai_pagu',
        'tahun',
        'id_dpa',
        'user_insert',
        'user_update'
    ];

    public function Dpa()
    {
        return $this->belongsTo(Dpa::class, 'id_dpa');
    }

    public function DetailRealisasi(){
        return $this->hasMany(DetailRealisasi::class,'id_sumber_dana_dpa');
    }

    public function getNilaiPaguRpAttribute(){
        if ($this->nilai_pagu)
            return number_format($this->nilai_pagu,2,',','.');
    }

    public function PaketDak(){
        return $this->hasMany(PaketDak::class,'id_sumber_dana_dpa');
    }
    
    public function PaketDau(){
        return $this->hasMany(PaketDau::class,'id_sumber_dana_dpa');
    }
}
