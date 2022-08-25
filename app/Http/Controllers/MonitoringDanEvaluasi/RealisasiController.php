<?php

namespace App\Http\Controllers\MonitoringDanEvaluasi;

use App\Http\Controllers\Controller;
use App\Models\Dpa;
use App\Models\Jadwal;

class RealisasiController extends Controller
{
    public function index()
    {
        $jadwal_input = Jadwal::where('tahapan','Target')->where('sub_tahapan','Target DPA Pokok Triwulan I-IV')
            ->where('tahun',session('tahun_penganggaran',''))->first();
        return view('monitoring/realisasi',compact('jadwal_input'));
    }

    public function realisasiPelaksanaan($uuid)
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
        $periode = [
            '1' =>  cekJadwal('Realisasi','Realisasi Triwulan I'),
            '2' =>  cekJadwal('Realisasi','Realisasi Triwulan II'),
            '3' =>  cekJadwal('Realisasi','Realisasi Triwulan III'),
            '4' =>  cekJadwal('Realisasi','Realisasi Triwulan IV'),
        ];
        $jadwal_input = Jadwal::where('tahapan','Realisasi')->where('sub_tahapan','like','Realisasi Triwulan%')->get();
        return view('monitoring/atur_realisasi',compact('dpa','periode','jadwal_input'));
    }
}
