@extends('layout/app')

@section('title', 'Target')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Kegiatan</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{url('kegiatan/dpa')}}" class="">DPA</a>
        </li>
        <li class="breadcrumb-item">
            <a href="" class="">Edit Tolak Ukur </a>
        </li>
    </ul>
@endsection
@section('style')
@endsection


@section('main_page')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->

        <!--end::Entry-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Card-->
                    <form id="dpa-form" action="{{route('api.dpa.update-tolak-ukur',[$uuid])}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="put">
                        <input type="hidden" name="uuid">
                        <input type="hidden" name="tahun" value="{{session('tahun_penganggaran')}}">
                        <div class="card card-custom card-fit card-border">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="tolak-ukur" class="card card-custom border-0 card-fit"
                                                 style="box-shadow:none">
                                                <div class="card-header border-0 pb-0">
                                                    <div class="card-title">
                                                        <h3 class="card-label">Tolak Ukur</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        <a href="javascript:;" data-repeater-create="" id="btn-tambah-tolak-ukur"
                                                           class="btn btn-text-dark-50 btn-icon-primary btn-hover-icon-danger font-weight-bold btn-hover-bg-light mr-3">
                                                            <i class="flaticon2-plus-1"></i>Tambah Tolak Ukur</a>
                                                    </div>
                                                </div>
                                                <div data-repeater-list="">
                                                    <div class="card-body py-0 row" data-repeater-item>
                                                        <div class="form-group col-12 col-lg-6">
                                                            <label>Tolak Ukur</label>
                                                            <textarea name="tolak_ukur" class="form-control"
                                                                      placeholder="Masukkan narasi tolak ukur"
                                                                      required></textarea>
                                                        </div>
                                                        <div class="form-group col-5 col-lg-2">
                                                            <label>Volume</label>
                                                            <input name="volume" type="number" class="form-control"
                                                                   min="0"
                                                                   placeholder="" required>
                                                        </div>
                                                        <div class="form-group col-6 col-lg-3">
                                                            <label for="">Satuan</label>
                                                            <select name="satuan" class="form-control" required>
                                                                <option value="" selected disabled>Pilih Satuan</option>
                                                                @foreach($satuan AS $s)
                                                                    <option value="{{$s->nama_satuan}}">{{$s->nama_satuan}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div
                                                            class="col-1 d-flex flex-column justify-content-center align-items-center">
                                                            <a href="javascript:;" data-repeater-delete=""
                                                               class="btn btn-text-dark-50 btn-icon-danger btn-hover-icon-danger font-weight-bold btn-hover-bg-light mr-3">
                                                                <i class="flaticon2-trash"></i></a>
                                                        </div>
                                                        <div class="col-12 separator separator-solid mt-3 mb-2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex">
                                <button type="submit" class="btn btn-sm btn-light-primary font-weight-bold mr-6">
                                <span class="svg-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path
                                                d="M17,4 L6,4 C4.79111111,4 4,4.7 4,6 L4,18 C4,19.3 4.79111111,20 6,20 L18,20 C19.2,20 20,19.3 20,18 L20,7.20710678 C20,7.07449854 19.9473216,6.94732158 19.8535534,6.85355339 L17,4 Z M17,11 L7,11 L7,4 L17,4 L17,11 Z"
                                                fill="#000000" fill-rule="nonzero"></path>
                                            <rect fill="#000000" opacity="0.3" x="12" y="4" width="3" height="5"
                                                  rx="0.5"></rect>
                                        </g>
                                    </svg>
                                </span>
                                    Simpan
                                </button>
                                <button type="reset" class="btn btn-sm btn-light-danger font-weight-bold">
                                <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path
                                            d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z"
                                            fill="#000000" fill-rule="nonzero"/>
                                        <path
                                            d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z"
                                            fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg>
                            </span>
                                    Batal
                                </button>
                            </div>
                        </div>
                    </form>
                    <!--end::Card-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>
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
            var initFvTolakukur = function (index){
                fv.addField('['+index+'][tolak_ukur]', {
                    validators: {
                        notEmpty: {
                            message: 'Tolak Ukur tidak boleh kosong'
                        }
                    }
                })
                fv.addField('['+index+'][volume]', {
                    validators: {
                        notEmpty: {
                            message: 'Volume tidak boleh kosong'
                        }
                    }
                })
                fv.addField('['+index+'][satuan]', {
                    validators: {
                        notEmpty: {
                            message: 'Satuan boleh kosong'
                        }
                    }
                })
            }
            $('#tolak-ukur').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function () {
                    $(this).slideDown();
                    var index = $('#tolak-ukur [data-repeater-item]').length - 1;
                    initFvTolakukur(index)
                    $(this).updatePolyfill();
                },

                hide: function (deleteElement) {
                    var index = $('#tolak-ukur [data-repeater-item]').length - 1;
                    $(this).slideUp(deleteElement);
                    fv.removeField('['+index+'][tolak_ukur]')
                    fv.removeField('['+index+'][volume]')
                    fv.removeField('['+index+'][satuan]')
                    setTimeout(function (){
                        initFvTolakukur(index-1)
                    },500)
                },
                isFirstItemUndeletable: true
            });
            @if (isset($uuid))
            axios.get('{{route('api.dpa.find-uuid',[$uuid])}}')
                .then(function (res){
                    for (key in res.data.response) {
                        var el = $('[name=' + key + ']');
                        if (el.length) {
                            el.val(res.data.response[key])
                        }
                    }
                    $('[name=nilai_pagu_dpa]').val(res.data.response.nilai_pagu_dpa)
                    $('#nilai_pagu_dpa').val(res.data.response.nilai_pagu_dpa.toLocaleString('id-ID', {style: 'currency', currency: 'IDR'}));
                    res.data.response.sumber_dana_dpa.forEach(function (val,i){
                        if (i > 0){
                            $('#btn-tambah-sumber-dana').click();
                        }
                        for (var key in val){
                            if ($('[name="['+i+']['+key+']"]').length)
                                $('[name="['+i+']['+key+']"]').val(val[key])
                        }
                    })
                    res.data.response.tolak_ukur.forEach(function (val,i){
                        if (i > 0){
                            $('#btn-tambah-tolak-ukur').click();
                        }
                        for (var key in val){
                            if ($('[name="['+i+']['+key+']"]').length)
                                $('[name="['+i+']['+key+']"]').val(val[key])
                        }
                    })
                    $('#sub_kegiatan').select2();
                    $('#penanggung-jawab').select2();
                })
            @endif
            var fv = FormValidation.formValidation(
                document.getElementById('dpa-form'),
                {
                    fields: {
                        '[0][tolak_ukur]': {
                            validators: {
                                notEmpty: {
                                    message: 'Tolak Ukur tidak boleh kosong'
                                }
                            }
                        },
                        '[0][volume]': {
                            validators: {
                                notEmpty: {
                                    message: 'Volume tidak boleh kosong'
                                }
                            }
                        },
                        '[0][satuan]': {
                            validators: {
                                notEmpty: {
                                    message: 'Satuan boleh kosong'
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
            )

            fv.on('core.form.valid', function () {
                var state = 'Update';
                Swal.fire({
                    title: 'Perhatian!!',
                    html: state + ' Data Tolak Ukur?',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: state,
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var action = $('#dpa-form').attr('action')
                        var data = $('#dpa-form').serialize();
                        var el_tolak_ukur = $('[name*=tolak_ukur]');
                        el_tolak_ukur.each(function (i, el) {
                            data += '&tolak_ukur[' + i + ']=' + $(el).val()
                        })
                        var el_volume = $('[name*=volume]');
                        el_volume.each(function (i, el) {
                            data += '&volume[' + i + ']=' + $(el).val()
                        })
                        var el_satuan = $('[name*=satuan]');
                        el_satuan.each(function (i, el) {
                            data += '&satuan[' + i + ']=' + $(el).val()
                        })
                        axios.post(action, data)
                            .then(function () {
                                Swal.fire('Sukses!', 'Berhasil Menyimpan Data Tolak Ukur', 'success')
                                window.location.href = '{{route('kegiatan.dpa')}}'
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
