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
            <th rowspan="2">KODE</th>
            <th rowspan="2" style="white-space:nowrap">SKPD, PROGRAM & KEGIATAN</th>
            <th rowspan="2">JUMLAH DANA / DPA (RP)</th>
            <th rowspan="2">BOBOT</th>
            <th rowspan="2">REALISASI KEUANGAN (RP)</th>
            <th colspan="2">REALISASI (%)</th>
            <th colspan="2">INDIKATOR KERJA KELUARAN (OUTPUT)</th>
            <th colspan="2">PERSENTASE TERTIMBANG</th>
            <th rowspan="2">PPTK/PELAKASANA</th>
            <th rowspan="2">KET</th>
        </tr>
        <tr>
            <th>FISIK</th>
            <th>KEUANGAN</th>
            <th>NARASI</th>
            <th>SATUAN</th>
            <th>FISIK (%)</th>
            <th>KEUANGAN (%)</th>
        </tr>
        </thead>
        @php
            $total_bobot = 0;
            $total_fisik = 0;
            $total_keuangan = 0;
            $jumlah_kegiatan = 0;
            $total_tertimbang_fisik = 0;
            $total_tertimbang_keuangan = 0;
            $no = 1;
            $jumlah_dana_skpd = [];
            $jumlah_dana_program = [];
            $bobot_skpd = [];
            $bobot_program = [];
            $realisasi_keuangan_skpd = [];
            $realisasi_keuangan_program = [];
            $realisasi_keuangan_persen_skpd = [];
            $realisasi_keuangan_persen_program = [];
            $realisasi_fisik_skpd = [];
            $realisasi_fisik_program = [];
            $jumlah_kegiatan_skpd = [];
            $jumlah_kegiatan_program = [];
            $tertimbang_fisik_skpd = [];
            $tertimbang_fisik_program = [];
            $tertimbang_keuangan_skpd = [];
            $tertimbang_keuangan_program = [];
            // print_r($data);
        @endphp
        @foreach ($data AS $index => $row)
            @php
                $jumlah_dana_skpd[$index] = 0;
                $bobot_skpd[$index] = 0;
                $realisasi_keuangan_skpd[$index] = 0;
                $realisasi_fisik_skpd[$index] = 0;
                $jumlah_kegiatan_skpd[$index] = 0;
                $realisasi_keuangan_persen_skpd[$index] = 0;
                $tertimbang_fisik_skpd[$index] = 0;
                $tertimbang_keuangan_skpd[$index] = 0;
            @endphp
            @if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0)
                @foreach($row->Kegiatan AS $index2 => $kegiatan)
                    @if ($kegiatan)
                        @php
                            $jumlah_dana_program[$index][$index2] = 0;
                            $bobot_program[$index][$index2] = 0;
                            $realisasi_keuangan_program[$index][$index2] = 0;
                            $realisasi_fisik_program[$index][$index2] = 0;
                            $jumlah_kegiatan_program[$index][$index2] = 0;
                            $realisasi_keuangan_persen_program[$index][$index2] = 0;
                            $tertimbang_fisik_program[$index][$index2] = 0;
                            $tertimbang_keuangan_program[$index][$index2] = 0;
                        @endphp
                        @foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa)
                            @php
                                $jumlah_kegiatan_skpd[$index]++;
                                $jumlah_kegiatan_program[$index][$index2]++;
                            @endphp
                            @php
                            $jumlah_dana_skpd[$index] += $dpa->nilai_pagu_dpa;
                            $jumlah_dana_program[$index][$index2] += $dpa->nilai_pagu_dpa;

                            $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;

                            $bobot_skpd[$index] += $bobot;
                            $bobot_program[$index][$index2] += $bobot;

                            $realisasi_keuangan_skpd[$index] += $dpa->realisasi_keuangan;
                            $realisasi_keuangan_program[$index][$index2] += $dpa->realisasi_keuangan;

                            $realisasi_fisik_skpd[$index] += $dpa->realisasi_fisik;
                            $realisasi_fisik_program[$index][$index2] += $dpa->realisasi_fisik;

                            $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
                            $realisasi_keuangan_persen_skpd[$index] += $persentase_keuangan;
                            $realisasi_keuangan_persen_program[$index][$index2] += $persentase_keuangan;

                            $rel_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
                            $tertimbang_fisik_skpd[$index] += $rel_fisik;
                            $tertimbang_fisik_program[$index][$index2] += $rel_fisik;

                            $rel_uanga = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
                            $tertimbang_keuangan_skpd[$index] += $rel_uanga;
                            $tertimbang_keuangan_program[$index][$index2] += $rel_uanga;
                            @endphp
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
        @foreach ($data AS $index => $row)
            @if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0)
                <tr>
                    {{-- <td rowspan="{{($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur + $row->jumlah_sumber_dana + $row->jumlah_kegiatan: 1)}}">{{$no++}}</td> --}}
                    <td class="color-1">{{$row->kode_program_baru}}</td>
                    <td class="color-1">{{$row->nama_program}}</td>
                    <td class="color-1">{{numberToCurrency($jumlah_dana_skpd[$index])}}</td>
                    <td class="color-1">{{pembulatanDuaDecimal($bobot_skpd[$index])}}</td>
                    <td class="color-1">{{numberToCurrency($realisasi_keuangan_skpd[$index])}}</td>
                    <td class="color-1">{{pembulatanDuaDecimal($realisasi_fisik_skpd[$index] ? $realisasi_fisik_skpd[$index]/$jumlah_kegiatan_skpd[$index] : 0)}}</td>
                    <td class="color-1">{{pembulatanDuaDecimal($realisasi_keuangan_persen_skpd[$index] ? $realisasi_keuangan_persen_skpd[$index] / $jumlah_kegiatan_skpd[$index] : 0)}}</td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                    <td class="color-1">{{pembulatanDuaDecimal($tertimbang_fisik_skpd[$index])}}</td>
                    <td class="color-1">{{pembulatanDuaDecimal($tertimbang_keuangan_skpd[$index])}}</td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                </tr>
                @foreach($row->Kegiatan AS $index2 => $kegiatan)
                    @if ($kegiatan)
                        <tr class="color-2">
                            <td>{{$kegiatan->kode_kegiatan_baru}}</td>
                            <td>{{$kegiatan->nama_kegiatan}}</td>
                            <td>{{numberToCurrency($jumlah_dana_program[$index][$index2])}}</td>
                            <td>{{pembulatanDuaDecimal($bobot_program[$index][$index2])}}</td>
                            <td>{{numberToCurrency($realisasi_keuangan_program[$index][$index2])}}</td>
                            <td>{{pembulatanDuaDecimal($realisasi_fisik_program[$index][$index2] ? $realisasi_fisik_program[$index][$index2] / $jumlah_kegiatan_program[$index][$index2] : 0)}}</td>
                            <td>{{pembulatanDuaDecimal($realisasi_keuangan_persen_program[$index][$index2] ? $realisasi_keuangan_persen_program[$index][$index2] / $jumlah_kegiatan_program[$index][$index2] : 0)}}</td>
                            <td></td>
                            <td></td>
                            <td>{{pembulatanDuaDecimal($tertimbang_fisik_program[$index][$index2])}}</td>
                            <td>{{pembulatanDuaDecimal($tertimbang_keuangan_program[$index][$index2])}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @php
                            // $q_sk=App\Models\Dpa::join('sub_kegiatan','sub_kegiatan.id','=','dpa.id_sub_kegiatan')->where('dpa.id_kegiatan',$kegiatan->id)->get();
                            // $q_sk=App\Models\Dpa::whereRaw("dpa.id_kegiatan='$kegiatan->id' AND dpa.id_unit_kerja='2'")->get();
                            // foreach($q_sk AS $dpa){
                            //     echo App\Models\SubKegiatan::where('id',$dpa->id_sub_kegiatan)->first()->kode_sub_kegiatan.'<br>';
                            // }
                            // print_r($kegiatan->Dpa);
                        @endphp
                        @foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa)
                            @php
                                $total_fisik += $dpa->realisasi_fisik;
                                $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                                $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
                                $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
                                $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
                                $total_keuangan += $persentase_keuangan;
                                $total_tertimbang_fisik += $tertimbang_fisik;
                                $total_tertimbang_keuangan += $tertimbang_keuangan;
                                $jumlah_kegiatan++;
                                $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            @endphp
                            <tr>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">{{$dpa->SubKegiatan->kode_sub_kegiatan}}</td>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">{{$dpa->SubKegiatan->nama_sub_kegiatan}}</td>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">
                                    <b>{{numberToCurrency($dpa->nilai_pagu_dpa)}}</b></td>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"><b>{{pembulatanDuaDecimal($bobot)}}</b></td>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">
                                    <b>{{numberToCurrency($dpa->realisasi_keuangan)}}</b></td>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"><b>{{pembulatanDuaDecimal($dpa->realisasi_fisik)}}
                                        {{--ini yg bermasalah--}}
                                    </b></td>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">
                                    <b>{{pembulatanDuaDecimal($persentase_keuangan)}}
                                        {{--ini yg bermasalah 2--}}
                                    </b></td>
                                <td>{{$dpa->TolakUkur[0]->tolak_ukur}}</td>
                                <td>{{$dpa->TolakUkur[0]->volume}} {{$dpa->TolakUkur[0]->satuan}}</td>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">{{pembulatanDuaDecimal($tertimbang_fisik)}}</td>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">{{pembulatanDuaDecimal($tertimbang_keuangan)}}</td>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">{{$dpa->PegawaiPenanggungJawab->nama_lengkap}}</td>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">-</td>
                            </tr>
                            @for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++)
                                <tr>
                                    <td>{{$dpa->TolakUkur[$i]->tolak_ukur}}</td>
                                    <td>{{$dpa->TolakUkur[$i]->volume}} {{$dpa->TolakUkur[$i]->satuan}}</td>
                                </tr>
                            @endfor
                            @foreach($dpa->SumberDanaDpa AS $sumber_dana)
                                <tr>
                                    <td></td>
                                    <td>{{$sumber_dana->jenis_belanja}}
                                        @if (request()->query('sumber_dana') == '')
                                        - {{$sumber_dana->sumber_dana}} - {{$sumber_dana->metode_pelaksanaan}}
                                        @endif
                                    </td>
                                    <td>{{numberToCurrency($sumber_dana->nilai_pagu)}}</td>
                                    <td>{{pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2)}}</td>
                                    <td>{{numberToCurrency($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}))}}</td>
                                    <td>{{pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}))}}</td>
                                    <td>{{pembulatanDuaDecimal($dpa->nilai_pagu_dpa ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $dpa->nilai_pagu_dpa * 100 : 0)}}</td>
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
        <tr>
            <td colspan="2">Jumlah</td>
            <td><b>{{numberToCurrency($total_pagu_keseluruhan)}}</b></td>
            <td><b>{{pembulatanDuaDecimal($total_bobot)}}</b></td>
            <td><b>{{numberToCurrency($total_realisasi_keuangan)}}</b></td>
            <td><b>{{pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0)}}</b></td>
            <td><b>{{pembulatanDuaDecimal($jumlah_kegiatan ? $total_keuangan/$jumlah_kegiatan : 0)}}</b></td>
            <td></td>
            <td></td>
            <td>{{pembulatanDuaDecimal($total_tertimbang_fisik)}}</td>
            <td>{{pembulatanDuaDecimal($total_tertimbang_keuangan)}}</td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
<!-- End Realisasi APBN Dinas -->
