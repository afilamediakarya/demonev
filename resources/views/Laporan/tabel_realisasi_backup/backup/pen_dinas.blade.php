<!-- Realisasi PEN Dinas -->
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
            <th rowspan="2">NO</th>
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
        @endphp
        @foreach ($data AS $index => $row)
            @if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0)
                <tr>
                    <td rowspan="{{($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur + $row->jumlah_sumber_dana + $row->jumlah_kegiatan: 1)}}">{{$no++}}</td>
                    <td class="color-1">{{$row->kode_program_baru}}</td>
                    <td class="color-1">{{$row->nama_program}}</td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                </tr>
                @foreach($row->Kegiatan AS $kegiatan)
                    @if ($kegiatan)
                        <tr class="color-2">
                            <td>{{$kegiatan->kode_kegiatan_baru}}</td>
                            <td>{{$kegiatan->nama_kegiatan}}</td>
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
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"><b>{{numberToCurrency($dpa->realisasi_keuangan)}}</b></td>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"><b>{{$dpa->realisasi_fisik}}</b></td>
                                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"><b>{{pembulatanDuaDecimal($persentase_keuangan)}}</b></td>
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
                                    <td>{{$sumber_dana->jenis_belanja}}</td>
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
            <td></td>
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
<!-- End Realisasi PEN Dinas -->
