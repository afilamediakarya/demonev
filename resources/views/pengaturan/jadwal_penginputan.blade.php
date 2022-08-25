@extends('layout/app')

@section('title', 'Jadwal Penginputan')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Pengaturan</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">Jadwal Penginputan</a>
        </li>
    </ul>
@endsection

@section('main_page')


    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <a href="#" class="btn btn-primary font-weight-bolder" id="side_panel_toggle">
                    <i class="flaticon-plus"></i>
                    Tambah Jadwal Penginputan
                </a>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Entry-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b">
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-bordered table-checkable" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th>TAHAPAN</th>
                                    <th>SUB TAHAPAN</th>
                                    <th>JADWAL</th>
                                    <th>AKSI</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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


@section('side_form')
    <div id="side_panel" class="offcanvas offcanvas-right p-10">
        <!--begin::Header-->
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-7">
            <h4 class="font-weight-bold m-0">Tambah Jadwal Penginputan</h4>
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_panel_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content">
            <!--begin::Wrapper-->
            <form id="data-form" action="{{route('api.jadwal.create')}}" method="post">
                <input type="hidden" name="uuid">
                <input type="hidden" name="tahun" value="">
                <div class="offcanvas-wrapper mb-5 scroll-pull">
                    <div class="form-group">
                        <label>Tahapan
                            <span class="text-danger">*</span></label>
                        <select name="tahapan" class="form-control" required></select>
                    </div>
                    <div class="form-group">
                        <label>Sub Tahapan
                            <span class="text-danger">*</span></label>
                        <select name="sub_tahapan" class="form-control" disabled required></select>
                    </div>
                    <div class="form-group">
                        <label> Jadwal Pelaksanaan
                            <span class="text-danger">*</span></label>
                        <div class="input-daterange input-group" id="kt_datepicker_5">
                            <input type="text" class="form-control" name="jadwal_mulai" autocomplete="off" required>
                            <div class="input-group-append">
                            <span class="input-group-text">
                                <p class="m-0">s/d</p>
                            </span>
                            </div>
                            <input type="text" class="form-control" name="jadwal_selesai" autocomplete="off" required>
                        </div>
                    </div>
                </div>
                <!--end::Wrapper-->
                <!--begin::Purchase-->
                <div class="offcanvas-footer">
                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                    <button type="reset" class="btn btn-secondary close-panel">Batal</button>
                </div>
            </form>
            <!--end::Purchase-->
        </div>
        <!--end::Content-->
    </div>
@endsection

