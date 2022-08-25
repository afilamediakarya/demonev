<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TolakUkur extends Model
{
    protected $table = 'tolak_ukur';
    protected $fillable = [
        'uuid',
        'uuid_tu',
        'id_dpa',
        'tolak_ukur',
        'volume',
        'satuan',
        'tahun',
        'user_insert',
        'user_update'
    ];

    public function Dpa()
    {
        return $this->belongsTo(Dpa::class, 'id_dpa');
    }
}
