@extends('layout/app')

@section('title', 'Target')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Kegiatan</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{url('kegiatan/dau')}}" class="">Perencanaan Paket DAU</a>
        </li>
        <li class="breadcrumb-item">
            <a href="" class="">Set Paket</a>
        </li>
    </ul>
@endsection
@section('style')
    <style type="text/css">
        .wrapper {
            padding-top: 65px !important;
        }

        .w-100 {
            width: 100%;
        }
    </style>
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
                    <form id="paket-form" action="{{route('api.dau.create')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="uuid" value="{{$uuid}}">
                        <input type="hidden" name="uuid_sd" value="{{$uuid_sd}}">
                        <input type="hidden" name="tahun" value="{{session('tahun_penganggaran')}}">
                        {{-- <input type="hidden" name="nilai_pagu_dau" value="{{$dpa->SumberDanaDpa->first()->nilai_pagu}}"> --}}
                        <div class="card card-custom card-fit card-border">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Detail Kegiatan</h3>
                                </div>
                            </div>
                            @php
                                // print_r($dpa);
                            @endphp
                            <div class="card-body" style="padding-top:0">
                                <div class="form-group mb-8">
                                    <div class="alert alert-custom alert-default" role="alert">
                                        <div class="row w-100">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <p class="font-size-sm">Urusan</p>
                                                    <p class="font-size-md">{{$dpa->Program->BidangUrusan->Urusan->kode_urusan}}
                                                        - {{$dpa->Program->BidangUrusan->Urusan->nama_urusan}}</p>
                                                </div>
                                                <div class="form-group">
                                                    <p class="font-size-sm">Bidang Urusan</p>
                                                    <p class="font-size-md">{{$dpa->Program->BidangUrusan->kode_bidang_urusan}}
                                                        - {{$dpa->Program->BidangUrusan->nama_bidang_urusan}}</p>
                                                </div>
                                                <div class="form-group">
                                                    <p class="font-size-sm">Program</p>
                                                    <p class="font-size-md">{{$dpa->Program->kode_program}}
                                                        - {{$dpa->Program->nama_program}}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <p class="font-size-sm">Kegiatan</p>
                                                    <p class="font-size-md">{{$dpa->Kegiatan->kode_kegiatan}}
                                                        - {{$dpa->Kegiatan->nama_kegiatan}}</p>
                                                </div>
                                                <div class="form-group">
                                                    <p class="font-size-sm">Sub Kegiatan</p>
                                                    <p class="font-size-md">{{$dpa->SubKegiatan->kode_sub_kegiatan}}
                                                        - {{$dpa->SubKegiatan->nama_sub_kegiatan}}</p>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div
                                                    class="separator separator-solid separator-border-2 separator-success"></div>
                                            </div>
                                            <div class="col-4 mt-4">
                                                <div class="form-group">
                                                    <p class="font-size-sm">Nilai Pagu</p>
                                                    <p class="font-size-lg">Rp {{numberToCurrency($dpa->SumberDanaDpa->first()->nilai_pagu)}}</p>
                                                </div>
                                            </div>
                                            <div class="col-4 mt-4">
                                                <div class="form-group">
                                                    <p class="font-size-sm">Output</p>
                                                    @foreach($dpa->TolakUkur AS $tolak_ukur)
                                                        <p class="font-size-lg">{{$tolak_ukur->tolak_ukur}}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <div id="paket-dau" class="card card-custom border-0 card-fit"
                                                    style="box-shadow:none">
                                                    <div class="card-header border-0 pb-0">
                                                        <div class="card-title">
                                                            <h3 class="card-label">Paket DAU</h3>
                                                        </div>
                                                        <div class="card-toolbar">
                                                            <a href="javascript:;" data-repeater-create id="btn-tambah-paket-dau"
                                                            class="btn btn-text-dark-50 btn-icon-primary btn-hover-icon-danger font-weight-bold btn-hover-bg-light mr-3">
                                                                <i class="flaticon2-plus-1"></i>Tambah Paket DAU</a>
                                                        </div>
                                                    </div>
                                                    <div data-repeater-list>
                                                        <div class="card-body py-0 row" data-repeater-item>

                                                        <input name="uuid" type="hidden"
                                                        class="form-control"
                                                        placeholder="" required>
                                                            <div class="form-group col-12 col-lg-7">
                                                                <label>Nama Paket</label>
                                                                <input name="nama_paket" type="text"
                                                                    class="form-control"
                                                                    placeholder="" required>
                                                            </div>
                                                            <div class="form-group col-6 col-lg-2">
                                                                <label>Volume</label>
                                                                <input name="volume" type="text"
                                                                    class="form-control"
                                                                    placeholder="" required>
                                                            </div>
                                                            <div class="form-group col-6 col-lg-2">
                                                                <label for="">Satuan</label>
                                                                <select name="satuan" class="form-control" required>
                                                                    <option value="" selected disabled>Pilih Satuan</option>
                                                                    @foreach($satuan AS $s)
                                                                        <option value="{{$s->nama_satuan}}">{{$s->nama_satuan}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-12 col-lg-6">
                                                                    <div id="desa" class="card desa card-custom border-0 card-fit" style="box-shadow:none">
                                                                        <div class="card-header border-0 pb-0 pl-0">
                                                                            <div class="card-title">
                                                                                <h3 class="card-label">Desa/Kelurahan</h3>
                                                                            </div>
                                                                            <div class="card-toolbar">
                                                                                <a href="javascript:;" data-repeater-create 
                                                                                class="btn btn-text-dark-50 btn-icon-primary btn-hover-icon-danger btn-tambah-desa font-weight-bold btn-hover-bg-light mr-3">
                                                                                    <i class="flaticon2-plus-1"></i>Tambah Desa</a>
                                                                            </div>
                                                                        </div>
                                                                        <div data-repeater-list>
                                                                            <div class="form-group col-12 col-lg-12 d-flex pl-0" data-repeater-item>
                                                                                <div class="col-6 pl-0">
                                                                                    <select name="id_desa" class="form-control desa-select" required>
                                                                                        <option value="" selected disabled>Pilih Desa/Kelurahan</option>
                                                                                        @foreach($desas AS $s)
                                                                                            <option value="{{$s->id}}">{{$s->nama}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-5 pl-0">
                                                                                    <a href="javascript:;" data-repeater-delete
                                                                                    class="btn  btn-danger btn-sm  font-weight-bold  mr-3">
                                                                                        <i class="flaticon2-trash pr-0"></i></a>
                                                                                </div>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-12 col-lg-6"> 
                                                                    <label>Pagu (Rp)</label>
                                                                    <input name="pagu" type="number"
                                                                        min="0"
                                                                        value=""
                                                                        class="form-control"
                                                                        placeholder="" required>
                                                                </div>
                                                                <div class="form-group col-12 col-lg-6"> 
                                                                    <label>Keterangan</label>
                                                                    <input name="keterangan" type="text"
                                                                        class="form-control"
                                                                        placeholder="" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-1 d-flex flex-column justify-content-center align-items-center">
                                                                <a href="javascript:;" data-repeater-delete
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
                            </div>
                            <div class="card-footer d-flex">
                                <button type="submit" class="btn btn-sm btn-light-primary font-weight-bold mr-6">
                                <span class="svg-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                         viewBox="0 0 24 24" version="1.1">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                     version="1.1">
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
@push('script')
<script>
        $(document).ready(function () {
            // $('.desa-select').select2();
            webshim.activeLang('fi');
            webshims.setOptions('forms-ext', {
                replaceUI: 'auto',
                types: 'number'
            });
            webshims.polyfill('forms forms-ext');
            var initFvPaketDak = function (index){
                fv.addField('['+index+'][nama_paket]', {
                    validators: {
                        notEmpty: {
                            message: 'nama paket tidak boleh kosong'
                        }
                    }
                })
                fv.addField('['+index+'][volume]', {
                    validators: {
                        notEmpty: {
                            message: 'volume tidak boleh kosong'
                        }
                    }
                })
                fv.addField('['+index+'][satuan]', {
                    validators: {
                        notEmpty: {
                            message: 'satuan tidak boleh kosong'
                        }
                    }
                })
                fv.addField('['+index+'][pagu]', {
                    validators: {
                        notEmpty: {
                            message: 'pagu tidak boleh kosong'
                        }
                    }
                })
            }
            
            var initFvDesa = function (index,head){
                fv.addField('['+head+'][]['+index+'][id_desa]', {
                    validators: {
                        notEmpty: {
                            message: 'Desa/Keluarahan tidak boleh kosong'
                        }
                    }
                })
                
            }

            axios.get('{{route('api.dau.find-paket',[$uuid_sd])}}')
            .then(function (res){
                for (key in res.data.response) {
                    var el = $('[name=' + key + ']');
                    if (el.length) {
                        el.val(res.data.response[key])
                    }
                }
                res.data.response.paket_dau.forEach(function (val,i){
                    if (i > 0){
                        $('#btn-tambah-paket-dau').click();
                    }
                    for (var key in val){
                        if(key=='paket_dau_lokasi'){
                                
                            val[key].forEach(function (vald,x){
                                    if (x > 0){
                                        $('.btn-tambah-desa')[i].click();
                                    }
                                    for (var keyd in vald){
                                        
                                        if ($('#desa [name="['+i+'][]['+x+']['+keyd+']"]').length)
                                            $('#desa [name="['+i+'][]['+x+']['+keyd+']"]').val(vald[keyd]);
                                    }
                                })
                            }

                        if ($('#paket-dau [name="['+i+']['+key+']"]').length)
                            $('#paket-dau [name="['+i+']['+key+']"]').val(val[key])

                            
                        
                    }
                })
            })


            $('#paket-dau').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                repeaters: [{
                    selector: '.desa',
                    initEmpty: false,

                    defaultValues: {
                        'text-input': 'foo'
                    },

                    show: function () {
                        $(this).slideDown();
                        var head = $('#paket-dau [data-repeater-item]').length - 1;
                        var index = $('#desa [data-repeater-item]').length - 1;
                        initFvDesa(index,head)
                        $(this).updatePolyfill();
                    },

                    hide: function (deleteElement) {
                        var index = $('#desa [data-repeater-item]').length - 1;
                        var head = $('#paket-dau [data-repeater-item]').length - 1;
                        $(this).slideUp(deleteElement);
                        fv.removeField('['+head+'][]['+index+'][id_desa]')
                        setTimeout(function (){
                            initFvDesa(index-1,head)
                        },500)
                    },
                    isFirstItemUndeletable: true
                }],

                show: function () {
                    $(this).slideDown();
                    var index = $('#paket-dau [data-repeater-item]').length - 1;
                    initFvPaketDak(index)
                    $(this).updatePolyfill();
                },

                hide: function (deleteElement) {
                    var index = $('#paket-dau [data-repeater-item]').length - 1;
                    $(this).slideUp(deleteElement);
                    fv.removeField('['+index+'][nama_paket]')
                    fv.removeField('['+index+'][volume]')
                    fv.removeField('['+index+'][satuan]')
                    fv.removeField('['+index+'][pagu]')
                    setTimeout(function (){
                        initFvPaketDak(index-1)
                    },500)
                },
                isFirstItemUndeletable: true
            });
            

            // $(document).on('keyup mouseup input', '[name*="[pagu]"],  [name*="[pendampingan]"]', function () {
            //     var ang = 0;
            //     var pen = 0;
            //     var swa = 0;
            //     var kon = 0;
            //     var total = 0;
            //     var anggaran = $('[name*="[pagu]');
            //     var nilai_pagu = $('[name*=nilai_pagu_dau]').val()
            //     anggaran.each(function (i, el) {
            //             ang = parseInt($(el).val()) > 0 ? parseInt($(el).val()) : 0;
            //             pen = $('[name="['+i+'][pendampingan]"]').val() > 0 ? parseInt( $('[name="['+i+'][pendampingan]"]').val()) : 0;
            //             total = parseInt(ang) + parseInt(pen) ;
            //             // $('[name="['+i+'][total_biaya]"]').val(total)
            //     })
            //     var new_total = total-nilai_pagu;
            //     if (total > nilai_pagu) {
            //         // $(this).val(0);
            //     }
            // })
            var fv = FormValidation.formValidation(
                document.getElementById('paket-form'),
                {
                    fields: {
                        '[0][nama_paket]': {
                            validators: {
                                notEmpty: {
                                    message: 'nama paket tidak boleh kosong'
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
                        '[0][pagu]': {
                            validators: {
                                notEmpty: {
                                    message: 'anggaran boleh kosong'
                                }
                            }
                        },
                        '[0][][0][id_desa]': {
                            validators: {
                                notEmpty: {
                                    message: 'Desa boleh kosong'
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
                var state = 'Simpan';
                var additional_info = ''
                if ($('[name=uuid]').val() != '') {
                    state = 'Update'
                    additional_info = '<br>Mengupdate Data DAU akan me-Reset data <b>Realisasi DAU</b>.';
                }
                Swal.fire({
                    title: 'Perhatian!!',
                    html: state + ' Data Perencanaan?'+additional_info,
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: state,
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var action = $('#paket-form').attr('action')
                        var data = $('#paket-form').serialize();
                        var el_uuid_pd = $('#paket-dau [name*=uuid]');
                        el_uuid_pd.each(function (i, el) {
                            data += '&uuid_pd[' + i + ']=' + $(el).val()
                        })
                        var el_nama_paket = $('[name*=nama_paket]');
                        el_nama_paket.each(function (i, el) {
                            data += '&nama_paket[' + i + ']=' + $(el).val()
                            var el_id_desa = $('[name*=id_desa]').filter('[name^="['+i+']"]');
                            el_id_desa.each(function (x, ex) {
                                data += '&id_desa[' + i + '][' + x + ']=' + $(ex).val()
                            })
                        })
                        var el_volume = $('[name*=volume]');
                        el_volume.each(function (i, el) {
                            data += '&volume[' + i + ']=' + $(el).val()
                        })
                        var el_keterangan = $('[name*=keterangan]');
                        el_keterangan.each(function (i, el) {
                            data += '&keterangan[' + i + ']=' + $(el).val()
                        })
                        var el_satuan = $('[name*=satuan]');
                        el_satuan.each(function (i, el) {
                            data += '&satuan[' + i + ']=' + $(el).val()
                        })
                        var el_pagu = $('[name*=pagu]');
                        el_pagu.each(function (i, el) {
                            data += '&pagu[' + i + ']=' + $(el).val()
                        })
                        
                        
                        
                        console.log(data);
                        axios.post(action, data)
                            .then(function () {
                                Swal.fire('Sukses!', 'Berhasil Menyimpan Data Perencanaan', 'success')
                                window.location.href = '{{route('kegiatan.dau')}}'
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
