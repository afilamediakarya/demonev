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
        <thead class="text-center">
        <tr>
            <th rowspan="3" class="align-middle">KODE</th>
            <th rowspan="3" class="align-middle" style="white-space:nowrap">JENIS KEGIATAN</th>
            {{--            <th colspan="6" class="align-middle" class="text-center">PERENCANAAN KEGIATAN</th>--}}
            <th colspan="6" class="align-middle" class="text-center">PERENCANAAN KEGIATAN</th>
            <th rowspan="2" colspan="2" class="align-middle">PELAKSANAAN KEGIATAN</th>
            <th rowspan="2" colspan="3" class="align-middle">REALISASAI</th>
            <th rowspan="2" colspan="2" class="align-middle">Kesesuaian Sasaran dan Lokasi dgn RKPD</th>
            <th rowspan="2" colspan="2" class="align-middle">Kesesuaian Antara DPA SKPD dgn Petunjuk Teknis DAK</th>
            <th rowspan="3" class="align-middle">Modifikasi Masalah</th>

        </tr>
        <tr>
            <th rowspan="2" class="align-middle">Kecamatan</th>
            <th rowspan="2" class="align-middle">Desa</th>
            <th rowspan="2" class="align-middle">Satuan</th>
            <th rowspan="2" class="align-middle">Volume</th>
            <th rowspan="2" class="align-middle">Jml Peneriman Manfaat</th>
            {{--            <th colspan="2" class="text-center">Jumlah</th>--}}
            <th colspan="" rowspan="2" class="text-center align-middle">Jumlah</th>
        </tr>
        <tr>
            {{--            <th>Jumlah</th>--}}
            {{--            <th>Non Pendamping</th>--}}
            {{--            <th>Total Biaya</th>--}}


            <th class="align-middle">Swakelola</th>
            <th class="align-middle">Kontrak</th>


            <th class="align-middle">Fisik (%)</th>
            <th class="align-middle">Keuangan (%)</th>
            <th class="align-middle">Keuangan (Rp)</th>

            <th class="align-middle">Ya</th>
            <th class="align-middle">Tidak</th>
            <th class="align-middle">Ya</th>
            <th class="align-middle">Tidak</th>

        </tr>
        </thead>
        @php
            $total_bobot = 0;
            $total_fisik = 0;
            $total_keuangan = 0;
            $jumlah_kegiatan = 0;
            $total_tertimbang_fisik = 0;
            $total_tertimbang_keuangan = 0;
            $total_anggaran_dak=0;
            $total_pendampingan=0;
            $total_total_biaya=0;
            $tot_swakelola=0;

            $kp=0;
                                $tot_kontrak=0;
                                $tot_fisik=0;
                                $tot_fisik_keseluruhan=0;
                                $tot_keuangan=0;
                                $tot_penerima_manfaat=0;

                                $total_anggaran_dak=0;
                                $total_pendampingan=0;
                                $total_total_biaya=0;
                                $total_keuangan_persen=0;
            $no = 1;
        @endphp
        @foreach ($data AS $index => $row)
            @if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0)
                @foreach($row->Kegiatan AS $kegiatan)
                    @if ($kegiatan)
                        @foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa)
                            @foreach($dpa->SumberDanaDpa AS $sumber_dana)
                                @foreach($sumber_dana->PaketDak AS $paket_dak)
                                    @php
                                        $realisasi=$paket_dak->RealisasiDak->where('periode','<=',$periode_selected);
                                        $keuangan=$realisasi->sum('realisasi_keuangan');
                                        $tot_keuangan+=$keuangan;
                                    @endphp
                                @endforeach
                            @endforeach
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
        @foreach ($data AS $index => $row)
            @if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0)
                {{-- <tr>
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
                </tr> --}}
                <tr>
                    {{-- <td rowspan="{{($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur + $row->jumlah_sumber_dana + $row->jumlah_kegiatan: 1)}}">{{$no++}}</td> --}}
                    <td class="color-1">{{$row->kode_program_baru}}</td>
                    <td class="color-1">{{$row->nama_program}}</td>
                    <td class="color-1">{{$row->id_unit_kerja}}</td>
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
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                    <td class="color-1"></td>
                </tr>
                @foreach($row->Kegiatan AS $kegiatan)
                    @if ($kegiatan)
                        {{-- <tr class="color-2">
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
                        </tr> --}}
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
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @php
                            //$kp=1;
                        @endphp
                        @foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa)
                            @php
                                // $tot_swakelola=0;
                                // $tot_kontrak=0;
                                // $tot_fisik=0;
                                // $tot_keuangan=0;
                                // $tot_penerima_manfaat=0;

                                // $total_anggaran_dak=0;
                                // $total_pendampingan=0;
                                // $total_total_biaya=0;
                                //$kp=1;
                            @endphp
                            <tr>
                                <td><b>{{$dpa->SubKegiatan->kode_sub_kegiatan}}<b></td>
                                <td><b>{{$dpa->SubKegiatan->nama_sub_kegiatan}}<b></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                                <td class=""></td>
                            </tr>
                            @foreach($dpa->SumberDanaDpa AS $sumber_dana)
                                @foreach($sumber_dana->PaketDak AS $paket_dak)
                                    @php
                                        $jumlah_kegiatan++;
                                        $tot_swakelola+=$paket_dak->swakelola;
                                        $tot_kontrak+=$paket_dak->kontrak;
                                        $tot_penerima_manfaat+=$paket_dak->penerima_manfaat;

                                        $anggaran_dak=$paket_dak->anggaran_dak;
                                        $pendampingan=$paket_dak->pendampingan;
                                        $total_biaya=$anggaran_dak+$pendampingan;

                                        $total_anggaran_dak+=$anggaran_dak;
                                        $total_pendampingan+=$pendampingan;
                                        $total_total_biaya+=$total_biaya;
                                    @endphp
                                    <tr>
                                        <td>{{$dpa->SubKegiatan->kode_sub_kegiatan.'.'.sprintf("%02d", $kp++)}}</td>
                                        <td>{{$paket_dak->nama_paket}}</td>
                                        <td>{{$paket_dak->kecamatan}}</td>
                                        <td>{{$paket_dak->desa}}</td>
                                        <td>{{$paket_dak->satuan}}</td>
                                        <td>{{$paket_dak->volume}}</td>
                                        <td>{{$paket_dak->penerima_manfaat}}</td>
                                        <td>{{numberToCurrency($anggaran_dak)}}</td>
                                        {{--                                        <td>{{numberToCurrency($pendampingan)}}</td>--}}
                                        {{--                                        <td>{{numberToCurrency($total_biaya)}}</td>--}}
                                        <td>{{numberToCurrency($paket_dak->swakelola)}}</td>
                                        <td>{{numberToCurrency($paket_dak->kontrak)}}</td>
                                        @php
                                            $realisasi=$paket_dak->RealisasiDak->where('periode','<=',$periode_selected);
                                            $fisik=$realisasi->sum('realisasi_fisik');
                                            $keuangan=$realisasi->sum('realisasi_keuangan');
                                            $tot_fisik+=$fisik;
                                            //$tot_keuangan+=$keuangan;
                                            $real_data=$paket_dak->RealisasiDak->where('periode',$periode_selected);
                                            $kes_rkpd=$paket_dak->kesesuaian_rkpd;
                                            $kes_skpd=$paket_dak->kesesuaian_dpa_skpd;
                                            $permasalahan=$real_data->first()->permasalahan;
                                            echo '<td>'.pembulatanDuaDecimal($fisik).'</td>
                                            <td>'.pembulatanDuaDecimal($keu_persen = ($keuangan ? ($keuangan / $dpa->nilai_pagu_dpa * 100) : 0)).'</td>
                                            <td>'.numberToCurrency($keuangan).'</td>';
                                            if($kes_rkpd=='Y'){
                                                echo '<td><span>&#10003;</span></td><td></td>';
                                            }else{
                                                echo '<td></td><td><span>&#10003;</span></td>';
                                            }
                                            if($kes_skpd=='Y'){
                                                echo '<td><span>&#10003;</span></td><td></td>';
                                            }else{
                                                echo '<td></td><td><span>&#10003;</span></td>';
                                            }
                                            $total_keuangan_persen+=$keu_persen;

                                        @endphp

                                        <td>{{$permasalahan}}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    @endif
                @endforeach
            @endif
        @endforeach
        @php
            $tot_fisik_keseluruhan=pembulatanDuaDecimal($tot_fisik ? $tot_fisik/$jumlah_kegiatan : 0);
        @endphp
        <tr>
            <th></th>
            <th colspan="4">Jumlah</th>
            <th></th>
            <th>{{$tot_penerima_manfaat}}</th>
            <th>{{numberToCurrency($total_anggaran_dak)}}</th>
            {{--            <th>{{numberToCurrency($total_pendampingan)}}</th>--}}
            {{--            <th>{{numberToCurrency($total_total_biaya)}}</th>--}}
            <th>{{numberToCurrency($tot_swakelola)}}</th>
            <th>{{numberToCurrency($tot_kontrak)}}</th>
            <th>{{$tot_fisik_keseluruhan}}</th>
            <th>{{pembulatanDuaDecimal($total_keuangan_persen)}}</th>
            <th>{{numberToCurrency($tot_keuangan)}}</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>

        </tr>
    </table>
</div>
<!-- End Realisasi APBN Dinas -->
