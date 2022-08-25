<?php

namespace App\Http\Controllers\Kegiatan;

use App\Http\Controllers\Controller;
use App\Models\Dpa;
use App\Models\Jadwal;
use App\Models\JenisBelanja;
use App\Models\MetodePelaksanaan;
use App\Models\Satuan;
use App\Models\SumberDana;
use Illuminate\Http\Request;

class RenstraController extends Controller
{
    public function index()
    {
        $jadwal_input = Jadwal::where('tahapan','Kegiatan')->where('sub_tahapan','Sub Kegiatan DPA Pokok')
            ->where('tahun',session('tahun_penganggaran',''))->first();
        return view('kegiatan/renstra',compact('jadwal_input'));
    }

    public function detail($uuid){
        $dpa = Dpa::with('TolakUkur','Realisasi','SubKegiatan','Kegiatan','Program.BidangUrusan.Urusan','Target','SumberDanaDpa')->whereUuid($uuid)->first();
        if ($dpa->is_non_urusan){
            $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
            if ($bidang_urusan) {
                $dpa->Program->BidangUrusan->Urusan->kode_urusan = $bidang_urusan->Urusan->kode_urusan;
                $dpa->Program->BidangUrusan->Urusan->nama_urusan = $bidang_urusan->Urusan->nama_urusan;
                $dpa->Program->BidangUrusan->kode_bidang_urusan = $bidang_urusan->kode_bidang_urusan;
                $dpa->Program->BidangUrusan->nama_bidang_urusan = $bidang_urusan->nama_bidang_urusan;
            }
        }
        return view('kegiatan/detail',compact('dpa'));
    }

    public function setOutput()
    {
        $jenis_belanja = JenisBelanja::get();
        $sumber_dana = SumberDana::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        return view('kegiatan/atur_dpa', compact('jenis_belanja', 'sumber_dana', 'metode_pelaksanaan', 'satuan'));
    }

    public function edit($uuid)
    {
        $jenis_belanja = JenisBelanja::get();
        $sumber_dana = SumberDana::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        return view('kegiatan/edit_dpa', compact('jenis_belanja', 'sumber_dana', 'metode_pelaksanaan', 'satuan','uuid'));
    }

    public function editTolakUkur($uuid)
    {
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        return view('kegiatan/atur_tolak_ukur_dpa', compact( 'satuan','uuid'));
    }

    public function paket_dak(){
        $jadwal_input = Jadwal::where('tahapan','Kegiatan')->where('sub_tahapan','Sub Kegiatan DPA Pokok')->where('tahun',session('tahun_penganggaran',''))->first();
        return view('kegiatan/dak', compact('jadwal_input'));
    }

    public function perencanaan($uuid,Request $request) {
        $uuid_sd=$request->get('uuid_sd');
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        $dpa = Dpa::query()->with(
        ['TolakUkur','Target','SubKegiatan','Kegiatan','Program.BidangUrusan.Urusan',
        'SumberDanaDpa' => function($query) use ($uuid_sd) {
            $query->whereRaw("uuid='$uuid_sd'");
        }]
        // $dpa = Dpa::with('TolakUkur',
        // 'Target',
        // 'SubKegiatan',
        // 'Kegiatan',
        // 'Program.BidangUrusan.Urusan',
        // array('SumberDanaDpa' => function($query) {
        //     $query->select('sumber_dana_dpa.nilai_pagu as nilai_pagu_dak');
        // })
        )->whereUuid($uuid)->first();
        if ($dpa->is_non_urusan){
            $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
            if ($bidang_urusan) {
                $dpa->Program->BidangUrusan->Urusan->kode_urusan = $bidang_urusan->Urusan->kode_urusan;
                $dpa->Program->BidangUrusan->Urusan->nama_urusan = $bidang_urusan->Urusan->nama_urusan;
                $dpa->Program->BidangUrusan->kode_bidang_urusan = $bidang_urusan->kode_bidang_urusan;
                $dpa->Program->BidangUrusan->nama_bidang_urusan = $bidang_urusan->nama_bidang_urusan;
            }
        }
        return view('kegiatan.atur_dak', compact('dpa', 'satuan', 'uuid','uuid_sd'));
    }
}
