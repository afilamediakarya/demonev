@extends('layout/app')

@section('title', 'Realisasi Sub Kegiatan')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Sub Kegiatan</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">Realisasi Sub Kegiatan</a>
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
                {{-- <a href="{{url('renstra/realisasi-sub-kegiatan/set-output')}}" class="btn btn-primary font-weight-bolder">
                    <i class="flaticon-plus"></i>
                    Tambah Realisasi Sub Kegiatan
                </a> --}}
                <span class="label label-warning label-pill label-inline mr-2"> 
                <!-- <div> -->
                    <!-- <i class="fas fa-info-circle icon-lg text-warning mr-3 "></i> -->
                <!-- </div> -->
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
                                            <th>TOTAL PAGU RENSTRA (RP)</th>
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
                    url: '{{route('api.renstra-realisasi-sub-kegiatan.data-table',['tahun' => session('tahun_penganggaran')])}}',
                    type: "GET",
                    headers: {'X-XSRF-TOKEN': Cookies.get("XSRF-TOKEN")},
                },
                columns: [
                    {data: 'kode_sub_kegiatan',orderable: false, name: 'kode_sub_kegiatan'},
                    {data: 'grouping', name: 'grouping', orderable: false, visible: false},
                    {data: 'nama_sub_kegiatan', orderable: false, name: 'nama_sub_kegiatan'},
                    {data: 'total_pagu_renstra', orderable: false, name: 'total_pagu_renstra'},
                    {data: 'action', name: 'action', orderable: false, width: '15%'},
                ],
                rowGroup : {
                    dataSrc : 'grouping'
                },
                // rowGroup : {
                //     dataSrc : 'grouping'
                // },
            });
            $('body').on('click', '.button-delete', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Perhatian!!',
                    text: 'Hapus Data Realisasi Sub Kegiatan?',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: `Hapus`,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    icon: 'warning'
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var uuid = $(this).data('uuid')
                        axios.delete('{{route('api.renstra-realisasi-sub-kegiatan')}}/uuid/' + uuid)
                            .then(function () {
                                _mainTable.ajax.reload();
                                Swal.fire('Sukses!', 'Berhasil Menghapus Data Dpa', 'success')
                            })
                            .catch(function () {
                                Swal.fire('Perhatian!', 'Terjadi kesalahan saat menghapus data', 'error')
                            })
                    }
                })

            })

        });
    </script>
@endpush
