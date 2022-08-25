<?php

namespace App\Http\Controllers\MonitoringDanEvaluasi;

use App\Http\Controllers\Controller;

use App\Models\Dpa;
use App\Models\PaketDak;
use App\Models\RealisasiDak;
use App\Models\SumberDanaDpa;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class DakController extends Controller
{
    public function realisasi_dak()
    {
        $label = 'Realisasi DAK Fisik';
        return view('monitoring/realisasi_dak',compact('label'));
    }

    public function realisasi_dak_non_fisik()
    {
        $label = 'Realisasi DAK Non Fisik';
        return view('monitoring/realisasi_dak_non_fisik',compact('label'));
    }

    public function realisasi_dak_pen()
    {
        $label = 'Realisasi PEN';
        return view('monitoring/realisasi_dak_pen',compact('label'));
    }

    public function realisasi_dak_apbn()
    {
        $label = 'Realisasi APBN';
        return view('monitoring/realisasi_dak_pen',compact('label'));
    }

    public function realisasi_dak_apbd1()
    {
        $label = 'Realisasi APBD I';
        return view('monitoring/realisasi_dak_pen',compact('label'));
    }

    public function realisasi_dak_apbd2()
    {
        $label = 'Realisasi APBD II';
        return view('monitoring/realisasi_dak_pen',compact('label'));
    }

    

    // public function atur_realisasi_dak(Request $request,$uuid)
    // {
    //     $dpa = Dpa::with('TolakUkur','Realisasi','SubKegiatan','Kegiatan','Program.BidangUrusan.Urusan','Target','SumberDanaDpa')->whereUuid($uuid)->first();
    //     if ($dpa->is_non_urusan){
    //         $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
    //         if ($bidang_urusan) {
    //             $dpa->Program->BidangUrusan->Urusan->kode_urusan = $bidang_urusan->Urusan->kode_urusan;
    //             $dpa->Program->BidangUrusan->Urusan->nama_urusan = $bidang_urusan->Urusan->nama_urusan;
    //             $dpa->Program->BidangUrusan->kode_bidang_urusan = $bidang_urusan->kode_bidang_urusan;
    //             $dpa->Program->BidangUrusan->nama_bidang_urusan = $bidang_urusan->nama_bidang_urusan;
    //         }
    //     }
    //     $periode = [
    //         '1' =>  cekJadwal('Realisasi','Realisasi Triwulan I'),
    //         '2' =>  cekJadwal('Realisasi','Realisasi Triwulan II'),
    //         '3' =>  cekJadwal('Realisasi','Realisasi Triwulan III'),
    //         '4' =>  cekJadwal('Realisasi','Realisasi Triwulan IV'),
    //     ];
    //     $jadwal_input = Jadwal::where('tahapan','Realisasi')->where('sub_tahapan','like','Realisasi Triwulan%')->get();
    //     return view('monitoring/atur_realisasi_dak',compact('dpa','periode','jadwal_input','realisasi_dak','tahun_anggaran','paket_daks'));
    // }
    public function atur_realisasi_dak(Request $request,$uuid)
    {
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
        $sumber_dana_dpa=SumberDanaDpa::select('id','nilai_pagu','sumber_dana')->where('uuid',$request->uuid_sd)->first();
        $id_sumber_dana_dpa=$sumber_dana_dpa->id;
        $nilai_pagu_sumber_dana_dpa=$sumber_dana_dpa->nilai_pagu;
        $sumber_dana=$sumber_dana_dpa->sumber_dana;
        $paket_daks=PaketDak::where('id_sumber_dana_dpa',$id_sumber_dana_dpa)->get();
        // $paket_dak=PaketDak::first();
        $sum=PaketDak::first();
        $periode = [
            '1' =>  cekJadwal('Realisasi','Realisasi Triwulan I'),
            '2' =>  cekJadwal('Realisasi','Realisasi Triwulan II'),
            '3' =>  cekJadwal('Realisasi','Realisasi Triwulan III'),
            '4' =>  cekJadwal('Realisasi','Realisasi Triwulan IV'),
        ];
        $uuid_sd=$request->uuid_sd;
        $realisasi_dak= new RealisasiDak;
        $jadwal_input = Jadwal::where('tahapan','Realisasi')->where('sub_tahapan','like','Realisasi Triwulan%')->get();
        $tahun_anggaran=$request->session()->get('tahun_penganggaran');
        return view('monitoring/atur_realisasi_dak',compact('dpa','periode','jadwal_input','realisasi_dak','tahun_anggaran','paket_daks','uuid_sd','nilai_pagu_sumber_dana_dpa','sumber_dana'));
    }

    public function atur_realisasi_dak_non_fisik(Request $request,$uuid)
    {
        $label = 'Realisasi DAK Non Fisik';
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
        $sumber_dana_dpa=SumberDanaDpa::select('id','nilai_pagu','sumber_dana')->where('uuid',$request->uuid_sd)->first();
        $id_sumber_dana_dpa=$sumber_dana_dpa->id;
        $nilai_pagu_sumber_dana_dpa=$sumber_dana_dpa->nilai_pagu;
        $sumber_dana=$sumber_dana_dpa->sumber_dana;
        $paket_daks=PaketDak::where('id_sumber_dana_dpa',$id_sumber_dana_dpa)->get();
        // $paket_dak=PaketDak::first();
        $sum=PaketDak::first();
        $periode = [
            '1' =>  cekJadwal('Realisasi','Realisasi Triwulan I'),
            '2' =>  cekJadwal('Realisasi','Realisasi Triwulan II'),
            '3' =>  cekJadwal('Realisasi','Realisasi Triwulan III'),
            '4' =>  cekJadwal('Realisasi','Realisasi Triwulan IV'),
        ];
        $uuid_sd=$request->uuid_sd;
        $realisasi_dak= new RealisasiDak;
        $jadwal_input = Jadwal::where('tahapan','Realisasi')->where('sub_tahapan','like','Realisasi Triwulan%')->get();
        $tahun_anggaran=$request->session()->get('tahun_penganggaran');
        return view('monitoring/atur_realisasi_dak_non_fisik',compact('dpa','periode','jadwal_input','realisasi_dak','tahun_anggaran','paket_daks','uuid_sd','nilai_pagu_sumber_dana_dpa','sumber_dana','label'));
    }

    public function atur_realisasi_dak_pen(Request $request,$uuid){
        $label = 'Realisasi PEN';
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
        $sumber_dana_dpa=SumberDanaDpa::select('id','nilai_pagu','sumber_dana')->where('uuid',$request->uuid_sd)->first();
        $id_sumber_dana_dpa=$sumber_dana_dpa->id;
        $nilai_pagu_sumber_dana_dpa=$sumber_dana_dpa->nilai_pagu;
        $sumber_dana=$sumber_dana_dpa->sumber_dana;
        $paket_daks=PaketDak::where('id_sumber_dana_dpa',$id_sumber_dana_dpa)->get();
        // $paket_dak=PaketDak::first();
        $sum=PaketDak::first();
        $periode = [
            '1' =>  cekJadwal('Realisasi','Realisasi Triwulan I'),
            '2' =>  cekJadwal('Realisasi','Realisasi Triwulan II'),
            '3' =>  cekJadwal('Realisasi','Realisasi Triwulan III'),
            '4' =>  cekJadwal('Realisasi','Realisasi Triwulan IV'),
        ];
        $uuid_sd=$request->uuid_sd;
        $realisasi_dak= new RealisasiDak;
        $jadwal_input = Jadwal::where('tahapan','Realisasi')->where('sub_tahapan','like','Realisasi Triwulan%')->get();
        $tahun_anggaran=$request->session()->get('tahun_penganggaran');
        return view('monitoring/atur_realisasi_dak_non_fisik',compact('dpa','periode','jadwal_input','realisasi_dak','tahun_anggaran','paket_daks','uuid_sd','nilai_pagu_sumber_dana_dpa','sumber_dana','label'));
    }

    public function atur_realisasi_dak_apbn(Request $request,$uuid){
        $label = 'Realisasi APBN';
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
        $sumber_dana_dpa=SumberDanaDpa::select('id','nilai_pagu','sumber_dana')->where('uuid',$request->uuid_sd)->first();
        $id_sumber_dana_dpa=$sumber_dana_dpa->id;
        $nilai_pagu_sumber_dana_dpa=$sumber_dana_dpa->nilai_pagu;
        $sumber_dana=$sumber_dana_dpa->sumber_dana;
        $paket_daks=PaketDak::where('id_sumber_dana_dpa',$id_sumber_dana_dpa)->get();
        // $paket_dak=PaketDak::first();
        $sum=PaketDak::first();
        $periode = [
            '1' =>  cekJadwal('Realisasi','Realisasi Triwulan I'),
            '2' =>  cekJadwal('Realisasi','Realisasi Triwulan II'),
            '3' =>  cekJadwal('Realisasi','Realisasi Triwulan III'),
            '4' =>  cekJadwal('Realisasi','Realisasi Triwulan IV'),
        ];
        $uuid_sd=$request->uuid_sd;
        $realisasi_dak= new RealisasiDak;
        $jadwal_input = Jadwal::where('tahapan','Realisasi')->where('sub_tahapan','like','Realisasi Triwulan%')->get();
        $tahun_anggaran=$request->session()->get('tahun_penganggaran');
        return view('monitoring/atur_realisasi_dak_non_fisik',compact('dpa','periode','jadwal_input','realisasi_dak','tahun_anggaran','paket_daks','uuid_sd','nilai_pagu_sumber_dana_dpa','sumber_dana','label'));
    }

    public function atur_realisasi_dak_apbd1(Request $request,$uuid){
        $label = 'Realisasi APBD I';
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
        $sumber_dana_dpa=SumberDanaDpa::select('id','nilai_pagu','sumber_dana')->where('uuid',$request->uuid_sd)->first();
        $id_sumber_dana_dpa=$sumber_dana_dpa->id;
        $nilai_pagu_sumber_dana_dpa=$sumber_dana_dpa->nilai_pagu;
        $sumber_dana=$sumber_dana_dpa->sumber_dana;
        $paket_daks=PaketDak::where('id_sumber_dana_dpa',$id_sumber_dana_dpa)->get();
        // $paket_dak=PaketDak::first();
        $sum=PaketDak::first();
        $periode = [
            '1' =>  cekJadwal('Realisasi','Realisasi Triwulan I'),
            '2' =>  cekJadwal('Realisasi','Realisasi Triwulan II'),
            '3' =>  cekJadwal('Realisasi','Realisasi Triwulan III'),
            '4' =>  cekJadwal('Realisasi','Realisasi Triwulan IV'),
        ];
        $uuid_sd=$request->uuid_sd;
        $realisasi_dak= new RealisasiDak;
        $jadwal_input = Jadwal::where('tahapan','Realisasi')->where('sub_tahapan','like','Realisasi Triwulan%')->get();
        $tahun_anggaran=$request->session()->get('tahun_penganggaran');
        return view('monitoring/atur_realisasi_dak_non_fisik',compact('dpa','periode','jadwal_input','realisasi_dak','tahun_anggaran','paket_daks','uuid_sd','nilai_pagu_sumber_dana_dpa','sumber_dana','label'));
    }

    public function atur_realisasi_dak_apbd2(Request $request,$uuid){
        $label = 'Realisasi APBD II';
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
        $sumber_dana_dpa=SumberDanaDpa::select('id','nilai_pagu','sumber_dana')->where('uuid',$request->uuid_sd)->first();
        $id_sumber_dana_dpa=$sumber_dana_dpa->id;
        $nilai_pagu_sumber_dana_dpa=$sumber_dana_dpa->nilai_pagu;
        $sumber_dana=$sumber_dana_dpa->sumber_dana;
        $paket_daks=PaketDak::where('id_sumber_dana_dpa',$id_sumber_dana_dpa)->get();
        // $paket_dak=PaketDak::first();
        $sum=PaketDak::first();
        $periode = [
            '1' =>  cekJadwal('Realisasi','Realisasi Triwulan I'),
            '2' =>  cekJadwal('Realisasi','Realisasi Triwulan II'),
            '3' =>  cekJadwal('Realisasi','Realisasi Triwulan III'),
            '4' =>  cekJadwal('Realisasi','Realisasi Triwulan IV'),
        ];
        $uuid_sd=$request->uuid_sd;
        $realisasi_dak= new RealisasiDak;
        $jadwal_input = Jadwal::where('tahapan','Realisasi')->where('sub_tahapan','like','Realisasi Triwulan%')->get();
        $tahun_anggaran=$request->session()->get('tahun_penganggaran');
        return view('monitoring/atur_realisasi_dak_non_fisik',compact('dpa','periode','jadwal_input','realisasi_dak','tahun_anggaran','paket_daks','uuid_sd','nilai_pagu_sumber_dana_dpa','sumber_dana','label'));
    }
}
