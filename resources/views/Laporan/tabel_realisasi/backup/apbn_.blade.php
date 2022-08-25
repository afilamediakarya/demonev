<!-- Realisasi APBN SEMUA -->
<div class="table-responsive">
    <table class="table table-bordered" id="kt_datatable">
        <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">NAMA UNIT KERJA</th>
            <th rowspan="2">SUMBER DANA</th>
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
        @endphp
        @foreach ($data AS $index => $row)
            @php
                $total_fisik += $row->Dpa[0]->realisasi_fisik;
                    $bobot = $row->Dpa[0]->nilai_pagu_dpa/$total_pagu_keseluruhan*100;
                    $persentase_keuangan = $row->Dpa[0]->realisasi_keuangan/$row->Dpa[0]->nilai_pagu_dpa*100;
                    $tertimbang_fisik = $row->Dpa[0]->realisasi_fisik * $row->Dpa[0]->nilai_pagu_dpa/$total_pagu_keseluruhan;
                    $tertimbang_keuangan = $row->Dpa[0]->realisasi_keuangan/$total_pagu_keseluruhan*100;
                    $total_keuangan += $persentase_keuangan;
                    $total_tertimbang_fisik += $tertimbang_fisik;
                    $total_tertimbang_keuangan += $tertimbang_keuangan;
                    $total_bobot += $row->Dpa[0]->nilai_pagu_dpa/$total_pagu_keseluruhan*100;
                    $jumlah_kegiatan++;
            @endphp

            <tr>
                <td rowspan="{{$row->jumlah_tolak_ukur}}">1</td>
                <td rowspan="{{$row->jumlah_tolak_ukur}}">{{$row->nama_unit_kerja}}</td>
                <td rowspan="{{$row->jumlah_tolak_ukur}}" style="white-space: normal">{{$sumber_dana_selected}}</td>
                <td rowspan="{{$row->Dpa[0]->jumlah_tolak_ukur}}">{{numberToCurrency($row->Dpa[0]->nilai_pagu_dpa)}}</td>
                <td rowspan="{{$row->Dpa[0]->jumlah_tolak_ukur}}">{{pembulatanDuaDecimal($bobot)}}</td>
                <td rowspan="{{$row->Dpa[0]->jumlah_tolak_ukur}}">{{numberToCurrency($row->Dpa[0]->realisasi_keuangan)}}</td>
                <td rowspan="{{$row->Dpa[0]->jumlah_tolak_ukur}}">{{$row->Dpa[0]->realisasi_fisik}}</td>
                <td rowspan="{{$row->Dpa[0]->jumlah_tolak_ukur}}">{{pembulatanDuaDecimal($persentase_keuangan)}}</td>
                <td>{{$row->Dpa[0]->TolakUkur[0]->tolak_ukur}}</td>
                <td>{{$row->Dpa[0]->TolakUkur[0]->volume}} {{$row->Dpa[0]->TolakUkur[0]->satuan}}</td>
                <td rowspan="{{$row->Dpa[0]->jumlah_tolak_ukur}}">{{pembulatanDuaDecimal($tertimbang_fisik)}}</td>
                <td rowspan="{{$row->Dpa[0]->jumlah_tolak_ukur}}">{{pembulatanDuaDecimal($tertimbang_keuangan)}}</td>
                <td rowspan="{{$row->Dpa[0]->jumlah_tolak_ukur}}">{{$row->Dpa[0]->PegawaiPenanggungJawab->nama_lengkap}}</td>
                <td rowspan="{{$row->Dpa[0]->jumlah_tolak_ukur}}">-</td>
            </tr>
            @for($i = 1; $i < $row->Dpa[0]->jumlah_tolak_ukur; $i++)
                <tr>
                    <td>{{$row->Dpa[0]->TolakUkur[$i]->tolak_ukur}}</td>
                    <td>{{$row->Dpa[0]->TolakUkur[0]->volume}} {{$row->Dpa[0]->TolakUkur[$i]->satuan}}</td>
                </tr>
            @endfor
            @for($n = 1; $n < $row->Dpa->count(); $n++)
                @php
                    $total_fisik += $row->Dpa[$n]->realisasi_fisik;
                    $bobot = $row->Dpa[$n]->nilai_pagu_dpa/$total_pagu_keseluruhan*100;
                    $persentase_keuangan = $row->Dpa[$n]->realisasi_keuangan/$row->Dpa[$n]->nilai_pagu_dpa*100;
                    $tertimbang_fisik = $row->Dpa[$n]->realisasi_fisik * $row->Dpa[$n]->nilai_pagu_dpa/$total_pagu_keseluruhan;
                    $tertimbang_keuangan = $row->Dpa[$n]->realisasi_keuangan/$total_pagu_keseluruhan*100;
                    $total_keuangan += $persentase_keuangan;
                    $total_tertimbang_fisik += $tertimbang_fisik;
                    $total_tertimbang_keuangan += $tertimbang_keuangan;
                    $jumlah_kegiatan++;
                    $total_bobot += $row->Dpa[$n]->nilai_pagu_dpa/$total_pagu_keseluruhan*100;
                @endphp
                <tr>
                    <td rowspan="{{$row->Dpa[$n]->jumlah_tolak_ukur}}">{{numberToCurrency($row->Dpa[$n]->nilai_pagu_dpa)}}</td>
                    <td rowspan="{{$row->Dpa[$n]->jumlah_tolak_ukur}}">{{pembulatanDuaDecimal($bobot)}}</td>
                    <td rowspan="{{$row->Dpa[$n]->jumlah_tolak_ukur}}">{{numberToCurrency($row->Dpa[$n]->realisasi_keuangan)}}</td>
                    <td rowspan="{{$row->Dpa[$n]->jumlah_tolak_ukur}}">{{$row->Dpa[$n]->realisasi_fisik}}</td>
                    <td rowspan="{{$row->Dpa[$n]->jumlah_tolak_ukur}}">{{pembulatanDuaDecimal($persentase_keuangan)}}</td>
                    <td>{{$row->Dpa[$n]->TolakUkur[0]->tolak_ukur}}</td>
                    <td>{{$row->Dpa[$n]->TolakUkur[0]->volume}} {{$row->Dpa[$n]->TolakUkur[0]->satuan}}</td>
                    <td rowspan="{{$row->Dpa[$n]->jumlah_tolak_ukur}}">{{pembulatanDuaDecimal($tertimbang_fisik)}}</td>
                    <td rowspan="{{$row->Dpa[$n]->jumlah_tolak_ukur}}">{{pembulatanDuaDecimal($tertimbang_keuangan)}}</td>
                    <td rowspan="{{$row->Dpa[$n]->jumlah_tolak_ukur}}">{{$row->Dpa[$n]->PegawaiPenanggungJawab->nama_lengkap}}</td>
                    <td rowspan="{{$row->Dpa[$n]->jumlah_tolak_ukur}}">-</td>
                </tr>
                @for($i = 1; $i < $row->Dpa[$n]->jumlah_tolak_ukur; $i++)
                    <tr>
                        <td>{{$row->Dpa[$n]->TolakUkur[$i]->tolak_ukur}}</td>
                        <td>{{$row->Dpa[$n]->TolakUkur[$i]->volume}} {{$row->Dpa[$n]->TolakUkur[$i]->satuan}}</td>
                    </tr>
                @endfor
            @endfor
        @endforeach
        <tr>
            <td></td>
            <td>Jumlah</td>
            <td></td>
            <td>{{numberToCurrency($total_pagu_keseluruhan)}}</td>
            <td>{{$total_bobot}}</td>
            <td>{{numberToCurrency($total_realisasi_keuangan)}}</td>
            <td>{{pembulatanDuaDecimal($total_fisik/$jumlah_kegiatan)}}</td>
            <td>{{pembulatanDuaDecimal($total_keuangan/$jumlah_kegiatan)}}</td>
            <td></td>
            <td></td>
            <td>{{pembulatanDuaDecimal($total_tertimbang_fisik)}}</td>
            <td>{{pembulatanDuaDecimal($total_tertimbang_keuangan)}}</td>
            <td></td>
            <td></td>
        </tr>
        <!-- <tbody>

            </tbody> -->
    </table>
</div>
<!-- End Realisasi APBN SEMUA -->
