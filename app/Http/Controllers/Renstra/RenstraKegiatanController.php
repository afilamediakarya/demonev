<?php

namespace App\Http\Controllers\Renstra;

use App\Http\Controllers\Controller;
use App\Models\Sasaran;
use App\Models\Satuan;
use App\Models\Kegiatan;
use App\Models\Program;

class RenstraKegiatanController extends Controller
{
    public function index()
    {
        $sasarans=Sasaran::all();
        $satuans=Satuan::all();
        $kegiatans=Kegiatan::select('kegiatan.*')->join('renstra_program','renstra_program.id_program','=','kegiatan.id_program')->where('renstra_program.id_unit_kerja',auth()->user()->id_unit_kerja)->get();
        $programs=Program::select('renstra_program.id','program.nama_program')->join('renstra_program','renstra_program.id_program','=','program.id')->where('renstra_program.id_unit_kerja',auth()->user()->id_unit_kerja)->get();
        return view('renstra/kegiatan',compact('sasarans','satuans','kegiatans','programs'));
    }

}
