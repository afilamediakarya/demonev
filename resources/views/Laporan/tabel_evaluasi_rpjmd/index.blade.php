<!-- Realisasi APBN SEMUA -->
<div class="table-responsive">
    <table class="table table-bordered" id="kt_datatable">
        <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">NAMA UNIT KERJA</th>
            <th colspan="2">Capaian Kinerja</th>
            <th colspan="3">Realisasi Anggaran </th>
        </tr>
        <tr>
            <th>%</th>
            <th>Kategori</th>
            <th>Rp</th>
            <th>%</th>
            <th>Kategori</th>
        </tr>
        </thead>
    
        <tbody>
            @foreach($data as $key => $value)
            @php
                
                if($value->persenK>90){
                    $PredikatK='ST';
                }elseif($value->persenK>75){
                    $PredikatK='T';
                }elseif($value->persenK>65){
                    $PredikatK='S';
                }elseif($value->persenK>50){
                    $PredikatK='R';
                }else{
                    $PredikatK='SR';
                }

                if($value->persenRp>90){
                        $PredikatRp='ST';
                    }elseif($value->persenRp>75){
                        $PredikatRp='T';
                    }elseif($value->persenRp>65){
                        $PredikatRp='S';
                    }elseif($value->persenRp>50){
                        $PredikatRp='R';
                    }else{
                        $PredikatRp='SR';
                    }
            @endphp
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->nama_unit_kerja}}</td>
                    <td>{{pembulatanDuaDecimal($value->persenK)}}</td>
                    <td>{{$PredikatK}}</td>
                    <td>{{numberToCurrency($value->totpersenRp)}}</td>
                    <td>{{pembulatanDuaDecimal($value->persenRp)}}</td>
                    <td>{{$PredikatRp}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- End Realisasi APBN SEMUA -->
