@extends('layout/app')

@section('title', 'Akun')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Pengaturan</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">Akun</a>
        </li>
    </ul>
@endsection

@section('style')
    <style>
        #kt_wrapper {
            padding-top: 65px;
        }
    </style>
@endsection
@section('main_page')


    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="col">
                    <div class="card card-custom">
                        <form id="akun-form" action="{{route('api.akun.update')}}" method="post">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="mb-5">Detail Akun</h5>
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input name="nama_lengkap" type="text" class="form-control"
                                                   placeholder="Masukkan Nama" value="{{auth()->user()->nama_lengkap}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>NIP</label>
                                            <input name="nip" type="text" class="form-control"
                                                   placeholder="Masukkan NIP" value="{{auth()->user()->nip}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input name="username" type="text" class="form-control"
                                                   placeholder="Masukkan Username" value="{{auth()->user()->username}}" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="mb-5">Ganti Password Akun</h5>
                                        <div class="form-group">
                                            <label>Password Lama</label>
                                            <input name="old_password" type="password" class="form-control"
                                                   placeholder="Masukkan Password Lama">
                                        </div>
                                        <div class="form-group">
                                            <label>Password Baru</label>
                                            <input name="password" type="password" class="form-control"
                                                   placeholder="Masukkan Password Baru">
                                        </div>
                                        <div class="form-group">
                                            <label>Ulangi Password Baru</label>
                                            <input name="password_confirmation" type="password" class="form-control"
                                                   placeholder="Ulangi Password Baru">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="submit"
                                        class="btn btn-sm btn-light-primary font-weight-bold mr-6">
                                    Simpan
                                </button>
                                <button type="reset"
                                        class="btn btn-sm btn-light-danger font-weight-bold">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            FormValidation.formValidation(
                document.getElementById('akun-form'),
                {
                    fields: {
                        nama_lengkap: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama Lengkap tidak boleh kosong'
                                }
                            }
                        },
                        username: {
                            validators: {
                                notEmpty: {
                                    message: 'Username tidak boleh kosong'
                                }
                            }
                        },
                        old_password: {
                            validators: {
                                notEmpty: {
                                    message: 'Password Lama tidak boleh kosong'
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: 'Password tidak boleh kosong'
                                }
                            }
                        },
                        password_confirmation: {
                            validators: {
                                notEmpty: {
                                    message: 'Konfirmasi Password tidak boleh kosong'
                                },
                                identical: {
                                    compare: function () {
                                        return $('[name="password"]').val();
                                    },
                                    message: 'Konfirmasi Password salah'
                                }
                            }
                        }
                    },

                    plugins: {
                        excluded: new FormValidation.plugins.Excluded({
                            excluded: function (field, ele, eles) {
                                var old_pass = $('[name=old_password]').val();
                                return (field === 'password' || field === 'password_confirmation' || field === 'old_password') && old_pass == ''
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
                Swal.fire({
                    title: 'Perhatian!!',
                    text: state + ' Akun?',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: state,
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var action = $('#akun-form').attr('action')
                        axios.post(action, $('#akun-form').serialize())
                            .then(function () {
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
        })
    </script>
@endpush
