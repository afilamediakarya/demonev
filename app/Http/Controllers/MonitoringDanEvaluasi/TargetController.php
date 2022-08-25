<?php

namespace App\Http\Controllers\MonitoringDanEvaluasi;

use App\Http\Controllers\Controller;
use App\Models\Dpa;
use App\Models\Jadwal;

class TargetController extends Controller
{
    public function index()
    {
        $jadwal_input = Jadwal::where('tahapan','Target')->where('sub_tahapan','Target DPA Pokok Triwulan I-IV')
            ->where('tahun',session('tahun_penganggaran',''))->first();
        return view('monitoring/target',compact('jadwal_input'));
    }

    public function aturTargetPelaksanaan($uuid)
    {
        $dpa = Dpa::with('TolakUkur','Target','SubKegiatan','Kegiatan','Program.BidangUrusan.Urusan')->whereUuid($uuid)->first();
        if ($dpa->is_non_urusan){
            $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
            if ($bidang_urusan) {
                $dpa->Program->BidangUrusan->Urusan->kode_urusan = $bidang_urusan->Urusan->kode_urusan;
                $dpa->Program->BidangUrusan->Urusan->nama_urusan = $bidang_urusan->Urusan->nama_urusan;
                $dpa->Program->BidangUrusan->kode_bidang_urusan = $bidang_urusan->kode_bidang_urusan;
                $dpa->Program->BidangUrusan->nama_bidang_urusan = $bidang_urusan->nama_bidang_urusan;
            }
        }
        return view('monitoring/atur_target',compact('dpa'));
    }
}
