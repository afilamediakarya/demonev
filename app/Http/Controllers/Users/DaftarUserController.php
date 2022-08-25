<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\UnitKerja;

class DaftarUserController extends Controller
{
    public function index()
    {
        $unit_kerja = UnitKerja::where(function ($q){
            if (hasRole('opd')){
                $q->where('id',auth()->user()->id_unit_kerja);
            }
        })->get();
        return view('users/daftar_user',compact('unit_kerja'));
    }

}
