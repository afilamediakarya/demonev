<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenstraKegiatanOutput extends Model
{

    protected $table = 'renstra_kegiatan_output';
    protected $fillable = [
        'uuid',
        'output',
        'volume',
        'satuan',
        'id_renstra_kegiatan',
        'user_insert',
        'user_update'
    ];

    public function RenstraKegiatan()
    {
        return $this->belongsTo(RenstraKegiatan::class, 'id_renstra_kegiatan');
    }
}