@section('add_script')
    <script src="{{asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            var getTahapan = function () {
                axios.get('{{route('api.tahapan')}}')
                    .then(function (res) {
                        var tahapan = res.data.response.map(function (val) {
                            return '<option value="' + val.tahapan + '">' + val.tahapan + '</option>'
                        })
                        $('[name=tahapan]').append('<option value="" selected disabled>Pilih Tahapan</option>' + tahapan.join(''));
                    })
            }
            var getSubTahapan = function (tahapan, _sub_tahapan) {
                $('[name=sub_tahapan]').removeAttr('disabled');
                $('[name=sub_tahapan]').html('')
                axios.get('{{route('api.tahapan')}}/' + tahapan + '/sub-tahapan')
                    .then(function (res) {
                        var sub_tahapan = res.data.response.map(function (val) {
                            return '<option value="' + val.sub_tahapan + '">' + val.sub_tahapan + '</option>'
                        })
                        $('[name=sub_tahapan]').append('<option value="" selected disabled>Pilih Sub Tahapan</option>' + sub_tahapan.join(''));
                        if (_sub_tahapan) {
                            $('[name=sub_tahapan]').val(_sub_tahapan)
                        }
                    })
            }
            getTahapan()
            $('[name=tahapan]').change(function () {
                var tahapan = $(this).val()
                if (tahapan) {
                    getSubTahapan(tahapan, '')
                }
            })
            var _sidePanel = new KTOffcanvas('side_panel', {
                overlay: true,
                baseClass: 'offcanvas',
                placement: 'right',
                closeBy: 'side_panel_close',
                toggleBy: 'side_panel_toggle'
            });
            var _mainTable = $('.table').DataTable({
                "processing": true,
                "serverSide": true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ajax": {
                    url: '{{route('api.jadwal.data-table',['tahun' => session('tahun_penganggaran')])}}',
                    type: "GET",
                    headers: {'X-XSRF-TOKEN': Cookies.get("XSRF-TOKEN")},
                },
                columns: [
                    {data: 'tahapan', name: 'tahapan'},
                    {data: 'sub_tahapan', name: 'sub_tahapan'},
                    {data: 'jadwal', name: 'jadwal'},
                    {data: 'action', name: 'action', orderable: false, width: '15%'},
                ],
            });
            $('#side_panel_toggle').click(function () {
                $('#side_panel [name]').val('');
                $('[name=tahun]').val('{{session('tahun_penganggaran')}}')
                $('[name=sub_tahapan]').attr('disabled', 'true')
                $('[name=sub_tahapan]').html('')
                $('#kt_datepicker_5').datepicker('destroy');
                $('#kt_datepicker_5').datepicker();
            })
            $('body').on('click', '.open-panel', function (e) {
                e.preventDefault();
                var uuid = $(this).data('uuid')
                $('.form-group.fv-plugins-icon-container').removeClass('has-danger').addClass('has-success')
                $('.fv-plugins-message-container').html('')
                axios.get('{{route('api.jadwal')}}/uuid/' + uuid)
                    .then(function (res) {
                        for (key in res.data.response) {
                            var el = $('[name=' + key + ']');
                            if (el.length) {
                                el.val(key == 'jadwal_mulai' || key == 'jadwal_selesai' ? (new Date(res.data.response[key])).toLocaleDateString() : res.data.response[key])
                            }
                        }
                        getSubTahapan(res.data.response.tahapan, res.data.response.sub_tahapan)
                        $('#kt_datepicker_5').datepicker('destroy');
                        $('#kt_datepicker_5').datepicker();
                    })
                _sidePanel.show();
            })
            $('body').on('click', '.button-delete', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Perhatian!!',
                    text: 'Hapus Jadwal?',
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
                        axios.delete('{{route('api.jadwal')}}/uuid/' + uuid)
                            .then(function () {
                                _mainTable.ajax.reload();
                                Swal.fire('Sukses!', 'Berhasil Menghapus Jadwal', 'success')
                            })
                            .catch(function () {
                                Swal.fire('Perhatian!', 'Terjadi kesalahan saat menghapus data', 'error')
                            })
                    }
                })

            })
            $('.close-panel').click(function () {
                _sidePanel.hide();
            })
            FormValidation.formValidation(
                document.getElementById('data-form'),
                {
                    fields: {
                        tahapan: {
                            validators: {
                                notEmpty: {
                                    message: 'Tahapan tidak boleh kosong'
                                }
                            }
                        },
                        sub_tahapan: {
                            validators: {
                                notEmpty: {
                                    message: 'Sub Tahapan tidak boleh kosong'
                                }
                            }
                        },
                        jadwal_mulai: {
                            validators: {
                                notEmpty: {
                                    message: 'Jadwal Mulai tidak boleh kosong'
                                }
                            }
                        },
                        jadwal_selesai: {
                            validators: {
                                notEmpty: {
                                    message: 'Jadwal Selesai tidak boleh kosong'
                                }
                            }
                        },
                    },

                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        // Validate fields when clicking the Submit button
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        // Bootstrap Framework Integration
                        bootstrap: new FormValidation.plugins.Bootstrap({
                            eleInvalidClass: '',
                            eleValidClass: '',
                        })
                    }
                }
            ).on('core.form.valid', function () {
                var state = 'Simpan';
                if ($('[name=uuid]').val() != '') {
                    state = 'Update'
                }
                Swal.fire({
                    title: 'Perhatian!!',
                    text: state + ' Jadwal?',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: state,
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var action = $('#data-form').attr('action')
                        axios.post(action, $('#data-form').serialize())
                            .then(function () {
                                _mainTable.ajax.reload();
                                _sidePanel.hide();
                                Swal.fire('Sukses!', 'Berhasil Menyimpan Data Jadwal', 'success')
                            })
                            .catch(function (err) {
                                console.log(err.response);
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
            });
            ;
        })
    </script>
@endpush
