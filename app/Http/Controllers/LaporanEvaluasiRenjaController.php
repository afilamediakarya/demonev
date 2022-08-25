<?php

namespace App\Http\Controllers;

use App\Models\BackupReport;
use App\Models\BidangUrusan;
use App\Models\JenisBelanja;
use App\Models\MetodePelaksanaan;
use App\Models\ProfileDaerah;
use App\Models\SumberDana;
use App\Models\UnitKerja;
use App\Models\Dpa;
use App\Models\Realisasi;
use App\Models\RenstraSubKegiatanTarget;
use App\Models\RenstraSubKegiatan;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;


class LaporanEvaluasiRenjaController extends Controller
{
    public function index()
    {
        
        $unit_kerja_selected = $metode_pelaksanaan_selected = $jenis_belanja_selected = $tabel = '';
        $sumber_dana = SumberDana::whereRaw("nama_sumber_dana NOT LIKE '%DAK%'")->get();
        $unit_kerja = UnitKerja::where(function ($q) {
            if (hasRole('opd'))
                $q->where('id', auth()->user()->id_unit_kerja);
        })->get();
        $jenis_belanja = JenisBelanja::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $sumber_dana_selected = request('sumber_dana', '');
        if (hasRole('admin')) {
            $unit_kerja_selected = request('unit_kerja', '');
        } else if (hasRole('opd')) {
            $unit_kerja_selected = auth()->user()->id_unit_kerja;
        }
       
        $jenis_belanja_selected = request('jenis_belanja', '');
        $metode_pelaksanaan_selected = request('metode_pelaksanaan', '');
        $tahun = session('tahun_penganggaran','');
        $semester_selected = request('semester', '');
        if($semester_selected==1){
            $triwulan=2;
        }else{
            $triwulan=4;
        }
        $tahun_sebelum=$tahun-1;
        $tahun_sebelum_sebelumnya=$tahun_sebelum-1;
        // $data[][] = [];
        $data=array();
        // $data['urusan'][] = [];
        $total_pagu_keseluruhan = 0;
        $total_realisasi_keuangan = 0;
        $where="";
        $where2="";
        if(!empty($unit_kerja_selected)){
            $where.="AND id_unit_kerja='$unit_kerja_selected'";
            $where2.="AND dpa.id_unit_kerja='$unit_kerja_selected'";
        }

        // return $semester_selected;

        if ($semester_selected !== '') {
            if($unit_kerja_selected != ''){
                $data=DB::table('renstra_sub_kegiatan')->select('sasaran.*')->join('sasaran','sasaran.id','=','renstra_sub_kegiatan.id_sasaran')->whereRaw("renstra_sub_kegiatan.id_sasaran<>'' AND renstra_sub_kegiatan.id_unit_kerja='$unit_kerja_selected'")->groupBy('renstra_sub_kegiatan.id_sasaran')->get();

                foreach ( $data as $dt ){
                    $dt->nama_unit_kerja='';
                    $dt->Urusan=DB::table('renstra_program')->select('urusan.*')->join('urusan','urusan.id','=','renstra_program.id_urusan')->whereRaw("renstra_program.id_sasaran='$dt->id' $where")->groupBy('renstra_program.id_urusan')->get();
                    foreach($dt->Urusan as $urusan){
    
                        $cek=DB::table('renstra_program')->where('id_urusan',$urusan->id)->count();
                        $urusan->BidangUrusan=DB::table('renstra_program')->select('bidang_urusan.*')->join('bidang_urusan','bidang_urusan.id','=','renstra_program.id_bidang_urusan')->whereRaw("renstra_program.id_sasaran='$dt->id' AND renstra_program.id_urusan='$urusan->id' $where")->groupBy('renstra_program.id_bidang_urusan')->get();
                        foreach($urusan->BidangUrusan as $bidang_urusan){
                            $bidang_urusan->Program=DB::table('renstra_program')
                            ->select('renstra_program.*','program.kode_program','program.nama_program')
                            ->join('program','program.id','=','renstra_program.id_program')->whereRaw("renstra_program.id_sasaran='$dt->id' AND renstra_program.id_bidang_urusan='$bidang_urusan->id' $where")->get();
                            foreach ( $bidang_urusan->Program as $program ){
                                $program->Outcome=DB::table('renstra_program_outcome')->where('id_renstra_program',$program->id)->get();
                                $program->Kegiatan=DB::table('renstra_kegiatan')
                                ->select('renstra_kegiatan.*','kegiatan.kode_kegiatan','kegiatan.nama_kegiatan')
                                ->join('kegiatan','kegiatan.id','=','renstra_kegiatan.id_kegiatan')->whereRaw("renstra_kegiatan.id_renstra_program='$program->id' $where")->get();
                                foreach ( $program->Kegiatan as $kegiatan ){
                                    $kegiatan->Output=DB::table('renstra_kegiatan_output')->where('id_renstra_kegiatan',$kegiatan->id)->get();
                                    $kegiatan->SubKegiatan=DB::table('renstra_sub_kegiatan')
                                    ->select('renstra_sub_kegiatan.*','unit_kerja.nama_unit_kerja','dpa.is_non_urusan','sub_kegiatan.kode_sub_kegiatan','sub_kegiatan.nama_sub_kegiatan')
                                    ->join('sub_kegiatan','sub_kegiatan.id','=','renstra_sub_kegiatan.id_sub_kegiatan')
                                    ->join('dpa','dpa.id_sub_kegiatan','=','sub_kegiatan.id')
                                    ->join('unit_kerja','unit_kerja.id','=','renstra_sub_kegiatan.id_unit_kerja')
                                    // ->whereRaw("renstra_sub_kegiatan.id_sasaran='$dt->id' AND renstra_sub_kegiatan.id_urusan='$urusan->id' AND renstra_sub_kegiatan.id_program='$program->id_program' AND renstra_sub_kegiatan.id_kegiatan='$kegiatan->id_kegiatan' $where")
                                    ->whereRaw("renstra_sub_kegiatan.id_renstra_kegiatan='$kegiatan->id' AND renstra_sub_kegiatan.id_urusan='$urusan->id' AND renstra_sub_kegiatan.id_program='$program->id_program' AND renstra_sub_kegiatan.id_kegiatan='$kegiatan->id_kegiatan' $where2")
                                    ->groupBy('renstra_sub_kegiatan.id_sub_kegiatan')
                                    //->whereRaw("renstra_sub_kegiatan.id_renstra_kegiatan='$kegiatan->id' AND renstra_sub_kegiatan.id_urusan='$urusan->id' AND renstra_sub_kegiatan.id_program='$program->id_program' AND renstra_sub_kegiatan.id_kegiatan='$kegiatan->id_kegiatan' AND dpa.tahun='$tahun' $where2")
                                    ->get();
                                    $kegiatan->totPersenK=0;
                                    $kegiatan->totPersenTargetK=0;
                                    $kegiatan->KegiatanTotalRealisasiK=0;
                                    $kegiatan->KegiatanTotalRealisasiRp=0;
                                    $kegiatan->KegiatanTotalTargetKinerjaK=0;
                                    $kegiatan->KegiatanTotalTargetKinerjaRp=0;
                                    for($p=1;$p<=$triwulan;$p++){
                                    $kegiatan->TotalRealisasiKinerjaK[$p]=0;
                                    $kegiatan->TotalPersenRealisasiKinerjaK[$p]=0;
                                    $kegiatan->TotalRealisasiKinerjaRp[$p]=0;
                                    }
                                    foreach($kegiatan->SubKegiatan as $sub_kegiatan){
                                        $dt->nama_unit_kerja=$sub_kegiatan->nama_unit_kerja;
                                        $id_dpa=DB::table('dpa')->whereRaw("id_sub_kegiatan='$sub_kegiatan->id_sub_kegiatan' AND id_unit_kerja='$unit_kerja_selected'")->first()->id;
                                        $sub_kegiatan->Indikator=DB::table('renstra_sub_kegiatan_indikator')->where('id_renstra_sub_kegiatan',$sub_kegiatan->id)->get();
                                        $sub_kegiatan->Realisasi0=DB::table('renstra_realisasi_sub_kegiatan')->whereRaw("id_renstra_sub_kegiatan='$sub_kegiatan->id' AND (tahun <= '$tahun_sebelum')")->get();
                                        // $sub_kegiatan->Realisasi1K=DB::table('realisasi')->whereRaw("id_dpa='$id_dpa' AND tahun='$tahun_sebelum' AND periode<=4")->unique('periode')->reduce(function($total,$value){return $total + optional($value)->realisasi_kinerja;})->get();
                                        $sub_kegiatan->Realisasi1K=0;
                                        $sub_kegiatan->Realisasi1Rp=0;
                                        $getRealisasi=DB::table('realisasi')->selectRaw("distinct(periode),realisasi_kinerja,realisasi_keuangan")->whereRaw("id_dpa='$id_dpa' AND (tahun<='$tahun_sebelum') AND periode<=4")->get();
                                        foreach($getRealisasi as $ds){
                                            $sub_kegiatan->Realisasi1K+=$ds->realisasi_kinerja;
                                            $sub_kegiatan->Realisasi1Rp+=$ds->realisasi_keuangan;
                                        }
                                        $sub_kegiatan->RealisasiK=$sub_kegiatan->Realisasi0->sum('volume')+$sub_kegiatan->Realisasi1K;
                                        $sub_kegiatan->RealisasiRp=$sub_kegiatan->Realisasi0->sum('realisasi_keuangan')+$sub_kegiatan->Realisasi1Rp;
                                        $sub_kegiatan->TargetK=DB::table('renstra_sub_kegiatan_target')->whereRaw("id_renstra_sub_kegiatan='$sub_kegiatan->id' AND tahun='$tahun'")->sum('volume');
                                        $sub_kegiatan->TargetRp=DB::table('dpa')->whereRaw("dpa.id_sub_kegiatan='$sub_kegiatan->id_sub_kegiatan' AND dpa.tahun='$tahun' $where")->sum('dpa.nilai_pagu_dpa');
                                        
                                        $kegiatan->totPersenK+=$sub_kegiatan->total_volume == 0 ? 0 : (($sub_kegiatan->RealisasiK)/$sub_kegiatan->total_volume)*100;
                                        $kegiatan->totPersenTargetK+=$sub_kegiatan->total_volume == 0 ? 0 : (($sub_kegiatan->TargetK)/$sub_kegiatan->total_volume)*100;
    
                                        $totRealisasiKinerjaK=0;
                                        $totRealisasiKinerjaRp=0;
                                        for($p=1;$p<=$triwulan;$p++){
                                            $realisasi=DB::table('dpa')->join('realisasi','realisasi.id_dpa','=','dpa.id')->whereRaw("dpa.id_sub_kegiatan='$sub_kegiatan->id_sub_kegiatan' AND realisasi.periode='$p' AND realisasi.tahun='$tahun' $where")->limit(1);
                                            if($realisasi->count()>0){
                                                $sub_kegiatan->RealisasiKinerjaRp[$p]=$realisasi->first()->realisasi_keuangan;
                                                $sub_kegiatan->RealisasiKinerjaK[$p]=$realisasi->first()->realisasi_kinerja;
                                            }else{
                                                $sub_kegiatan->RealisasiKinerjaRp[$p]=0;
                                                $sub_kegiatan->RealisasiKinerjaK[$p]=0;
                                            }
    
                                            $kegiatan->TotalRealisasiKinerjaK[$p]+=$sub_kegiatan->RealisasiKinerjaK[$p];
                                            $kegiatan->TotalRealisasiKinerjaRp[$p]+=$sub_kegiatan->RealisasiKinerjaRp[$p];
    
                                            $kegiatan->TotalPersenRealisasiKinerjaK[$p]+=$sub_kegiatan->total_volume == 0 ? 0 : (($sub_kegiatan->RealisasiKinerjaK[$p])/$sub_kegiatan->total_volume)*100;
    
                                            $totRealisasiKinerjaK+=$sub_kegiatan->RealisasiKinerjaK[$p];
                                            $totRealisasiKinerjaRp+=$sub_kegiatan->RealisasiKinerjaRp[$p];
                                        }
    
                                            $kegiatan->KegiatanTotalRealisasiK+=$sub_kegiatan->RealisasiK;
                                            $kegiatan->KegiatanTotalRealisasiRp+=$sub_kegiatan->RealisasiRp;
                                    
                                        
                                        // if ($sub_kegiatan->Target->count()>0){
                                            $kegiatan->KegiatanTotalTargetKinerjaK+=$sub_kegiatan->TargetK;
                                            $kegiatan->KegiatanTotalTargetKinerjaRp+=$sub_kegiatan->TargetRp;
                                        // }
    
                                        $sub_kegiatan->K13=$totRealisasiKinerjaK;
                                        $sub_kegiatan->Rp13=$totRealisasiKinerjaRp;
                                        
                                        $sub_kegiatan->K14=$sub_kegiatan->RealisasiK+$sub_kegiatan->K13;
                                        $sub_kegiatan->Rp14=$sub_kegiatan->Rp13+$sub_kegiatan->RealisasiRp;
                                        $sub_kegiatan->K15=$sub_kegiatan->total_volume==0?0:(($sub_kegiatan->K14/$sub_kegiatan->total_volume)*100);
                                        $sub_kegiatan->Rp15=$sub_kegiatan->total_pagu_renstra==0?0:(($sub_kegiatan->Rp14/$sub_kegiatan->total_pagu_renstra)*100);
    
                                    }
    
                                }
                            }
                        }
                    }
                }
    
                foreach ( $data as $dt ){
                    foreach($dt->Urusan as $urusan){
                        foreach($urusan->BidangUrusan as $bidang_urusan){
                           foreach ( $bidang_urusan->Program as $program ){
                                $program->KegiatanTotalTargetK=0;
                                $program->KegiatanTotalTargetRp=0;
                                $program->KegiatanTotalRealisasiK=0;
                                $program->KegiatanTotalRealisasiRp=0;
                                $program->KegiatanTotalTargetKinerjaK=0;
                                $program->KegiatanTotalTargetKinerjaRp=0;
                                for($p=1;$p<=$triwulan;$p++){
                                $program->TotalRealisasiKinerjaK[$p]=0;
                                $program->TotalRealisasiKinerjaRp[$p]=0;
                                }
    
    
                                foreach ( $program->Kegiatan as $kegiatan ){
                                    $sub_kegiatan_count=$kegiatan->SubKegiatan->count();
                                    $kegiatan->TargetK=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->SubKegiatan->sum('total_volume'))/$sub_kegiatan_count);
                                    $kegiatan->TargetRp=$kegiatan->SubKegiatan->sum('total_pagu_renstra');
                                    // $kegiatan->RealisasiK=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->KegiatanTotalRealisasiK)/$sub_kegiatan_count);
                                    $kegiatan->RealisasiK=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->totPersenK)/$sub_kegiatan_count);
                                    $kegiatan->RealisasiRp=$kegiatan->KegiatanTotalRealisasiRp;
                                    // $kegiatan->TargetKinerjaK=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->KegiatanTotalTargetKinerjaK)/$sub_kegiatan_count);
                                    $kegiatan->TargetKinerjaK=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->totPersenTargetK)/$sub_kegiatan_count);
                                    $kegiatan->TargetKinerjaRp=$kegiatan->KegiatanTotalTargetKinerjaRp;
                                    
                                    
    
                                    $program->KegiatanTotalTargetK+=$kegiatan->TargetK;
                                    $program->KegiatanTotalTargetRp+=$kegiatan->TargetRp;
                                    $program->KegiatanTotalRealisasiK+=$kegiatan->RealisasiK;
                                    $program->KegiatanTotalRealisasiRp+=$kegiatan->RealisasiRp;
                                    $program->KegiatanTotalTargetKinerjaK+=$kegiatan->TargetKinerjaK;
                                    $program->KegiatanTotalTargetKinerjaRp+=$kegiatan->TargetKinerjaRp;
    
    
                                    $totRealisasiKinerjaK=0;
                                    $totRealisasiKinerjaRp=0;
    
                                    for($p=1;$p<=$triwulan;$p++){
                                        // $kegiatan->RealisasiKinerjaK[$p]=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->TotalRealisasiKinerjaK[$p])/$sub_kegiatan_count);
                                        $kegiatan->RealisasiKinerjaK[$p]=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->TotalPersenRealisasiKinerjaK[$p])/$sub_kegiatan_count);
                                        $kegiatan->RealisasiKinerjaRp[$p]=$kegiatan->TotalRealisasiKinerjaRp[$p];
                                        $program->TotalRealisasiKinerjaK[$p]+=$kegiatan->RealisasiKinerjaK[$p];
                                        $program->TotalRealisasiKinerjaRp[$p]+=$kegiatan->RealisasiKinerjaRp[$p];
                                        $totRealisasiKinerjaK+=$kegiatan->RealisasiKinerjaK[$p];
                                        $totRealisasiKinerjaRp+=$kegiatan->RealisasiKinerjaRp[$p];
                                    }
    
