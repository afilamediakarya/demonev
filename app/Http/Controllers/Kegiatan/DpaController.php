<?php

namespace App\Http\Controllers\Kegiatan;

use App\Http\Controllers\Controller;
use App\Models\Dpa;
use App\Models\Jadwal;
use App\Models\Desa;
use App\Models\RincianDak;
use App\Models\JenisBelanja;
use App\Models\MetodePelaksanaan;
use App\Models\Satuan;
use App\Models\SumberDana;
use Illuminate\Http\Request;
use DB;

class DpaController extends Controller
{
    public function index()
    {
        $jadwal_input = Jadwal::where('tahapan','Kegiatan')->where('sub_tahapan','Sub Kegiatan DPA Pokok')
            ->where('tahun',session('tahun_penganggaran',''))->first();
        return view('kegiatan/dpa',compact('jadwal_input'));
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

    public function paket_dak_non_fisik(){
        $jadwal_input = Jadwal::where('tahapan','Kegiatan')->where('sub_tahapan','Sub Kegiatan DPA Pokok')->where('tahun',session('tahun_penganggaran',''))->first();
        return view('kegiatan/dak_non_fisik', compact('jadwal_input'));
    }

    public function paket_dak_pen(){
        $label = 'Paket PEN';
        $jadwal_input = Jadwal::where('tahapan','Kegiatan')->where('sub_tahapan','Sub Kegiatan DPA Pokok')->where('tahun',session('tahun_penganggaran',''))->first();
        return view('kegiatan/paketDakSame', compact('jadwal_input','label'));
    }

    public function paket_dak_apbn(){
        $label = 'Paket APBN';
        $jadwal_input = Jadwal::where('tahapan','Kegiatan')->where('sub_tahapan','Sub Kegiatan DPA Pokok')->where('tahun',session('tahun_penganggaran',''))->first();
        return view('kegiatan/paketDakSame', compact('jadwal_input','label'));
    }

    public function paket_dak_apbd1(){
        $label = 'Paket APBD I';
        $jadwal_input = Jadwal::where('tahapan','Kegiatan')->where('sub_tahapan','Sub Kegiatan DPA Pokok')->where('tahun',session('tahun_penganggaran',''))->first();
        return view('kegiatan/paketDakSame', compact('jadwal_input','label'));
    }

    public function paket_dak_apbd2(){
        $label = 'Paket APBD II';
        $jadwal_input = Jadwal::where('tahapan','Kegiatan')->where('sub_tahapan','Sub Kegiatan DPA Pokok')->where('tahun',session('tahun_penganggaran',''))->first();
        return view('kegiatan/paketDakSame', compact('jadwal_input','label'));
    }
    
    public function paket_dau(){
        $jadwal_input = Jadwal::where('tahapan','Kegiatan')->where('sub_tahapan','Sub Kegiatan DPA Pokok')->where('tahun',session('tahun_penganggaran',''))->first();
        return view('kegiatan/dau', compact('jadwal_input'));
    }

    public function perencanaan($uuid,Request $request) {
        $uuid_sd=$request->get('uuid_sd');
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        $rincianDak = DB::table('rincian_dak')->select('id','kode_rincian','rincian')->latest()->get();
        $desas = Desa::orderBy('nama','ASC')->get();
        $dpa = Dpa::query()->with(
        ['TolakUkur','Target','SubKegiatan','Kegiatan','Program.BidangUrusan.Urusan',
        'SumberDanaDpa' => function($query) use ($uuid_sd) {
            $query->whereRaw("uuid='$uuid_sd'");
        }]
      
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
        return view('kegiatan.atur_dak', compact('dpa', 'satuan', 'uuid','uuid_sd','desas','rincianDak'));
    }

    public function perencanaan_dak_non_fisik($uuid,Request $request) {
        $label = 'Paket DAK - Non Fisik';
        $uuid_sd=$request->get('uuid_sd');
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        $desas = Desa::orderBy('nama','ASC')->get();
        $dpa = Dpa::query()->with(
        ['TolakUkur','Target','SubKegiatan','Kegiatan','Program.BidangUrusan.Urusan',
        'SumberDanaDpa' => function($query) use ($uuid_sd) {
            $query->whereRaw("uuid='$uuid_sd'");
        }]
      
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
        return view('kegiatan.atur_dak_non_fisik', compact('dpa', 'satuan', 'uuid','uuid_sd','desas','label'));
    }

    public function perencanaan_dak_pen($uuid,Request $request) {
        $label = 'Paket PEN';

        $uuid_sd=$request->get('uuid_sd');
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        $desas = Desa::orderBy('nama','ASC')->get();
        $dpa = Dpa::query()->with(
        ['TolakUkur','Target','SubKegiatan','Kegiatan','Program.BidangUrusan.Urusan',
        'SumberDanaDpa' => function($query) use ($uuid_sd) {
            $query->whereRaw("uuid='$uuid_sd'");
        }]
      
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
        return view('kegiatan.atur_dak_non_fisik', compact('dpa', 'satuan', 'uuid','uuid_sd','desas','label'));
    }

    public function perencanaan_dak_apbn($uuid,Request $request){
        $label = 'Paket APBN';
        $uuid_sd=$request->get('uuid_sd');
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        $desas = Desa::orderBy('nama','ASC')->get();
        $dpa = Dpa::query()->with(
        ['TolakUkur','Target','SubKegiatan','Kegiatan','Program.BidangUrusan.Urusan',
        'SumberDanaDpa' => function($query) use ($uuid_sd) {
            $query->whereRaw("uuid='$uuid_sd'");
        }]
      
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
        return view('kegiatan.atur_dak_non_fisik', compact('dpa', 'satuan', 'uuid','uuid_sd','desas','label'));
    }
    
    public function perencanaan_dak_apbd1($uuid,Request $request){
        $label = 'Paket APBD I';
        $uuid_sd=$request->get('uuid_sd');
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        $desas = Desa::orderBy('nama','ASC')->get();
        $dpa = Dpa::query()->with(
        ['TolakUkur','Target','SubKegiatan','Kegiatan','Program.BidangUrusan.Urusan',
        'SumberDanaDpa' => function($query) use ($uuid_sd) {
            $query->whereRaw("uuid='$uuid_sd'");
        }]
      
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
        return view('kegiatan.atur_dak_non_fisik', compact('dpa', 'satuan', 'uuid','uuid_sd','desas','label'));
    }

    public function perencanaan_dak_apbd2($uuid,Request $request){
        $label = 'Paket APBD II';
        $uuid_sd=$request->get('uuid_sd');
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        $desas = Desa::orderBy('nama','ASC')->get();
        $dpa = Dpa::query()->with(
        ['TolakUkur','Target','SubKegiatan','Kegiatan','Program.BidangUrusan.Urusan',
        'SumberDanaDpa' => function($query) use ($uuid_sd) {
            $query->whereRaw("uuid='$uuid_sd'");
        }]
      
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
        return view('kegiatan.atur_dak_non_fisik', compact('dpa', 'satuan', 'uuid','uuid_sd','desas','label'));
    }
    

    public function perencanaan_dau($uuid,Request $request) {
        $uuid_sd=$request->get('uuid_sd');
        $satuan = Satuan::orderBy('nama_satuan','ASC')->get();
        $desas = Desa::orderBy('nama','ASC')->get();
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
        return view('kegiatan.atur_dau', compact('dpa', 'satuan', 'uuid','uuid_sd','desas'));
    }
}
