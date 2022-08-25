<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tujuan extends Model
{
    protected $table = 'tujuan';
    protected $fillable = [
        'uuid',
        'id_unit_kerja',
        'tujuan',
        'urutan',
        'periode',
        'user_insert',
        'user_update'
    ];

    public function BidangTujuan()
    {
        return $this->hasMany(BidangTujuan::class, 'id_tujuan');
    }
}
