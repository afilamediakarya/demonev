@extends('layout/app')

@section('title', 'Daftar Unit Kerja')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Unit Kerja</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">Daftar Unit Kerja</a>
        </li>
    </ul>
@endsection
@section('main_page')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <a href="#" class="btn btn-primary font-weight-bolder" id="kt_quick_user_toggle">
                    <i class="flaticon-plus"></i>
                    Tambah Unit Kerja
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
                                    <th>KODE</th>
                                    <th>UNIT KERJA</th>
                                    <th>MAX PAGU</th>
                                    <th>BIDANG URUSAN</th>
                                    <th>AKSI</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
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
    <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
        <!--begin::Header-->
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-7">
            <h4 class="font-weight-bold m-0">Tambah Unit Kerja</h4>
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content">
            <!--begin::Wrapper-->
            <form id="data-form" action="{{route('api.unit-kerja.create')}}" method="post">
                <input type="hidden" name="uuid">
                <input name="tahun" type="hidden" class="form-control" required>
                <div class="offcanvas-wrapper mb-5 scroll-pull">
                    <div class="form-group">
                        <label>Nama Unit Kerja
                            <span class="text-danger">*</span>
                        </label>
                        <input name="nama_unit_kerja" type="text" class="form-control" required>
                    </div>
                    <div id="bidang-urusan">
                        <div data-repeater-list="">
                            <div data-repeater-item class="form-group">
                                <label for="exampleSelect1">Bidang Urusan
                                    <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <select name="bidang_urusan" class="form-control" required>

                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="javascript:;" data-repeater-delete=""
                                           class="btn btn-danger btn-bidang-urusan"><span
                                                class="fa fa-trash"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">
                                <span class="text-danger"></span></label>
                            <a href="javascript:;" data-repeater-create="" class="btn btn-primary btn-sm"><span
                                    class="fa fa-plus-circle"></span></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Max Pagu
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="max_pagu" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label>Masukkan Nama Jabatan Kepala
                            <span class="text-danger">*</span>
                        </label>
                        <input name="nama_jabatan_kepala" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label>Masukkan Nama Kepala
                            <span class="text-danger">*</span>
                        </label>
                        <input name="nama_kepala" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label>Masukkan Nip Kepala
                            <span class="text-danger">*</span>
                        </label>
                        <input name="nip_kepala" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label>Masukkan Pangkat
                            <span class="text-danger">*</span>
                        </label>
                        <input name="pangkat_kepala" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Status Kepala
                            <span class="text-danger">*</span></label>
                        <select name="status_kepala" class="form-control" id="exampleSelect1">
                            <option value="" selected disabled>Pilih Status Kepala</option>
                            <option value="Pejabat Tetap">Pejabat Tetap</option>
                            <option value="Pejabat Sementara">Pejabat Sementara</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label> Kode
                            <span class="text-danger">*</span>
                        </label>
                        <input type="hidden" name="kode_unit_kerja" value="123">
                        <input name="preview_kode_unit_kerja" type="text" class="form-control" placeholder="Enter Kode"
                               readonly>
                        <span class="form-text text-muted">Automatis sesuai kode bidang urusan.</span>
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
    <script src="{{asset('assets/js/pages/crud/forms/widgets/form-repeater.js')}}"></script>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            webshim.activeLang('fi');
            webshims.setOptions('forms-ext', {
                replaceUI: 'auto',
                types: 'number'
            });
            webshims.polyfill('forms forms-ext');
            $('form').on('focus', 'input[type=number]', function (e) {
                $(this).on('wheel.disableScroll', function (e) {
                    e.preventDefault()
                })
            })
            $('form').on('blur', 'input[type=number]', function (e) {
                $(this).off('wheel.disableScroll')
            })
            $('#bidang-urusan').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function () {
                    var itemcount = $(this).parents("[data-repeater-list]").find("[data-repeater-item]").length;
                    if (itemcount <= 3) {
                        $(this).slideDown();
                        getBidangUrusan()
                    } else {
                        $(this).remove();
                    }
                },

                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                    setTimeout(function (){
                        generateKode()
                    },1000)
                },
                isFirstItemUndeletable: true
            });
            var _sidePanel = new KTOffcanvas('kt_quick_user', {
                overlay: true,
                baseClass: 'offcanvas',
                placement: 'right',
                closeBy: 'kt_quick_user_close',
                toggleBy: 'kt_quick_user_toggle'
            });
            var _mainTable = $('.table').DataTable({
                "processing": true,
                "serverSide": true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ajax": {
                    url: '{{route('api.unit-kerja.data-table',['tahun_anggaran' => session('tahun_penganggaran')])}}',
                    type: "GET",
                    headers: {'X-XSRF-TOKEN': Cookies.get("XSRF-TOKEN")},
                },
                columns: [
                    {data: 'kode_unit_kerja', name: 'kode_unit_kerja'},
                    {data: 'nama_unit_kerja', name: 'nama_unit_kerja'},
                    {data: 'max_pagu', name: 'max_pagu'},
                    {data: 'bidang_urusan', name: 'bidang_urusan', orderable: false},
                    {data: 'action', name: 'action', orderable: false, width: '15%'},
                ],
            });
            var generateKode = function (){
                var data = '';
                var el_bidang_urusan = $('[name*=bidang_urusan]');
                el_bidang_urusan.each(function (i, el) {
                    if (i > 0)
                        data += '&';
                    data += 'bidang_urusan[' + i + ']=' + $(el).val()
                })
                axios.post('{{route('api.unit-kerja.generate-kode')}}',data)
                    .then(function (res){
                        $('[name=preview_kode_unit_kerja],[name=kode_unit_kerja]').val(res.data.response.kode_sub_kegiatan)
                    })
            }
            var getBidangUrusan = function () {
                axios.get('{{route('api.bidang-urusan')}}')
                    .then(function (res) {
                        var bidang_urusan = res.data.response.map(function (value) {
                            return '<option value="' + value.id + '">' + value.kode_urusan + '.' + value.kode_bidang_urusan + ' - ' + value.nama_bidang_urusan + '</option>';
                        })
                        var el = $('[name*="bidang_urusan"]');
                        el.each(function (i, el) {
                            if ($(el).children().length == 0) {
                                $(el).append('<option value="" selected disabled>Pilih Bidang Urusan</option>' + bidang_urusan.join(''))
                                $(el).select2();
                            }
                        })
                    })
            }
            getBidangUrusan()
            $('#kt_quick_user_toggle').click(function () {
                $('#kt_quick_user [name]').val('');
                $('[name*=bidang_urusan]').select2()
                $('[name=tahun]').val('{{session('tahun_penganggaran')}}')
            })
            $('body').on('click', '.open-panel', function (e) {
                e.preventDefault();
                var uuid = $(this).data('uuid')
                $('[name=tahun]').val('{{session('tahun_penganggaran')}}')
                $('.form-group.fv-plugins-icon-container').removeClass('has-danger').addClass('has-success')
                $('.fv-plugins-message-container').html('')
                axios.get('{{route('api.unit-kerja')}}/uuid/' + uuid+'?tahun={{session('tahun_penganggaran')}}')
                    .then(function (res) {
                        for (key in res.data.response) {
                            var el = $('[name=' + key + ']');
                            if (el.length) {
                                el.val(res.data.response[key])
                            }
                        }
                        $('[name=preview_kode_unit_kerja]').val(res.data.response.kode_unit_kerja)
                        var jumlah_unit_kerja_pagu=res.data.response.unit_kerja_pagu.length;
                        
                        if(jumlah_unit_kerja_pagu>0){
                            console.log(res.data.response.unit_kerja_pagu);
                            $('[name=max_pagu]').val(res.data.response.unit_kerja_pagu[0].max_pagu_tahun);
                        }else{
                            $('[name=max_pagu]').val('0');
                        }

                        console.log('unit kerja pagu : '+jumlah_unit_kerja_pagu);

                        var jumlah_bidang_urusan = res.data.response.bidang_urusan.length;

                        console.log('bidang urusan : '+jumlah_bidang_urusan);
                        var jumlah_form_bidang_urusan = $('[name*=bidang_urusan]').length;
                        if (jumlah_form_bidang_urusan > jumlah_bidang_urusan){
                            for (i = (jumlah_form_bidang_urusan - jumlah_bidang_urusan); i > 0; i--) {
                                $('[data-repeater-delete]:eq('+(i-1)+')').click();
                            }
                        }
                        if (jumlah_bidang_urusan > jumlah_form_bidang_urusan) {
                            for (i = 0; i < (jumlah_bidang_urusan - jumlah_form_bidang_urusan); i++) {
                                $('[data-repeater-create]').click();
                            }
                        }
                        setTimeout(function () {
                            res.data.response.bidang_urusan.forEach(function (value, i) {
                                $('[name="[' + i + '][bidang_urusan]"]').val(value.id)
                                $('[name="[' + i + '][bidang_urusan]"]').select2();
                            })
                        }, 500)
                    })
                _sidePanel.show();
            })
            $('body').on('click', '.button-delete', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Perhatian!!',
                    text: 'Hapus Unit Kerja?',
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
                        axios.delete('{{route('api.unit-kerja')}}/uuid/' + uuid)
                            .then(function () {
                                _mainTable.ajax.reload();
                                Swal.fire('Sukses!', 'Berhasil Menghapus Unit Kerja', 'success')
                            })
                            .catch(function () {
                                Swal.fire('Perhatian!', 'Terjadi kesalahan saat menghapus data', 'error')
                            })
                    }
                })

            })

            $('body').on('change','[name*=bidang_urusan]',function (e){
                generateKode()
            })
            $('.close-panel').click(function () {
                _sidePanel.hide();
            })
            FormValidation.formValidation(
                document.getElementById('data-form'),
                {
                    fields: {
                        nama_unit_kerja: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama Unit Kerja tidak boleh kosong'
                                }
                            }
                        },max_pagu: {
                            validators: {
                                notEmpty: {
                                    message: 'Max Pagu tidak boleh kosong'
                                }
                            }
                        },
                        '[0][bidang_urusan]': {
                            validators: {
                                notEmpty: {
                                    message: 'Bidang Urusan tidak boleh kosong'
                                }
                            }
                        },
                        nama_kepala: {
                            validators: {
                                notEmpty: {
                                    message: 'Nama Kepala tidak boleh kosong'
                                }
                            }
                        },
                        nip_kepala: {
                            validators: {
                                notEmpty: {
                                    message: 'NIP Kepala tidak boleh kosong'
                                }
                            }
                        },
                        pangkat_kepala: {
                            validators: {
                                notEmpty: {
                                    message: 'Pangkat Kepala tidak boleh kosong'
                                }
                            }
                        },
                        kode_unit_kerja: {
                            validators: {
                                notEmpty: {
                                    message: 'Kode Unit Kerja tidak boleh kosong'
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
                    text: state + ' Unit Kerja?',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: state,
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var action = $('#data-form').attr('action')
                        var data = $('#data-form').serialize();
                        var el_bidang_urusan = $('[name*=bidang_urusan]');
                        el_bidang_urusan.each(function (i, el) {
                            data += '&bidang_urusan[' + i + ']=' + $(el).val()
                        })
                        axios.post(action, data)
                            .then(function () {
                                _mainTable.ajax.reload();
                                _sidePanel.hide();
                                Swal.fire('Sukses!', 'Berhasil Menyimpan Data Unit Kerja', 'success')
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
