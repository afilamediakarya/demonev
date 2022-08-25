@extends('layout/app')

@section('title', 'Profile Daerah')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Pengaturan</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">Profile Daerah</a>
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
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="col">
                    <form id="profile-form" action="{{route('api.profile-daerah.create')}}" method="post">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Profil Daerah</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Nama Daerah</label>
                                            <input type="text" name="nama_daerah" value="{{$profile->nama_daerah}}"
                                                   class="form-control" placeholder="Masukkan Nama Daerah">
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Pimpinan</label>
                                            <input type="text" name="pimpinan_daerah" value="{{$profile->pimpinan_daerah}}"
                                                   class="form-control" placeholder="Masukkan Nama Pimpinan">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" value="{{$profile->email}}"
                                                   class="form-control" placeholder="Masukkan Email">
                                        </div>
                                        <div class="form-group">
                                            <label>No. Telpon</label>
                                            <input type="text" name="no_telp" value="{{$profile->no_telp}}"
                                                   class="form-control" placeholder="Masukkan No. Telpon">
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea name="alamat" class="form-control"
                                                      row="3">{{$profile->alamat}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Visi daerah</label>
                                            <textarea name="visi_daerah" id="visi_daerah"
                                                      class="form-control">{{$profile->visi_daerah}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Misi daerah</label>
                                            <textarea name="misi_daerah" id="misi_daerah"
                                                      class="form-control">{{$profile->misi_daerah}}</textarea>
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    {{--	<script src="{{ asset('assets/js/pages/crud/forms/editors/ckeditor-classic.js') }}"></script>--}}
    <script>
        $(document).ready(function () {
            var visi = misi = '';
            ClassicEditor
                .create(document.querySelector('#visi_daerah'))
                .then(editor => {
                    visi = editor;
                })
                .catch(error => {
                });
            ClassicEditor
                .create(document.querySelector('#misi_daerah'))
                .then(editor => {
                    misi = editor
                })
                .catch(error => {
                });
            FormValidation.formValidation(
                document.getElementById('profile-form'),
                {
                    fields: {
                        nama_daerah: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama Daerah tidak boleh kosong'
                                }
                            }
                        },
                        pimpinan_daerah: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama Pimpinan tidak boleh kosong'
                                }
                            }
                        },
                        email: {
                            validators: {
                                notEmpty: {
                                    message: 'Email tidak boleh kosong'
                                }
                            }
                        },
                        no_telp: {
                            validators: {
                                notEmpty: {
                                    message: 'No. Telpon tidak boleh kosong'
                                }
                            }
                        },
                        alamat: {
                            validators: {
                                notEmpty: {
                                    message: 'Alamat tidak boleh kosong'
                                }
                            }
                        },
                        // visi_daerah: {
                        //     validators: {
                        //         notEmpty: {
                        //             message: 'Visi Daerah tidak boleh kosong'
                        //         }
                        //     }
                        // },
                        // misi_daerah: {
                        //     validators: {
                        //         notEmpty: {
                        //             message: 'Misi Daerah tidak boleh kosong'
                        //         }
                        //     }
                        // },
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
                Swal.fire({
                    title: 'Perhatian!!',
                    text: state + ' Profile Daerah?',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: state,
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('[name=visi_daerah]').val(visi.getData());
                        $('[name=misi_daerah]').val(misi.getData());
                        var action = $('#profile-form').attr('action')
                        axios.post(action, $('#profile-form').serialize())
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