                                    $kegiatan->K13=$totRealisasiKinerjaK;
                                    $kegiatan->Rp13=$totRealisasiKinerjaRp;
    
                                    $kegiatan->K14=($kegiatan->RealisasiK+$kegiatan->K13);
                                    $kegiatan->Rp14=$kegiatan->Rp13+$kegiatan->RealisasiRp;
                                    $kegiatan->K15=$kegiatan->Output->first()->volume==0?0:(($kegiatan->K14/$kegiatan->Output->first()->volume)*100);
                                    $kegiatan->Rp15=$kegiatan->TargetRp==0?0:(($kegiatan->Rp14/$kegiatan->TargetRp)*100);
    
    
                                }
                            }
                        }
                    }
                }
                
                foreach ( $data as $dt ){
                    foreach($dt->Urusan as $urusan){
                        foreach($urusan->BidangUrusan as $bidang_urusan){
    
                           foreach ( $bidang_urusan->Program as $program ){
                               $kegiatan_count=$program->Kegiatan->count();
                                $program->TargetK=$kegiatan_count == 0 ? 0 : ($program->KegiatanTotalTargetK/$kegiatan_count);
                                $program->TargetRp=$program->KegiatanTotalTargetRp;
                                $program->RealisasiK=$kegiatan_count == 0 ? 0 : ($program->KegiatanTotalRealisasiK/$kegiatan_count);
                                $program->RealisasiRp=$program->KegiatanTotalRealisasiRp;
                                $program->TargetKinerjaK=$kegiatan_count == 0 ? 0 : ($program->KegiatanTotalTargetKinerjaK/$kegiatan_count);
                                $program->TargetKinerjaRp=$program->KegiatanTotalTargetKinerjaRp;
    
                                
    
    
                                $totRealisasiKinerjaK=0;
                                $totRealisasiKinerjaRp=0;
    
                                for($p=1;$p<=$triwulan;$p++){
                                    $program->RealisasiKinerjaK[$p]=$kegiatan_count == 0 ? 0 : ($program->TotalRealisasiKinerjaK[$p]/$kegiatan_count);
                                    $program->RealisasiKinerjaRp[$p]=$program->TotalRealisasiKinerjaRp[$p];
    
                                    $totRealisasiKinerjaK+=$program->RealisasiKinerjaK[$p];
                                    $totRealisasiKinerjaRp+=$program->RealisasiKinerjaRp[$p];
                                }
    
                                
    
                                $program->K13=$totRealisasiKinerjaK;
                                $program->Rp13=$totRealisasiKinerjaRp;
    
                                $program->K14=($program->RealisasiK+($program->TargetKinerjaK*$program->K13))/100;
                                $program->Rp14=$program->Rp13+$program->RealisasiRp;
                                $program->K15=$program->TargetK==0?0:($program->K14/$program->TargetK*100);
                                $program->Rp15=$program->TargetRp==0?0:($program->Rp14/$program->TargetRp*100);
    
                                
                            }
                        }
                    }
                }
                
                foreach ( $data as $dt ){
                    foreach($dt->Urusan as $urusan){
    
                        foreach($urusan->BidangUrusan as $bidang_urusan){
                            
                            foreach ( $bidang_urusan->Program as $program ){
                                foreach($program->Outcome as $po){
                                    $poTotTarget=$program->Kegiatan->where('id_renstra_program_outcome',$po->id);
                                    
                                    $po->PoTargetRp=$poTotTarget->sum('TargetRp');
                                    $po->PoRealisasiK=$poTotTarget->count()==0?0:$poTotTarget->sum('RealisasiK')/$poTotTarget->count();
                                    $po->PoRealisasiRp=$poTotTarget->sum('RealisasiRp');
                                    $po->PoTargetKinerjaRp=$poTotTarget->sum('TargetKinerjaRp');
                                    $po->PoTargetKinerjaK=$poTotTarget->count()==0?0:$poTotTarget->sum('TargetKinerjaK')/$poTotTarget->count();
    
                                    for($p=1;$p<=$triwulan;$p++){
                                        $po->PoRealisasiKinerjaK[$p]=$poTotTarget->count()==0?0:$poTotTarget->reduce(function ($sum,$option) use ($p) {
                                            return $sum+=$option->RealisasiKinerjaK[$p];
                                        }, 0)/$poTotTarget->count();
                                        $po->PoRealisasiKinerjaRp[$p]=$poTotTarget->count()==0?0:$poTotTarget->reduce(function ($sum,$option) use ($p) {
                                            return $sum+=$option->RealisasiKinerjaRp[$p];
                                        }, 0);
                                    }
    
    
                                    $po->PoRp13=$poTotTarget->sum('Rp13');
                                    $po->PoK13=$poTotTarget->count()==0?0:$poTotTarget->sum('K13')/$poTotTarget->count();
                                    $po->PoRp14=$poTotTarget->sum('Rp14');
                                    $po->PoK14=$poTotTarget->count()==0?0:$poTotTarget->sum('K14')/$poTotTarget->count();
                                    $po->PoRp15=$poTotTarget->count()==0?0:$poTotTarget->sum('Rp15')/$poTotTarget->count();
                                    $po->PoK15=$poTotTarget->count()==0?0:$poTotTarget->sum('K15')/$poTotTarget->count();
    
                                }
    
                            }
    
                        }
                    }
                }
                
                foreach ( $data as $dt ){
    
                    foreach($dt->Urusan as $urusan){
    
    
                        foreach($urusan->BidangUrusan as $bidang_urusan){
                            $bidang_urusan->Program->reduce(function ($sum,$program) use ($bidang_urusan,$triwulan) {
                                $program_count=$program->Outcome->count();
    
                                $bidang_urusan->TargetK=$program_count == 0 ? 0 : ($program->Outcome->sum('volume')/$program_count);
                                $bidang_urusan->TargetRp=$program->Outcome->sum('PoTargetRp');
                                $bidang_urusan->RealisasiK=$program_count == 0 ? 0 : ($program->Outcome->sum('PoRealisasiK')/$program_count);
                                $bidang_urusan->RealisasiRp=$program->Outcome->sum('PoRealisasiRp');
                                $bidang_urusan->TargetKinerjaK=$program_count == 0 ? 0 : ($program->Outcome->sum('PoTargetKinerjaK')/$program_count);
                                $bidang_urusan->TargetKinerjaRp=$program->Outcome->sum('PoTargetKinerjaRp');
    
                                for($p=1;$p<=$triwulan;$p++){
                                    $bidang_urusan->RealisasiKinerjaK[$p]=$program_count==0?0:$program->Outcome->reduce(function ($sum,$option) use ($p) {
                                        return $sum+=$option->PoRealisasiKinerjaK[$p];
                                    }, 0)/$program_count;
                                    $bidang_urusan->RealisasiKinerjaRp[$p]=$program->Outcome->reduce(function ($sum,$option) use ($p) {
                                        return $sum+=$option->PoRealisasiKinerjaRp[$p];
                                    }, 0);
                                }
    
                                $bidang_urusan->TargetKinerjaK=$program_count == 0 ? 0 : ($program->Outcome->sum('PoTargetKinerjaK')/$program_count);
                                $bidang_urusan->TargetKinerjaRp=$program->Outcome->sum('PoTargetKinerjaRp');
    
                                $bidang_urusan->K13=$program_count == 0 ? 0 : ($program->Outcome->sum('PoK13')/$program_count);
                                $bidang_urusan->Rp13=$program->Outcome->sum('PoRp13');
                                $bidang_urusan->K14=$program_count == 0 ? 0 : ($program->Outcome->sum('PoK14')/$program_count);
                                $bidang_urusan->Rp14=$program->Outcome->sum('PoRp13')+$bidang_urusan->RealisasiRp;
                                $bidang_urusan->K15=$program_count == 0 ? 0 : ($program->Outcome->sum('PoK15')/$program_count);
                                $bidang_urusan->Rp15=$program_count == 0 ? 0 : ($program->Outcome->sum('PoRp15')/$program_count);
                                
                                
    
                                
                                
                            });
    
                        }
                    }
                }
                
                foreach ( $data as $dt ){
    
                        foreach($dt->Urusan as $urusan){
    
                            $bidang_urusan_count=$urusan->BidangUrusan->count();
    
                                $urusan->TargetK=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('TargetK')/$bidang_urusan_count);
                                $urusan->TargetRp=$urusan->BidangUrusan->sum('TargetRp');
                                $urusan->RealisasiK=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('RealisasiK')/$bidang_urusan_count);
                                $urusan->RealisasiRp=$urusan->BidangUrusan->sum('RealisasiRp');
                                $urusan->TargetKinerjaK=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('TargetKinerjaK')/$bidang_urusan_count);
                                $urusan->TargetKinerjaRp=$urusan->BidangUrusan->sum('TargetKinerjaRp');
    
                                for($p=1;$p<=$triwulan;$p++){
                                    $urusan->RealisasiKinerjaK[$p]=$bidang_urusan_count==0?0:$urusan->BidangUrusan->reduce(function ($sum,$option) use ($p) {
                                        return $sum+=$option->RealisasiKinerjaK[$p];
                                    }, 0)/$bidang_urusan_count;
                                    $urusan->RealisasiKinerjaRp[$p]=$urusan->BidangUrusan->reduce(function ($sum,$option) use ($p) {
                                        return $sum+=$option->RealisasiKinerjaRp[$p];
                                    }, 0);
                                }
    
                                $urusan->TargetKinerjaK=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('TargetKinerjaK')/$bidang_urusan_count);
                                $urusan->TargetKinerjaRp=$urusan->BidangUrusan->sum('TargetKinerjaRp');
    
                                $urusan->K13=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('K13')/$bidang_urusan_count);
                                $urusan->Rp13=$urusan->BidangUrusan->sum('Rp13');
                                $urusan->K14=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('K14')/$bidang_urusan_count);
                                $urusan->Rp14=$urusan->BidangUrusan->sum('Rp13')+$urusan->RealisasiRp;
                                $urusan->K15=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('K15')/$bidang_urusan_count);
                                $urusan->Rp15=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('Rp15')/$bidang_urusan_count);
    
                        }
                }
    
                foreach ( $data as $dt ){
                                
                                $urusan_count=$dt->Urusan->count();
    
                                $dt->TargetK=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('TargetK')/$urusan_count);
                                $dt->TargetRp=$dt->Urusan->sum('TargetRp');
                                $dt->RealisasiK=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('RealisasiK')/$urusan_count);
                                $dt->RealisasiRp=$dt->Urusan->sum('RealisasiRp');
                                $dt->TargetKinerjaK=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('TargetKinerjaK')/$urusan_count);
                                $dt->TargetKinerjaRp=$dt->Urusan->sum('TargetKinerjaRp');
    
                                for($p=1;$p<=$triwulan;$p++){
                                    $dt->RealisasiKinerjaK[$p]=$urusan_count==0?0:$dt->Urusan->reduce(function ($sum,$option) use ($p) {
                                        return $sum+=$option->RealisasiKinerjaK[$p];
                                    }, 0)/$urusan_count;
                                    $dt->RealisasiKinerjaRp[$p]=$dt->Urusan->reduce(function ($sum,$option) use ($p) {
                                        return $sum+=$option->RealisasiKinerjaRp[$p];
                                    }, 0);
                                }
    
                                $dt->TargetKinerjaK=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('TargetKinerjaK')/$urusan_count);
                                $dt->TargetKinerjaRp=$dt->Urusan->sum('TargetKinerjaRp');
    
                                $dt->K13=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('K13')/$urusan_count);
                                $dt->Rp13=$dt->Urusan->sum('Rp13');
                                $dt->K14=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('K14')/$urusan_count);
                                $dt->Rp14=$dt->Urusan->sum('Rp13')+$dt->RealisasiRp;
                                $dt->K15=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('K15')/$urusan_count);
                                $dt->Rp15=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('Rp15')/$urusan_count);
                }

               }else{
                $data=DB::table('unit_kerja')->select('unit_kerja.*')->get();
                
                foreach ($data as $unit ){
                    $unit->renstra=DB::table('renstra_sub_kegiatan')->select('renstra_sub_kegiatan.*')
                    ->join('unit_kerja','unit_kerja.id','=','renstra_sub_kegiatan.id_unit_kerja')
                    ->whereRaw("renstra_sub_kegiatan.id_unit_kerja=$unit->id")
                    ->get();
                    $unit->jumlah_kegiatan=0;
                    $unit->persenK=0;
                    $unit->persenRp=0;
                    $unit->totpersenK=0;
                    $unit->totpersenRp=0;
                    foreach ($unit->renstra as $renstra){
                        $renstra->dpa=DB::table('dpa')
                        ->whereRaw("dpa.id_unit_kerja=$renstra->id_unit_kerja AND dpa.id_sub_kegiatan=$renstra->id_sub_kegiatan")
                        ->first();
                        //$renstra->id_dpa=DB::table('dpa')->whereRaw("id_sub_kegiatan='$renstra->id_sub_kegiatan' AND id_unit_kerja=$renstra->id_unit_kerja ")->first();
                        $renstra->TargetK=DB::table('renstra_sub_kegiatan_target')->whereRaw("renstra_sub_kegiatan_target.id_renstra_sub_kegiatan='$renstra->id' AND tahun='$tahun'")->sum('volume');
                        $renstra->TargetRp=DB::table('dpa')->whereRaw("dpa.id_sub_kegiatan='$renstra->id_sub_kegiatan' AND dpa.id_unit_kerja=$renstra->id_unit_kerja  AND dpa.tahun='$tahun'")->sum('dpa.nilai_pagu_dpa');
                        $renstra->totRealisasiKinerjaK=0;
                        $renstra->totRealisasiKinerjaRp=0;
                        $renstra->persenK=0;
                        $renstra->persenRp=0;
                        for($p=1;$p<=$triwulan;$p++){
                            $realisasi=DB::table('dpa')->join('realisasi','realisasi.id_dpa','=','dpa.id')->whereRaw("dpa.id_sub_kegiatan='$renstra->id_sub_kegiatan' AND realisasi.periode='$p' AND realisasi.tahun='$tahun' AND dpa.id_unit_kerja=$renstra->id_unit_kerja")->limit(1);
                            if($realisasi->count()>0){
                                $renstra->RealisasiKinerjaRp[$p]=$realisasi->first()->realisasi_keuangan;
                                $renstra->RealisasiKinerjaK[$p]=$realisasi->first()->realisasi_kinerja;
                            }else{
                                $renstra->RealisasiKinerjaRp[$p]=0;
                                $renstra->RealisasiKinerjaK[$p]=0;
                            }
                            $renstra->totRealisasiKinerjaK+=$renstra->RealisasiKinerjaK[$p];
                            $renstra->totRealisasiKinerjaRp+=$renstra->RealisasiKinerjaRp[$p];
                            
                        }
                        
                        $renstra->persenK=$renstra->TargetK==0?0:(($renstra->totRealisasiKinerjaK/$renstra->TargetK)*100);
                        $renstra->persenRp=$renstra->TargetRp==0?0:(($renstra->totRealisasiKinerjaRp/$renstra->TargetRp)*100);
                        
                        if(isset($renstra->dpa)){
                            $unit->jumlah_kegiatan++;
                        }
                        

                        $unit->totpersenK+=$renstra->persenK;
                        $unit->totpersenRp+=$renstra->persenRp;
                    }
                        $unit->persenK=$unit->jumlah_kegiatan==0?0:($unit->totpersenK/$unit->jumlah_kegiatan);
                        $unit->persenRp=$unit->jumlah_kegiatan==0?0:($unit->totpersenRp/$unit->jumlah_kegiatan);;

                        


                }
               }
        
        $tabel = view('Laporan.tabel_evaluasi_renja.' . Str::slug( ($unit_kerja_selected ? ' index_dinas' : 'index'), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected', 'semester_selected','tahun','tahun_sebelum','triwulan'))->render();
        }

            
        return view('Laporan/laporan_evaluasi_renja', compact('sumber_dana', 'unit_kerja', 'semester_selected', 'sumber_dana_selected', 'unit_kerja_selected', 'tabel', 'metode_pelaksanaan', 'jenis_belanja', 'metode_pelaksanaan_selected', 'jenis_belanja_selected','tahun','tahun_sebelum','triwulan'));
    }

    public function export($tipe)
    {
        $unit_kerja_selected = $metode_pelaksanaan_selected = $jenis_belanja_selected = $tabel = '';
        $sumber_dana = SumberDana::whereRaw("nama_sumber_dana NOT LIKE '%DAK%'")->get();
        $unit_kerja = UnitKerja::where(function ($q) {
            if (hasRole('opd'))
                $q->where('id', auth()->user()->id_unit_kerja);
        })->get();
        $jenis_belanja = JenisBelanja::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $periode_selected = request('periode', '');
        $sumber_dana_selected = request('sumber_dana', '');
        if (hasRole('admin')) {
            $unit_kerja_selected = request('unit_kerja', '');
        } else if (hasRole('opd')) {
            $unit_kerja_selected = auth()->user()->id_unit_kerja;
        }
       
        $jenis_belanja_selected = request('jenis_belanja', '');
        $metode_pelaksanaan_selected = request('metode_pelaksanaan', '');
        $tahun = session('tahun_penganggaran','');
        $semester_selected = request('semester', '');
        if($semester_selected==1){
            $triwulan=2;
        }else{
            $triwulan=4;
        }
        $tahun_sebelum=$tahun-1;
        $tahun_sebelum_sebelumnya=$tahun_sebelum-1;
        // $data[][] = [];
        $data=array();
        // $data['urusan'][] = [];
        $total_pagu_keseluruhan = 0;
        $total_realisasi_keuangan = 0;
        $where="";
        $where2="";


        if(!empty($unit_kerja_selected)){
            // return 'hai1';
         
            $where.="AND id_unit_kerja='$unit_kerja_selected'";
            $where2.="AND dpa.id_unit_kerja='$unit_kerja_selected'";
        }

            if($unit_kerja_selected != ''){
                // Untuk per Dinas
                $data=DB::table('renstra_sub_kegiatan')->select('sasaran.*')->join('sasaran','sasaran.id','=','renstra_sub_kegiatan.id_sasaran')->whereRaw("renstra_sub_kegiatan.id_sasaran<>'' AND renstra_sub_kegiatan.id_unit_kerja='$unit_kerja_selected'")->groupBy('renstra_sub_kegiatan.id_sasaran')->get();
                foreach ( $data as $dt ){
                    $dt->nama_unit_kerja='';
                    $dt->Urusan=DB::table('renstra_program')->select('urusan.*')->join('urusan','urusan.id','=','renstra_program.id_urusan')->whereRaw("renstra_program.id_sasaran='$dt->id' $where")->groupBy('renstra_program.id_urusan')->get();
                    foreach($dt->Urusan as $urusan){
    
                        $cek=DB::table('renstra_program')->where('id_urusan',$urusan->id)->count();
                        $urusan->BidangUrusan=DB::table('renstra_program')->select('bidang_urusan.*')->join('bidang_urusan','bidang_urusan.id','=','renstra_program.id_bidang_urusan')->whereRaw("renstra_program.id_sasaran='$dt->id' AND renstra_program.id_urusan='$urusan->id' $where")->groupBy('renstra_program.id_bidang_urusan')->get();
                        foreach($urusan->BidangUrusan as $bidang_urusan){
                            $bidang_urusan->Program=DB::table('renstra_program')
                            ->select('renstra_program.*','program.kode_program','program.nama_program')
                            ->join('program','program.id','=','renstra_program.id_program')->whereRaw("renstra_program.id_sasaran='$dt->id' AND renstra_program.id_bidang_urusan='$bidang_urusan->id' $where")->get();
                            foreach ( $bidang_urusan->Program as $program ){
                                $program->Outcome=DB::table('renstra_program_outcome')->where('id_renstra_program',$program->id)->get();
                                $program->Kegiatan=DB::table('renstra_kegiatan')
                                ->select('renstra_kegiatan.*','kegiatan.kode_kegiatan','kegiatan.nama_kegiatan')
                                ->join('kegiatan','kegiatan.id','=','renstra_kegiatan.id_kegiatan')->whereRaw("renstra_kegiatan.id_renstra_program='$program->id' $where")->get();
                                foreach ( $program->Kegiatan as $kegiatan ){
                                    $kegiatan->Output=DB::table('renstra_kegiatan_output')->where('id_renstra_kegiatan',$kegiatan->id)->get();
                                    $kegiatan->SubKegiatan=DB::table('renstra_sub_kegiatan')
                                    ->select('renstra_sub_kegiatan.*','unit_kerja.nama_unit_kerja','dpa.is_non_urusan','sub_kegiatan.kode_sub_kegiatan','sub_kegiatan.nama_sub_kegiatan')
                                    ->join('sub_kegiatan','sub_kegiatan.id','=','renstra_sub_kegiatan.id_sub_kegiatan')
                                    ->join('dpa','dpa.id_sub_kegiatan','=','sub_kegiatan.id')
                                    ->join('unit_kerja','unit_kerja.id','=','renstra_sub_kegiatan.id_unit_kerja')
                                    //->whereRaw("renstra_sub_kegiatan.id_sasaran='$dt->id' AND renstra_sub_kegiatan.id_urusan='$urusan->id' AND renstra_sub_kegiatan.id_program='$program->id_program' AND renstra_sub_kegiatan.id_kegiatan='$kegiatan->id_kegiatan' $where")
                                    //->whereRaw("renstra_sub_kegiatan.id_renstra_kegiatan='$kegiatan->id' AND renstra_sub_kegiatan.id_urusan='$urusan->id' AND renstra_sub_kegiatan.id_program='$program->id_program' AND renstra_sub_kegiatan.id_kegiatan='$kegiatan->id_kegiatan' AND dpa.tahun='$tahun' $where2")
                                    ->whereRaw("renstra_sub_kegiatan.id_renstra_kegiatan='$kegiatan->id' AND renstra_sub_kegiatan.id_urusan='$urusan->id' AND renstra_sub_kegiatan.id_program='$program->id_program' AND renstra_sub_kegiatan.id_kegiatan='$kegiatan->id_kegiatan' $where2")
                                    ->groupBy('renstra_sub_kegiatan.id_sub_kegiatan')
                                    ->get();
                                    
                                    $kegiatan->totPersenK=0;
                                    $kegiatan->totPersenTargetK=0;
                                    $kegiatan->KegiatanTotalRealisasiK=0;
                                    $kegiatan->KegiatanTotalRealisasiRp=0;
                                    $kegiatan->KegiatanTotalTargetKinerjaK=0;
                                    $kegiatan->KegiatanTotalTargetKinerjaRp=0;
                                    for($p=1;$p<=$triwulan;$p++){
                                    $kegiatan->TotalRealisasiKinerjaK[$p]=0;
                                    $kegiatan->TotalPersenRealisasiKinerjaK[$p]=0;
                                    $kegiatan->TotalPersenRealisasiKinerjaRenstra[$p]=0;
                                    $kegiatan->TotalRealisasiKinerjaRp[$p]=0;
                                    }
                                    foreach($kegiatan->SubKegiatan as $sub_kegiatan){
                                        $dt->nama_unit_kerja=$sub_kegiatan->nama_unit_kerja;
                                        $id_dpa=DB::table('dpa')->whereRaw("id_sub_kegiatan='$sub_kegiatan->id_sub_kegiatan' AND id_unit_kerja='$unit_kerja_selected'")->first()->id;
                                        $sub_kegiatan->Indikator=DB::table('renstra_sub_kegiatan_indikator')->where('id_renstra_sub_kegiatan',$sub_kegiatan->id)->get();
                                        $sub_kegiatan->Realisasi0=DB::table('renstra_realisasi_sub_kegiatan')->whereRaw("id_renstra_sub_kegiatan='$sub_kegiatan->id' AND (tahun <= '$tahun_sebelum')")->get();
                                        // $sub_kegiatan->Realisasi1K=DB::table('realisasi')->whereRaw("id_dpa='$id_dpa' AND tahun='$tahun_sebelum' AND periode<=4")->unique('periode')->reduce(function($total,$value){return $total + optional($value)->realisasi_kinerja;})->get();
                                        $sub_kegiatan->Realisasi1K=0;
                                        $sub_kegiatan->Realisasi1Rp=0;
                                        $getRealisasi=DB::table('realisasi')->selectRaw("distinct(periode),realisasi_kinerja,realisasi_keuangan")->whereRaw("id_dpa='$id_dpa' AND (tahun <= '$tahun_sebelum') AND periode<=4")->get();
                                        foreach($getRealisasi as $ds){
                                            $sub_kegiatan->Realisasi1K+=$ds->realisasi_kinerja;
                                            $sub_kegiatan->Realisasi1Rp+=$ds->realisasi_keuangan;
                                        }
                                        $sub_kegiatan->RealisasiK=$sub_kegiatan->Realisasi0->sum('volume')+$sub_kegiatan->Realisasi1K;
                                        $sub_kegiatan->RealisasiRp=$sub_kegiatan->Realisasi0->sum('realisasi_keuangan')+$sub_kegiatan->Realisasi1Rp;
                                        $sub_kegiatan->TargetK=DB::table('renstra_sub_kegiatan_target')->whereRaw("id_renstra_sub_kegiatan='$sub_kegiatan->id' AND tahun='$tahun'")->sum('volume');
                                        $sub_kegiatan->TargetRp=DB::table('dpa')->whereRaw("dpa.id_sub_kegiatan='$sub_kegiatan->id_sub_kegiatan' AND dpa.tahun='$tahun' $where")->sum('dpa.nilai_pagu_dpa');
                                        
                                        $kegiatan->totPersenK+=$sub_kegiatan->total_volume == 0 ? 0 : (($sub_kegiatan->RealisasiK)/$sub_kegiatan->total_volume)*100;
                                        $kegiatan->totPersenTargetK+=$sub_kegiatan->TargetK == 0 ? 0 : (($sub_kegiatan->TargetK)/$sub_kegiatan->TargetK)*100;
    
                                        $totRealisasiKinerjaK=0;
                                        $totRealisasiKinerjaRp=0;
                                        for($p=1;$p<=$triwulan;$p++){
                                            $realisasi=DB::table('dpa')->join('realisasi','realisasi.id_dpa','=','dpa.id')->whereRaw("dpa.id_sub_kegiatan='$sub_kegiatan->id_sub_kegiatan' AND realisasi.periode='$p' AND realisasi.tahun='$tahun' $where")->limit(1);
                                            if($realisasi->count()>0){
                                                $sub_kegiatan->RealisasiKinerjaRp[$p]=$realisasi->first()->realisasi_keuangan;
                                                $sub_kegiatan->RealisasiKinerjaK[$p]=$realisasi->first()->realisasi_kinerja;
                                            }else{
                                                $sub_kegiatan->RealisasiKinerjaRp[$p]=0;
                                                $sub_kegiatan->RealisasiKinerjaK[$p]=0;
                                            }
    
                                            $kegiatan->TotalRealisasiKinerjaK[$p]+=$sub_kegiatan->RealisasiKinerjaK[$p];
                                            $kegiatan->TotalRealisasiKinerjaRp[$p]+=$sub_kegiatan->RealisasiKinerjaRp[$p];
    
                                            $kegiatan->TotalPersenRealisasiKinerjaK[$p]+=$sub_kegiatan->TargetK == 0 ? 0 : (($sub_kegiatan->RealisasiKinerjaK[$p])/$sub_kegiatan->TargetK)*100;
                                            //for renstra
                                            $kegiatan->TotalPersenRealisasiKinerjaRenstra[$p]+=$sub_kegiatan->total_volume == 0 ? 0 : (($sub_kegiatan->RealisasiKinerjaK[$p])/$sub_kegiatan->total_volume)*100;
    
    
                                            $totRealisasiKinerjaK+=$sub_kegiatan->RealisasiKinerjaK[$p];
                                            $totRealisasiKinerjaRp+=$sub_kegiatan->RealisasiKinerjaRp[$p];
                                        }
    
                                            $kegiatan->KegiatanTotalRealisasiK+=$sub_kegiatan->RealisasiK;
                                            $kegiatan->KegiatanTotalRealisasiRp+=$sub_kegiatan->RealisasiRp;
                                    
                                        
                                        // if ($sub_kegiatan->Target->count()>0){
                                            $kegiatan->KegiatanTotalTargetKinerjaK+=$sub_kegiatan->TargetK;
                                            $kegiatan->KegiatanTotalTargetKinerjaRp+=$sub_kegiatan->TargetRp;
                                        // }
    
                                        $sub_kegiatan->K13=$totRealisasiKinerjaK;
                                        $sub_kegiatan->Rp13=$totRealisasiKinerjaRp;
                                        
                                        $sub_kegiatan->K14=$sub_kegiatan->RealisasiK+$sub_kegiatan->K13;
                                        $sub_kegiatan->Rp14=$sub_kegiatan->Rp13+$sub_kegiatan->RealisasiRp;
                                        $sub_kegiatan->K15=$sub_kegiatan->total_volume==0?0:(($sub_kegiatan->K14/$sub_kegiatan->total_volume)*100);
                                        $sub_kegiatan->Rp15=$sub_kegiatan->total_pagu_renstra==0?0:(($sub_kegiatan->Rp14/$sub_kegiatan->total_pagu_renstra)*100);
    
                                    }
    
                                }
                            }
                        }
                    }
                }
    
                foreach ( $data as $dt ){
                    foreach($dt->Urusan as $urusan){
                        foreach($urusan->BidangUrusan as $bidang_urusan){
                           foreach ( $bidang_urusan->Program as $program ){
                                $program->KegiatanTotalTargetK=0;
                                $program->KegiatanTotalTargetRp=0;
                                $program->KegiatanTotalRealisasiK=0;
                                $program->KegiatanTotalRealisasiRp=0;
                                $program->KegiatanTotalTargetKinerjaK=0;
                                $program->KegiatanTotalTargetKinerjaRp=0;
                                for($p=1;$p<=$triwulan;$p++){
                                $program->TotalRealisasiKinerjaK[$p]=0;
                                $program->TotalRealisasiKinerjaRp[$p]=0;
                                }
    
    
                                foreach ( $program->Kegiatan as $kegiatan ){
                                    $sub_kegiatan_count=$kegiatan->SubKegiatan->count();
                                    $kegiatan->TargetK=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->SubKegiatan->sum('total_volume'))/$sub_kegiatan_count);
                                    $kegiatan->TargetRp=$kegiatan->SubKegiatan->sum('total_pagu_renstra');
                                    // $kegiatan->RealisasiK=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->KegiatanTotalRealisasiK)/$sub_kegiatan_count);
                                    $kegiatan->RealisasiK=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->totPersenK)/$sub_kegiatan_count);
                                    $kegiatan->RealisasiRp=$kegiatan->KegiatanTotalRealisasiRp;
                                    // $kegiatan->TargetKinerjaK=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->KegiatanTotalTargetKinerjaK)/$sub_kegiatan_count);
                                    $kegiatan->TargetKinerjaK=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->totPersenTargetK)/$sub_kegiatan_count);
                                    $kegiatan->TargetKinerjaRp=$kegiatan->KegiatanTotalTargetKinerjaRp;
                                    
                                    
    
                                    $program->KegiatanTotalTargetK+=$kegiatan->TargetK;
                                    $program->KegiatanTotalTargetRp+=$kegiatan->TargetRp;
                                    $program->KegiatanTotalRealisasiK+=$kegiatan->RealisasiK;
                                    $program->KegiatanTotalRealisasiRp+=$kegiatan->RealisasiRp;
                                    $program->KegiatanTotalTargetKinerjaK+=$kegiatan->TargetKinerjaK;
                                    $program->KegiatanTotalTargetKinerjaRp+=$kegiatan->TargetKinerjaRp;
    
    
                                    $totRealisasiKinerjaK=0;
                                    $totRealisasiKinerjaRenstra=0;
                                    $totRealisasiKinerjaRp=0;
    
                                    for($p=1;$p<=$triwulan;$p++){
                                        // $kegiatan->RealisasiKinerjaK[$p]=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->TotalRealisasiKinerjaK[$p])/$sub_kegiatan_count);
                                        $kegiatan->RealisasiKinerjaK[$p]=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->TotalPersenRealisasiKinerjaK[$p])/$sub_kegiatan_count);
                                        $kegiatan->RealisasiKinerjaRenstra[$p]=$sub_kegiatan_count == 0 ? 0 : (($kegiatan->TotalPersenRealisasiKinerjaRenstra[$p])/$sub_kegiatan_count);
                                        $kegiatan->RealisasiKinerjaRp[$p]=$kegiatan->TotalRealisasiKinerjaRp[$p];
                                        $program->TotalRealisasiKinerjaK[$p]+=$kegiatan->RealisasiKinerjaK[$p];
                                        $program->TotalRealisasiKinerjaRp[$p]+=$kegiatan->RealisasiKinerjaRp[$p];
                                        $totRealisasiKinerjaK+=$kegiatan->RealisasiKinerjaK[$p];
                                        $totRealisasiKinerjaRenstra+=$kegiatan->RealisasiKinerjaRenstra[$p];
                                        $totRealisasiKinerjaRp+=$kegiatan->RealisasiKinerjaRp[$p];
                                    }
    
                                    $kegiatan->K13=$totRealisasiKinerjaK;
                                    $kegiatan->Rp13=$totRealisasiKinerjaRp;
    
                                    $kegiatan->K14=($kegiatan->RealisasiK+$totRealisasiKinerjaRenstra);
                                    $kegiatan->Rp14=$kegiatan->Rp13+$kegiatan->RealisasiRp;
                                    $kegiatan->K15=$kegiatan->Output->first()->volume==0?0:(($kegiatan->K14/$kegiatan->Output->first()->volume)*100);
                                    $kegiatan->Rp15=$kegiatan->TargetRp==0?0:(($kegiatan->Rp14/$kegiatan->TargetRp)*100);
    
    
                                }
                            }
                        }
                    }
                }
                
                foreach ( $data as $dt ){
                    foreach($dt->Urusan as $urusan){
                        foreach($urusan->BidangUrusan as $bidang_urusan){
    
                           foreach ( $bidang_urusan->Program as $program ){
                               $kegiatan_count=$program->Kegiatan->count();
                                $program->TargetK=$kegiatan_count == 0 ? 0 : ($program->KegiatanTotalTargetK/$kegiatan_count);
                                $program->TargetRp=$program->KegiatanTotalTargetRp;
                                $program->RealisasiK=$kegiatan_count == 0 ? 0 : ($program->KegiatanTotalRealisasiK/$kegiatan_count);
                                $program->RealisasiRp=$program->KegiatanTotalRealisasiRp;
                                $program->TargetKinerjaK=$kegiatan_count == 0 ? 0 : ($program->KegiatanTotalTargetKinerjaK/$kegiatan_count);
                                $program->TargetKinerjaRp=$program->KegiatanTotalTargetKinerjaRp;
    
                                
    
    
                                $totRealisasiKinerjaK=0;
                                $totRealisasiKinerjaRp=0;
    
                                for($p=1;$p<=$triwulan;$p++){
                                    $program->RealisasiKinerjaK[$p]=$kegiatan_count == 0 ? 0 : ($program->TotalRealisasiKinerjaK[$p]/$kegiatan_count);
                                    $program->RealisasiKinerjaRp[$p]=$program->TotalRealisasiKinerjaRp[$p];
    
                                    $totRealisasiKinerjaK+=$program->RealisasiKinerjaK[$p];
                                    $totRealisasiKinerjaRp+=$program->RealisasiKinerjaRp[$p];
                                }
    
                                
    
                                $program->K13=$totRealisasiKinerjaK;
                                $program->Rp13=$totRealisasiKinerjaRp;
    
                                $program->K14=($program->RealisasiK+($program->TargetKinerjaK*$program->K13))/100;
                                $program->Rp14=$program->Rp13+$program->RealisasiRp;
                                $program->K15=$program->TargetK==0?0:($program->K14/$program->TargetK*100);
                                $program->Rp15=$program->TargetRp==0?0:($program->Rp14/$program->TargetRp*100);
    
                                
                            }
                        }
                    }
                }
                
                foreach ( $data as $dt ){
                    foreach($dt->Urusan as $urusan){
    
                        foreach($urusan->BidangUrusan as $bidang_urusan){
                            
                            foreach ( $bidang_urusan->Program as $program ){
                                foreach($program->Outcome as $po){
                                    $poTotTarget=$program->Kegiatan->where('id_renstra_program_outcome',$po->id);
                                    
                                    $po->PoTargetRp=$poTotTarget->sum('TargetRp');
                                    $po->PoRealisasiK=$poTotTarget->count()==0?0:$poTotTarget->sum('RealisasiK')/$poTotTarget->count();
                                    $po->PoRealisasiRp=$poTotTarget->sum('RealisasiRp');
                                    $po->PoTargetKinerjaRp=$poTotTarget->sum('TargetKinerjaRp');
                                    $po->PoTargetKinerjaK=$poTotTarget->count()==0?0:$poTotTarget->sum('TargetKinerjaK')/$poTotTarget->count();
    
                                    for($p=1;$p<=$triwulan;$p++){
                                        $po->PoRealisasiKinerjaK[$p]=$poTotTarget->count()==0?0:$poTotTarget->reduce(function ($sum,$option) use ($p) {
                                            return $sum+=$option->RealisasiKinerjaK[$p];
                                        }, 0)/$poTotTarget->count();
                                        $po->PoRealisasiKinerjaRp[$p]=$poTotTarget->count()==0?0:$poTotTarget->reduce(function ($sum,$option) use ($p) {
                                            return $sum+=$option->RealisasiKinerjaRp[$p];
                                        }, 0);
                                    }
    
    
                                    $po->PoRp13=$poTotTarget->sum('Rp13');
                                    $po->PoK13=$poTotTarget->count()==0?0:$poTotTarget->sum('K13')/$poTotTarget->count();
                                    $po->PoRp14=$poTotTarget->sum('Rp14');
                                    $po->PoK14=$poTotTarget->count()==0?0:$poTotTarget->sum('K14')/$poTotTarget->count();
                                    $po->PoRp15=$poTotTarget->count()==0?0:$poTotTarget->sum('Rp15')/$poTotTarget->count();
                                    $po->PoK15=$poTotTarget->count()==0?0:$poTotTarget->sum('K15')/$poTotTarget->count();
    
                                }
    
                            }
    
                        }
                    }
                }
                
                foreach ( $data as $dt ){
    
                    foreach($dt->Urusan as $urusan){
    
    
                        foreach($urusan->BidangUrusan as $bidang_urusan){
                            $bidang_urusan->Program->reduce(function ($sum,$program) use ($bidang_urusan,$triwulan) {
                                $program_count=$program->Outcome->count();
    
                                $bidang_urusan->TargetK=$program_count == 0 ? 0 : ($program->Outcome->sum('volume')/$program_count);
                                $bidang_urusan->TargetRp=$program->Outcome->sum('PoTargetRp');
                                $bidang_urusan->RealisasiK=$program_count == 0 ? 0 : ($program->Outcome->sum('PoRealisasiK')/$program_count);
                                $bidang_urusan->RealisasiRp=$program->Outcome->sum('PoRealisasiRp');
                                $bidang_urusan->TargetKinerjaK=$program_count == 0 ? 0 : ($program->Outcome->sum('PoTargetKinerjaK')/$program_count);
                                $bidang_urusan->TargetKinerjaRp=$program->Outcome->sum('PoTargetKinerjaRp');
    
                                for($p=1;$p<=$triwulan;$p++){
                                    $bidang_urusan->RealisasiKinerjaK[$p]=$program_count==0?0:$program->Outcome->reduce(function ($sum,$option) use ($p) {
                                        return $sum+=$option->PoRealisasiKinerjaK[$p];
                                    }, 0)/$program_count;
                                    $bidang_urusan->RealisasiKinerjaRp[$p]=$program->Outcome->reduce(function ($sum,$option) use ($p) {
                                        return $sum+=$option->PoRealisasiKinerjaRp[$p];
                                    }, 0);
                                }
    
                                $bidang_urusan->TargetKinerjaK=$program_count == 0 ? 0 : ($program->Outcome->sum('PoTargetKinerjaK')/$program_count);
                                $bidang_urusan->TargetKinerjaRp=$program->Outcome->sum('PoTargetKinerjaRp');
    
                                $bidang_urusan->K13=$program_count == 0 ? 0 : ($program->Outcome->sum('PoK13')/$program_count);
                                $bidang_urusan->Rp13=$program->Outcome->sum('PoRp13');
                                $bidang_urusan->K14=$program_count == 0 ? 0 : ($program->Outcome->sum('PoK14')/$program_count);
                                $bidang_urusan->Rp14=$program->Outcome->sum('PoRp13')+$bidang_urusan->RealisasiRp;
                                $bidang_urusan->K15=$program_count == 0 ? 0 : ($program->Outcome->sum('PoK15')/$program_count);
                                $bidang_urusan->Rp15=$program_count == 0 ? 0 : ($program->Outcome->sum('PoRp15')/$program_count);
                                
                                
    
                                
                                
                            });
    
                        }
                    }
                }
                
                foreach ( $data as $dt ){
    
                        foreach($dt->Urusan as $urusan){
    
                            $bidang_urusan_count=$urusan->BidangUrusan->count();
    
                                $urusan->TargetK=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('TargetK')/$bidang_urusan_count);
                                $urusan->TargetRp=$urusan->BidangUrusan->sum('TargetRp');
                                $urusan->RealisasiK=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('RealisasiK')/$bidang_urusan_count);
                                $urusan->RealisasiRp=$urusan->BidangUrusan->sum('RealisasiRp');
                                $urusan->TargetKinerjaK=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('TargetKinerjaK')/$bidang_urusan_count);
                                $urusan->TargetKinerjaRp=$urusan->BidangUrusan->sum('TargetKinerjaRp');
    
                                for($p=1;$p<=$triwulan;$p++){
                                    $urusan->RealisasiKinerjaK[$p]=$bidang_urusan_count==0?0:$urusan->BidangUrusan->reduce(function ($sum,$option) use ($p) {
                                        return $sum+=$option->RealisasiKinerjaK[$p];
                                    }, 0)/$bidang_urusan_count;
                                    $urusan->RealisasiKinerjaRp[$p]=$urusan->BidangUrusan->reduce(function ($sum,$option) use ($p) {
                                        return $sum+=$option->RealisasiKinerjaRp[$p];
                                    }, 0);
                                }
    
                                $urusan->TargetKinerjaK=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('TargetKinerjaK')/$bidang_urusan_count);
                                $urusan->TargetKinerjaRp=$urusan->BidangUrusan->sum('TargetKinerjaRp');
    
                                $urusan->K13=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('K13')/$bidang_urusan_count);
                                $urusan->Rp13=$urusan->BidangUrusan->sum('Rp13');
                                $urusan->K14=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('K14')/$bidang_urusan_count);
                                $urusan->Rp14=$urusan->BidangUrusan->sum('Rp13')+$urusan->RealisasiRp;
                                $urusan->K15=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('K15')/$bidang_urusan_count);
                                $urusan->Rp15=$bidang_urusan_count == 0 ? 0 : ($urusan->BidangUrusan->sum('Rp15')/$bidang_urusan_count);
    
                        }
                }
    
                foreach ( $data as $dt ){
                                
                                $urusan_count=$dt->Urusan->count();
    
                                $dt->TargetK=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('TargetK')/$urusan_count);
                                $dt->TargetRp=$dt->Urusan->sum('TargetRp');
                                $dt->RealisasiK=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('RealisasiK')/$urusan_count);
                                $dt->RealisasiRp=$dt->Urusan->sum('RealisasiRp');
                                $dt->TargetKinerjaK=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('TargetKinerjaK')/$urusan_count);
                                $dt->TargetKinerjaRp=$dt->Urusan->sum('TargetKinerjaRp');
    
                                for($p=1;$p<=$triwulan;$p++){
                                    $dt->RealisasiKinerjaK[$p]=$urusan_count==0?0:$dt->Urusan->reduce(function ($sum,$option) use ($p) {
                                        return $sum+=$option->RealisasiKinerjaK[$p];
                                    }, 0)/$urusan_count;
                                    $dt->RealisasiKinerjaRp[$p]=$dt->Urusan->reduce(function ($sum,$option) use ($p) {
                                        return $sum+=$option->RealisasiKinerjaRp[$p];
                                    }, 0);
                                }
    
                                $dt->TargetKinerjaK=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('TargetKinerjaK')/$urusan_count);
                                $dt->TargetKinerjaRp=$dt->Urusan->sum('TargetKinerjaRp');
    
                                $dt->K13=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('K13')/$urusan_count);
                                $dt->Rp13=$dt->Urusan->sum('Rp13');
                                $dt->K14=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('K14')/$urusan_count);
                                $dt->Rp14=$dt->Urusan->sum('Rp13')+$dt->RealisasiRp;
                                $dt->K15=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('K15')/$urusan_count);
                                $dt->Rp15=$urusan_count == 0 ? 0 : ($dt->Urusan->sum('Rp15')/$urusan_count);
    
                }
    
    
                $fungsi = Str::slug(($unit_kerja_selected ? 'semua unit kerja' : 'semua'), '_');
                $dinas = '';
                $periode = '';
                if ($unit_kerja_selected) {
                    $dinas = UnitKerja::find($unit_kerja_selected)->nama_unit_kerja;
                }
    
                switch ($periode_selected) {
                    case 1:
                        $periode = 'Januari - Maret';
                        break;
                    case 2:
                        $periode = 'April - Juni';
                        break;
                    case 3:
                        $periode = 'Juli - September';
                        break;
                    case 4:
                        $periode = 'Oktober - Desember';
                        break;
                    default:
                        break;
                }
    
                if ($fungsi) {
                    $fungsi = "export_evaluasi_renja_$fungsi";
                }
                return $this->{$fungsi}($tipe, $data, $total_pagu_keseluruhan, $total_realisasi_keuangan, $periode, $dinas, $tahun, $periode_selected, $sumber_dana_selected,$triwulan,$tahun_sebelum);    
            }else{

                $tahun = session('tahun_penganggaran','');
            
                $data=DB::table('unit_kerja')->select('unit_kerja.*')->get();
                
                foreach ($data as $unit ){
                    $unit->renstra=DB::table('renstra_sub_kegiatan')->select('renstra_sub_kegiatan.*')
                    ->join('unit_kerja','unit_kerja.id','=','renstra_sub_kegiatan.id_unit_kerja')
                    ->whereRaw("renstra_sub_kegiatan.id_unit_kerja=$unit->id")
                    ->get();
                    $unit->jumlah_kegiatan=0;
                    $unit->persenK=0;
                    $unit->persenRp=0;
                    $unit->totpersenK=0;
                    $unit->totpersenRp=0;
                    $unit->totalRp=0;
                    $unit->targetRp=0;
                    foreach ($unit->renstra as $renstra){
                        $renstra->dpa=DB::table('dpa')
                        ->whereRaw("dpa.id_unit_kerja=$renstra->id_unit_kerja AND dpa.id_sub_kegiatan=$renstra->id_sub_kegiatan")
                        ->first();
                        //$renstra->id_dpa=DB::table('dpa')->whereRaw("id_sub_kegiatan='$renstra->id_sub_kegiatan' AND id_unit_kerja=$renstra->id_unit_kerja ")->first();
                        $renstra->TargetK=DB::table('renstra_sub_kegiatan_target')->whereRaw("renstra_sub_kegiatan_target.id_renstra_sub_kegiatan='$renstra->id' AND tahun='$tahun'")->sum('volume');
                        $renstra->TargetRp=DB::table('dpa')->whereRaw("dpa.id_sub_kegiatan='$renstra->id_sub_kegiatan' AND dpa.id_unit_kerja=$renstra->id_unit_kerja  AND dpa.tahun='$tahun'")->sum('dpa.nilai_pagu_dpa');
                        $renstra->totRealisasiKinerjaK=0;
                        $renstra->totRealisasiKinerjaRp=0;
                        $renstra->persenK=0;
                        $renstra->persenRp=0;
                        for($p=1;$p<=$triwulan;$p++){
                            $realisasi=DB::table('dpa')->join('realisasi','realisasi.id_dpa','=','dpa.id')->whereRaw("dpa.id_sub_kegiatan='$renstra->id_sub_kegiatan' AND realisasi.periode='$p' AND realisasi.tahun='$tahun' AND dpa.id_unit_kerja=$renstra->id_unit_kerja")->limit(1);
                            if($realisasi->count()>0){
                                $renstra->RealisasiKinerjaRp[$p]=$realisasi->first()->realisasi_keuangan;
                                $renstra->RealisasiKinerjaK[$p]=$realisasi->first()->realisasi_kinerja;
                            }else{
                                $renstra->RealisasiKinerjaRp[$p]=0;
                                $renstra->RealisasiKinerjaK[$p]=0;
                            }
                            $renstra->totRealisasiKinerjaK+=$renstra->RealisasiKinerjaK[$p];
                            $renstra->totRealisasiKinerjaRp+=$renstra->RealisasiKinerjaRp[$p];
                            
                        }
                        
                        $renstra->persenK=$renstra->TargetK==0?0:(($renstra->totRealisasiKinerjaK/$renstra->TargetK)*100);
                        $renstra->persenRp=$renstra->TargetRp==0?0:(($renstra->totRealisasiKinerjaRp/$renstra->TargetRp)*100);
                        
                        

                        if(isset($renstra->dpa)){
                            $unit->jumlah_kegiatan++;
                        }
                        

                        $unit->totpersenK+=$renstra->persenK;
                        $unit->totpersenRp+=$renstra->persenRp;
                        $unit->totalRp+=$renstra->totRealisasiKinerjaRp;
                        $unit->targetRp+=$renstra->TargetRp;

                    }
                        
                        $unit->persenK=$unit->jumlah_kegiatan==0?0:($unit->totpersenK/$unit->jumlah_kegiatan);
                        //$unit->persenRp=$unit->jumlah_kegiatan==0?0:($unit->totpersenRp/$unit->jumlah_kegiatan);

                        $unit->persenRp=$unit->targetRp==0?0:(($unit->totalRp/$unit->targetRp)*100);


                        //$unit->totalRp=$unit->jumlah_kegiatan==0?0:($unit->totpersenRp/$unit->jumlah_kegiatan);
                        
                        //$unit->persenRp=$unit->jumlah_kegiatan;
                        


                }
                // return $data;

                $fungsi = "export_evaluasi_renja_semua";
                return $this->{$fungsi}($tipe,$data,$tahun); 
            }
        
            

        // return $data;
    }


    public function export_evaluasi_renja_semua_unit_kerja($tipe, $data, $total_pagu_keseluruhan, $total_realisasi_keuangan, $periode, $dinas, $tahun, $periode_selected, $sumber_dana_selected, $triwulan,$tahun_sebelum, $query = [])
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('AFILA')
            ->setLastModifiedBy('AFILA')
            ->setTitle('EVALUASI RENJA ' . $dinas . '')
            ->setSubject('EVALUASI RENJA ' . $dinas . '')
            ->setDescription('EVALUASI RENJA ' . $dinas . '')
            ->setKeywords('pdf php')
            ->setCategory('KEMAJUAN');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);
        if ($sumber_dana_selected == 'semua') {
            $sumber_dana_selected = 'APBN, DAK, APBD I & APBD II';
        } else {
            $sumber_dana_selected = strtoupper($sumber_dana_selected);
        }
        // Header Text
        $sheet->setCellValue('A1', 'LAPORAN EVALUASI TERHADAP RKPD');
        $sheet->setCellValue('A2', 'KABUPATEN ENREKANG TAHUN ANGGARAN ' . $tahun . '' . $periode_selected);
        $sheet->setCellValue('A3', strtoupper($dinas));
        $sheet->setCellValue('A4', ' ');
        
        //$sheet->setCellValue('A3', 'SUMBER DANA ' . $sumber_dana_selected);
        $sheet->mergeCells('A1:AA1');
        $sheet->mergeCells('A2:AA2');
        $sheet->mergeCells('A3:AA3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'No')->mergeCells('A5:A6')->getColumnDimension('A')->setWidth(5,31);;
        $sheet->setCellValue('B5', 'Sasaran')->mergeCells('B5:B6')->getColumnDimension('B')->setWidth(13,16);;
        $sheet->setCellValue('C5', 'Kode')->mergeCells('C5:C6')->getColumnDimension('C')->setWidth(11,98);;
        $sheet->setCellValue('D5', 'Urusan/Bidang Urusan Pemerintah Daerah dan Program/Kegiatan/Sub Kegiatan')->mergeCells('D5:D6')->getColumnDimension('D')->setWidth(15,94);;
        $sheet->setCellValue('E5', 'Indikator Kinerja Program (outcome) / Kegiatan (output)')->mergeCells('E5:E6')->getColumnDimension('E')->setWidth(14,85);;
        $sheet->setCellValue('F5', 'Target Renstra OPD pada Tahun 2019 s/d 2023 (akhir periode Renstra OPD)')->mergeCells('F5:G6');
        $sheet->setCellValue('H5', 'Realisasi Capaian Kinerja Renstra OPD s/d Renja OPD Tahun lalu ('.$tahun_sebelum.')')->mergeCells('H5:I6');
        $sheet->setCellValue('J5', 'Target Kinerja dan Anggaran Renja OPD Tahun berjalan yang dievaluasi ('.$tahun.')')->mergeCells('J5:K6');
        $sheet->setCellValue('L5', 'Realisasi Kinerja Pada Triwulan')->mergeCells('L5:S5');
        
        $sheet->setCellValue('T5', 'Realisasi Capaian Kinerja dan Anggaran Renja OPD yang Dievaluasi')->mergeCells('T5:U6');
        $sheet->setCellValue('V5', 'Realisasi kinerja dan Anggaran Renstra OPD s/d tahun '.$tahun.' (Ahkir Tahun pelaksanaan Renja OPD)')->mergeCells('V5:W6');
        $sheet->setCellValue('X5', 'Tingkat Capaian Kinerja dan Realisasi Anggaran Renstra OPD s/d tahun '.$tahun.' (%)')->mergeCells('X5:Y6');
        $sheet->setCellValue('Z5', 'Unit OPD penanggung jawab')->mergeCells('Z5:Z7')->getColumnDimension('Z')->setWidth(17,63);;
        $sheet->setCellValue('AA5', 'Ket')->mergeCells('AA5:AA7')->getColumnDimension('AA')->setWidth(5,31);;

        $sheet->setCellValue('L6', 'I')->mergeCells('L6:M6');
        $sheet->setCellValue('N6', 'II')->mergeCells('N6:O6');
        $sheet->setCellValue('P6', 'III')->mergeCells('P6:Q6');
        $sheet->setCellValue('R6', 'IV')->mergeCells('R6:S6');


        $sheet->setCellValue('A7', '1')->mergeCells('A7:A8');
        $sheet->setCellValue('B7', '2')->mergeCells('B7:B8');
        $sheet->setCellValue('C7', '3')->mergeCells('C7:C8');
        $sheet->setCellValue('D7', '4')->mergeCells('D7:D8');
        $sheet->setCellValue('E7', '5')->mergeCells('E7:E8');
        $sheet->setCellValue('F7', '6')->mergeCells('F7:G7');
        $sheet->setCellValue('H7', '7')->mergeCells('H7:I7');
        $sheet->setCellValue('J7', '8')->mergeCells('J7:K7');
        $sheet->setCellValue('L7', '9')->mergeCells('L7:M7');
        $sheet->setCellValue('N7', '10')->mergeCells('N7:O7');
        $sheet->setCellValue('P7', '11')->mergeCells('P7:Q7');
        $sheet->setCellValue('R7', '12')->mergeCells('R7:S7');
        $sheet->setCellValue('T7', '13=9+10+11+12')->mergeCells('T7:U7');
        $sheet->setCellValue('V7', '14=7+13')->mergeCells('V7:W7');
        $sheet->setCellValue('X7', '15=14/6x100')->mergeCells('X7:Y7');
        

        $sheet->setCellValue('F8', 'K')->mergeCells('F8:F8')->getColumnDimension('F')->setWidth(9,36);
        $sheet->setCellValue('G8', 'Rp')->mergeCells('G8:G8')->getColumnDimension('G')->setWidth(14);
        $sheet->setCellValue('H8', 'K')->mergeCells('H8:H8')->getColumnDimension('H')->setWidth(9,36);
        $sheet->setCellValue('I8', 'Rp')->mergeCells('I8:I8')->getColumnDimension('I')->setWidth(13,5);
        $sheet->setCellValue('J8', 'K')->mergeCells('J8:J8')->getColumnDimension('J')->setWidth(9,36);
        $sheet->setCellValue('K8', 'Rp')->mergeCells('K8:K8')->getColumnDimension('K')->setWidth(13,5);
        $sheet->setCellValue('L8', 'K')->mergeCells('L8:L8')->getColumnDimension('L')->setWidth(9,5);
        $sheet->setCellValue('M8', 'Rp')->mergeCells('M8:M8')->getColumnDimension('M')->setWidth(13,5);
        $sheet->setCellValue('N8', 'K')->mergeCells('N8:N8')->getColumnDimension('N')->setWidth(9,36);
        $sheet->setCellValue('O8', 'Rp')->mergeCells('O8:O8')->getColumnDimension('O')->setWidth(13,5);
        $sheet->setCellValue('P8', 'K')->mergeCells('P8:P8')->getColumnDimension('P')->setWidth(9,36);
        $sheet->setCellValue('Q8', 'Rp')->mergeCells('Q8:Q8')->getColumnDimension('Q')->setWidth(13,5);
        $sheet->setCellValue('R8', 'K')->mergeCells('R8:R8')->getColumnDimension('R')->setWidth(9,36);
        $sheet->setCellValue('S8', 'Rp')->mergeCells('S8:S8')->getColumnDimension('S')->setWidth(13,5);
        $sheet->setCellValue('T8', 'K')->mergeCells('T8:T8')->getColumnDimension('T')->setWidth(9,36);
        $sheet->setCellValue('U8', 'Rp')->mergeCells('U8:U8')->getColumnDimension('U')->setWidth(13,5);
        $sheet->setCellValue('V8', 'K')->mergeCells('V8:V8')->getColumnDimension('V')->setWidth(9,36);
        $sheet->setCellValue('W8', 'Rp')->mergeCells('W8:W8')->getColumnDimension('W')->setWidth(13,5);
        $sheet->setCellValue('X8', 'K')->mergeCells('X8:X8')->getColumnDimension('X')->setWidth(9,36);
        $sheet->setCellValue('Y8', 'Rp')->mergeCells('Y8:Y8')->getColumnDimension('Y')->setWidth(9,36);

        
        
        


        $sheet->getStyle('A:AA')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:AA8')->getFont()->setBold(true);
        $sheet->getStyle('A5:AA8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('C6E0B4');
        
        

        $cell = 9;

        $jumlah_sub_kegiatan = 0;
        $jumlah_persen_kinerja_sub_kegiatan = 0;
        $jumlah_persen_keuangan_sub_kegiatan = 0;
        $rata_rata_capaian_kinerja = 0;
        $rata_rata_capaian_keuangan = 0;
        $jumlah_rp = 0;
        $jumlah_target = 0;

        


        $i=0;

        foreach ( $data as $sasaran ){
        $sheet->setCellValue('A' . $cell, ++$i);
        $sheet->setCellValue('B' . $cell, $sasaran->sasaran);
        $sheet->setCellValue('C' . $cell, '');
        $sheet->setCellValue('D' . $cell, '');
        $sheet->setCellValue('E' . $cell, '');
        //$sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($sasaran->TargetK).'%');
        //$sheet->setCellValue('G' . $cell, numberToCurrency($sasaran->TargetRp));
        //$sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($sasaran->RealisasiK).'%');
        //$sheet->setCellValue('I' . $cell, numberToCurrency($sasaran->RealisasiRp));
        //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($sasaran->TargetKinerjaK).'%');
        //$sheet->setCellValue('K' . $cell, numberToCurrency($sasaran->TargetKinerjaRp));
        $kolom='L';
        if ($triwulan==2){
        for ($p=1;$p<=$triwulan;$p++){
        //    $sheet->setCellValue($kolom++ . $cell, pembulatanDuaDecimal($sasaran->RealisasiKinerjaK[$p]).'%');
        //    $sheet->setCellValue($kolom++ . $cell, numberToCurrency($sasaran->RealisasiKinerjaRp[$p]));
        }
        $sheet->setCellValue('P' . $cell, '');
        $sheet->setCellValue('Q' . $cell, '');
        $sheet->setCellValue('R' . $cell, '');
        $sheet->setCellValue('S' . $cell, '');
        }else{
        for ($p=1;$p<=$triwulan;$p++){
        //    $sheet->setCellValue($kolom++ . $cell, pembulatanDuaDecimal($sasaran->RealisasiKinerjaK[$p]).'%');
        //    $sheet->setCellValue($kolom++ . $cell, numberToCurrency($sasaran->RealisasiKinerjaRp[$p]));
        }
        }
        
        
        
        //$sheet->setCellValue('T' . $cell, pembulatanDuaDecimal($sasaran->K13).'%');
        //$sheet->setCellValue('U' . $cell, numberToCurrency($sasaran->Rp13));
        //$sheet->setCellValue('V' . $cell, pembulatanDuaDecimal($sasaran->K14).'%');
        //$sheet->setCellValue('W' . $cell, numberToCurrency($sasaran->Rp14));
        //$sheet->setCellValue('X' . $cell, pembulatanDuaDecimal($sasaran->K15).'%');
        //$sheet->setCellValue('Y' . $cell, pembulatanDuaDecimal($sasaran->Rp15).'%');
        //$sheet->setCellValue('Z' . $cell, $sasaran->nama_unit_kerja);
        $sheet->setCellValue('AA' . $cell, '');
        $sheet->getStyle('A' . $cell . ':AA' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('9BC2E6');
        $cell++;

        

            $j=0;
            foreach ( $sasaran->Urusan->sortBy('urusan') as $urusan ){
                //$sheet->setCellValue('A' . $cell, $i.'.'.++$j);
                //$sheet->setCellValue('B' . $cell, '');
                //$sheet->setCellValue('C' . $cell, $urusan->kode_urusan);
                //$sheet->setCellValue('D' . $cell, $urusan->nama_urusan);
                //$sheet->setCellValue('E' . $cell, '');
                //$sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($urusan->TargetK).'%');
                //$sheet->setCellValue('G' . $cell, numberToCurrency($urusan->TargetRp));
                //$sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($urusan->RealisasiK).'%');
                //$sheet->setCellValue('I' . $cell, numberToCurrency($urusan->RealisasiRp));
                //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($urusan->TargetKinerjaK).'%');
                //$sheet->setCellValue('K' . $cell, numberToCurrency($urusan->TargetKinerjaRp));
                $kolom='L';
                if ($triwulan==2){
                for ($p=1;$p<=$triwulan;$p++){
                  //  $sheet->setCellValue($kolom++ . $cell, pembulatanDuaDecimal($urusan->RealisasiKinerjaK[$p]).'%');
                  //  $sheet->setCellValue($kolom++ . $cell, numberToCurrency($urusan->RealisasiKinerjaRp[$p]));
                }
                //$sheet->setCellValue('P' . $cell, '');
                //$sheet->setCellValue('Q' . $cell, '');
                //$sheet->setCellValue('R' . $cell, '');
                //$sheet->setCellValue('S' . $cell, '');
                }else{
                for ($p=1;$p<=$triwulan;$p++){
                   // $sheet->setCellValue($kolom++ . $cell, pembulatanDuaDecimal($urusan->RealisasiKinerjaK[$p]).'%');
                   // $sheet->setCellValue($kolom++ . $cell, numberToCurrency($urusan->RealisasiKinerjaRp[$p]));
                }
                }
                
                
                
                //$sheet->setCellValue('T' . $cell, pembulatanDuaDecimal($urusan->K13).'%');
                //$sheet->setCellValue('U' . $cell, numberToCurrency($urusan->Rp13));
                //$sheet->setCellValue('V' . $cell, pembulatanDuaDecimal($urusan->K14).'%');
                //$sheet->setCellValue('W' . $cell, numberToCurrency($urusan->Rp14));
                //$sheet->setCellValue('X' . $cell, pembulatanDuaDecimal($urusan->K15).'%');
                //$sheet->setCellValue('Y' . $cell, pembulatanDuaDecimal($urusan->Rp15).'%');
                //$sheet->setCellValue('Z' . $cell, $sasaran->nama_unit_kerja);
                //$sheet->setCellValue('AA' . $cell, '');
                //$sheet->getStyle('A' . $cell . ':AA' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('6D9EEB');
                //$cell++;
        
                    $k=0;
                    foreach ( $urusan->BidangUrusan->sortBy('kode_bidang_urusan') as $bidang_urusan ){
                        //$sheet->setCellValue('A' . $cell, $i.'.'.$j.'.'.++$k);
                        //$sheet->setCellValue('B' . $cell, '');
                        //$sheet->setCellValue('C' . $cell, $urusan->kode_urusan.'.'.$bidang_urusan->kode_bidang_urusan);
                        //$sheet->setCellValue('D' . $cell, $bidang_urusan->nama_bidang_urusan);
                        //$sheet->setCellValue('E' . $cell, '');
                        //$sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($bidang_urusan->TargetK).'%');
                        //$sheet->setCellValue('G' . $cell, numberToCurrency($bidang_urusan->TargetRp));
                        //$sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($bidang_urusan->RealisasiK).'%');
                        //$sheet->setCellValue('I' . $cell, numberToCurrency($bidang_urusan->RealisasiRp));
                        //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($bidang_urusan->TargetKinerjaK).'%');
                        //$sheet->setCellValue('K' . $cell, numberToCurrency($bidang_urusan->TargetKinerjaRp));
                        $kolom='L';
                        if ($triwulan==2){
                        for ($p=1;$p<=$triwulan;$p++){
                            //$sheet->setCellValue($kolom++ . $cell, pembulatanDuaDecimal($bidang_urusan->RealisasiKinerjaK[$p]).'%');
                            //$sheet->setCellValue($kolom++ . $cell, numberToCurrency($bidang_urusan->RealisasiKinerjaRp[$p]));
                        }
                        //$sheet->setCellValue('P' . $cell, '');
                        //$sheet->setCellValue('Q' . $cell, '');
                        //$sheet->setCellValue('R' . $cell, '');
                        //$sheet->setCellValue('S' . $cell, '');
                        }else{
                        for ($p=1;$p<=$triwulan;$p++){
                            //$sheet->setCellValue($kolom++ . $cell, pembulatanDuaDecimal($bidang_urusan->RealisasiKinerjaK[$p]).'%');
                            //$sheet->setCellValue($kolom++ . $cell, numberToCurrency($bidang_urusan->RealisasiKinerjaRp[$p]));
                        }
                        }
                        
                        
                        
                        //$sheet->setCellValue('T' . $cell, pembulatanDuaDecimal($bidang_urusan->K13).'%');
                        //$sheet->setCellValue('U' . $cell, numberToCurrency($bidang_urusan->Rp13));
                        //$sheet->setCellValue('V' . $cell, pembulatanDuaDecimal($bidang_urusan->K14).'%');
                        //$sheet->setCellValue('W' . $cell, numberToCurrency($bidang_urusan->Rp14));
                        //$sheet->setCellValue('X' . $cell, pembulatanDuaDecimal($bidang_urusan->K15).'%');
                        //$sheet->setCellValue('Y' . $cell, pembulatanDuaDecimal($bidang_urusan->Rp15).'%');
                        //$sheet->setCellValue('Z' . $cell, $sasaran->nama_unit_kerja);
                        //$sheet->setCellValue('AA' . $cell, '');
                        // $sheet->getStyle('A' . $cell . ':AA' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('6D9EEB');
                        //$cell++;
                        if ($bidang_urusan->Program->count()>0)
                        $l=0;
                        foreach ( $bidang_urusan->Program->sortBy('kode_program') as $program ){
                            if ($urusan->kode_urusan == '00') {
                                $non_urusan = true;
                                $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                                $kode_program = $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . '.' . $program->kode_program;
                            } else {
                                $kode_program = $urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . '.' . $program->kode_program;
                            }
                            $count_outcome=$cell+$program->Outcome->count();
                            $sheet->setCellValue('A' . $cell, '')->mergeCells('A'.$cell.':A'.$count_outcome);
                            $sheet->setCellValue('B' . $cell, '')->mergeCells('B'.$cell.':B'.$count_outcome);
                            $sheet->setCellValue('C' . $cell, $kode_program)->mergeCells('C'.$cell.':C'.$count_outcome);
                            $sheet->setCellValue('D' . $cell, $program->nama_program)->mergeCells('D'.$cell.':D'.$count_outcome);
                            $sheet->getStyle('A' . $cell . ':AA' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('F0B6E8');
                            $cell++;
                            
                            foreach ($program->Outcome as $dt ){
                              

                                $outcome="";
                                $outcome.=$dt->outcome." \n";
                                $sheet->setCellValue('E' . $cell, $outcome);
                                $sheet->getStyle('E')->getAlignment()->setWrapText(true);
                                $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($dt->volume).''.$dt->satuan);
                                // $sheet->setCellValue('G' . $cell, numberToCurrency($dt->PoTargetRp));
                                // $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dt->PoRealisasiK).'%');
                                // $sheet->setCellValue('I' . $cell, numberToCurrency($dt->PoRealisasiRp));
                                // $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dt->PoTargetKinerjaK).'%');
                                // $sheet->setCellValue('K' . $cell, numberToCurrency($dt->PoTargetKinerjaRp));
                                // $kolom='L';
                                // if ($triwulan==2){
                                // for ($p=1;$p<=$triwulan;$p++){
                                //     $sheet->setCellValue($kolom++ . $cell, pembulatanDuaDecimal($dt->PoRealisasiKinerjaK[$p]).'%');
                                //     $sheet->setCellValue($kolom++ . $cell, numberToCurrency($dt->PoRealisasiKinerjaRp[$p]));
                                // }
                                // $sheet->setCellValue('P' . $cell, '');
                                // $sheet->setCellValue('Q' . $cell, '');
                                // $sheet->setCellValue('R' . $cell, '');
                                // $sheet->setCellValue('S' . $cell, '');
                                // }else{
                                // for ($p=1;$p<=$triwulan;$p++){
                                //     $sheet->setCellValue($kolom++ . $cell, pembulatanDuaDecimal($dt->PoRealisasiKinerjaK[$p]).'%');
                                //     $sheet->setCellValue($kolom++ . $cell, numberToCurrency($dt->PoRealisasiKinerjaRp[$p]));
                                // }
                                // }
                                
                                
                                
                                // $sheet->setCellValue('T' . $cell, pembulatanDuaDecimal($dt->PoK13).'%');
                                // $sheet->setCellValue('U' . $cell, numberToCurrency($dt->PoRp13));
                                // $sheet->setCellValue('V' . $cell, pembulatanDuaDecimal($dt->PoK14).'%');
                                // $sheet->setCellValue('W' . $cell, numberToCurrency($dt->PoRp14));
                                // $sheet->setCellValue('X' . $cell, pembulatanDuaDecimal($dt->PoK15).'%');
                                // $sheet->setCellValue('Y' . $cell, pembulatanDuaDecimal($dt->PoRp15).'%');
                                // $sheet->setCellValue('Z' . $cell, $sasaran->nama_unit_kerja);
                                // $sheet->setCellValue('AA' . $cell, '');
                                $sheet->getStyle('A' . $cell . ':AA' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('F0B6E8');
                                $cell++;
                                
                            }
                            
                    
                        
                            if ($program->Kegiatan->count() >0)
                                $m=0;
                            foreach ( $program->Kegiatan->sortBy('kode_kegiatan') as $kegiatan ){
                                if ($urusan->kode_urusan == '00') {
                                    $non_urusan = true;
                                    $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                                    $kode_kegiatan = $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . '.' . $program->kode_program.'.'.$kegiatan->kode_kegiatan;
                                } else {
                                    $kode_kegiatan = $urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . '.' . $program->kode_program.'.'.$kegiatan->kode_kegiatan;
                                }
                                $sheet->setCellValue('A' . $cell, '');
                                $sheet->setCellValue('B' . $cell, '');
                                $sheet->setCellValue('C' . $cell, $kode_kegiatan);
                                $sheet->setCellValue('D' . $cell, $kegiatan->nama_kegiatan);
                                $output="";
                                $volume='';
                                $satuan='';
                                foreach ($kegiatan->Output as $dt ){
                                    $volume.=$dt->volume;
                                    $satuan.=$dt->satuan;
                                    $output.=$dt->output."\n";
                                }
                                $sheet->setCellValue('E' . $cell, $output);
                                $sheet->getStyle('E')->getAlignment()->setWrapText(true);
                                $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($volume).''.$satuan);
                                $sheet->setCellValue('G' . $cell, numberToCurrency($kegiatan->TargetRp));
                                // $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($kegiatan->RealisasiK).'%');
                                // $sheet->setCellValue('I' . $cell, numberToCurrency($kegiatan->RealisasiRp));
                                // $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($kegiatan->TargetKinerjaK).'%');
                                // $sheet->setCellValue('K' . $cell, numberToCurrency($kegiatan->TargetKinerjaRp));
                                // $kolom='L';
                                // if ($triwulan==2){
                                // for ($p=1;$p<=$triwulan;$p++){
                                //     $sheet->setCellValue($kolom++ . $cell, pembulatanDuaDecimal($kegiatan->RealisasiKinerjaK[$p]).'%');
                                //     $sheet->setCellValue($kolom++ . $cell, numberToCurrency($kegiatan->RealisasiKinerjaRp[$p]));
                                // }
                                // $sheet->setCellValue('P' . $cell, '');
                                // $sheet->setCellValue('Q' . $cell, '');
                                // $sheet->setCellValue('R' . $cell, '');
                                // $sheet->setCellValue('S' . $cell, '');
                                // }else{
                                // for ($p=1;$p<=$triwulan;$p++){
                                //     $sheet->setCellValue($kolom++ . $cell, pembulatanDuaDecimal($kegiatan->RealisasiKinerjaK[$p]).'%');
                                //     $sheet->setCellValue($kolom++ . $cell, numberToCurrency($kegiatan->RealisasiKinerjaRp[$p]));
                                // }
                                // }
                                
                                
                                
                                // $sheet->setCellValue('T' . $cell, pembulatanDuaDecimal($kegiatan->K13).'%');
                                // $sheet->setCellValue('U' . $cell, numberToCurrency($kegiatan->Rp13));
                                // $sheet->setCellValue('V' . $cell, pembulatanDuaDecimal($kegiatan->K14).'%');
                                // $sheet->setCellValue('W' . $cell, numberToCurrency($kegiatan->Rp14));
                                // $sheet->setCellValue('X' . $cell, pembulatanDuaDecimal($kegiatan->K15).'%');
                                // $sheet->setCellValue('Y' . $cell, pembulatanDuaDecimal($kegiatan->Rp15).'%');
                                // $sheet->setCellValue('Z' . $cell, $sasaran->nama_unit_kerja);
                                // $sheet->setCellValue('AA' . $cell, '');
                                $sheet->getStyle('A' . $cell . ':AA' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('CC99FF');
                                $cell++;
                                    $n=0;
                                    foreach ( $kegiatan->SubKegiatan->sortBy('kode_sub_kegiatan') as $sub_kegiatan ){
                                        if ($sub_kegiatan->is_non_urusan) {
                                            $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                                            $kode_sub_kegiatan= $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . substr($sub_kegiatan->kode_sub_kegiatan, 4);
                                        }else{
                                            $kode_sub_kegiatan=$sub_kegiatan->kode_sub_kegiatan;
                                        }
                                        
                                        

                                        $sheet->setCellValue('A' . $cell, '');
                                        $sheet->setCellValue('B' . $cell, '');
                                        $sheet->setCellValue('C' . $cell, $kode_sub_kegiatan);
                                        $sheet->setCellValue('D' . $cell, $sub_kegiatan->nama_sub_kegiatan);
                                        $indikator="";
                                        foreach ($sub_kegiatan->Indikator as $dt ){
                                            $indikator.=$dt->indikator." (".$dt->satuan.") \n";
                                        }
                                        $sheet->setCellValue('E' . $cell, $indikator);
                                        $sheet->getStyle('E')->getAlignment()->setWrapText(true);
                                        $sheet->setCellValue('F' . $cell, $sub_kegiatan->total_volume);
                                        $sheet->setCellValue('G' . $cell, $sub_kegiatan->total_pagu_renstra);
                                        
                                        $sheet->setCellValue('H' . $cell, $sub_kegiatan->RealisasiK);
                                        $sheet->setCellValue('I' . $cell, $sub_kegiatan->RealisasiRp);
                                        $sheet->setCellValue('J' . $cell, $sub_kegiatan->TargetK);
                                        $sheet->setCellValue('K' . $cell, $sub_kegiatan->TargetRp);
                                        $kolom='L';
                                        if ($triwulan==2){
                                        for ($p=1;$p<=$triwulan;$p++){
                                            $sheet->setCellValue($kolom++ . $cell, $sub_kegiatan->RealisasiKinerjaK[$p]);
                                            $sheet->setCellValue($kolom++ . $cell, $sub_kegiatan->RealisasiKinerjaRp[$p]);
                                        }
                                        $sheet->setCellValue('P' . $cell, '');
                                        $sheet->setCellValue('Q' . $cell, '');
                                        $sheet->setCellValue('R' . $cell, '');
                                        $sheet->setCellValue('S' . $cell, '');
                                        }else{
                                        for ($p=1;$p<=$triwulan;$p++){
                                            $sheet->setCellValue($kolom++ . $cell, $sub_kegiatan->RealisasiKinerjaK[$p]);
                                            $sheet->setCellValue($kolom++ . $cell, $sub_kegiatan->RealisasiKinerjaRp[$p]);
                                        }
                                        }
                                        
                                        
                                        
                                        $sheet->setCellValue('T' . $cell, $sub_kegiatan->K13);
                                        $sheet->setCellValue('U' . $cell, $sub_kegiatan->Rp13);
                                        $sheet->setCellValue('V' . $cell, $sub_kegiatan->K14);
                                        $sheet->setCellValue('W' . $cell, $sub_kegiatan->Rp14);
                                        $sheet->setCellValue('X' . $cell, pembulatanDuaDecimal($sub_kegiatan->K15).'%');
                                        $sheet->setCellValue('Y' . $cell, pembulatanDuaDecimal($sub_kegiatan->Rp15).'%');
                                        $sheet->setCellValue('Z' . $cell, $sasaran->nama_unit_kerja);
                                        $sheet->setCellValue('AA' . $cell, '');
                                        $sheet->getStyle('A' . $cell . ':AA' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('D9E1F2');
                                        $cell++;
                                        
                                        
                                        $jumlah_sub_kegiatan++;
                                    

                                        $jumlah_persen_kinerja_sub_kegiatan+= $sub_kegiatan->TargetK == 0 ? 0 : (($sub_kegiatan->K13/$sub_kegiatan->TargetK)*100);
                                        $jumlah_persen_keuangan_sub_kegiatan+= $sub_kegiatan->TargetRp == 0 ? 0 : (($sub_kegiatan->Rp13/$sub_kegiatan->TargetRp)*100);
                                        $jumlah_rp+=$sub_kegiatan->Rp13;
                                        $jumlah_target+=$sub_kegiatan->TargetRp;
                                    }
                                
                                    
                                }
                            
                                }
                            }
                            }
                
                        }
        
                    
        
        


        $sheet->getStyle('A1:AA' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:AA' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B9:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C9:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D9:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('E9:E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('G9:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('I9:I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('K9:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('M9:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('O9:O' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('W9:W' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('S9:S' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('U9:U' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('W9:W' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        
        // $sheet->getStyle('C8:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F9:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G9:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H9:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('I9:I' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J9:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('K9:K' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L9:L' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('M9:M' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('N9:N' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('O9:O' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('P9:P' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('Q9:Q' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('R9:R' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('S9:S' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('T9:T' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('U9:U' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('V9:V' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('W9:W' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        
        
        $rata_rata_capaian_kinerja=$jumlah_sub_kegiatan == 0 ? 0 : ($jumlah_persen_kinerja_sub_kegiatan/$jumlah_sub_kegiatan);
        $rata_rata_capaian_keuangan=$jumlah_sub_kegiatan == 0 ? 0 : ($jumlah_persen_keuangan_sub_kegiatan/$jumlah_sub_kegiatan);
        

        // Total
        $cell++;
        $sheet->getStyle('A'.$cell.':Y' . ($cell+1))->getFont()->setBold(true);     
        $sheet->getStyle('K'.$cell.':L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($jumlah_target==0?0:($jumlah_target)));
        $sheet->setCellValue('L' . $cell, 'Rata-rata capaian kinerja (%)')->mergeCells('L' . $cell . ':O' . $cell);
        $sheet->setCellValue('T' . $cell, pembulatanDuaDecimal($rata_rata_capaian_kinerja));
        //$sheet->setCellValue('U' . $cell, pembulatanDuaDecimal($rata_rata_capaian_keuangan));
        $sheet->setCellValue('U' . $cell, pembulatanDuaDecimal($jumlah_target==0?0:($jumlah_rp/$jumlah_target)*100));

        
        

        //$sheet->setCellValue('U' . $cell, pembulatanDuaDecimal($jumlah_rp));
        //$sheet->setCellValue('V' . $cell, pembulatanDuaDecimal($jumlah_target));
        $sheet->setCellValue('V' . $cell, '')->mergeCells('V' . $cell . ':AA' . $cell);;
        
        
        if($rata_rata_capaian_kinerja>90){
            $PredikatK='ST';
        }elseif($rata_rata_capaian_kinerja>75){
            $PredikatK='T';
        }elseif($rata_rata_capaian_kinerja>65){
            $PredikatK='S';
        }elseif($rata_rata_capaian_kinerja>50){
            $PredikatK='R';
        }else{
            $PredikatK='SR';
        }
        if($rata_rata_capaian_keuangan>90){
            $PredikatRp='ST';
        }elseif($rata_rata_capaian_kinerja>75){
            $PredikatRp='T';
        }elseif($rata_rata_capaian_kinerja>65){
            $PredikatRp='S';
        }elseif($rata_rata_capaian_kinerja>50){
            $PredikatRp='R';
        }else{
            $PredikatRp='SR';
        }
        $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('T' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('U' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $cell++;
        $sheet->setCellValue('A' . $cell, 'Predikat kinerja')->mergeCells('A' . $cell . ':O' . $cell);
        $sheet->setCellValue('T' . $cell, $PredikatK);
        $sheet->setCellValue('U' . $cell, $PredikatRp);
        $sheet->setCellValue('V' . $cell, '')->mergeCells('V' . $cell . ':AA' . $cell);;
        $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('T' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('U' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.($cell-1).':AA'. $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('C6E0B4');
        $cell++;
        $sheet->setCellValue('A' . $cell, 'Faktor pendorong keberhasilan kinerja:')->mergeCells('A' . $cell . ':AA' . $cell);
        $sheet->setCellValue('A' . ++$cell, 'Faktor penghambat pencapaian kinerja:')->mergeCells('A' . $cell . ':AA' . $cell);
        $sheet->setCellValue('A' . ++$cell, 'Tindak lanjut yang diperlukan dalam triwulan berikutnya:')->mergeCells('A' . $cell . ':AA' . $cell);
        $sheet->setCellValue('A' . ++$cell, 'Tindak lanjut yang diperlukan dalam RKPD berikutnya:')->mergeCells('A' . $cell . ':AA' . $cell);
        
        
        
        

        $sheet->getStyle('X9:X' . $cell)->getFont()->setBold(true);
        $sheet->getStyle('Y9:Y' . $cell)->getFont()->setBold(true);
        
        // $sheet->getStyle('A' . $cell . ':AA' . $cell)->getFont()->setBold(true);
        // $sheet->getRowDimension($cell)->setRowHeight(30);
        //$sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A5:AA' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak', date('d/m/Y')));
        if (hasRole('admin')) {
        } else if (hasRole('opd')) {
            $sheet->setCellValue('V' . ++$cell, optional($profile)->nama_daerah . ', ' . $tgl_cetak)->mergeCells('V' . $cell . ':AA' . $cell);
            $sheet->getStyle('V' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('V' . ++$cell, request('nama_jabatan_kepala', ''))->mergeCells('V' . $cell . ':AA' . $cell);
            $sheet->getStyle('V' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $cell = $cell + 5;
            $sheet->setCellValue('V' . ++$cell, request('nama', ''))->mergeCells('V' . $cell . ':AA' . $cell);
            $sheet->getStyle('V' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('V' . ++$cell, 'Pangkat/Golongan : ' . request('jabatan', ''))->mergeCells('V' . $cell . ':AA' . $cell);
            $sheet->getStyle('V' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('V' . ++$cell, 'NIP : ' . request('nip', ''))->mergeCells('V' . $cell . ':AA' . $cell);
            $sheet->getStyle('V' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
        if ($tipe == 'excel') {
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="EVALUASI RENJA ' . $dinas . '.xlsx"');

        } else {
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui ' . url()->current())->mergeCells('A' . $cell . ':L' . $cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H' . url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            // header('Content-Disposition: attachment;filename="EVALUASI RENJA '.$dinas.'.pdf"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }
        $writer->save('php://output');
        exit;
    }

    public function export_evaluasi_renja_semua($tipe, $data, $tahun)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('AFILA')
            ->setLastModifiedBy('AFILA')
            ->setTitle('Capaian Kinerja dan Anggaran Program/Kegiatan RKPD')
            ->setSubject('Capaian Kinerja dan Anggaran Program/Kegiatan RKPD')
            ->setDescription('Capaian Kinerja dan Anggaran Program/Kegiatan RKPD')
            ->setKeywords('pdf php')
            ->setCategory('KEMAJUAN DAK');
        $sheet = $spreadsheet->getActiveSheet();
        //$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(6)->setRowHeight(30);
        $sheet->getRowDimension(5)->setRowHeight(30);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(14);

        //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $profile = ProfileDaerah::first();
        // Header Tex
        $sumber_dana_selected = 'DAK FISIK & NON FISIK';
        $sheet->setCellValue('A1', 'CAPAIAN KINERJA DAN ANGGARAN PROGRAM/KEGIATAN RKPD');
        $sheet->setCellValue('A2', 'PEMERINTAH DAERAH KABUPATEN ' . strtoupper(optional($profile)->nama_daerah). ' TAHUN ' . $tahun);
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A3:G3');

        // $sheet->getStyle('A1')->getFont()->setSize(12);

                $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
                $sheet->getColumnDimension('A')->setWidth(10);
                $sheet->setCellValue('B5', 'UNIT KERJA (PERANGKAT DAERAH)')->mergeCells('B5:B6');
                $sheet->getColumnDimension('B')->setWidth(50);
                $sheet->setCellValue('C5', 'Capaian Kinerja')->mergeCells('C5:D5');
                        $sheet->setCellValue('C6', '%')->getColumnDimension('C')->setWidth(15);
                        $sheet->setCellValue('D6', 'Kategori')->getColumnDimension('D')->setWidth(15);
                $sheet->setCellValue('E5', 'Realisasi Anggaran')->mergeCells('E5:G5');
                $sheet->setCellValue('E6', 'Rp')->getColumnDimension('E')->setWidth(25);
                $sheet->setCellValue('F6', '%')->getColumnDimension('F')->setWidth(15);
                $sheet->setCellValue('G6', 'Kategori')->getColumnDimension('G')->setWidth(15);
                $sheet->getStyle('A5:G6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('C6E0B4');
                $cell = 7;
                
                foreach($data as $index =>$row){

                    $sheet->getRowDimension($cell)->setRowHeight(30);
                //    return $row;
                    $sheet->setCellValue('A' . $cell, $index + 1);
                    $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
                    $sheet->setCellValue('C' . $cell, pembulatanDuaDecimal($row->persenK));
                    // Cari Predikat Kinerja
                    if($row->persenK>90){
                        $PredikatK='ST';
                    }elseif($row->persenK>75){
                        $PredikatK='T';
                    }elseif($row->persenK>65){
                        $PredikatK='S';
                    }elseif($row->persenK>50){
                        $PredikatK='R';
                    }else{
                        $PredikatK='SR';
                    }
                    $sheet->setCellValue('D' . $cell, $PredikatK);
                    $sheet->setCellValue('E' . $cell, numberToCurrency($row->totalRp));
                    $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($row->persenRp));
                    
                    if($row->persenRp>90){
                        $PredikatRp='ST';
                    }elseif($row->persenRp>75){
                        $PredikatRp='T';
                    }elseif($row->persenRp>65){
                        $PredikatRp='S';
                    }elseif($row->persenRp>50){
                        $PredikatRp='R';
                    }else{
                        $PredikatRp='SR';
                    }
                    $sheet->setCellValue('G' . $cell, $PredikatRp);
                    $cell++;
                }

                $sheet->getStyle('A1:G' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A1:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('E7:E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                //$sheet->getStyle('E7:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');

                $border = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '0000000'],
                        ],
                    ],
                ];

                $sheet->getStyle('A5:G' . $cell)->applyFromArray($border);

                                    if ($tipe == 'excel') {
                                        $writer = new Xlsx($spreadsheet);
                                        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                                        header('Content-Disposition: attachment;filename="KEMAJUAN.xlsx"');
                                    } else {
                                        $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&H' . url()->current());
                                        $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B &RPage &P of &N');
                                        $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
                                        \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
                                        header('Content-Type: application/pdf');
                                        // header('Content-Disposition: attachment;filename="EVALUASI RENJA '.$dinas.'.pdf"');
                                        header('Cache-Control: max-age=0');
                                        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
                                    }
                                    $writer->save('php://output');
    }

}
