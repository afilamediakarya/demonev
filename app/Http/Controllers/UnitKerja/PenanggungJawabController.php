<?php

namespace App\Http\Controllers\UnitKerja;

use App\Http\Controllers\Controller;
use App\Models\UnitKerja;

class PenanggungJawabController extends Controller
{
    public function index()
    {
        $unit_kerja = UnitKerja::where(function ($q){
            if (hasRole('opd')){
                $q->where('id',auth()->user()->id_unit_kerja);
            }
        })->get();
        return view('unit_kerja/penanggung_jawab',compact('unit_kerja'));
    }

}
