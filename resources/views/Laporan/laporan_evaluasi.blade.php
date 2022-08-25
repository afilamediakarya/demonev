@extends('layout/app')

@section('title', 'Laporan Evaluasi')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Laporan</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">REALISASI</a>
        </li>
    </ul>
@endsection
<!-- 37751550 cph2380 -->
@section('style')
    <style>
        .table tr > th:nth-child(3) {
            /* white-space: nowrap !important; */
            width: 13%
        }

        tr > th {
            vertical-align: top !important;
        }
    </style>
@endsection


@section('main_page')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <!--end::Info-->
            </div>
        </div>
        <!--end::Entry-->
        <div class="content d-flex flex-column flex-column-fluid p-0" id="kt_content">
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <div class="col">
                        <div class="card card-custom card-stretch example example-compact" id="kt_page_stretched_card">
                            <div class="card-header d-flex flex-column" kt-hidden-height="74" style="">
                                <div class="card-title my-7">
                                    <h3 class="card-label">Laporan Evaluasi</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row my-3 justify-content-between">
                                    <span class="d-block text-muted pt-2 font-size-sm"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>
    </div>
@endsection


@push('script')
    <script>
        $('#export-excel').click(function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            var param = $('#laporan-form').serialize();
            window.open(url+'?'+param, '_blank');
        })
        $('[name=unit_kerja],[name=sumber_dana]').select2();
        var KTBootstrapDatepicker = function () {

            var arrows;
            if (KTUtil.isRTL()) {
                arrows = {
                    leftArrow: '<i class="la la-angle-right"></i>',
                    rightArrow: '<i class="la la-angle-left"></i>'
                }
            } else {
                arrows = {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            }

// Private functions
            var demos = function () {
                // input group layout
                $('#kt_datepicker_2, #kt_datepicker_2_validate').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: arrows
                });

                // input group layout for modal demo
                $('#kt_datepicker_2_modal').datepicker({
                    rtl: KTUtil.isRTL(),
                    todayHighlight: true,
                    orientation: "bottom left",
                    templates: arrows
                });
            }

            return {
                // public functions
                init: function () {
                    demos();
                }
            };
        }();

        jQuery(document).ready(function () {
            KTBootstrapDatepicker.init();
        });
    </script>
@endpush
