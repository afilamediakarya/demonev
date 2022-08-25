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
            <th rowspan="2" class="align-middle">NO</th>
            <th rowspan="2" class="align-middle">URAIAN KEGIATAN</th>
            <th rowspan="2" class="align-middle">PAGU</th>
            <th class="align-middle" colspan="2">LOKASI</th>
            <th rowspan="2" class="align-middle">VOLUME</th>
            <th rowspan="2" class="align-middle">PPK/PPTK</th>
            <th rowspan="2" class="align-middle">SUMBER DANA</th>
            <th rowspan="2" class="align-middle">KET</th>

        </tr>
        <tr>
            <th class="align-middle">DESA/KEL</th>
            <th class="align-middle">KECAMATAN</th>
        </tr>
        
        </thead>
        <tbody>

            @foreach($data as $res)
            <tr class="bg-warning">
                <td colspan="9">{{$res->nama_unit_kerja}}</td>
            </tr>

            @foreach ($res->Dpa as $dpa )
                @php
                    $i=0;
                  
                @endphp
                @if(count($dpa->Paket) !== 0)
                    @if($dpa->Pagu > 0)
                    <tr class="bg-primary">
                        <td>{{++$i}}</td>
                        <td>{{$dpa->nama_sub_kegiatan}}</td>
                        <td>{{numberToCurrency($dpa->Pagu)}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                @endif
                
                    @php
                        $j=0;
                    @endphp
                    @foreach ( $dpa->Paket as $paket )
                    @php
                    if($paket->Desa=='' || $paket->Kecamatan==''){
                        continue;
                    }
                    @endphp
                    <tr>
                        <td>{{$i.'.'.++$j}}</td>
                        <td>{{$paket->nama_paket}}</td>
                        <td>{{numberToCurrency($paket->pagu)}}</td>
                        @if (!empty($paket->Desa))
                        <td>{{ rtrim($paket->Desa, "/ ")}}</td>
                        <td>{{$paket->Kecamatan}}</td>
                        @else
                        <td></td>
                        <td></td>
                        @endif
                        <td>{{$paket->volume.' '.$paket->satuan}}</td>
                        <td>{{$dpa->ppk}}</td>
                        <td>{{$paket->sumber_dana}}</td>
                        <td>{{$paket->keterangan}}</td>
                    </tr>

                    @endforeach
                @endforeach

            @endforeach
          
            
           
            
        </tbody>
    </table>
</div>
<!-- End Realisasi APBN Dinas -->
