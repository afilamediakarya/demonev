<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupReport extends Model
{
    protected $table = 'backup_report';
    protected $fillable = [
        'uuid',
        'triwulan',
        'tahun',
        'user_insert',
        'user_update'
    ];

}
