<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TematikDak extends Model
{
    protected $table = 'tematik_dak';
    protected $fillable = [
        'uuid',
        'kode_tematik',
        'tematik',
        'user_insert',
        'user_update'
    ];

    public function RincianDak()
    {
        return $this->hasMany(RincianDak::class, 'id_tematik');
    }

}
