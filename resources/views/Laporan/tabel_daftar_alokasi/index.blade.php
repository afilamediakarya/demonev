<!-- Realisasi APBN SEMUA -->

<div class="table-responsive">
    <table class="table table-bordered" id="kt_datatable">
        <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">URAIAN KEGIATAN</th>
            <th rowspan="2">PAGU</th>
            <th colspan="2">LOKASI</th>

            <th rowspan="2">VOLUME</th>
            <th rowspan="2">PPK/PPTK</th>
            <th rowspan="2">SUMBER DANA</th>


            <th rowspan="2">KET</th>
        </tr>
        <tr>

            <th>DESA/KEL</th>
            <th>KECAMATAN</th>

        </tr>
        </thead>
        @php
            $total_bobot = 0;
            $total_kegiatan = 0;
            $jumlah_kegiatan = 0;
            $total_tertimbang_fisik = 0;
            $total_tertimbang_keuangan = 0;
            $total_dak_keseluruhan=0;
            $total_pendampingan_keseluruhan=0;
            $total_swakelola_keseluruhan=0;
            $total_kontrak_keseluruhan=0;
            $total_fisik_keseluruhan=0;
            $total_keuangan_keseluruhan=0;
            $total_keuangan_persen=0;
            $total_tertimbang_keu=0;
            $total_tertimbang_fis=0;
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

                $total_dak[$index]=0;
                $total_pendampingan[$index]=0;
                $total_swakelola[$index]=0;
                $total_kontrak[$index]=0;
                $total_fisik[$index]=0;
                $total_keuangan[$index]=0;
            @endphp
            @foreach($row->Dpa As $dpa)
                @php

                @endphp

                @foreach($dpa->SumberDanaDpa AS $sumber_dana)
                    @foreach($sumber_dana->PaketDak AS $paket_dak)
                        @php
                            $total_dak[$index]+=$paket_dak->anggaran_dak;
                            $total_pendampingan[$index]+=$paket_dak->pendampingan;
                            $total_swakelola[$index]+=$paket_dak->swakelola;
                            $total_kontrak[$index]+=$paket_dak->kontrak;

                            $realisasi=$paket_dak->RealisasiDak->where('periode','<=',$periode_selected);
                            $fisik=$realisasi->sum('realisasi_fisik');
                            $keuangan=$realisasi->sum('realisasi_keuangan');

                            $total_fisik[$index]+=$fisik;
                            $total_keuangan[$index]+=$keuangan;
                        @endphp
                    @endforeach
                @endforeach
            @endforeach
            @php
                $total_dak_keseluruhan+=$total_dak[$index];
                $total_pendampingan_keseluruhan+=$total_pendampingan[$index];
                $total_swakelola_keseluruhan+=$total_swakelola[$index];
                $total_kontrak_keseluruhan+=$total_kontrak[$index];
                $total_fisik_keseluruhan+=$total_fisik[$index];
                $total_keuangan_keseluruhan+=$total_keuangan[$index];
            @endphp
        @endforeach

        @foreach ($data AS $index => $row)
        @php
            $total_per_kegiatan_keseluruhan=($total_dak_keseluruhan+$total_pendampingan_keseluruhan);
            if(!$total_per_kegiatan_keseluruhan){$total_per_kegiatan_keseluruhan=1;}
            $total_per_kegiatan=($total_dak[$index]+$total_pendampingan[$index]);
            if(!$total_per_kegiatan){$total_per_kegiatan=0;}
            if($total_keuangan_keseluruhan==0){
                $total_keuangan_keseluruhan=1;
            }
            if($total_fisik_keseluruhan==0){
                $total_fisik_keseluruhan=1;
            }
            $bobot=($total_per_kegiatan/$total_per_kegiatan_keseluruhan)*100;
            $total_bobot+=$bobot;
            $keuangan_persen=($total_keuangan[$index]/$total_keuangan_keseluruhan)*100;
            $total_keuangan_persen+=$keuangan_persen;

            $tertimbang_keu=($total_keuangan[$index]/$total_per_kegiatan_keseluruhan)*100;
            $total_tertimbang_keu+=$tertimbang_keu;
            $tertimbang_fisik=($total_fisik[$index]/$total_fisik_keseluruhan)*100;
            $total_tertimbang_fis+=$tertimbang_fisik;
        @endphp
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->nama_unit_kerja}}</td>
                <td>{{numberToCurrency($total_dak[$index])}}</td>
{{--                <td>{{numberToCurrency($total_pendampingan[$index])}}</td>--}}
                <td>{{pembulatanDuaDecimal($bobot)}}</td>
                <td>{{numberToCurrency($total_swakelola[$index])}}</td>
                <td>{{numberToCurrency($total_kontrak[$index])}}</td>
                <td>{{numberToCurrency($total_keuangan[$index])}}</td>
                <td>{{numberToCurrency($total_fisik[$index])}}</td>
                <td>{{numberToCurrency($keuangan_persen)}}</td>
                <td>{{numberToCurrency($tertimbang_fisik)}}</td>
                <td>{{numberToCurrency($tertimbang_keu)}}</td>
                <td></td>
            </tr>
        @endforeach
        <!-- <tbody>

            </tbody> -->
    </table>
</div>
<!-- End Realisasi APBN SEMUA -->
