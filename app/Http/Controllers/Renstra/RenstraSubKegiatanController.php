<?php

namespace App\Http\Controllers\Renstra;

use App\Http\Controllers\Controller;
use App\Models\RenstraSubKegiatan;
use App\Models\SubKegiatan;
use App\Models\Jadwal;
use App\Models\JenisBelanja;
use App\Models\MetodePelaksanaan;
use App\Models\Satuan;
use App\Models\SumberDana;
use Illuminate\Http\Request;

class RenstraSubKegiatanController extends Controller
{
    public function index()
    {
        $jadwal_input = Jadwal::where('tahapan','Kegiatan')->where('sub_tahapan','Sub Kegiatan DPA Pokok')
            ->where('tahun',session('tahun_penganggaran',''))->first();
        return view('renstra/sub_kegiatan/main',compact('jadwal_input'));
    }

    public function detail($uuid){
        $dpa = RenstraSubKegiatan::with('TolakUkur','Realisasi','SubKegiatan','Kegiatan','Program.BidangUrusan.Urusan','Target','SumberDanaRenstraSubKegiatan')->whereUuid($uuid)->first();
        if ($dpa->is_non_urusan){
            $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
            if ($bidang_urusan) {
                $dpa->Program->BidangUrusan->Urusan->kode_urusan = $bidang_urusan->Urusan->kode_urusan;
                $dpa->Program->BidangUrusan->Urusan->nama_urusan = $bidang_urusan->Urusan->nama_urusan;
                $dpa->Program->BidangUrusan->kode_bidang_urusan = $bidang_urusan->kode_bidang_urusan;
                $dpa->Program->BidangUrusan->nama_bidang_urusan = $bidang_urusan->nama_bidang_urusan;
            }
        }
        return view('renstra/sub_kegiatan/detail',compact('dpa'));
    }

    public function setOutput()
    {
        $jenis_belanja = JenisBelanja::get();
        $sumber_dana = SumberDana::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        $sub_kegiatans = SubKegiatan::join('renstra_kegiatan','renstra_kegiatan.id_kegiatan','=','sub_kegiatan.id_kegiatan')
        ->select('sub_kegiatan.*')->where('renstra_kegiatan.id_unit_kerja',auth()->user()->id_unit_kerja)->get();

        return view('renstra/sub_kegiatan/atur', compact('jenis_belanja', 'sumber_dana', 'metode_pelaksanaan', 'satuan','sub_kegiatans'));
    }


    public function edit($uuid)
    {
        $jenis_belanja = JenisBelanja::get();
        $sumber_dana = SumberDana::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        $sub_kegiatans = SubKegiatan::join('renstra_kegiatan','renstra_kegiatan.id_kegiatan','=','sub_kegiatan.id_kegiatan')
        ->select('sub_kegiatan.*')->get();
        $data=RenstraSubkegiatan::where('uuid',$uuid)->first();
        return view('renstra/sub_kegiatan/edit', compact('jenis_belanja', 'sumber_dana', 'metode_pelaksanaan', 'satuan','uuid','sub_kegiatans','data'));
    }

  
}
