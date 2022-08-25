<?php

namespace App\Http\Controllers\Renstra;

use App\Http\Controllers\Controller;
use App\Models\Sasaran;
use App\Models\Satuan;
use App\Models\Program;

class RenstraProgramController extends Controller
{
    public function index()
    {
        
        $id_unit_kerja=auth()->user()->id_unit_kerja;
        $sasarans=Sasaran::where('id_unit_kerja',$id_unit_kerja)->get();
        $satuans=Satuan::all();
        $program1=Program::join('unit_kerja_bidang_urusan','unit_kerja_bidang_urusan.id_bidang_urusan','=','program.id_bidang_urusan')
        ->where('unit_kerja_bidang_urusan.id_unit_kerja',$id_unit_kerja)
        ->select('program.id','program.nama_program')
        ->groupBy('program.nama_program');
        $programs=Program::
        join('bidang_urusan','bidang_urusan.id','=','program.id_bidang_urusan')
        ->where('bidang_urusan.kode_bidang_urusan','00')
        ->select('program.id','program.nama_program')
        ->union($program1)

        ->get();
        return view('renstra/program',compact('sasarans','satuans','programs'));
    }

}
