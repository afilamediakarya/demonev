@extends('layout/app')

@section('title', 'Target')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Monitoring & Evaluasi</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{url('monitoring-dan-evaluasi/target')}}" class="">Evaluasi Realisasi </a>
        </li>
        <li class="breadcrumb-item">
            <a href="" class="">Evaluasi Pelaksanaan </a>
        </li>
    </ul>
@endsection
@section('style')
    <style type="text/css">
        .wrapper {
            padding-top: 65px !important;
        }

        .w-100 {
            width: 100%;
        }
    </style>
@endsection


@section('main_page')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->

        <!--end::Entry-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Card-->
                    <div class="card card-custom card-fit card-border">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Detail Kegiatan</h3>
                            </div>
                        </div>
                        <div class="card-body" style="padding-top:0">
                            <div class="form-group mb-8">
                                <div class="alert alert-custom alert-default" role="alert">
                                    <div class="row w-100">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <p class="font-size-sm">Urusan</p>
                                                <p class="font-size-md">{{$dpa->Program->BidangUrusan->Urusan->kode_urusan}}
                                                    - {{$dpa->Program->BidangUrusan->Urusan->nama_urusan}}</p>
                                            </div>
                                            <div class="form-group">
                                                <p class="font-size-sm">Bidang Urusan</p>
                                                <p class="font-size-md">{{$dpa->Program->BidangUrusan->kode_bidang_urusan}}
                                                    - {{$dpa->Program->BidangUrusan->nama_bidang_urusan}}</p>
                                            </div>
                                            <div class="form-group">
                                                <p class="font-size-sm">Program</p>
                                                <p class="font-size-md">{{$dpa->Program->kode_program}}
                                                    - {{$dpa->Program->nama_program}}</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <p class="font-size-sm">Kegiatan</p>
                                                <p class="font-size-md">{{$dpa->Kegiatan->kode_kegiatan}}
                                                    - {{$dpa->Kegiatan->nama_kegiatan}}</p>
                                            </div>
                                            <div class="form-group">
                                                <p class="font-size-sm">Sub Kegiatan</p>
                                                <p class="font-size-md">{{$dpa->SubKegiatan->kode_sub_kegiatan}}
                                                    - {{$dpa->SubKegiatan->nama_sub_kegiatan}}</p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div
                                                class="separator separator-solid separator-border-2 separator-success"></div>
                                        </div>
                                        <div class="col-4 mt-4">
                                            <div class="form-group">
                                                <p class="font-size-sm">Nilai Pagu</p>
                                                <p class="font-size-lg">Rp {{$dpa->nilai_pagu_rp}}</p>
                                            </div>
                                        </div>
                                        <div class="col-4 mt-4">
                                            <div class="form-group">
                                                <p class="font-size-sm">Indikator</p>
                                                @foreach($dpa->TolakUkur AS $tolak_ukur)
                                                    <p class="font-size-lg">{{$tolak_ukur->tolak_ukur}} : {{$tolak_ukur->volume}} ({{$tolak_ukur->satuan}})</p>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-4 mt-4">
                                            <div class="form-group">
                                                <p class="font-size-sm">Kinerja</p>
                                                    <p class="font-size-lg">{{$dpa->SubKegiatan->kinerja}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>PERIODE</th>
                                            <th class="hide">TARGET KEUANGAN (RP)</th>
                                            <th>REALISASI KEUANGAN (RP)</th>
                                            <th>REALISASI KEUANGAN (%)</th>
                                            <th class="hide">TARGET FISIK (%)</th>
                                            <th>REALISASI FISIK (%)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $total_target_keuangan = 0 @endphp
                                        @php $total_target_fisik = 0 @endphp
                                        @php $total_realisasi_keuangan_persen = 0 @endphp
                                        @php $total_realisasi_keuangan = 0 @endphp
                                        @php $total_realisasi_fisik = 0 @endphp
                                        @foreach ($dpa->Target AS $target)
                                                @php $total_realisasi_keuangan += optional($dpa->Realisasi->where('periode',$target->periode)->first())->realisasi_keuangan @endphp
                                        @endforeach
                                        @foreach ($dpa->Target AS $target)
                                            <tr>
                                                <td nowrap="nowrap" style="vertical-align:middle">
                                                    Triwulan {{$target->periode}}</td>
                                                <td class="hide">{{numberToCurrency($target->target_keuangan)}}</td>
                                                <td>{{numberToCurrency($rk = optional($dpa->Realisasi->where('periode',$target->periode)->first())->realisasi_keuangan)}}</td>
                                                <td>{{pembulatanDuaDecimal($rkp = ($rk ? $rk / $dpa->nilai_pagu_dpa * 100 : 0))}}</td>
                                                <td class="hide">{{pembulatanDuaDecimal($target->target_fisik)}}</td>
                                                <td>{{pembulatanDuaDecimal($rf = optional($dpa->Realisasi->where('periode',$target->periode)->first())->realisasi_fisik)}}</td>
                                                @php $total_target_keuangan += $target->target_keuangan @endphp
                                                @php $total_target_fisik += $target->target_fisik @endphp
                                                {{--@php $total_realisasi_keuangan += $rk @endphp--}}
                                                @php $total_realisasi_keuangan_persen += $rkp @endphp
                                                @php $total_realisasi_fisik += $rf @endphp
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td nowrap="nowrap" style="vertical-align:middle">Total</td>
                                            <td class="hide">{{numberToCurrency($total_target_keuangan)}}</td>
                                            <td>{{numberToCurrency($total_realisasi_keuangan)}}</td>
                                            <td>{{pembulatanDuaDecimal($total_realisasi_keuangan_persen)}}</td>
                                            <td class="hide">{{pembulatanDuaDecimal($total_target_fisik)}}</td>
                                            <td>{{pembulatanDuaDecimal($total_realisasi_fisik)}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12">
                                    <div class="card card-custom">
                                        <div class="card-header card-header-tabs-line">
                                            <div class="card-toolbar">
                                                <ul class="nav nav-tabs nav-light-success nav-tabs-line">
                                                    @foreach($dpa->Target AS $target)
                                                        <li class="nav-item">
                                                            <a class="nav-link {{$loop->index === 0 ? 'active' : ''}}"
                                                               data-toggle="tab"
                                                               href="#kt_tab_pane_{{$target->periode}}_4">
                                                                <span
                                                                    class="font-size-xs">TRIWULAN {{integerToRoman($target->periode)}}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <form id="realisasi-form"
                                              action="{{route('api.dpa.realisasi.update',[$dpa->uuid])}}" method="post">
                                            {{csrf_field()}}
                                            <div class="card-body px-2">
                                                <div class="tab-content">
                                                    @foreach($dpa->Target AS $index => $target)
                                                        <div
                                                            class="tab-pane fade show {{$loop->index === 0 ? 'active' : ''}}"
                                                            id="kt_tab_pane_{{$target->periode}}_4" role="tabpanel"
                                                            aria-labelledby="kt_tab_pane_{{$target->periode}}_4">
                                                            <div class="card card-custom">
                                                                <div class="card-body pt-5 px-2 py-0">
                                                                    @php $j = $jadwal_input->where('tahun',session('tahun_penganggaran'))->where('sub_tahapan','Realisasi Triwulan '.(integerToRoman($target->periode)))->first() @endphp
                                                                    <span class="label label-warning label-pill label-inline mr-2"> Jadwal Input : {{ $j ? optional($j->jadwal_mulai)->format('Y/m/d').' - '.optional($j->jadwal_selesai)->format('Y/m/d') : 'Belum Tersedia'}}</span>
                                                                        <hr>
                                                                    @foreach($dpa->SumberDanaDpa AS $i => $sumber_dana)
                                                                            @if ($index == 0)
                                                                                <input type="hidden"
                                                                                       name="total_dana[{{$sumber_dana->id}}]"
                                                                                       data-realisasi="{{$sumber_dana->id}}"
                                                                                       data-index="{{$i}}"
                                                                                       value="{{$sumber_dana->nilai_pagu}}">
                                                                            @endif
                                                                            <div class="row">
                                                                            <div class="form-group col-6">
                                                                                <label style="font-size:0.8rem">Sumber
                                                                                    Dana</label>
                                                                                <input
                                                                                    value="{{$sumber_dana->sumber_dana}}-{{$sumber_dana->jenis_belanja}}"
                                                                                    type="text" class="form-control"
                                                                                    placeholder="" readonly>
                                                                            </div>
                                                                            <div class="form-group col-6">
                                                                                <label style="font-size:0.8rem">Total
                                                                                    Pagu {{$sumber_dana->sumber_dana}}-{{$sumber_dana->jenis_belanja}} (Rp)</label>
                                                                                <input
                                                                                    value="{{$sumber_dana->nilai_pagu}}"
                                                                                    min="0"
                                                                                    type="number" class="form-control"
                                                                                    placeholder="" readonly>
                                                                            </div>
                                                                            
                                                                            
                                                                            
                                                                            <div class="form-group col-6">
                                                                                <label style="font-size:0.8rem">Realisasi
                                                                                    Fisik {{$sumber_dana->sumber_dana}}-{{$sumber_dana->jenis_belanja}} Triwulan {{integerToRoman($target->periode)}} (%) </label>
                                                                                <input
                                                                                    value="{{optional($dpa->DetailRealisasi->where('periode',$target->periode)->where('id_sumber_dana_dpa',$sumber_dana->id)->first())->realisasi_fisik}}"
                                                                                    name="realisasi_fisik[{{$target->periode}}][{{$sumber_dana->id}}]"
                                                                                    data-realisasi="{{$sumber_dana->id}}"
                                                                                    data-periode="{{$target->periode}}"
                                                                                    data-index="{{$i}}"
                                                                                    type="number"
                                                                                    min="0"
                                                                                    step="0.01"
                                                                                    class="form-control"
                                                                                    {{!$periode[$target->periode] ? 'disabled' : ''}}
                                                                                    placeholder="Realisasi Fisik Triwulan {{integerToRoman($target->periode)}}"
                                                                                    @if(strpos($sumber_dana->sumber_dana, 'DAK') !== false)
                                                                                    readonly
                                                                                    @elseif(strpos($sumber_dana->sumber_dana, 'APB') !== false || strpos($sumber_dana->sumber_dana, 'PEN') !== false)
                                                                                    @if($sumber_dana->jenis_belanja == 'Belanja Modal')
                                                                                    readonly
                                                                                    @endif
                                                                                    
                                                                                    @else
                                                                                    required
                                                                                    @endif
                                                                                     >
                                                                            </div>
                                                                            <div class="form-group col-6">
                                                                                <label style="font-size:0.8rem">Realisasi
                                                                                    Keuangan {{$sumber_dana->sumber_dana}}-{{$sumber_dana->jenis_belanja}} Triwulan  {{integerToRoman($target->periode)}} (Rp) </label>
                                                                                <input
                                                                                    value="{{optional($dpa->DetailRealisasi->where('periode',$target->periode)->where('id_sumber_dana_dpa',$sumber_dana->id)->first())->realisasi_keuangan}}"
                                                                                    name="realisasi_keuangan[{{$target->periode}}][{{$sumber_dana->id}}]"
                                                                                    data-realisasi="{{$sumber_dana->id}}"
                                                                                    data-periode="{{$target->periode}}"
                                                                                    data-index="{{$i}}"
                                                                                    type="number"
                                                                                    min="0"
                                                                                    class="form-control"
                                                                                    data-label="{{$sumber_dana->sumber_dana}}"
                                                                                    {{!$periode[$target->periode] ? 'disabled' : ''}}
                                                                                    placeholder="Realisasi Keuangan Triwulan {{integerToRoman($target->periode)}}"

                                                                                    @if(strpos($sumber_dana->sumber_dana, 'DAK') !== false)
                                                                                    readonly
                                                                                    @elseif(strpos($sumber_dana->sumber_dana, 'APB') !== false || strpos($sumber_dana->sumber_dana, 'PEN') !== false)
                                                                                    @if($sumber_dana->jenis_belanja == 'Belanja Modal')
                                                                                    readonly
                                                                                    @endif
                                                                                    
                                                                                    @else
                                                                                    required
                                                                                    @endif
                                                                                     >
                                                                            </div>

                                                                            <div class="form-group col-6">
                                                                                <label style="font-size:0.8rem">Realisasi
                                                                                    Fisik {{$sumber_dana->sumber_dana}}-{{$sumber_dana->jenis_belanja}} Sampai Triwulan  {{integerToRoman($target->periode)}} (%) </label>
                                                                                <input
                                                                                    value="{{optional($dpa->DetailRealisasi->where('periode','<=',$target->periode)->where('id_sumber_dana_dpa',$sumber_dana->id))->reduce(function ($total,$value){return $total + optional($value)->realisasi_fisik;})}}"
                                                                                    name="tot_fis"
                                                                                    data-realisasi="{{$sumber_dana->id}}"
                                                                                    data-periode="{{$target->periode}}"
                                                                                    data-index="{{$i}}"
                                                                                    type="number"
                                                                                    step="0.01"
                                                                                    min="0"
                                                                                    class="form-control"
                                                                                    placeholder="Realisasi Fisik Saat Ini"
                                                                                    readonly>
                                                                            </div>
                                                                            <div class="form-group col-6">
                                                                                <label style="font-size:0.8rem">
                                                                                    Realisasi Keuangan {{$sumber_dana->sumber_dana}}-{{$sumber_dana->jenis_belanja}} Sampai Triwulan  {{integerToRoman($target->periode)}} (Rp)  </label>
                                                                                <input
                                                                                    value="{{$dpa->DetailRealisasi->where('periode','<=',$target->periode)->where('id_sumber_dana_dpa',$sumber_dana->id)->reduce(function ($total,$value){return $total + optional($value)->realisasi_keuangan;})}}"
                                                                                    name="tot_res"
                                                                                    data-realisasi="{{$sumber_dana->id}}"
                                                                                    data-periode="{{$target->periode}}"
                                                                                    data-index="{{$i}}"
                                                                                    type="number"
                                                                                    min="0"
                                                                                    class="form-control"
                                                                                    placeholder="Realisasi Keuangan Saat Ini"
                                                                                    readonly>
                                                                            </div>
                                                                        </div>
                                                                            <hr>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="card card-custom  mt-5"
                                                                 style="background:#F7F7F7">
                                                                <div class="card-body pt-5 px-2 py-0">
                                                                    <div class="row">
                                                                        <div class="hide form-group col-12 col-lg-6 ">
                                                                            <label style="font-size:0.8rem">Target
                                                                                Keuangan (RP)</label>
                                                                            <input value="{{$target->target_keuangan}}"
                                                                                   name="target_keuangan"
                                                                                   type="number" class="form-control"
                                                                                   min="0"
                                                                                   data-periode="{{$target->periode}}"
                                                                                   placeholder="Target Keuangan"
                                                                                   readonly>
                                                                        </div>
                                                                        <div class="hide form-group col-6 col-lg-3">
                                                                            <label style="font-size:0.8rem">Target
                                                                                Keuangan (%)</label>
                                                                            <input value="{{$target->persentase}}"
                                                                                   type="number" class="form-control"
                                                                                   min="0"
                                                                                   step="0.01"
                                                                                   placeholder="Target Keuangan"
                                                                                   readonly>
                                                                        </div>
                                                                        <div class="hide form-group col-6 col-lg-3">
                                                                            <label style="font-size:0.8rem">Target Fisik
                                                                                (%)</label>
                                                                            <input value="{{$target->target_fisik}}"
                                                                                   type="number" class="form-control"
                                                                                   min="0"
                                                                                   step="0.01"
                                                                                   placeholder="Target Fisik" readonly>
                                                                        </div>
                                                                        <div class="form-group col-6 col-lg-3">
                                                                            <label style="font-size:0.8rem">
                                                                                Kinerja
                                                                                Triwulan {{integerToRoman($target->periode)}} ({{$tolak_ukur->satuan}})
                                                                                </label>
                                                                            <input type="number" class="form-control"
                                                                                   value="{{optional($dpa->Realisasi->where('periode',$target->periode)->first())->realisasi_kinerja}}"
                                                                                   name="realisasi_kinerja[{{$target->periode}}]"
                                                                                   data-periode="{{$target->periode}}"
                                                                                   step="0.01"
                                                                                   min="0"
                                                                                   {{!$periode[$target->periode] ? 'disabled' : ''}}
                                                                                   placeholder="Realisasi Kinerja"
                                                                                   required>
                                                                        </div>
                                                                        <div class="form-group col-6 col-lg-3">
                                                                            <label style="font-size:0.8rem">Realisasi
                                                                                Fisik
                                                                                Triwulan {{integerToRoman($target->periode)}}
                                                                                (%)</label>
                                                                            <input type="number" class="form-control"
                                                                                   value="{{pembulatanDuaDecimal(optional($dpa->Realisasi->where('periode',$target->periode)->first())->realisasi_fisik,2)}}"
                                                                                   name="realisasi_fisik_periode[{{$target->periode}}]"
                                                                                   data-periode="{{$target->periode}}"
                                                                                   step="0.01"
                                                                                   min="0"
                                                                                   {{!$periode[$target->periode] ? 'disabled' : ''}}
                                                                                   placeholder="Realisasi Fisik"
                                                                                   required readonly>
                                                                        </div>
                                                                        <div class="form-group col-12 col-lg-3 ">
                                                                            <label style="font-size:0.8rem">Realisasi
                                                                                Keuangan
                                                                                Triwulan {{integerToRoman($target->periode)}}
                                                                                (Rp)</label>
                                                                            <input
                                                                                value="{{optional($dpa->Realisasi->where('periode',$target->periode)->first())->realisasi_keuangan}}"
                                                                                name="realisasi_keuangan_periode[{{$target->periode}}]"
                                                                                data-periode="{{$target->periode}}"
                                                                                type="number" class="form-control"
                                                                                min="0"
                                                                                {{!$periode[$target->periode] ? 'disabled' : ''}}
                                                                                placeholder="Realisasi Keuangan"
                                                                                required readonly>
                                                                        </div>
                                                                        <div class="form-group col-6 col-lg-3">
                                                                            <label style="font-size:0.8rem">Realisasi
                                                                                Keuangan
                                                                                Triwulan {{integerToRoman($target->periode)}}
                                                                                (%)</label>
                                                                            <input  type="number" class="form-control"
                                                                                   value="{{pembulatanDuaDecimal(optional($dpa->Realisasi->where('periode',$target->periode)->first())->realisasi_keuangan && $dpa->nilai_pagu_dpa ? optional($dpa->Realisasi->where('periode',$target->periode)->first())->realisasi_keuangan / $dpa->nilai_pagu_dpa * 100 : 0,2)}}"
                                                                                   name="persentase_keuangan_periode[{{$target->periode}}]"
                                                                                   data-periode="{{$target->periode}}"
                                                                                   step="0.01"
                                                                                   min="0"
                                                                                   {{!$periode[$target->periode] ? 'disabled' : ''}}
                                                                                   placeholder="Persentase Realisasi Keuangan"
                                                                                   required readonly>
                                                                        </div>

                                                                        <div class="form-group col-6 col-lg-3">
                                                                            <label style="font-size:0.8rem">
                                                                                Kinerja Sampai Saat Ini ({{$tolak_ukur->satuan}})</label>
                                                                            <input type="number" class="form-control"
                                                                                   value="{{$dpa->Realisasi->sortByDesc('created_at')->where('periode','<=',$target->periode)->unique('periode')->reduce(function($total,$value){return $total + optional($value)->realisasi_kinerja;})}}"
                                                                                   name="kinerja_tot"
                                                                                   data-periode="{{$target->periode}}"
                                                                                   step="0.01"
                                                                                   min="0
                                                                                   placeholder="Realisasi Kinerja"
                                                                            required readonly>
                                                                        </div>
                                                                        <!-- <div class="form-group col-6 col-lg-2">
                                                                                @foreach($dpa->TolakUkur AS $tolak_ukur)
                                                                            <label style="font-size:0.8rem">Satuan</label>
                                                                            <input type="text" class="form-control" value="{{$tolak_ukur->satuan}}" readonly>
                                                                            @endforeach
                                                                        </div> -->
                                                                            
                                                                        
                                                                        <div class="form-group col-6 col-lg-3">
                                                                            <label style="font-size:0.8rem">Realisasi
                                                                                Fisik Sampai Saat Ini (%)</label>
                                                                            <input type="number" class="form-control"
                                                                                   value="{{pembulatanDuaDecimal($dpa->Realisasi->sortByDesc('created_at')->where('periode','<=',$target->periode)->unique('periode')->reduce(function($total,$value){return $total + optional($value)->realisasi_fisik;}),2)}}"
                                                                                   name="fis_tot"
                                                                                   data-periode="{{$target->periode}}"
                                                                                   step="0.01"
                                                                                   min="0
                                                                                   placeholder="Realisasi Fisik"
                                                                            required readonly>
                                                                        </div>
                                                                        <div class="form-group col-12 col-lg-3">
                                                                            <label style="font-size:0.8rem">Realisasi
                                                                                Keuangan Sampai Saat Ini (Rp)</label>
                                                                            <input
                                                                                value="{{$dpa->Realisasi->sortByDesc('created_at')->where('periode','<=',$target->periode)->unique('periode')->reduce(function($total,$value){return $total + optional($value)->realisasi_keuangan;})}}"
                                                                                name="res_tot"
                                                                                data-periode="{{$target->periode}}"
                                                                                type="number" class="form-control"
                                                                                min="0"
                                                                                placeholder="Realisasi Keuangan Saat Ini"
                                                                                required readonly>
                                                                        </div>
                                                                        <div class="form-group col-6 col-lg-3">
                                                                            <label style="font-size:0.8rem">Realisasi
                                                                                Keuangan Sampai Saat Ini (%)</label>
                                                                            <input type="number" class="form-control"
                                                                                   value="{{pembulatanDuaDecimal($dpa->Realisasi->sortByDesc('created_at')->where('periode','<=',$target->periode)->unique('periode')->reduce(function($total,$value){return $total + optional($value)->realisasi_keuangan;}) && $dpa->nilai_pagu_dpa ? $dpa->Realisasi->sortByDesc('created_at')->where('periode','<=',$target->periode)->unique('periode')->reduce(function($total,$value){return $total + optional($value)->realisasi_keuangan;}) / $dpa->nilai_pagu_dpa *100 : 0,2)}}"
                                                                                   name="persentase_res_tot"
                                                                                   data-periode="{{$target->periode}}"
                                                                                   step="0.01"
                                                                                   min="0"
                                                                                   placeholder="Persentase Realisasi Keuangan Saat Ini"
                                                                                   required readonly>
                                                                        </div>
                                                                        <div class="form-group col-12">
                                                                            <label
                                                                                style="font-size:0.8rem">Permasalahan</label>
                                                                            <textarea
                                                                                name="permasalahan[{{$target->periode}}]"
                                                                                class="form-control"
                                                                                {{!$periode[$target->periode] ? 'disabled' : ''}}
                                                                                rows="3">{{optional($dpa->Realisasi->where('periode',$target->periode)->first())->permasalahan}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="card-footer d-flex">
                                                        <button type="submit"
                                                                class="btn btn-sm btn-light-primary font-weight-bold mr-6">
                                    <span class="svg-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                <path
                                                    d="M17,4 L6,4 C4.79111111,4 4,4.7 4,6 L4,18 C4,19.3 4.79111111,20 6,20 L18,20 C19.2,20 20,19.3 20,18 L20,7.20710678 C20,7.07449854 19.9473216,6.94732158 19.8535534,6.85355339 L17,4 Z M17,11 L7,11 L7,4 L17,4 L17,11 Z"
                                                    fill="#000000" fill-rule="nonzero"></path>
                                                <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="5"
                                                      rx="0.5">
                                                </rect>
                                            </g>
                                        </svg>
                                    </span>
                                                            Simpan
                                                        </button>
                                                        <button type="reset"
                                                                class="btn btn-sm btn-light-danger font-weight-bold">
                                    <span class="svg-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path
                                                    d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                                    fill="#000000" fill-rule="nonzero"/>
                                                <path
                                                    d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                                    fill="#000000" opacity="0.3"/>
                                            </g>
                                        </svg>
                                    </span>
                                                            Batal
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            webshim.activeLang('fi');
            webshims.setOptions('forms-ext', {
                replaceUI: 'auto',
                types: 'number'
            });
            webshims.polyfill('forms forms-ext');
            $('.nav-item').click(function () {
                var tab_id = $(this).find('.nav-link').attr('href');
                $('input').removeAttr('required');
                $(tab_id).find('input').attr('required', true);
            });
            $('.nav-item:first').click();
            $('form').on('focus', 'input[type=number]', function (e) {
                $(this).on('wheel.disableScroll', function (e) {
                    e.preventDefault()
                })
            })
            $('form').on('blur', 'input[type=number]', function (e) {
                $(this).off('wheel.disableScroll')
            })
            var total = [];
            $('[name*=total_dana]').each(function (i, el) {
                total.push({
                    'index': $(el).data('index'),
                    'nilai_pagu': $(el).val()
                })
            })
            $('[name*=realisasi_keuangan][data-index]').on('keyup mouseup input', function () {
               
                var index = $(this).data('index')
                var nilai_pagu = $('[name*=total_dana][data-index=' + index + ']').val()
                var total_realisasi = 0;
                var value = $(this).val();
                if (value < 0) {
                    $(this).val(0)
                    value = 0;
                }
                var periode = $(this).data('periode')
                $('[name*=realisasi_keuangan][data-index=' + index + ']:not([data-periode=' + periode + '])').each(function (i, el) {
                    total_realisasi += $(el).val() ? parseInt($(el).val()) : 0;
                })
                var new_total = nilai_pagu - total_realisasi;
                if (value > new_total) {
                    $(this).val(new_total);
                }
                for (i = periode; i <= 4; i++) {
                    var tr = 0;
                    for (n = i; n >= 1; n--) {
                        if (n <= i) {
                            var tot = $('[name*=realisasi_keuangan][data-index=' + index + '][data-periode=' + n + ']').val();
                            tr += tot ? parseInt(tot) : 0

                            console.log(index+' '+n);
                        }
                    }
                    $('[name=tot_res][data-index=' + index + '][data-periode=' + i + ']').val(tr);
                }
            })
            $('[name*=realisasi_fisik][data-index]').on('keyup mouseup input', function () {
                var index = $(this).data('index')
                var total_realisasi = 0;
                var value = $(this).val();
                if (value < 0) {
                    $(this).val(0)
                    value = 0;
                }
                var periode = $(this).data('periode')
                $('[name*=realisasi_fisik][data-index=' + index + ']:not([data-periode=' + periode + '])').each(function (i, el) {
                    total_realisasi += $(el).val() ? parseFloat($(el).val()) : 0;
                })
                var new_total = 100 - total_realisasi;
                if (value > new_total) {
                    $(this).val(new_total);
                }
                for (i = periode; i <= 4; i++) {
                    var tr = 0;
                    for (n = i; n >= 1; n--) {
                        if (n <= i) {
                            var tot = $('[name*=realisasi_fisik][data-index=' + index + '][data-periode=' + n + ']').val();
                            tr += tot ? parseFloat(tot) : 0
                        }
                    }
                    $('[name=tot_fis][data-index=' + index + '][data-periode=' + i + ']').val(tr);
                }
            })
            // total.forEach(function (val) {
            //     $('[name*=realisasi_keuangan][data-index=' + val.index + ']').on('keyup mouseup input', function () {
            //         var total_realisasi = 0;
            //         var value = $(this).val();
            //         if (value < 0){
            //             $(this).val(0)
            //             value = 0;
            //         }
            //         var periode = $(this).data('periode')
            //         $('[name*=realisasi_keuangan][data-index=' + val.index + ']:not([data-periode=' + periode + '])').each(function (i, el) {
            //             total_realisasi += $(el).val() ? parseInt($(el).val()) : 0;
            //         })
            //         var new_total = val.nilai_pagu - total_realisasi;
            //         if (value > new_total) {
            //             $(this).val(new_total);
            //         }
            //         for (i = periode; i <= 4; i++) {
            //             var tr = 0;
            //             for (n = i; n >= 1; n--) {
            //                 if (n <= i) {
            //                     var tot = $('[name*=realisasi_keuangan][data-index=' + val.index + '][data-periode=' + n + ']').val();
            //                     tr += tot ? parseInt(tot) : 0
            //                 }
            //             }
            //             $('[name=tot_res][data-index=' + val.index + '][data-periode=' + i + ']').val(tr);
            //         }
            //     })
            //     $('[name*=realisasi_fisik][data-index=' + val.index + ']').on('keyup mouseup input', function () {
            //         var total_realisasi = 0;
            //         var value = $(this).val();
            //         if (value < 0){
            //             $(this).val(0)
            //             value = 0;
            //         }                    var periode = $(this).data('periode')
            //         $('[name*=realisasi_fisik][data-index=' + val.index + ']:not([data-periode=' + periode + '])').each(function (i, el) {
            //             total_realisasi += $(el).val() ? parseInt($(el).val()) : 0;
            //         })
            //         var new_total = 100 - total_realisasi;
            //         if (value > new_total) {
            //             $(this).val(new_total);
            //         }
            //         for (i = periode; i <= 4; i++) {
            //             var tr = 0;
            //             for (n = i; n >= 1; n--) {
            //                 if (n <= i) {
            //                     var tot = $('[name*=realisasi_fisik][data-index=' + val.index + '][data-periode=' + n + ']').val();
            //                     tr += tot ? parseInt(tot) : 0
            //                 }
            //             }
            //             $('[name=tot_fis][data-index=' + val.index + '][data-periode=' + i + ']').val(tr);
            //         }
            //     })
            // })
            $('[name*=realisasi_keuangan][data-periode]').on('keyup mouseup input', function () {
                var periode = parseInt($(this).data('periode'));
                var total = 0;
                $('[name*=realisasi_keuangan][data-periode=' + periode + ']:not([name*=realisasi_keuangan_periode])').each(function (i, el) {
                    total += $(el).val() ? parseInt($(el).val()) : 0;
                })
                $('[name*=realisasi_keuangan_periode][data-periode=' + periode + ']').val(total)
                var total_pagu = {{$dpa->nilai_pagu_dpa}}
                $('[name="persentase_keuangan_periode[' + periode + ']"]').val(total && total_pagu ? (total / total_pagu * 100).toFixed(2) : 0)
                for (i = periode; i <= 4; i++) {
                    var tr = 0;
                    for (n = i; n >= 1; n--) {
                        if (n <= i) {
                            $('[name*=realisasi_keuangan][data-periode=' + n + ']:not([name*=realisasi_keuangan_periode])').each(function (i, el) {
                                tr += $(el).val() ? parseInt($(el).val()) : 0
                            });
                        }
                    }
                    $('[name=res_tot][data-periode=' + i + ']').val(tr);
                    $('[name=persentase_res_tot][data-periode=' + i + ']').val(tr && total_pagu ? (tr / total_pagu * 100).toFixed(2) : 0);
                }

            })
            $('[name*=realisasi_fisik][data-periode]').on('keyup mouseup input', function () {
                var periode = parseInt($(this).data('periode'));
                var total = 0;
                var realisasi_fisik_el = $('[name*=realisasi_fisik][data-periode=' + periode + ']:not([name*=realisasi_fisik_periode])');
                realisasi_fisik_el.each(function (i, el) {
                    total += $(el).val() ? parseFloat($(el).val()) : 0;
                })
                total = total / realisasi_fisik_el.length;
                $('[name*=realisasi_fisik_periode][data-periode=' + periode + ']').val(total.toFixed(2))
                for (i = periode; i <= 4; i++) {
                    var tr = 0;
                    for (n = i; n >= 1; n--) {
                        if (n <= i) {
                            $('[name*=realisasi_fisik][data-periode=' + n + ']:not([name*=realisasi_fisik_periode])').each(function (i, el) {
                                tr += $(el).val() ? parseFloat($(el).val()) : 0
                            });
                        }
                    }
                    $('[name=fis_tot][data-periode=' + i + ']').val((tr / realisasi_fisik_el.length).toFixed(2));
                }
            })
            $('[name*=realisasi_kinerja][data-periode]').on('keyup mouseup input', function () {
                var periode = parseInt($(this).data('periode'));
                var total = 0;
                var realisasi_kinerja_el = $('[name*=realisasi_kinerja][data-periode=' + periode + ']:not([name*=realisasi_kinerja_periode])');
                realisasi_kinerja_el.each(function (i, el) {
                    total += $(el).val() ? parseFloat($(el).val()) : 0;
                })
                total = total / realisasi_kinerja_el.length;
                for (i = periode; i <= 4; i++) {
                    var tr = 0;
                    for (n = i; n >= 1; n--) {
                        if (n <= i) {
                            $('[name*=realisasi_kinerja][data-periode=' + n + ']').each(function (i, el) {
                                tr += $(el).val() ? parseFloat($(el).val()) : 0
                            });
                        }
                    }
                    $('[name=kinerja_tot][data-periode=' + i + ']').val((tr / realisasi_kinerja_el.length).toFixed(2));
                }
            })
            $('#realisasi-form').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Perhatian!!',
                    text: 'Simpan Data Realisasi?',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Simpan',
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var action = $('#realisasi-form').attr('action')
                        var data = $('#realisasi-form').serialize();
                        axios.post(action, data)
                            .then(function () {
                                Swal.fire('Sukses!', 'Berhasil Menyimpan Data Realisasi', 'success')
                            })
                            .catch(function (err) {
                                if (err.response.status == 422) {
                                    var message = err.response.data.diagnostic.message;
                                    var required_parameter = err.response.data.diagnostic.required_parameter;
                                    var validation_error = '';
                                    for (key in required_parameter) {
                                        validation_error += key + ' : ' + required_parameter[key].map(function (value) {
                                            return value + '<br>'
                                        }).join('')
                                    }
                                    swal.fire(message, validation_error, 'error')
                                } else {
                                    Swal.fire('Perhatian!', 'Terjadi kesalahan saat menyimpan data', 'error')
                                }
                            })
                    }
                })
            })
        })
    </script>
@endpush
