@extends('layout/app')

@section('title', 'Daftar User')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Users</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">Daftar User</a>
        </li>
    </ul>
@endsection

@section('main_page')


    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <!-- <a href="#" class="btn btn-primary font-weight-bolder" id="kt_quick_user_toggle">
                    <i class="flaticon-plus"></i>
                    Tambah User
                </a> -->
                <a href="#" class="btn btn-primary font-weight-bolder" id="kt_quick_user_toggle">
                    <i class="flaticon-plus"></i>
                    Tambah User
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
                                        <th>USERNAME</th>
                                        <th>ROLE</th>
                                        <th>NAMA LENGKAP</th>
                                        <th>NIP</th>
                                        <th>UNIT KERJA</th>
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
    <!-- <div id="side_panel" class="offcanvas offcanvas-right p-10">
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-7">
            <h4 class="font-weight-bold m-0">Tambah User</h4>
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="side_panel_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
        <div class="offcanvas-content">
            </div>
        </div> -->
        <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
            <!--begin::Header-->
			<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
                <h3 class="font-weight-bold m-0">Tambah User</h3>
				<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                    <i class="ki ki-close icon-xs text-muted"></i>
				</a>
			</div>
			<!--end::Header-->
			<!--begin::Content-->
			<div class="offcanvas-content pr-5 mr-n5">
                <div class="navi navi-spacer-x-0 p-0">
                    <form id="data-form" action="{{route('api.user.create')}}" method="post">
                        <input type="hidden" name="uuid">
                        <div class="offcanvas-wrapper mb-5 scroll-pull">
                            <div class="form-group">
                                <label>Username
                                    <span class="text-danger">*</span></label>
                                <input name="username" type="text" class="form-control" placeholder="Enter Username"/>
                            </div>
                            <div class="form-group">
                                <label>Role
                                    <span class="text-danger">*</span></label>
                                <select name="id_role" class="form-control" required></select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password
                                            <span class="text-danger"></span></label>
                                        <input name="password" type="password" class="form-control" id="exampleInputPassword1"
                                            autocomplete="off"
                                            placeholder="Password"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Ulangi Password
                                            <span class="text-danger"></span></label>
                                        <input name="password_confirmation" type="password" class="form-control"
                                            id="exampleInputPassword1"
                                            autocomplete="off"
                                            placeholder="Password"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>NIP
                                    <span class="text-danger"></span></label>
                                <input name="nip" class="form-control" placeholder="Enter NIP" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap
                                    <span class="text-danger">*</span></label>
                                <input name="nama_lengkap" type="text" class="form-control" placeholder="Enter Nama Lengkap" required/>
                            </div>
                            <div class="form-group">
                                <label>Jabatan
                                    <span class="text-danger"></span></label>
                                <input name="jabatan" type="text" class="form-control" placeholder="Enter Jabatan" required/>
                            </div>
                            <div class="form-group">
                                <label>No. Telp
                                    <span class="text-danger"></span></label>
                                <input name="no_telp" type="text" class="form-control" placeholder="Enter Nomor Telepon" required/>
                            </div>
                            <div class="form-group">
                                <label>Unit Kerja
                                    <span class="text-danger"></span></label>
                                <select name="id_unit_kerja" class="form-control" required>
                                    <option value="" selected>Pilih Unit Kerja</option>
                                    @foreach($unit_kerja As $uk)
                                        <option value="{{$uk->id}}">{{$uk->kode_unit_kerja}} - {{$uk->nama_unit_kerja}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <div class="radio-inline">
                                    <label class="radio">
                                        <input value="1" checked type="radio" name="status">
                                        <span></span>Aktif</label>
                                    <label class="radio">
                                        <input value="0" type="radio" name="status">
                                        <span></span>Tidak Aktif</label>
                                    <label class="radio">
                                </div>
                            </div>
                        </div>
                        <div class="offcanvas-footer">
                            <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                            <button type="reset" class="btn btn-secondary close-panel">Batal</button>
                        </div>
                    </form>
					
				</div>
			</div>
			<!--end::Content-->
		</div>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            $('[name=id_unit_kerja]').select2();
            var _sidePanel = new KTOffcanvas('kt_quick_user');
            var _mainTable = $('.table').DataTable({
                "processing": true,
                "serverSide": true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ajax": {
                    url: '{{route('api.user.data-table')}}',
                    type: "GET",
                    headers: {'X-XSRF-TOKEN': Cookies.get("XSRF-TOKEN")},
                },
                columns: [
                    {data: 'username', name: 'username'},
                    {data: 'role', name: 'role'},
                    {data: 'nama_lengkap', name: 'nama_lengkap'},
                    {data: 'nip', name: 'nip'},
                    {data: 'unit_kerja', name: 'unit_kerja'},
                    {data: 'action', name: 'action', orderable: false, width: '15%'},
                ],
            });
            axios.get('{{route('api.role')}}')
                .then(function (res) {
                    var role = res.data.response.map(function (value) {
                        return '<option value="' + value.id + '">' + value.nama_role + '</option>'
                    })
                    $('[name=id_role]').append('<option value="" selected disabled>Pilih Role</option>' + role.join(''))
                })
            axios.get('{{route('api.pegawai')}}')
                .then(function (res) {
                    var pegawai = res.data.response.map(function (value) {
                        return '<option value="' + value.id + '" data-nama="' + value.nama + '">' + value.nip + ' - ' + value.nama  + '</option>'
                    })
                    $('[name=id_pegawai]').append('<option value="" selected disabled>Pilih NIP</option>' + pegawai.join(''))
                    $('[name=id_pegawai]').select2();
                })
            $('#kt_quick_user_toggle').click(function () {
                $('#kt_quick_user [name]:not([type=radio])').val('');
                $('[name=id_unit_kerja]').val('')
                $('[name=id_unit_kerja]').select2();
            })
            $('[name=id_pegawai]').change(function (){
                var nama = $('[name=id_pegawai] option:selected').data('nama')
                $('[name=nama_lengkap]').val(nama)
            })
            $('body').on('click', '.open-panel', function (e) {
                e.preventDefault();
                $('[type=password]').val('')
                var uuid = $(this).data('uuid')
                $('.form-group.fv-plugins-icon-container').removeClass('has-danger').addClass('has-success')
                $('.fv-plugins-message-container').html('')
                axios.get('{{route('api.user')}}/uuid/' + uuid)
                    .then(function (res) {
                        for (key in res.data.response) {
                            var el = $('[name=' + key + ']');
                            if (el.length && key != 'status') {
                                el.val(res.data.response[key])
                            }
                        }
                        $('[name=status][value="' + res.data.response.status + '"]').click();
                        $('[name=id_unit_kerja]').select2();
                    })
                _sidePanel.show();
            })
            $('body').on('click', '.button-status', function (e) {
                e.preventDefault();
                var status = $(this).data('status') == 1 ? 'Nonaktifkan' : 'Aktifkan'
                Swal.fire({
                    title: 'Perhatian!!',
                    text: status + ' Status User?',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: status,
                    icon: 'question'
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var uuid = $(this).data('uuid')
                        axios.post('{{route('api.user')}}/toggle-status/' + uuid)
                            .then(function () {
                                _mainTable.ajax.reload();
                                Swal.fire('Sukses!', 'Update Status User Berhasil', 'success')
                            })
                            .catch(function () {
                                Swal.fire('Perhatian!', 'Terjadi kesalahan saat mengupdate data', 'error')
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
                        username: {
                            validators: {
                                notEmpty: {
                                    message: 'Username tidak boleh kosong'
                                }
                            }
                        },
                        role: {
                            validators: {
                                notEmpty: {
                                    message: 'Role tidak boleh kosong'
                                }
                            }
                        },
                        nama_lengkap: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama Lengkap tidak boleh kosong'
                                }
                            }
                        },
                        nip: {
                            validators: {
                                notEmpty: {
                                    message: 'NIP tidak boleh kosong'
                                }
                            }
                        },
                        id_unit_kerja: {
                            validators: {
                                notEmpty: {
                                    message: 'Unit Kerja tidak boleh kosong'
                                }
                            }
                        },
                        password : {
                            validators: {
                                notEmpty: {
                                    message: 'Password tidak boleh kosong'
                                }
                            }
                        },
                        password_confirmation : {
                            validators: {
                                notEmpty: {
                                    message: 'Konfirmasi Password tidak boleh kosong'
                                },
                                identical : {
                                    compare: function() {
                                        return $('[name="password"]').val();
                                    },
                                    message: 'Konfirmasi Password salah'
                                }
                            }
                        }
                    },

                    plugins: {
                        excluded: new FormValidation.plugins.Excluded({
                            excluded: function(field, ele, eles) {
                                var uuid = $('[name=uuid]').val();
                                if (uuid)
                                    return (field === 'password' || field === 'password_confirmation') && uuid !== ''
                                var role = $('[name=id_role]').val();
                                if (role)
                                    return (field === 'nip' || field === 'id_unit_kerja') && role == 1;
                            },
                        }),
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
                    text: state + ' User?',
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
                                Swal.fire('Sukses!', 'Berhasil Menyimpan Data User', 'success')
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
        });
    </script>
@endpush
