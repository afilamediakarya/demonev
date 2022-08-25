<!-- Realisasi DAK FISIK SEMUA -->
<div class="table-responsive">
    <table class="table table-bordered" id="kt_datatable">
        <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">NAMA UNIT KERJA</th>
            <th colspan="2">PERENCANAAN KEGIATAN</th>
            <th rowspan="2">BOBOT</th>
            <th colspan="2">PELAKSANAAN KEGIATAN</th>
            <th colspan="3">REALISASI</th>
            <th colspan="2">REALISASI TERRIMBANG</th>
            <th rowspan="2">KET</th>
        </tr>
        <tr>
            <th>DAK (RP)</th>
            <th>PENDAMPINGAN (RP)</th>
            <th>SWAKELOLA (RP)</th>
            <th>KONTRAK (RP)</th>
            <th>KEUANGAN (RP)</th>
            <th>FISIK (%)</th>
            <th>KEUANGAN (%)</th>
            <th>FISIK (%)</th>
            <th>KEUANGAN (%)</th>
        </tr>
        </thead>
        @php
            $total_bobot = 0;
            $total_swakelola = 0;
            $total_kontrak = 0;
            $total_realisasi_fisik = 0;
            $total_persentase_kuangan = 0;
            $total_tertimbang_fisik = 0;
            $total_tertimbang_keuangan = 0;
            $jumlah = 0;
        @endphp
        @foreach($data AS $row)
            @php
                $total_bobot += $row->bobot;
                $total_swakelola += $row->swakelola;
                $total_kontrak += $row->kontrak;
                $total_realisasi_fisik += $row->realisasi_fisik;
                $total_persentase_kuangan += $row->persentase_realisasi_keuangan;
                $total_tertimbang_fisik += $row->tertimbang_fisik;
                $total_tertimbang_keuangan += $row->tertimbang_keuangan;
                $jumlah++;
            @endphp
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->nama_unit_kerja}}</td>
                <td>{{numberToCurrency($row->dak)}}</td>
                <td></td>
                <td>{{pembulatanDuaDecimal($row->bobot)}}</td>
                <td>{{numberToCurrency($row->swakelola)}}</td>
                <td>{{numberToCurrency($row->kontrak)}}</td>
                <td>{{numberToCurrency($row->realisasi_keuangan)}}</td>
                <td>{{pembulatanDuaDecimal($row->realisasi_fisik)}}</td>
                <td>{{pembulatanDuaDecimal($row->persentase_realisasi_keuangan)}}</td>
                <td>{{pembulatanDuaDecimal($row->tertimbang_fisik)}}</td>
                <td>{{pembulatanDuaDecimal($row->tertimbang_keuangan)}}</td>
                <td></td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td>Jumlah</td>
            <td>{{numberToCurrency($total_pagu_keseluruhan)}}</td>
            <td></td>
            <td>{{pembulatanDuaDecimal($total_bobot)}}</td>
            <td>{{numberToCurrency($total_swakelola)}}</td>
            <td>{{numberToCurrency($total_kontrak)}}</td>
            <td>{{numberToCurrency($total_realisasi_keuangan)}}</td>
            <td>{{pembulatanDuaDecimal($jumlah ? $total_realisasi_fisik/$jumlah : 0)}}</td>
            <td>{{pembulatanDuaDecimal($jumlah ? $total_persentase_kuangan/$jumlah : 0)}}</td>
            <td>{{pembulatanDuaDecimal($total_tertimbang_fisik)}}</td>
            <td>{{pembulatanDuaDecimal($total_tertimbang_keuangan)}}</td>
            <td></td>
        </tr>
    </table>
</div>
<!-- End Realisasi DAK FISIK SEMUA -->
