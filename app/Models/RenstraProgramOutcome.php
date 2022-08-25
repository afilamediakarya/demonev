<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenstraProgramOutcome extends Model
{

    protected $table = 'renstra_program_outcome';
    protected $fillable = [
        'uuid',
        'outcome',
        'volume',
        'satuan',
        'capaian_awal',
        'id_renstra_program',
        'user_insert',
        'user_update'
    ];

    public function RenstraProgram()
    {
        return $this->belongsTo(RenstraProgram::class, 'id_renstra_program');
    }
}
