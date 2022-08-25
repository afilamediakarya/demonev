<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahapan extends Model
{
    protected $table = 'tahapan';
    protected $fillable = [
        'tahapan',
    ];

    public function SubTahapan()
    {
        return $this->hasMany(SubTahapan::class, 'id_tahapan');
    }
}
