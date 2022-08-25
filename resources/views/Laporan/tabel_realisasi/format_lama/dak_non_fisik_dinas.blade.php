<!-- Realisasi DAK FISIK Dinas -->
<div class="table-responsive">
    <table class="table table-bordered" id="kt_datatable">
        <thead>
        <tr>
            <th rowspan="3">NO</th>
            <th rowspan="3">SUB KEGIATAN</th>
            <th colspan="6">PERENCANAAN KEGIATAN</th>
            <th rowspan="2" colspan="2">PELAKSANAAN KEGIATAN</th>
            <th rowspan="2" colspan="2">REALISASI</th>
            <th rowspan="2" colspan="2">KESESUAIAN SASARAN DAN LOKASI DENGAN RKPD</th>
            <th rowspan="2" colspan="2">KESESUAIAN ANTARA DPA SKPD DENGAN PETUNJUK
                TEKNIS DAK
            </th>
            <th rowspan="3">KODEFIKASI MASALAH</th>
        </tr>
        <tr>
            <th rowspan="2">SATUAN</th>
            <th rowspan="2">VOLUME</th>
            <th rowspan="2">JUMLAH PENERIMA MANFAAT</th>
            <th colspan="3">JUMLAH</th>
        </tr>

        <tr>
            <th>JUMLAH</th>
            <th>NON PENDAMPINGAN</th>
            <th>TOTAL BIAYA</th>
            <th>SWAKELOLA</th>
            <th>KONTRAK</th>
            <th>FISIK</th>
            <th>KEUANGAN</th>
            <th>YA</th>
            <th>TIDAK</th>
            <th>YA</th>
            <th>TIDAK</th>
        </tr>
        </thead>
        @foreach ($data->Dpa AS $dpa)
            <tr>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">{{$loop->iteration}}</td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"
                    style="white-space: normal">{{$dpa->SubKegiatan->nama_sub_kegiatan}}
                </td>
                <td>{{$dpa->TolakUkur[0]->tolak_ukur}}</td>
                <td>{{$dpa->TolakUkur[0]->volume}} {{$dpa->TolakUkur[0]->satuan}}</td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"></td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">{{numberToCurrency($dpa->nilai_pagu_dpa)}}</td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"></td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">{{numberToCurrency($dpa->nilai_pagu_dpa)}}</td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">{{numberToCurrency($dpa->swakelola)}}</td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">{{numberToCurrency($dpa->kontrak)}}</td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">{{pembulatanDuaDecimal($dpa->tertimbang_fisik)}}</td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}">{{pembulatanDuaDecimal($dpa->tertimbang_keuangan)}}</td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"></td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"></td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"></td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"></td>
                <td rowspan="{{$dpa->jumlah_tolak_ukur}}"></td>
            </tr>
            @for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++)
                <tr>
                    <td>{{$dpa->TolakUkur[$i]->tolak_ukur}}</td>
                    <td>{{$dpa->TolakUkur[$i]->volume}} {{$dpa->TolakUkur[$i]->satuan}}</td>
                </tr>
            @endfor
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{numberToCurrency($data->total_dak)}}</td>
            <td></td>
            <td>{{numberToCurrency($data->total_dak)}}</td>
            <td>{{numberToCurrency($data->swakelola)}}</td>
            <td>{{numberToCurrency($data->kontrak)}}</td>
            <td>{{pembulatanDuaDecimal($data->realisasi_fisik)}}</td>
            <td>{{pembulatanDuaDecimal($data->persentase_realisasi_keuangan)}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
<!-- End Realisasi DAK FISIK Dinas -->
