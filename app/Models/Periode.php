<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'periode';
    protected $fillable = [
        'uuid',
        'nama_periode',
        'user_insert',
        'user_update'
    ];

    public function Target()
    {
        return $this->hasMany(Target::class, 'id_periode');
    }
}
