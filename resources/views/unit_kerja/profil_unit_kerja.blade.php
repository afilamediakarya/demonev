@extends('layout/app')

@section('title', 'Profil Unit Kerja')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Unit Kerja</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">Profil Unit Kerja</a>
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
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                @foreach($unit_kerja AS $item)
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <h4 class="card-title align-items-start flex-column">
                            <span class="font-weight-bolder text-dark">Profil Unit Kerja : {{$item->nama_unit_kerja}}</span>
                        </h4>
                        <div class="row col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="d-flex card-title align-items-start flex-column">
                                        <span class="form-text text-muted font-size-xs">Kode Unit Kerja</span>
                                        <span class="card-label mt-2">{{$item->kode_unit_kerja}}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="d-flex card-title align-items-start flex-column">
                                        <span class="form-text text-muted font-size-xs">Nama Unit Kerja</span>
                                        <span class="card-label mt-2">{{$item->nama_unit_kerja}}</span>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <p class="d-flex card-title align-items-start flex-column m-0">
                                        <span class="form-text text-muted font-size-xs">Bidang Urusan</span>
                                    </p>
                                    <div class="mt-2">
                                        @foreach($item->BidangUrusan AS $bidang_urusan)
                                        <label class="label label-md label-success label-inline m-1">{{$bidang_urusan->nama_bidang_urusan}}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title align-items-start flex-column mt-10">
                            <span class="font-weight-bolder text-dark">Detail Kepala Unit Kerja</span>
                        </h4>
                        <div class="row col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="d-flex card-title align-items-start flex-column">
                                        <span class="form-text text-muted font-size-xs">NIP</span>
                                        <span class="card-label mt-2">{{$item->nip_kepala}}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="d-flex card-title align-items-start flex-column">
                                        <span class="form-text text-muted font-size-xs">Nama </span>
                                        <span class="card-label mt-2">{{$item->nama_kepala}}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="d-flex card-title align-items-start flex-column">
                                        <span class="form-text text-muted font-size-xs">Pangkat </span>
                                        <span class="card-label mt-2">{{$item->pangkat_kepala}}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="d-flex card-title align-items-start flex-column">
                                        <span class="form-text text-muted font-size-xs">Status </span>
                                        <span class="card-label mt-2">{{$item->status_kepala}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection



@section('add_script')

@endsection
