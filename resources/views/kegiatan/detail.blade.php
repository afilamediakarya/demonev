@extends('layout/app')

@section('title', 'Target')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Kegiatan</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('kegiatan.dpa')}}" class="">DPA </a>
        </li>
        <li class="breadcrumb-item">
            <a href="" class="">Detail </a>
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
                                                <p class="font-size-sm">Sumber Dana</p>
                                                @foreach($dpa->SumberDanaDpa AS $sumber_dana)
                                                    <p class="font-size-lg">Jenis Belanja : {{$sumber_dana->jenis_belanja}}</p>
                                                    <p class="font-size-lg">Sumber Dana : {{$sumber_dana->sumber_dana}}</p>
                                                    <p class="font-size-lg">Metode Pelaksanaan : {{$sumber_dana->metode_pelaksanaan}}</p>
                                                    <p class="font-size-lg">Nilai Pagu : Rp {{$sumber_dana->nilai_pagu_rp}}</p>
                                                    <hr>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-4 mt-4">
                                            <div class="form-group">
                                                <p class="font-size-sm">Output</p>
                                                @foreach($dpa->TolakUkur AS $tolak_ukur)
                                                    <p class="font-size-lg">{{$tolak_ukur->tolak_ukur}} : {{$tolak_ukur->volume}} ({{$tolak_ukur->satuan}})</p>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-4 mt-4">
                                            <div class="form-group">
                                                <p class="font-size-sm">Total Pagu</p>
                                                <p class="font-size-lg">Rp {{$dpa->nilai_pagu_rp}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    </script>
@endpush
