@extends('layout/app')

@section('title', 'DAK')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Kegiatan</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">Paket DAK-Non Fisik</a>
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
                
                <div></div>
                <span class="label label-warning label-pill label-inline mr-2"> 
                    Jadwal Input : {{$jadwal_input ? $jadwal_input->jadwal_mulai->format('Y/m/d').' - '.$jadwal_input->jadwal_selesai->format('Y/m/d') : 'Belum Tersedia'}}</i>
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
                                            <th>TOTAL PAGU (RP)</th>
                                            <th>TOTAL INPUT</th>
                                            <th>STATUS INPUT</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                    url: '{{route('api.dak_non_fisik.data-table',['tahun' => session('tahun_penganggaran')])}}',
                    type: "GET",
                    headers: {'X-XSRF-TOKEN': Cookies.get("XSRF-TOKEN")},
                },
                columns: [
                    {data: 'kode_sub_kegiatan',orderable: false, name: 'kode_sub_kegiatan'},
                    {data: 'grouping', name: 'grouping', orderable: false, visible: false},
                    {data: 'nama_sub_kegiatan', orderable: false, name: 'nama_sub_kegiatan'},
                    {data: 'sumber_dana', orderable: false, name: 'sumber_dana'},
                    {data: 'nilai_pagu_dpa', orderable: false, name: 'nilai_pagu_dpa'},
                    {data: 'total_input', orderable: false, name: 'total_input'},
                    {data: 'status_input', orderable: false, name: 'status_input'},
                    {data: 'action', name: 'action', orderable: false, width: '15%'},
                ],
                rowGroup : {
                    dataSrc : 'grouping'
                },
            });
        });
    </script>
@endpush
