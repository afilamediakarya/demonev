@extends('layout/app')

@section('title', 'Target')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Monitoring & Evaluasi</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{url('monitoring-dan-evaluasi/target')}}" class="">Evaluasi Target </a>
        </li>
        <li class="breadcrumb-item">
            <a href="" class="">Atur Target Pelaksanaan </a>
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
                    <form id="target-form" action="{{route('api.dpa.target.update',['uuid' => $dpa->uuid])}}"
                          method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="nilai_pagu_dpa" value="{{$dpa->nilai_pagu_dpa}}">
                        <div class="card card-custom card-fit card-border">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="card-label">Detail Kegiatan</h3>
                                </div>
                            </div>
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
                                                    <p class="font-size-lg">Rp {{$dpa->nilai_pagu_rp}}</p>
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
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="width:30%">PERIODE</th>
                                                <th style="width:30%">TARGET KEUANGAN (RP)</th>
                                                <th style="width:20%">PRESENTASE</th>
                                                <th style="width:20%">FISIK INPUT</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($dpa->Target AS $target)
                                                <tr>
                                                    <td style="vertical-align:middle">Triwulan {{$target->periode}}</td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">RP</span>
                                                                </div>
                                                                <input data-periode="{{$target->periode}}"
                                                                       name="target_keuangan[{{$target->periode}}]"
                                                                       min="0"
                                                                       type="number" class="form-control form-control-sm"
                                                                       value="{{$target->target_keuangan}}"
                                                                       aria-label="" required>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="input-group input-group-sm">
                                                                <input data-periode="{{$target->periode}}"
                                                                       name="persentase[{{$target->periode}}]" type="number"
                                                                       min="0"
                                                                       class="form-control"
                                                                       placeholder="Persentase"
                                                                       value="{{$target->persentase}}"
                                                                       step="0,01";
                                                                       aria-describedby="basic-addon2" required readonly>
                                                                <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                %
                                                            </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group mb-0">
                                                            <input data-periode="{{$target->periode}}"
                                                                   name="target_fisik[{{$target->periode}}]"
                                                                   min="0"
                                                                   type="number" class="form-control form-control-sm"
                                                                   value="{{$target->target_fisik}}"
                                                                   placeholder="Fisik Input" required>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
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
            var total_pagu = $('[name=nilai_pagu_dpa]').val();
            $('[name*=target_keuangan]').on('keyup mouseup input', function () {
                var total_terinput = 0;
                var periode = $(this).data('periode');
                var value = $(this).val();
                if (value < 0){
                    $(this).val(0)
                    value = 0;
                }
                $('[name*=target_keuangan]:not([data-periode=' + periode + '])').each(function (i, el) {
                    total_terinput += $(el).val() ? parseInt($(el).val()) : 0;
                })
                var new_total = total_pagu - total_terinput;
                if (value > new_total) {
                    $(this).val(new_total);
                    value = new_total;
                }
                var persentase = parseFloat(value / total_pagu * 100);
                $('[name="persentase[' + periode + ']"]').val(persentase.toFixed(2));
                // $('[name="persentase[' + periode + ']"]').val(roundToTwo(persentase));
            })
            $('[name*=target_fisik]').on('keyup mouseup input', function () {
                var total_fisik_terinput = 0;
                var periode = $(this).data('periode');
                var value = $(this).val();
                if (value < 0){
                    $(this).val(0)
                    value = 0;
                }
                $('[name*=target_fisik]:not([data-periode=' + periode + '])').each(function (i, el) {
                    total_fisik_terinput += $(el).val() ? parseInt($(el).val()) : 0;
                })
                var new_total = 100 - total_fisik_terinput;
                if (value > new_total) {
                    $(this).val(new_total);
                }
            })
            FormValidation.formValidation(
                document.getElementById('target-form'),
                {
                    fields: {
                        'target_keuangan[1]': {
                            validators: {
                                notEmpty: {
                                    message: 'Target Keuangan Triwulan 1 tidak boleh kosong'
                                }
                            }
                        },
                        'target_keuangan[2]': {
                            validators: {
                                notEmpty: {
                                    message: 'Target Keuangan Triwulan 2 tidak boleh kosong'
                                }
                            }
                        },
                        'target_keuangan[3]': {
                            validators: {
                                notEmpty: {
                                    message: 'Target Keuangan Triwulan 3 tidak boleh kosong'
                                }
                            }
                        },
                        'target_keuangan[4]': {
                            validators: {
                                notEmpty: {
                                    message: 'Target Keuangan Triwulan 3 tidak boleh kosong'
                                }
                            }
                        },
                        'persentase[1]': {
                            validators: {
                                notEmpty: {
                                    message: 'Persentase Triwulan 1 tidak boleh kosong'
                                }
                            }
                        },
                        'persentase[2]': {
                            validators: {
                                notEmpty: {
                                    message: 'Persentase Triwulan 2 tidak boleh kosong'
                                }
                            }
                        },
                        'persentase[3]': {
                            validators: {
                                notEmpty: {
                                    message: 'Persentase Triwulan 3 tidak boleh kosong'
                                }
                            }
                        },
                        'persentase[4]': {
                            validators: {
                                notEmpty: {
                                    message: 'Persentase Triwulan 3 tidak boleh kosong'
                                }
                            }
                        },
                        'target_fisik[1]': {
                            validators: {
                                notEmpty: {
                                    message: 'Target Fisik Triwulan 1 tidak boleh kosong'
                                }
                            }
                        },
                        'target_fisik[2]': {
                            validators: {
                                notEmpty: {
                                    message: 'Target Fisik Triwulan 2 tidak boleh kosong'
                                }
                            }
                        },
                        'target_fisik[3]': {
                            validators: {
                                notEmpty: {
                                    message: 'Target Fisik Triwulan 3 tidak boleh kosong'
                                }
                            }
                        },
                        'target_fisik[4]': {
                            validators: {
                                notEmpty: {
                                    message: 'Target Fisik Triwulan 3 tidak boleh kosong'
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
                Swal.fire({
                    title: 'Perhatian!!',
                    text: 'Simpan Data Target?',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Simpan',
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var action = $('#target-form').attr('action')
                        var data = $('#target-form').serialize();
                        axios.post(action, data)
                            .then(function () {
                                Swal.fire('Sukses!', 'Berhasil Menyimpan Data Target', 'success')
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

        function roundToTwo(num) {    
            var result=(Math.round(num + "e+2")  + "e-2");
            return result;
        }
    </script>
    
@endpush
