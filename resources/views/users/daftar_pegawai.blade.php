@extends('layout/app')

@section('title', 'Daftar Pegawai')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Master</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">Pegawai</a>
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
                    Tambah Pegawai
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
                            <div class="table-responsive">

                                <table class="table table-bordered table-checkable" id="kt_datatable">
                                    <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIP</th>
                                        <th>Jabatan</th>
                                        <th>Unit Kerja</th>
                                        <th>Nomor Telepon</th>
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


@section('side_form')
    <div id="side_panel" class="offcanvas offcanvas-right p-10">
        <!--begin::Header-->
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-7">
            <h4 class="font-weight-bold m-0">Tambah Pegawai</h4>
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_panel_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content">
            <!--begin::Wrapper-->
            <form id="data-form" action="{{route('api.pegawai.create')}}" method="post">
                <input type="hidden" name="uuid">

                <div class="offcanvas-wrapper mb-5 scroll-pull">
                    <div class="form-group">
                        <label>NIP
                            <span class="text-danger">*</span></label>
                        <input name="nip" type="text" class="form-control" placeholder="Enter NIP" autocomplete="off"
                               required/>
                    </div>
                    <div class="form-group">
                        <label>Nama
                            <span class="text-danger">*</span></label>
                        <input name="nama" type="text" class="form-control"
                               placeholder="Enter Nama Pegawai" autocomplete="off" required/>
                    </div>
                    <div class="form-group">
                        <label>Jabatan
                            <span class="text-danger"></span></label>
                        <input name="jabatan" type="text" class="form-control"
                               placeholder="Enter Jabatan" autocomplete="off"/>
                    </div>
                    <div class="form-group">
                        <label>Unit Kerja
                            <span class="text-danger"></span></label>
                        <select name="id_unit_kerja" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Alamat
                            <span class="text-danger"></span></label>
                        <textarea name="alamat" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir
                            <span class="text-danger"></span></label>
                        <input name="tempat_lahir" type="text" class="form-control" placeholder="Enter Tempat Lahir">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir
                            <span class="text-danger"></span></label>
                        <input name="tanggal_lahir" id="kt_datepicker_1" type="text" class="form-control"
                               autocomplete="off" placeholder="Enter Tanggal Lahir">
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon
                            <span class="text-danger"></span></label>
                        <input name="no_telp" type="text" class="form-control" placeholder="Enter Nomor Telepon"
                               autocomplete="off">
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
                    url: '{{route('api.pegawai.data-table')}}',
                    type: "GET",
                    headers: {'X-XSRF-TOKEN': Cookies.get("XSRF-TOKEN")},
                },
                columns: [
                    {data: 'nama', name: 'nama'},
                    {data: 'nip', name: 'nip'},
                    {data: 'jabatan', name: 'jabatan'},
                    {data: 'unit_kerja', name: 'unit_kerja'},
                    {data: 'no_telp', name: 'no_telp'},
                    {data: 'action', name: 'action', orderable: false, width: '15%'},
                ],
            });
            axios.get('{{route('api.unit-kerja')}}')
                .then(function (res) {
                    var unit_kerja = res.data.response.map(function (value) {
                        return '<option value="' + value.id + '">' + value.nama_unit_kerja + '</option>'
                    })
                    $('[name=id_unit_kerja]').append('<option value="" selected disabled>Pilih Unit Kerja</option>' + unit_kerja.join(''))
                    $('[name=id_unit_kerja]').select2();
                })
            $('#side_panel_toggle').click(function () {
                $('#side_panel [name]').val('');
                $('[name=id_unit_kerja]').select2();
            })
            $('body').on('click', '.open-panel', function (e) {
                e.preventDefault();
                var uuid = $(this).data('uuid')
                $('.form-group.fv-plugins-icon-container').removeClass('has-danger').addClass('has-success')
                $('.fv-plugins-message-container').html('')
                axios.get('{{route('api.pegawai')}}/uuid/' + uuid)
                    .then(function (res) {
                        for (key in res.data.response) {
                            var el = $('[name=' + key + ']');
                            if (el.length) {
                                el.val(key == 'tanggal_lahir' ? (new Date(res.data.response[key])).toLocaleDateString() : res.data.response[key])
                            }
                        }
                        $('[name=id_unit_kerja]').select2();
                        $('#kt_datepicker_1').datepicker('destroy')
                        $('#kt_datepicker_1').datepicker()
                    })
                _sidePanel.show();
            })
            $('body').on('click', '.button-delete', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Perhatian!!',
                    text: 'Hapus Pegawai?',
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
                        axios.delete('{{route('api.pegawai')}}/uuid/' + uuid)
                            .then(function () {
                                _mainTable.ajax.reload();
                                Swal.fire('Sukses!', 'Berhasil Menghapus Pegawai', 'success')
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
                        nip: {
                            validators: {
                                notEmpty: {
                                    message: 'NIP tidak boleh kosong'
                                }
                            }
                        },
                        nama: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama Pegawai tidak boleh kosong'
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
                    text: state + ' Pegawai?',
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
                                Swal.fire('Sukses!', 'Berhasil Menyimpan Data Pegawai', 'success')
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
            });
            ;
        });
    </script>
@endpush
