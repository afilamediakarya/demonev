<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'nama_lengkap',
        'username',
        'password',
//        'id_pegawai',
        'nip',
        'jabatan',
        'no_telp',
        'id_unit_kerja',
        'id_role',
        'status',
        'user_insert',
        'user_update'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//    public function Pegawai()
//    {
//        return $this->belongsTo(Pegawai::class, 'id_pegawai');
//    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function hasAkses($akses)
    {
        return $this->Role->hasAkses($akses);
    }

    public function hasRole($role)
    {
        return $this->Role()->where('nama_role', $role)->first() !== null;
    }

    public function Role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function UnitKerja(){
        return $this->belongsTo(UnitKerja::class,'id_unit_kerja');
    }
}
