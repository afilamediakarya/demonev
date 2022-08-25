<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sasaran extends Model
{
    protected $table = 'sasaran';
    protected $fillable = [
        'uuid',
        'id_unit_kerja',
        'id_tujuan',
        'sasaran',
        'urutan',
        'periode',
        'user_insert',
        'user_update'
    ];

    public function BidangSasaran()
    {
        return $this->hasMany(BidangSasaran::class, 'id_sasaran');
    }
}
