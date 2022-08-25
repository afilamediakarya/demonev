@extends('layout/app')

@section('title', 'Realisasi')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Monitoring & Evaluasi</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">Evaluasi Realisasi</a>
        </li>
    </ul>
@endsection
@section('style')
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
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Card-->
                    <div class="card card-custom">
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-checkable" id="kt_datatable"
                                       style="margin-top: 13px !important">
                                    <thead>
                                        <tr>
                                            <th>KODE</th>
                                            <th>GROUPING</th>
                                            <th>SUB KEGIATAN</th>
                                            <th>SUMBER DANA</th>
                                            <th>NILAI PAGU (RP)</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <tr>
                                            <td>1.01.01.2.01.01</td>
                                            <td>
                                                <span class="label label-lg label-warning label-inline m-1">1 - URUSAN PEMERINTAHAN WAJIB YANG BERKAITAN DENGAN PELAYANAN DASAR</span>
                                                <span class="label label-lg label-info label-inline m-1">01 - URUSAN PEMERINTAHAN BIDANG PENDIDIKAN</span>
                                                <span class="label label-lg label-success label-inline m-1">01 - PROGRAM  PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOT</span>
                                                <span class="label label-lg label-primary label-inline m-1">2.01 - Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah</span>
                                            </td>
                                            <td>Penyusunan Dokumen Perencanaan Perangkat Daerah	</td>
                                            <td>234234 : 1 (Dokumen)	</td>
                                            <!--<td>Rp 51.250.000,00	</td>-->
                                            <td>
                                                <a href="{{route('atur.realisasi-dak','e4bacb44-81d3-471a-a6e6-b6dbd3c7cfb5')}}" class="btn btn-sm btn-primary font-weight-bolder ">
                                                    <span class="svg-icon svg-icon-sm">
                                                        <svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0 0.5V13.5H10V3.79688L9.85938 3.64062L6.85938 0.640625L6.70312 0.5H0ZM1 1.5H6V4.5H9V12.5H1V1.5ZM7 2.21875L8.28125 3.5H7V2.21875ZM2.5 5.5V6.5H7.5V5.5H2.5ZM2.5 7.5V8.5H7.5V7.5H2.5ZM2.5 9.5V10.5H7.5V9.5H2.5Z" fill="white"></path>
                                                        </svg>
                                                    </span>Realisasi
                                                </a>
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                            <!--end: Datatable-->
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
            var _mainTable = $('.table').DataTable({
                "processing": true,
                "serverSide": true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ajax": {
                    url: '{{route('api.dak.realisasi.data-table',['tahun' => session('tahun_penganggaran')])}}&type=realisasi_dak',
                    type: "GET",
                    headers: {'X-XSRF-TOKEN': Cookies.get("XSRF-TOKEN")},
                },
                columns: [
                    {data: 'kode_sub_kegiatan',orderable: false, name: 'kode_sub_kegiatan'},
                    {data: 'grouping', name: 'grouping', orderable: false, visible: false},
                    {data: 'nama_sub_kegiatan', orderable: false, name: 'nama_sub_kegiatan'},
                    {data: 'sumber_dana', orderable: false, name: 'sumber_dana'},
                    {data: 'nilai_pagu_dpa', orderable: false, name: 'nilai_pagu_dpa'},
                    {data: 'action', name: 'action', orderable: false, width: '15%'},
                ],
                rowGroup : {
                    dataSrc : 'grouping'
                },
            });
        });
    </script>
@endpush
