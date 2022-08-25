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
            <th colspan="2" rowspan="2" class="text-center">Realisasi Capaian Kinerja Renstra OPD s/d Renja OPD Tahun lalu (2020) </th>
            <th colspan="2" rowspan="2" class="text-center">Target Kinerja dan Anggaran Renja OPD Tahun berjalan yang dievaluasi (2021)</th>
            <th colspan="8" class="text-center">Realisasi Kinerja Pada Triwulan</th>


            <th rowspan="2" colspan="2" class="text-center">Realisasi Capaian Kinerja dan Anggaran Renja OPD  yang Dievaluasi</th>
            <th rowspan="2" colspan="2" class="text-center">Realisasi kinerja dan Anggaran Renstra OPD s/d tahun 2020 (Ahkir Tahun pelaksanaan Renja OPD)</th>
            <th rowspan="2" colspan="2" class="text-center">Tingkat Capaian Kinerja dan Realisasi Anggaran Renstra OPD s/d tahun 2020 (%)</th>
            <th rowspan="3" class="text-center">Unit OPD penanggung jawab</th>
            <th rowspan="3" class="text-center">Ket</th>
        </tr>
        <tr>

            <th colspan="2" class="text-center">I</th>
            <th colspan="2" class="text-center">II</th>
            <th colspan="2" class="text-center">III</th>
            <th colspan="2" class="text-center">IV</th>
        </tr>

        <tr>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
            <th class="text-center">K</th>
            <th class="text-center">Rp</th>
        </tr>
        </thead>
        @php
            $i=1;
            echo '<pre>';
            // var_dump();
            // var_dump($data);
            // print_r($data[1]->Urusan[2]->BidangUrusan);
            // echo $data[1]->Urusan[2]->BidangUrusan;
            echo '</pre>';
        // foreach($data as $dt){
        //     echo $dt->Urusan->count();
        // }
        @endphp
       <tbody>
            @php
                $sasarans=DB::table('sasaran')->get();
            @endphp
            @foreach ( $sasarans as $sasaran )
                <tr class="bg-primary">
                    <td>{{$i++}}</td>
                    <td>{{$sasaran->sasaran}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @php
                    $urusans=DB::table('urusan')->get();
                @endphp
                @foreach ( $urusans as $urusan )
                <tr class="bg-info">
                    <td>{{$i++}}</td>
                    <td></td>
                    <td></td>
                    <td>{{$urusan->nama_urusan}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                        @php
                            $bidang_urusans=DB::table('bidang_urusan')->where('id_urusan',$urusan->id)->get();
                        @endphp
                        @foreach ( $bidang_urusans as $bidang_urusan )
                        <tr class="bg-dark">
                            <td>{{$i++}}</td>
                            <td></td>
                            <td></td>
                            <td>{{$bidang_urusan->nama_bidang_urusan}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                            @php
                                $programs=DB::table('renstra_program')
                                ->select('renstra_program.*','program.kode_program','program.nama_program')
                                ->join('program','program.id','=','renstra_program.id_program')->where('renstra_program.id_tujuan',$sasaran->id_tujuan);
                            @endphp
                            @if ($programs->count()>0)
                            @foreach ( $programs->get() as $program )
                            @php
                                $program_outcome=DB::table('renstra_program_outcome')->where('id_renstra_program',$program->id)
                            @endphp
                            <tr class="bg-success">
                                <td>{{$i++}}</td>
                                <td></td>
                                <td></td>
                                <td>{{$program->nama_program}}</td>
                                <td>
                                    @foreach ($program_outcome->get() as $dt )
                                        <p>{{$dt->outcome}} ({{$dt->volume.' '.$dt->satuan}})</p>
                                    @endforeach
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                                
                                    @php
                                    $kegiatans=DB::table('renstra_kegiatan')
                                    ->select('renstra_kegiatan.*','kegiatan.kode_kegiatan','kegiatan.nama_kegiatan')
                                    ->join('kegiatan','kegiatan.id','=','renstra_kegiatan.id_kegiatan')->where('renstra_kegiatan.id_program',$program->id_program);
                                    @endphp
                                    @if ($kegiatans->count() >0)
                                    @foreach ( $kegiatans->get() as $kegiatan )
                                    @php
                                        $sub_kegiatans=DB::table('renstra_sub_kegiatan')->selectRaw("total_volume,total_pagu_renstra")
                                        ->where('id_kegiatan',$kegiatan->id_kegiatan);
                                        $sub_kegiatans_count=$sub_kegiatans->count();
                                        $total_volume=($sub_kegiatans->sum('total_volume'))/$sub_kegiatans_count;
                                        $total_pagu_renstra=($sub_kegiatans->sum('total_pagu_renstra'))/$sub_kegiatans_count;
                                        $kegiatan_output=DB::table('renstra_kegiatan_output')->where('id_renstra_kegiatan',$kegiatan->id)
                                    @endphp
                                    <tr class="bg-warning">
                                        <td>{{$i++}}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$kegiatan->nama_kegiatan}}</td>
                                        <td>
                                            @foreach ($kegiatan_output->get() as $dt )
                                                <p>{{$dt->output}} ({{$dt->volume.' '.$dt->satuan}})</p>
                                            @endforeach
                                        </td>
                                        <td>{{pembulatanDuaDecimal($total_volume)}}</td>
                                        <td>{{'Rp.'.numberToCurrency($total_pagu_renstra)}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                            @php
                                            $sub_kegiatans=DB::table('renstra_sub_kegiatan')
                                            ->select('renstra_sub_kegiatan.*','sub_kegiatan.kode_sub_kegiatan','sub_kegiatan.nama_sub_kegiatan')
                                            ->join('sub_kegiatan','sub_kegiatan.id','=','renstra_sub_kegiatan.id_sub_kegiatan')->where('renstra_sub_kegiatan.id_kegiatan',$kegiatan->id_kegiatan)->get();
                                            @endphp
                                            @foreach ( $sub_kegiatans as $sub_kegiatan )
                                            @php
                                                $sub_kegiatan_indikator=DB::table('renstra_sub_kegiatan_indikator')->where('id_renstra_sub_kegiatan',$sub_kegiatan->id);
                                               
                                            @endphp
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td></td>
                                                <td></td>
                                                <td>{{$sub_kegiatan->nama_sub_kegiatan}}</td>
                                                <td>
                                                    @foreach ($sub_kegiatan_indikator->get() as $dt )
                                                        <p>{{$dt->indikator}} ({{$dt->volume.' '.$dt->satuan}})</p>
                                                    @endforeach
                                                </td>
                                                <td>{{$sub_kegiatan->total_volume}}</td>
                                                <td>{{'Rp.'.numberToCurrency($sub_kegiatan->total_pagu_renstra)}}</td>
                                                @php
                                                     $realiasasi_sub_kegiatan=DB::table('renstra_realisasi_sub_kegiatan')->whereRaw("id_renstra_sub_kegiatan='$sub_kegiatan->id' AND tahun='2020'");
                                                     $sub_kegiatan_target=DB::table('renstra_sub_kegiatan_target')->whereRaw("id_renstra_sub_kegiatan='$sub_kegiatan->id' AND tahun='2021'");
                                                @endphp
                                                @if ($realiasasi_sub_kegiatan->count()>0)
                                                    <td>{{$realiasasi_sub_kegiatan->first()->volume.'%'}}</td>
                                                    <td>{{'Rp.'.numberToCurrency($realiasasi_sub_kegiatan->first()->realisasi_keuangan)}}</td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                                @if ($sub_kegiatan_target->count()>0)
                                                    <td>{{$sub_kegiatan_target->first()->volume.'%'}}</td>
                                                    <td>{{'Rp.'.numberToCurrency($sub_kegiatan_target->first()->pagu)}}</td>
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
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
