@foreach ( $data as $unit_kerja )
@php
    if($unit_kerja->subCount<=0){
        continue;
    }
@endphp
<tr class="bg-warning">
    <td colspan="9">{{$unit_kerja->nama_unit_kerja}}</td>
</tr>

@foreach ($unit_kerja->Dpa as $dpa )
@php
    $i=0;
if($dpa->Paket->count()<=0){
    continue;
}
@endphp
<tr class="bg-primary">
    <td>{{++$i}}</td>
    <td>{{$dpa->nama_sub_kegiatan}}</td>
    {{-- <td>{{numberToCurrency($dpa->nilai_pagu_dpa)}}</td> --}}
    <td>{{numberToCurrency($dpa->Pagu)}}</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
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



$unit_kerja_selected = $metode_pelaksanaan_selected = $jenis_belanja_selected = $tabel = '';
        $sumber_dana = SumberDana::get();
        $unit_kerja = UnitKerja::where(function ($q) {
            if (hasRole('opd'))
                $q->where('id', auth()->user()->id_unit_kerja);
        })->get();
        $jenis_belanja = JenisBelanja::get();
        $kecamatan = Kecamatan::get();
        $desa = Desa::orderBy('nama','ASC')->get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $sumber_dana_selected = request('sumber_dana', '');
        $kecamatan_selected = request('kecamatan', '');
        $desa_selected = request('desa', '');
        if (hasRole('admin')) {
            $unit_kerja_selected = request('unit_kerja', '');
        } else if (hasRole('opd')) {
            $unit_kerja_selected = auth()->user()->id_unit_kerja;
        }
        $periode_selected = request('periode', '');
        $jenis_belanja_selected = request('jenis_belanja', '');
        $metode_pelaksanaan_selected = request('metode_pelaksanaan', '');
        $tahun = session('tahun_penganggaran','');
        $data = array();
        $total_pagu_keseluruhan = 0;
        $total_realisasi_keuangan = 0;

        $where="";
        $where_paket="";
        $where_unit_kerja="";
        $desa_label = '';
        $kecamatan_label = '';
        if(!empty($unit_kerja_selected)){
            $where_unit_kerja.=" AND id='$unit_kerja_selected'";
        }
        if(!empty($sumber_dana_selected)){
            $where.=" AND sumber_dana_dpa.sumber_dana='$sumber_dana_selected'";
            // if ($sumber_dana_selected !== '-') {
            //     $where.=" AND sumber_dana_dpa.sumber_dana='$sumber_dana_selected'";  
            // }
        }
        if(!empty($desa_selected)){
            $where_paket.=" AND desa.id='$desa_selected'";
        //    $desa_label = Desa::select('nama')->where('id',$desa_selected)->first()['nama'];

        }
        if(!empty($kecamatan_selected)){
            // $kecamatan_label = Kecamatan::select('nama')->where('id',$kecamatan_selected)->first()['nama'];
            $where_paket.=" AND kecamatan.id='$kecamatan_selected'";
        }
        

        // return 'kecamatan : '.$kecamatan_label.' desa : '.$desa_label;

        if ($sumber_dana_selected !== '') {

            $data = DB::table('unit_kerja')->select('id','nama_unit_kerja')->whereRaw("id<>'' $where_unit_kerja")->get();
        foreach($data as $unit_kerja_list){
            $unit_kerja_list->Dpa=DB::table('dpa')
            ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
            ->join('pegawai_penanggung_jawab', 'dpa.id_pegawai_penanggung_jawab', '=', 'pegawai_penanggung_jawab.id')
            ->select('dpa.id','dpa.nilai_pagu_dpa','sub_kegiatan.nama_sub_kegiatan','sub_kegiatan.kode_sub_kegiatan','pegawai_penanggung_jawab.nama_lengkap as ppk')
            ->where('dpa.tahun',$tahun)
            ->where('dpa.id_unit_kerja',$unit_kerja_list->id)
            ->get();


            foreach ( $unit_kerja_list->Dpa as $dpa ){
                
                $dpa->Paket1=DB::table('paket_dau')
                ->selectRaw("paket_dau.id,paket_dau.satuan,paket_dau.id_sumber_dana_dpa,paket_dau.nama_paket,paket_dau.volume,paket_dau.pagu,paket_dau.keterangan,@jenis_paket:='dau' as jenis_paket,sumber_dana_dpa.sumber_dana")
                ->join('sumber_dana_dpa','sumber_dana_dpa.id','=','paket_dau.id_sumber_dana_dpa')
                ->whereRaw("paket_dau.id_dpa='$dpa->id' $where");

                $dpa->Paket=DB::table('paket_dak')
                ->selectRaw("paket_dak.id,paket_dak.satuan,paket_dak.id_sumber_dana_dpa,paket_dak.nama_paket,paket_dak.volume,paket_dak.anggaran_dak as pagu,@keterangan:='' as keterangan,@jenis_paket:='dak' as jenis_paket,sumber_dana_dpa.sumber_dana")
                ->join('sumber_dana_dpa','sumber_dana_dpa.id','=','paket_dak.id_sumber_dana_dpa')
                ->whereRaw("paket_dak.id_dpa='$dpa->id' $where")
                ->union($dpa->Paket1)->get();

                
                foreach($dpa->Paket as $paket){
                    if($paket->jenis_paket=='dau'){
                        $paket->Lokasi=DB::table('paket_dau_lokasi')
                        ->join('desa','paket_dau_lokasi.id_desa','=','desa.id')
                        ->join('kecamatan','desa.id_kecamatan','=','kecamatan.id')
                        ->select('desa.nama as nama_desa','kecamatan.nama as nama_kecamatan')
                        ->whereRaw("id_paket_dau='$paket->id' $where_paket")
                        ->get();
                    }else{
                        $paket->Lokasi=DB::table('paket_dak_lokasi')
                        ->join('desa','paket_dak_lokasi.id_desa','=','desa.id')
                        ->join('kecamatan','desa.id_kecamatan','=','kecamatan.id')
                        ->select('desa.nama as nama_desa','kecamatan.nama as nama_kecamatan')
                        ->whereRaw("id_paket_dak='$paket->id' $where_paket")
                        ->get();
                    }
                    $paket->Desa='';
                    $paket->Kecamatan='';
                    foreach($paket->Lokasi as $lokasi){
                        $paket->Desa.=$lokasi->nama_desa.'/';
                        $paket->Kecamatan=$lokasi->nama_kecamatan;

                    }
                }
                
            }

        }
            

        foreach ( $data as $unit_kerja_list ){

            $unit_kerja_list->subCount=0;
            foreach ( $unit_kerja_list->Dpa as $dpa ){
                $dpa->Pagu=0;
            
                foreach($dpa->Paket as $paket){
                    if($paket->Desa=='' || $paket->Kecamatan==''){
                        $dpa->Pagu-=$paket->pagu;
                        $unit_kerja_list->subCount-=1;
                    }else{
                        $unit_kerja_list->subCount+=1;
                    }
                    $dpa->Pagu+=$paket->pagu;
                }
            }
            
        }

        }