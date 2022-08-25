<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTahapan extends Model
{
    protected $table = 'sub_tahapan';
    protected $fillable = [
        'id_tahapan',
        'sub_tahapan',
    ];

    public function Tahapan()
    {
        return $this->belongsTo(Tahapan::class, 'id_tahapan');
    }
}
