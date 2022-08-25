<?php

namespace App\Http\Controllers\Renstra;

use App\Http\Controllers\Controller;
use App\Models\RenstraRealisasiSubKegiatan;
use App\Models\RealisasiSubKegiatan;
use App\Models\RenstraSubKegiatan;
use App\Models\Jadwal;
use App\Models\JenisBelanja;
use App\Models\MetodePelaksanaan;
use App\Models\Satuan;
use App\Models\SumberDana;
use Illuminate\Http\Request;

class RenstraRealisasiSubKegiatanController extends Controller
{
    public function index()
    {
        $jadwal_input = Jadwal::where('tahapan','Kegiatan')->where('sub_tahapan','Sub Kegiatan DPA Pokok')
            ->where('tahun',session('tahun_penganggaran',''))->first();
        return view('renstra/realisasi_sub_kegiatan/main',compact('jadwal_input'));
    }

    public function detail($uuid){
        $dpa = RenstraRealisasiSubKegiatan::with('TolakUkur','Realisasi','RealisasiSubKegiatan','Kegiatan','Program.BidangUrusan.Urusan','Target','SumberDanaRenstraRealisasiSubKegiatan')->whereUuid($uuid)->first();
        if ($dpa->is_non_urusan){
            $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
            if ($bidang_urusan) {
                $dpa->Program->BidangUrusan->Urusan->kode_urusan = $bidang_urusan->Urusan->kode_urusan;
                $dpa->Program->BidangUrusan->Urusan->nama_urusan = $bidang_urusan->Urusan->nama_urusan;
                $dpa->Program->BidangUrusan->kode_bidang_urusan = $bidang_urusan->kode_bidang_urusan;
                $dpa->Program->BidangUrusan->nama_bidang_urusan = $bidang_urusan->nama_bidang_urusan;
            }
        }
        return view('renstra/realisasi_sub_kegiatan/detail',compact('dpa'));
    }



    public function edit($uuid)
    {
        $jenis_belanja = JenisBelanja::get();
        $sumber_dana = SumberDana::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        $data=RenstraSubKegiatan::
          join('sasaran','sasaran.id','=','renstra_sub_kegiatan.id_sasaran')
        ->join('tujuan','tujuan.id','=','renstra_sub_kegiatan.id_tujuan')
        ->join('program','program.id','=','renstra_sub_kegiatan.id_program')
        ->join('bidang_urusan','bidang_urusan.id','=','renstra_sub_kegiatan.id_bidang_urusan')
        ->join('urusan','bidang_urusan.id_urusan','=','urusan.id')
        ->join('kegiatan','kegiatan.id','=','renstra_sub_kegiatan.id_kegiatan')
        ->join('sub_kegiatan','sub_kegiatan.id','=','renstra_sub_kegiatan.id_sub_kegiatan')
        ->select('renstra_sub_kegiatan.*','bidang_urusan.nama_bidang_urusan as bidang_urusan','urusan.nama_urusan as urusan','sub_kegiatan.kode_sub_kegiatan','sub_kegiatan.nama_sub_kegiatan as sub_kegiatan','sasaran.sasaran','tujuan.tujuan','program.nama_program as program','kegiatan.nama_kegiatan as kegiatan')
        ->where('renstra_sub_kegiatan.uuid',$uuid)->first();
        return view('renstra/realisasi_sub_kegiatan/edit', compact('jenis_belanja', 'sumber_dana', 'metode_pelaksanaan', 'satuan','uuid','data'));
    }

  
}
