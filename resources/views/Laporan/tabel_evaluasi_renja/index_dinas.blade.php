<!-- Realisasi APBN Dinas -->
<style>
    .color-1 {
        background-color: lightblue;
    }
    .color-2 {
        background-color: lightgrey;
    }
</style>
<div class="table-responsive">
    <table class="table table-bordered" id="kt_datatable">
        <thead>
        <tr>
            <th rowspan="3" class="text-center" style="white-space:nowrap">NO</th>
            <th rowspan="3" class="text-center">Sasaran</th>
            <th rowspan="3" class="text-center">Kode</th>
            <th rowspan="3" class="text-center">Urusan/Bidang Urusan Pemerintah Daerah dan Program/Kegiatan</th>
            <th rowspan="3" class="text-center">Indikator Kinerja Program (outcome) / Kegiatan (output)</th>
             <th colspan="2" rowspan="2" class="text-center">Target Renstra OPD pada Tahun 2019 s/d 2023 (akhir periode Renstra OPD) </th>
            <th colspan="2" rowspan="2" class="text-center">Realisasi Capaian Kinerja Renstra OPD s/d Renja OPD Tahun lalu ({{$tahun_sebelum}}) </th>
            <th colspan="2" rowspan="2" class="text-center">Target Kinerja dan Anggaran Renja OPD Tahun berjalan yang dievaluasi ({{$tahun}})</th>
            {{-- @php
                if($triwulan==2){
                    $colspan_realisasi=4;
                }else{
                    $colspan_realisasi=8;

                }
            @endphp --}}
            <th colspan="8" class="text-center">Realisasi Kinerja Pada Triwulan</th>


            <th rowspan="2" colspan="2" class="text-center">Realisasi Capaian Kinerja dan Anggaran Renja OPD  yang Dievaluasi</th>
            <th rowspan="2" colspan="2" class="text-center">Realisasi kinerja dan Anggaran Renstra OPD s/d tahun {{$tahun}} (Ahkir Tahun pelaksanaan Renja OPD)</th>
            <th rowspan="2" colspan="2" class="text-center">Tingkat Capaian Kinerja dan Realisasi Anggaran Renstra OPD s/d tahun {{$tahun}} (%)</th>
            <th rowspan="3" class="text-center">Unit OPD penanggung jawab</th>
            <th rowspan="3" class="text-center">Ket</th>
        </tr>
        <tr>
            @for ($p=1;$p<=4;$p++)
            <th colspan="2" class="text-center">{{integerToRoman($p)}}</th>
            @endfor
        </tr>

        <tr>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            {{-- @for ($p=1;$p<=$triwulan;$p++) --}}
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            {{-- @endfor --}}
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
        </tr>
        </thead>
        @php
            $i=0;
            echo '<pre>';
            // var_dump();
            // var_dump($data);
            // print_r($data[0]->Urusan[0]);
            // echo $data[1]->Urusan[2]->BidangUrusan;
            echo '</pre>';
        // foreach($data as $dt){
        //     echo $dt->Urusan->count();
        // }
        @endphp
       <tbody>
            @foreach ( $data as $sasaran )
            @php
                
            @endphp
                <tr class="bg-primary">
                    <td>{{++$i}}</td>
                    <td>{{$sasaran->sasaran}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{pembulatanDuaDecimal($sasaran->TargetK).'%'}}</td>
                    <td>{{numberToCurrency($sasaran->TargetRp)}}</td>
                    
                    <td>{{pembulatanDuaDecimal($sasaran->RealisasiK).'%'}}</td>
                    <td>{{numberToCurrency($sasaran->RealisasiRp)}}</td>
                    
                    <td>{{pembulatanDuaDecimal($sasaran->TargetKinerjaK).'%'}}</td>
                    <td>{{numberToCurrency($sasaran->TargetKinerjaRp)}}</td>
                    @if ($triwulan==2)
                    @for ($p=1;$p<=$triwulan;$p++)
                    <td>{{pembulatanDuaDecimal($sasaran->RealisasiKinerjaK[$p]).'%'}}</td>
                    <td>{{numberToCurrency($sasaran->RealisasiKinerjaRp[$p])}}</td>
                    @endfor
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @else
                    @for ($p=1;$p<=$triwulan;$p++)
                    <td>{{pembulatanDuaDecimal($sasaran->RealisasiKinerjaK[$p]).'%'}}</td>
                    <td>{{numberToCurrency($sasaran->RealisasiKinerjaRp[$p])}}</td>
                    @endfor
                    @endif
                    
                    <td>{{pembulatanDuaDecimal($sasaran->K13).'%'}}</td>
                    <td>{{numberToCurrency($sasaran->Rp13)}}</td>
                    <td>{{pembulatanDuaDecimal($sasaran->K14).'%'}}</td>
                    <td>{{numberToCurrency($sasaran->Rp14)}}</td>
                    
                    <td>{{pembulatanDuaDecimal($sasaran->K15).'%'}}</td>
                    <td>{{pembulatanDuaDecimal($sasaran->Rp15).'%'}}</td>
                    <td>{{$sasaran->nama_unit_kerja}}</td>
                    <td></td>
                </tr>
                @php
                    $j=0;
                @endphp
                @foreach ( $sasaran->Urusan->sortBy('urusan') as $urusan )
                <tr style="background-color:#41c30c !important;">
                    <td></td>
                    <td>
                    </td>
                    <td>{{$urusan->kode_urusan}}</td>
                    <td>{{$urusan->nama_urusan}}</td>
                    <td></td>
                    <td>{{pembulatanDuaDecimal($urusan->TargetK).'%'}}</td>
                    <td>{{numberToCurrency($urusan->TargetRp)}}</td>
                    
                    <td>{{pembulatanDuaDecimal($urusan->RealisasiK).'%'}}</td>
                    <td>{{numberToCurrency($urusan->RealisasiRp)}}</td>
                    
                    <td>{{pembulatanDuaDecimal($urusan->TargetKinerjaK).'%'}}</td>
                    <td>{{numberToCurrency($urusan->TargetKinerjaRp)}}</td>
                    @if ($triwulan==2)
                    @for ($p=1;$p<=$triwulan;$p++)
                    <td>{{pembulatanDuaDecimal($urusan->RealisasiKinerjaK[$p]).'%'}}</td>
                    <td>{{numberToCurrency($urusan->RealisasiKinerjaRp[$p])}}</td>
                    @endfor
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    @else
                    @for ($p=1;$p<=$triwulan;$p++)
                    <td>{{pembulatanDuaDecimal($urusan->RealisasiKinerjaK[$p]).'%'}}</td>
                    <td>{{numberToCurrency($urusan->RealisasiKinerjaRp[$p])}}</td>
                    @endfor
                    @endif
                    
                    <td>{{pembulatanDuaDecimal($urusan->K13).'%'}}</td>
                    <td>{{numberToCurrency($urusan->Rp13)}}</td>
                    <td>{{pembulatanDuaDecimal($urusan->K14).'%'}}</td>
                    <td>{{numberToCurrency($urusan->Rp14)}}</td>
                    
                    <td>{{pembulatanDuaDecimal($urusan->K15).'%'}}</td>
                    <td>{{pembulatanDuaDecimal($urusan->Rp15).'%'}}</td>
                    <td>{{$sasaran->nama_unit_kerja}}</td>
                    <td></td>
                </tr>
                @php
                    $k=0;
                @endphp
                        @foreach ( $urusan->BidangUrusan->sortBy('kode_bidang_urusan') as $bidang_urusan )
                        
                        <tr class="" style="background-color: #efe93c !important">
                            <td></td>
                            <td>
                                
                            </td>
                            <td>{{$urusan->kode_urusan.'.'.$bidang_urusan->kode_bidang_urusan}}</td>
                            <td>{{$bidang_urusan->nama_bidang_urusan}}</td>
                            <td></td>
                            <td>{{pembulatanDuaDecimal($bidang_urusan->TargetK).'%'}}</td>
                            <td>{{numberToCurrency($bidang_urusan->TargetRp)}}</td>
                            
                            <td>{{pembulatanDuaDecimal($bidang_urusan->RealisasiK).'%'}}</td>
                            <td>{{numberToCurrency($bidang_urusan->RealisasiRp)}}</td>
                            
                            <td>{{pembulatanDuaDecimal($bidang_urusan->TargetKinerjaK).'%'}}</td>
                            <td>{{numberToCurrency($bidang_urusan->TargetKinerjaRp)}}</td>
                            @if ($triwulan==2)
                            @for ($p=1;$p<=$triwulan;$p++)
                            <td>{{pembulatanDuaDecimal($bidang_urusan->RealisasiKinerjaK[$p]).'%'}}</td>
                            <td>{{numberToCurrency($bidang_urusan->RealisasiKinerjaRp[$p])}}</td>
                            @endfor
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @else
                            @for ($p=1;$p<=$triwulan;$p++)
                            <td>{{pembulatanDuaDecimal($bidang_urusan->RealisasiKinerjaK[$p]).'%'}}</td>
                            <td>{{numberToCurrency($bidang_urusan->RealisasiKinerjaRp[$p])}}</td>
                            @endfor
                            @endif
                            
                            <td>{{pembulatanDuaDecimal($bidang_urusan->K13).'%'}}</td>
                            <td>{{numberToCurrency($bidang_urusan->Rp13)}}</td>
                            <td>{{pembulatanDuaDecimal($bidang_urusan->K14).'%'}}</td>
                            <td>{{numberToCurrency($bidang_urusan->Rp14)}}</td>
                            
                            <td>{{pembulatanDuaDecimal($bidang_urusan->K15).'%'}}</td>
                            <td>{{pembulatanDuaDecimal($bidang_urusan->Rp15).'%'}}</td>
                            <td>{{$sasaran->nama_unit_kerja}}</td>
                            <td></td>
                        </tr>
                            @if ($bidang_urusan->Program->count()>0)
                            @php
                            $l=0;
                                
                            @endphp
                            @foreach ( $bidang_urusan->Program->sortBy('kode_program') as $program )
                            @php
                            if ($urusan->kode_urusan == '00') {
                                        $non_urusan = true;
                                        $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                                        $kode_program = $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . '.' . $program->kode_program;
                                    } else {
                                        $kode_program = $urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . '.' . $program->kode_program;
                                    }
                            @endphp
 
                            <tr class="bg-success">
                                <td rowspan="{{$program->Outcome->count()+1}}">
 
                                </td>
                                <td rowspan="{{$program->Outcome->count()+1}}"></td>
                                <td rowspan="{{$program->Outcome->count()+1}}">{{$kode_program}}</td>
                                <td rowspan="{{$program->Outcome->count()+1}}">{{$program->nama_program}}</td>
                            </tr>
                                    @foreach ($program->Outcome as $dt )
                                        <tr class="bg-success">

                                        <td>
                                            <p>
                                                {{$dt->outcome}}</p>
                                        </td>
                                        <td>{{pembulatanDuaDecimal($dt->volume).''.$dt->satuan}}</td>
                                        <td>{{numberToCurrency($dt->PoTargetRp)}}</td>
                                        <td>{{pembulatanDuaDecimal($dt->PoRealisasiK).'%'}}</td>
                                        <td>{{numberToCurrency($dt->PoRealisasiRp)}}</td>
                                        
                                        <td>{{pembulatanDuaDecimal($dt->PoTargetKinerjaK).'%'}}</td>
                                        <td>{{numberToCurrency($dt->PoTargetKinerjaRp)}}</td>
                                        @if ($triwulan==2)
                                        @for ($p=1;$p<=$triwulan;$p++)
                                        <td>
                                            {{pembulatanDuaDecimal($dt->PoRealisasiKinerjaK[$p]).'%'}}
                                        </td>
                                        <td>{{numberToCurrency($dt->PoRealisasiKinerjaRp[$p])}}</td>
                                        @endfor
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        @else
                                        @for ($p=1;$p<=$triwulan;$p++)
                                        <td>{{pembulatanDuaDecimal($dt->PoRealisasiKinerjaK[$p]).'%'}}</td>
                                        <td>{{numberToCurrency($dt->PoRealisasiKinerjaRp[$p])}}</td>
                                        @endfor
                                        @endif
                                        
                                        <td>{{pembulatanDuaDecimal($dt->PoK13).'%'}}</td>
                                        <td>{{numberToCurrency($dt->PoRp13)}}</td>
                                        <td>{{pembulatanDuaDecimal($dt->PoK14).'%'}}</td>
                                        <td>{{numberToCurrency($dt->PoRp14)}}</td>
                                        
                                        <td>{{pembulatanDuaDecimal($dt->PoK15).'%'}}</td>
                                        <td>{{pembulatanDuaDecimal($dt->PoRp15).'%'}}</td>
                                        <td>{{$sasaran->nama_unit_kerja}}</td>
                                        <td></td>

                                        </tr>

                                    @endforeach
                                
                                
                                
                                    @if ($program->Kegiatan->count() >0)
                                    @php
                                        $m=0;
                                    @endphp
                                    @foreach ( $program->Kegiatan->sortBy('kode_kegiatan') as $kegiatan )
                                    @php
                                    if ($urusan->kode_urusan == '00') {
                                                $non_urusan = true;
                                                $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                                                $kode_kegiatan = $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . '.' . $program->kode_program.'.'.$kegiatan->kode_kegiatan;
                                    } else {
                                        $kode_kegiatan = $urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . '.' . $program->kode_program.'.'.$kegiatan->kode_kegiatan;
                                    }
                                    @endphp
                                    <tr class="bg-warning">
                                        <td></td>
                                        <td></td>
                                        <td>{{$kode_kegiatan}}</td>
                                        <td>{{$kegiatan->nama_kegiatan}}</td>
                                        <td>
                                            @php
                                                $volume='';
                                                $satuan='';
                                            @endphp
                                            @foreach ($kegiatan->Output as $dt )
                                                @php
                                                    $volume.=$dt->volume;
                                                    $satuan.=$dt->satuan;
                                                @endphp
                                                <p>{{$dt->output}}</p>
                                            @endforeach
                                        </td>
                                        <td>{{pembulatanDuaDecimal($volume).''.$satuan}}</td>
                                        <td>{{numberToCurrency($kegiatan->TargetRp)}}</td>
                                        
                                        <td>{{pembulatanDuaDecimal($kegiatan->RealisasiK).'%'}}</td>
                                        <td>{{numberToCurrency($kegiatan->RealisasiRp)}}</td>
                                        
                                        <td>{{pembulatanDuaDecimal($kegiatan->TargetKinerjaK).'%'}}</td>
                                        <td>{{numberToCurrency($kegiatan->TargetKinerjaRp)}}</td>
                                        @if ($triwulan==2)
                                        @for ($p=1;$p<=$triwulan;$p++)
                                        <td>{{pembulatanDuaDecimal($kegiatan->RealisasiKinerjaK[$p]).'%'}}</td>
                                        <td>{{numberToCurrency($kegiatan->RealisasiKinerjaRp[$p])}}</td>
                                        @endfor
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        @else
                                        @for ($p=1;$p<=$triwulan;$p++)
                                        <td>{{pembulatanDuaDecimal($kegiatan->RealisasiKinerjaK[$p]).'%'}}</td>
                                        <td>{{numberToCurrency($kegiatan->RealisasiKinerjaRp[$p])}}</td>
                                        @endfor
                                        @endif
                                        
                                        <td>{{pembulatanDuaDecimal($kegiatan->K13).'%'}}</td>
                                        <td>{{numberToCurrency($kegiatan->Rp13)}}</td>
                                        <td>{{pembulatanDuaDecimal($kegiatan->K14).'%'}}</td>
                                        <td>{{numberToCurrency($kegiatan->Rp14)}}</td>
                                        
                                        <td>{{pembulatanDuaDecimal($kegiatan->K15).'%'}}</td>
                                        <td>{{pembulatanDuaDecimal($kegiatan->Rp15).'%'}}</td>
                                        <td>{{$sasaran->nama_unit_kerja}}</td>
                                        <td></td>
                                    </tr>
                                            @php
                                                $n=0;
                                            @endphp
                                            @foreach ( $kegiatan->SubKegiatan->sortBy('kode_sub_kegiatan') as $sub_kegiatan )
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                @php
                                                    if ($sub_kegiatan->is_non_urusan) {
                                                        $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                                                        $kode_sub_kegiatan= $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . substr($sub_kegiatan->kode_sub_kegiatan, 4);
                                                    }else{
                                                        $kode_sub_kegiatan=$sub_kegiatan->kode_sub_kegiatan;
                                                    }
                                                @endphp 
                                                <td>{{$kode_sub_kegiatan}}</td>
                                                <td>{{$sub_kegiatan->nama_sub_kegiatan}}</td>
                                                <td>
                                                    @foreach ($sub_kegiatan->Indikator as $dt )
                                                        <p>{{$dt->indikator}} ({{$dt->satuan}})</p>
                                                    @endforeach
                                                </td>
                                                <td>{{$sub_kegiatan->total_volume}}</td>
                                                <td>{{numberToCurrency($sub_kegiatan->total_pagu_renstra)}}</td>
                                                @php
                                                    $realisasiK=$sub_kegiatan->RealisasiK;
                                                    $realisasiRp=$sub_kegiatan->RealisasiRp;
                                                @endphp
                                                    <td>{{$realisasiK}}</td>
                                                    <td>{{numberToCurrency($realisasiRp)}}</td>
                                                {{-- @if ($sub_kegiatan->Target->count()>0) --}}
                                                @php
                                                    $targetK=$sub_kegiatan->TargetK;
                                                    $targetRp=$sub_kegiatan->TargetRp;
                                                @endphp
                                                    <td>{{$targetK}}</td>
                                                    <td>{{numberToCurrency($targetRp)}}</td>
                                                {{-- @else
                                                @php
                                                    $targetK=0;
                                                    $targetRp=0;
                                                @endphp
                                                    <td></td>
                                                    <td></td>
                                                @endif --}}
                                                @if ($triwulan==2)
                                                @for ($p=1;$p<=$triwulan;$p++)
                                                <td>{{$sub_kegiatan->RealisasiKinerjaK[$p]}}</td>
                                                <td>{{numberToCurrency($sub_kegiatan->RealisasiKinerjaRp[$p])}}</td>
                                                @endfor
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                @else
                                                @for ($p=1;$p<=$triwulan;$p++)
                                                <td>{{$sub_kegiatan->RealisasiKinerjaK[$p]}}</td>
                                                <td>{{numberToCurrency($sub_kegiatan->RealisasiKinerjaRp[$p])}}</td>
                                                @endfor
                                                @endif

                                                @php
                                                    
                                                @endphp
                                                
                                                <td>{{numberToCurrency($sub_kegiatan->K13)}}</td>
                                                <td>{{numberToCurrency($sub_kegiatan->Rp13)}}</td>
                                                <td>{{numberToCurrency($sub_kegiatan->K14)}}</td>
                                                <td>{{numberToCurrency($sub_kegiatan->Rp14)}}</td>
                                                
                                                <td>{{pembulatanDuaDecimal($sub_kegiatan->K15).'%'}}</td>
                                                <td>{{pembulatanDuaDecimal($sub_kegiatan->Rp15).'%'}}</td>
                                                <td>{{$sasaran->nama_unit_kerja}}</td>
                                                <td></td>
                                            </tr>
                                                
                                            @endforeach
                                        
                                    @endforeach
                                    @endif
                                    
                            @endforeach
                            @endif
                        @endforeach
                        
                @endforeach
                
            @endforeach

       </tbody>

    </table>
</div>
<!-- End Realisasi APBN Dinas -->
