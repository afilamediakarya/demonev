<!-- Realisasi APBN SEMUA -->
<div class="table-responsive">
    <table class="table table-bordered" id="kt_datatable">
        <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">NAMA UNIT KERJA</th>
            <th rowspan="2">ANGGARAN (RP)</th>
            <th rowspan="2">JUMLAH KEGIATAN</th>
{{--            <th rowspan="2">SUMBER DANA</th>--}}
            <th rowspan="2">BOBOT</th>
            <th rowspan="2">REALISASI KEUANGAN (RP)</th>
            <th colspan="2">REALISASI (%)</th>
{{--            <th colspan="2">INDIKATOR KERJA KELUARAN (OUTPUT)</th>--}}
            <th colspan="2">PERSENTASE TERTIMBANG</th>
            <th rowspan="2">PPTK/PELAKASANA</th>
            <th rowspan="2">KET</th>
        </tr>
        <tr>
            <th>FISIK</th>
            <th>KEUANGAN</th>
{{--            <th>NARASI</th>--}}
{{--            <th>SATUAN</th>--}}
            <th>FISIK (%)</th>
            <th>KEUANGAN (%)</th>
        </tr>
        </thead>
        @php
            $total_bobot = 0;
            $total_fisik = 0;
            $total_keuangan = 0;
            $total_kegiatan = 0;
            $jumlah_kegiatan = 0;
            $total_tertimbang_fisik = 0;
            $total_tertimbang_keuangan = 0;
        @endphp
        @foreach ($data AS $index => $row)
            @php
                $jumlah_kegiatan++;
                $dpa_bobot = 0;
                $dpa_fisik = 0;
                $dpa_keuangan = 0;
                $jumlah_kegiatan_dpa = 0;
                $dpa_tertimbang_fisik = 0;
                $dpa_tertimbang_keuangan = 0;
                $dpa_total_pagu = 0;
                $dpa_realisasi_keuangan = 0;
            @endphp
            @foreach($row->Dpa As $dpa)
                @php
                    $dpa_fisik += $dpa->realisasi_fisik;
                    $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                    $dpa_total_pagu += $dpa->nilai_pagu_dpa;
                    $dpa_realisasi_keuangan += $dpa->realisasi_keuangan;
                    $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
                    $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
                    $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
                    $dpa_keuangan += $persentase_keuangan;
                    $dpa_tertimbang_fisik += $tertimbang_fisik;
                    $dpa_tertimbang_keuangan += $tertimbang_keuangan;
                    $jumlah_kegiatan_dpa++;
                    $dpa_bobot += $total_pagu_keseluruhan ? $bobot : 0;

                    $total_bobot += $total_pagu_keseluruhan ? $bobot : 0;
                    $total_tertimbang_fisik += $tertimbang_fisik;
                    $total_tertimbang_keuangan += $tertimbang_keuangan;
                @endphp
            @endforeach
        @php
        $dpa_total_fisik = $jumlah_kegiatan_dpa ? $dpa_fisik/$jumlah_kegiatan_dpa : 0;
        $dpa_total_keuangan = $jumlah_kegiatan_dpa ? $dpa_keuangan/$jumlah_kegiatan_dpa : 0;
        $total_fisik += $dpa_total_fisik;
        $total_keuangan += $dpa_total_keuangan;
        $total_kegiatan += $jumlah_kegiatan_dpa;
        @endphp
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->nama_unit_kerja}}</td>
                <td>{{numberToCurrency($dpa_total_pagu)}}</td>
                <td>{{numberToCurrency($jumlah_kegiatan_dpa)}}</td>
{{--                <td style="white-space: normal">{{$sumber_dana_selected}}</td>--}}
                <td>{{pembulatanDuaDecimal($dpa_bobot)}}</td>
                <td>{{numberToCurrency($dpa_realisasi_keuangan)}}</td>
                <td>{{pembulatanDuaDecimal($dpa_total_fisik)}}</td>
                <td>{{pembulatanDuaDecimal($dpa_total_keuangan)}}</td>
{{--                <td></td>--}}
{{--                <td></td>--}}
                <td>{{pembulatanDuaDecimal($dpa_tertimbang_fisik)}}</td>
                <td>{{pembulatanDuaDecimal($dpa_tertimbang_keuangan)}}</td>
                <td>{{$row->nama_kepala}}</td>
                <td>-</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td>Jumlah</td>
{{--            <td></td>--}}
            <td>{{numberToCurrency($total_pagu_keseluruhan)}}</td>
            <td>{{numberToCurrency($total_kegiatan)}}</td>
            <td>{{pembulatanDuaDecimal($total_bobot)}}</td>
            <td>{{numberToCurrency($total_realisasi_keuangan)}}</td>
            <td>{{pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0)}}</td>
            <td>{{pembulatanDuaDecimal($jumlah_kegiatan ? $total_keuangan/$jumlah_kegiatan : 0)}}</td>
{{--            <td></td>--}}
{{--            <td></td>--}}
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
