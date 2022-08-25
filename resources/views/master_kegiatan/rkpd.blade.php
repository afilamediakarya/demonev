@extends('layout/app')

@section('title', 'RKPD')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Kegiatan</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">RKPD</a>
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
                <a href="{{ cekJadwal('Kegiatan','Sub Kegiatan RKPD Pokok') ? url('kegiatan/dpa/set-output') : '#'}}" class="btn btn-primary font-weight-bolder {{cekJadwal('Kegiatan','Sub Kegiatan RKPD Pokok') ? '' : 'disabled'}}">
                    <i class="flaticon-plus"></i>
                    Tambah RKPD
                </a>
                {{-- <span class="label label-warning label-pill label-inline mr-2"> 
                    Jadwal Input : {{$jadwal_input ? $jadwal_input->jadwal_mulai->format('Y/m/d').' - '.$jadwal_input->jadwal_selesai->format('Y/m/d') : 'Belum Tersedia'}}</i> --}}
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
                                            <th>TOLAK UKUR KEGIATAN (OUTPUT)</th>
                                            <th>NILAI PAGU (RP)</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
    {{--                                    <tr>--}}
    {{--                                        <td>5.01.03.2.01.01</td>--}}
    {{--                                        <td>--}}
    {{--                                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Delivered</span>--}}
    {{--                                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Delivered</span>--}}
    {{--                                        </td>--}}
    {{--                                        <td>Koordinasi Penyusunan Dokumen Perencanaan Pembangunan Daerah Bidang Pemerintahan (RPJD, RPJMD dan RKPD)</td>--}}
    {{--                                        <td>* Koordinasi Penyusunan Dokumen <br>* Perencanaan Pembangunan Daerah Bidang Pemerintahan (RPJD, RPJMD dan RKP</td>--}}
    {{--                                        <td nowrap="nowrap">RP. 100.000</td>--}}
    {{--                                        <td nowrap="nowrap">100.000.000</td>--}}
    {{--                                        <td>--}}
    {{--                                            <a href="{{url('monitoring-dan-evaluasi/dpa/set-output')}}" class="btn btn-sm btn-primary font-weight-bolder">--}}
    {{--                                                <span class="svg-icon svg-icon-sm">--}}
    {{--                                                    <svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
    {{--                                                        <path d="M0 0.5V13.5H10V3.79688L9.85938 3.64062L6.85938 0.640625L6.70312 0.5H0ZM1 1.5H6V4.5H9V12.5H1V1.5ZM7 2.21875L8.28125 3.5H7V2.21875ZM2.5 5.5V6.5H7.5V5.5H2.5ZM2.5 7.5V8.5H7.5V7.5H2.5ZM2.5 9.5V10.5H7.5V9.5H2.5Z" fill="white"/>--}}
    {{--                                                    </svg>--}}
    {{--                                                </span>Edit Output--}}
    {{--                                            </a>--}}
    {{--                                        </td>--}}
    {{--                                    </tr>--}}
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
                    url: '{{route('api.rkpd.data-table',['tahun' => session('tahun_penganggaran')])}}',
                    type: "GET",
                    headers: {'X-XSRF-TOKEN': Cookies.get("XSRF-TOKEN")},
                },
                columns: [
                    {data: 'kode_sub_kegiatan',orderable: false, name: 'kode_sub_kegiatan'},
                    {data: 'grouping', name: 'grouping', orderable: false, visible: false},
                    {data: 'nama_sub_kegiatan', orderable: false, name: 'nama_sub_kegiatan'},
                    {data: 'tolak_ukur', orderable: false, name: 'tolak_ukur'},
                    {data: 'nilai_pagu_dpa', orderable: false, name: 'nilai_pagu_dpa'},
                    {data: 'action', name: 'action', orderable: false, width: '15%'},
                ],
                rowGroup : {
                    dataSrc : 'grouping'
                },
            });
            $('body').on('click', '.button-delete', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Perhatian!!',
                    text: 'Hapus Data RKPD?',
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
                        axios.delete('{{route('api.dpa')}}/uuid/' + uuid)
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
