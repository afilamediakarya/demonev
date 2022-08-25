@extends('layout/app')

@section('title', 'Laporan Realisasi')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Laporan</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">Evaluasi RKPD</a>
        </li>
    </ul>
@endsection
<!-- 37751550 cph2380 -->
@section('style')
    <style>
        .table tr > th:nth-child(3) {
            /* white-space: nowrap !important; */
            width: 13%
        }

        tr > th {
            vertical-align: top !important;
        }
    </style>
@endsection


@section('main_page')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <!--end::Info-->
            </div>
        </div>
        <!--end::Entry-->
        <div class="content d-flex flex-column flex-column-fluid p-0" id="kt_content">
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <div class="col">
                        <div class="card card-custom card-stretch example example-compact" id="kt_page_stretched_card">
                            <div class="card-header d-flex flex-column" kt-hidden-height="74" style="">
                                <div class="card-title my-7">
                                    <h3 class="card-label">Laporan Evaluasi RKPD</h3>
                                </div>
                                <form id="laporan-form" style="background-color:#f6f9ff" class="py-5 rounded mb-5">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row px-5">
                                                <div class="col-md col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">Tahun Anggaran</label>
                                                        <select name="periode" class="form-control" required>
                                                            <option value="" selected disabled>Pilih Tahun Anggaran</option>
                                                            @for($i = 2019; $i<= 2023; $i++)
                                                                {{-- <option value="{{$i}}" {{$periode_selected == $i ? 'selected' : ''}}>Triwulan {{integerToRoman($i)}}</option> --}}
                                                                <option value="{{$i}}" {{$periode_selected == $i ? 'selected' : ''}}>Tahun Anggaran {{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md col-sm-12">
                                                    <div class="form-group">
                                                        <label for="">Sumber Dana</label>
                                                        <select name="sumber_dana" class="form-control">
                                                            <option value="">Semua</option>
                                                            @foreach($sumber_dana AS $sd)
                                                                <option
                                                                    value="{{$sd->nama_sumber_dana}}" {{$sumber_dana_selected == $sd->nama_sumber_dana ? 'selected' : ''}}>{{$sd->nama_sumber_dana}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md col-sm-12 " style="display: none">
                                                    <div class="form-group">
                                                        <label for="">Jenis Belanja</label>
                                                        <select name="jenis_belanja" class="form-control">
                                                            <option value="">Semua</option>
                                                            @foreach($jenis_belanja AS $jb)
                                                            <option value="{{$jb->nama_jenis_belanja}}" {{$jb->nama_jenis_belanja == $jenis_belanja_selected ? 'selected' : ''}}>{{$jb->nama_jenis_belanja}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md col-sm-12" style="display: none">
                                                    <div class="form-group">
                                                        <label for="">Metode Pelaksanaan</label>
                                                        <select name="metode_pelaksanaan" class="form-control">
                                                            <option value="">Semua</option>
                                                            @foreach($metode_pelaksanaan AS $mp)
                                                                <option value="{{$mp->nama_metode_pelaksanaan}}" {{$mp->nama_metode_pelaksanaan == $metode_pelaksanaan_selected ? 'selected' : ''}}>{{$mp->nama_metode_pelaksanaan}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md col-sm-12"  {{hasRole('opd') ? 'style=display:none' : ''}}>
                                                    <div class="form-group">
                                                        <label for="">Unit Kerja</label>
                                                        <select name="unit_kerja" class="form-control">
                                                            @if (hasRole('opd'))
                                                                @foreach($unit_kerja AS $uk)
                                                                    <option
                                                                        value="{{$uk->id}}" selected data-nama-kepala="{{$uk->nama_kepala}}" data-nip-kepala="{{$uk->nip_kepala}}" data-nama-jabatan-kepala="{{$uk->nama_jabatan_kepala}}" data-pangkat-kepala="{{$uk->pangkat_kepala}}">{{$uk->nama_unit_kerja}}</option>
                                                                @endforeach
                                                            @endif
                                                            @if (hasRole('admin'))
                                                            @php
                                                            $bapeda = $unit_kerja->where('nama_unit_kerja','Badan Perencanaan Pembangunan, Penelitian dan Pengembangan Daerah')->first();
                                                                @endphp
                                                            <option value="" data-nama-kepala="{{$bapeda->nama_kepala}}" data-nip-kepala="{{$bapeda->nip_kepala}}" data-nama-jabatan-kepala="{{$bapeda->nama_jabatan_kepala}}" data-pangkat-kepala="{{$bapeda->pangkat_kepala}}">Semua</option>
                                                            @foreach($unit_kerja AS $uk)
                                                                <option
                                                                    value="{{$uk->id}}" {{$unit_kerja_selected == $uk->id ? 'selected' : ''}} data-nama-kepala="{{$uk->nama_kepala}}" data-nip-kepala="{{$uk->nip_kepala}}" data-nama-jabatan-kepala="{{$uk->nama_jabatan_kepala}}" data-pangkat-kepala="{{$uk->pangkat_kepala}}">{{$uk->nama_unit_kerja}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row px-5">
                                                <div class="col-12 col-sm">
                                                    <div class="form-group">
                                                        <label for="">Nama</label>
                                                        <Input type="text" name="nama" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="form-group">
                                                        <label for="">Nip</label>
                                                        <Input type="text" name="nip" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="form-group">
                                                        <label for="">Pangkat/Golongan</label>
                                                        <Input type="text" name="jabatan" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="form-group">
                                                        <label for="">Nama Jabatan Kepala</label>
                                                        <Input type="text" name="nama_jabatan_kepala" class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm">
                                                    <div class="form-group">
                                                        <label for="">Tanggal Cetak</label>
                                                        <div class="input-group date">
                                                            <input name="tgl_cetak" value="{{date('d/m/Y')}}" type="text" class="form-control" id="datepicker" readonly="readonly" placeholder="Select date" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <i class="la la-calendar-check-o"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex">
                                            <div class="px-5">
                                                <a id="export-excel" href="{{url('laporan/export_evaluasi_rkpd/excel')}}" class="btn btn-success btn-xs m-1 ">
                                                    <i class="fas fa-file-excel"></i> Export Excel
                                                </a>
                                                <a id="export-pdf" href="{{url('laporan/export_evaluasi_rkpd/pdf')}}" class="btn btn-danger btn-xs m-1">
                                                <i class="fas fa-file-pdf"></i> Export Pdf
                                                </a>
                                                <button type="submit" class="btn btn-primary btn-xs m-1">
                                                    <i class="fas fa-table"></i> Tampilkan Data
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="row my-3 justify-content-between">
                                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                                </div>
                                {!!$tabel!!}
                            </div>
                        </div>
                    </div>

                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>
    </div>
@endsection


@push('script')
    <script>
        $('#datepicker').datepicker({
            'format' : 'dd/mm/yyyy'
        });
        $('#export-excel,#export-pdf').click(function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            var param = $('#laporan-form').serialize();
            var periode = $('[name=periode]');
            if (periode.val())
                window.open(url+'?'+param, '_blank');

            if (!periode.val()){
                periode.select2('open')
            }
        })
        $('[name=unit_kerja],[name=sumber_dana],[name=periode]').select2();
        var pimpinan = $('[name=unit_kerja]').find('option:first')
        var pim_default = $(pimpinan).data();
        $('[name=nama]').val(pim_default.namaKepala);
        $('[name=nip]').val(pim_default.nipKepala);
        $('[name=jabatan]').val(pim_default.pangkatKepala);
        $('[name=nama_jabatan_kepala]').val(pim_default.namaJabatanKepala);
        $('[name=unit_kerja]').on('select2:select',function (e){
            var data = e.params.data;
            if (data.id){
                var selected = $('[name=unit_kerja]').find('option[value='+data.id+']')
            } else {
                var selected = $('[name=unit_kerja]').find('option:first')
            }
            var dapim = $(selected).data();
            $('[name=nama]').val(dapim.namaKepala);
            $('[name=nip]').val(dapim.nipKepala);
            $('[name=jabatan]').val(dapim.pangkatKepala);
            $('[name=nama_jabatan_kepala]').val(dapim.namaJabatanKepala);
        })
        var KTBootstrapDatepicker = function () {
            var arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }

// Private functions
            var demos = function () {
                // input group layout
                $('#kt_datepicker_2, #kt_datepicker_2_validate').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: arrows
                });

                // input group layout for modal demo
                $('#kt_datepicker_2_modal').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: arrows
                });
            }

            return {
                // public functions
                init: function () {
                    demos();
                }
            };
        }();

        jQuery(document).ready(function () {
            KTBootstrapDatepicker.init();
        });
    </script>
@endpush
