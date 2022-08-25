@extends('layout/app')

@section('title', 'Target')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Laporan</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">DAK</a>
        </li>
    </ul>
@endsection

@section('style')
    <style>
        /* .table tr>td{
            white-space: nowrap !important;
            padding : 15px !important;
        } */

        tr>th{
            vertical-align : top !important;
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
                                    <h3 class="card-label">Laporan DAK</h3>
                                </div>
                                <form class="bg-success-o-55 py-5 rounded row mb-5">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Jenis DAK</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">DAK NON FISIK</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Periode</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Triwulan I</option>
                                                <option value="">Triwulan II</option>
                                                <option value="">Triwulan III</option>
                                                <option value="">Triwulan IV</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Tanggal Cetak</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" id="kt_datepicker_2" readonly="readonly" placeholder="Select date" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-calendar-check-o"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Unit Kerja</label>
                                            <select name="" id="" class="form-control">
                                                <option value="">Triwulan I</option>
                                                <option value="">Triwulan II</option>
                                                <option value="">Triwulan III</option>
                                                <option value="">Triwulan IV</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">&nbsp;</label>
                                            <button href="#" class="btn btn-primary mb-3 form-control font-weight-bold mr-2">
                                                <span class="svg-icon">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M3.75 3.75V20.25H20.25V3.75H3.75ZM5.25 5.25H9V9H5.25V5.25ZM10.5 5.25H13.5V9H10.5V5.25ZM15 5.25H18.75V9H15V5.25ZM5.25 10.5H9V13.5H5.25V10.5ZM10.5 10.5H13.5V13.5H10.5V10.5ZM15 10.5H18.75V13.5H15V10.5ZM5.25 15H9V18.75H5.25V15ZM10.5 15H13.5V18.75H10.5V15ZM15 15H18.75V18.75H15V15Z" fill="white"/>
                                                    </svg>
                                                </span> Tampilkan Data
                                            </button>
                                            <!-- <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password"> -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                                <div class="row my-3 justify-content-between">
                                    <span class="d-block text-muted pt-2 font-size-sm">Menampilkan 100 Data</span>
                                    <div class="">
                                        <a class="btn btn-default btn-xs">
                                            <span class="svg-icon">
                                                <svg width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0.25 0.625V10.375H7.75V3.09766L5.27734 0.625H0.25ZM1 1.375H4.75V3.625H7V9.625H1V1.375ZM5.5 1.90234L6.47266 2.875H5.5V1.90234ZM2.125 4.375L3.55469 6.4375L2.125 8.5H3.02734L4 7.07031L4.97266 8.5H5.875L4.44531 6.4375L5.875 4.375H4.97266L4 5.80469L3.02734 4.375H2.125Z" fill="#219653"/>
                                                </svg>
                                            </span> Export Excel
                                        </a>
                                        <a class="btn btn-default btn-xs">
                                            <span class="svg-icon">
                                                <svg width="8" height="11" viewBox="0 0 8 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.25 0.625V10.375H7.75V0.625H0.25ZM1 1.375H7V9.625H1V1.375ZM3.77734 3.37891C3.64453 3.37891 3.53125 3.41797 3.4375 3.49609C3.35938 3.55859 3.30469 3.65234 3.27344 3.77734C3.22656 3.95703 3.23047 4.17188 3.28516 4.42188C3.31641 4.5625 3.40234 4.79297 3.54297 5.11328L3.63672 5.33594C3.62109 5.40625 3.60156 5.50781 3.57812 5.64062C3.53906 5.86719 3.49609 6.04297 3.44922 6.16797C3.41016 6.26953 3.34766 6.39844 3.26172 6.55469C3.20703 6.65625 3.16797 6.73438 3.14453 6.78906C3.08984 6.8125 3.00391 6.83984 2.88672 6.87109C2.66797 6.94141 2.51953 7 2.44141 7.04688C2.20703 7.19531 2.04688 7.34766 1.96094 7.50391C1.90625 7.60547 1.88281 7.71875 1.89062 7.84375C1.89844 7.96875 1.9375 8.08203 2.00781 8.18359C2.07812 8.28516 2.17188 8.35938 2.28906 8.40625C2.41406 8.45312 2.53516 8.45703 2.65234 8.41797C2.82422 8.35547 3 8.20703 3.17969 7.97266C3.24219 7.89453 3.32031 7.74219 3.41406 7.51562C3.46875 7.38281 3.51172 7.28516 3.54297 7.22266L3.74219 7.14062C3.875 7.08594 3.98438 7.05078 4.07031 7.03516C4.15625 7.01953 4.26953 7.00781 4.41016 7C4.49609 7 4.56641 6.99609 4.62109 6.98828C4.64453 7.01953 4.67969 7.06641 4.72656 7.12891C4.78906 7.22266 4.83594 7.28516 4.86719 7.31641C5.07812 7.49609 5.28125 7.59375 5.47656 7.60938C5.59375 7.61719 5.70703 7.58984 5.81641 7.52734C5.92578 7.45703 6.01172 7.36719 6.07422 7.25781H6.08594V7.24609C6.14844 7.12891 6.17969 7.01953 6.17969 6.91797C6.17969 6.79297 6.13281 6.68359 6.03906 6.58984C5.96875 6.51172 5.88281 6.45703 5.78125 6.42578C5.70312 6.39453 5.60156 6.37109 5.47656 6.35547C5.40625 6.34766 5.28906 6.35547 5.125 6.37891C5.01562 6.39453 4.9375 6.40234 4.89062 6.40234L4.75 6.22656C4.58594 6.03125 4.46875 5.86328 4.39844 5.72266C4.36719 5.66016 4.33203 5.57422 4.29297 5.46484C4.26953 5.38672 4.24609 5.32422 4.22266 5.27734C4.23828 5.21484 4.26172 5.11719 4.29297 4.98438C4.35547 4.76562 4.39062 4.60938 4.39844 4.51562C4.41406 4.21875 4.39062 3.98047 4.32812 3.80078C4.28125 3.67578 4.21094 3.57422 4.11719 3.49609C4.02344 3.41797 3.91406 3.37891 3.78906 3.37891H3.77734ZM4.02344 6.15625C4.04688 6.20312 4.08594 6.26172 4.14062 6.33203C4.1875 6.38672 4.22266 6.42969 4.24609 6.46094C4.21484 6.46875 4.16797 6.47266 4.10547 6.47266C4.04297 6.47266 3.99219 6.47656 3.95312 6.48438L3.90625 6.50781L3.97656 6.35547C3.98438 6.33203 3.99219 6.29688 4 6.25L4.02344 6.15625ZM5.40625 6.91797C5.48438 6.92578 5.54688 6.94141 5.59375 6.96484V6.97656C5.57031 7.00781 5.55469 7.02734 5.54688 7.03516C5.53906 7.04297 5.52734 7.04688 5.51172 7.04688C5.48047 7.04688 5.41016 7.00781 5.30078 6.92969L5.40625 6.91797ZM2.78125 7.50391C2.77344 7.51172 2.76172 7.53516 2.74609 7.57422C2.73828 7.60547 2.73047 7.625 2.72266 7.63281C2.62891 7.75781 2.54688 7.83594 2.47656 7.86719C2.47656 7.86719 2.47656 7.86328 2.47656 7.85547H2.46484L2.44141 7.82031L2.46484 7.77344C2.51172 7.69531 2.60156 7.61328 2.73438 7.52734L2.78125 7.50391Z" fill="#EB5757"/>
                                                </svg>
                                            </span> Export Pdf
                                        </a>
                                        <a class="btn btn-default btn-xs">
                                            <span class="svg-icon">
                                                <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.375 0V2.625H1.625C1.32031 2.625 1.05469 2.73828 0.828125 2.96484C0.609375 3.18359 0.5 3.44531 0.5 3.75V7.5H2.375V9H7.625V7.5H9.5V3.75C9.5 3.44531 9.38672 3.18359 9.16016 2.96484C8.94141 2.73828 8.67969 2.625 8.375 2.625H7.625V0H2.375ZM3.125 0.75H6.875V2.625H3.125V0.75ZM1.625 3.375H8.375C8.48438 3.375 8.57422 3.41016 8.64453 3.48047C8.71484 3.55078 8.75 3.64062 8.75 3.75V6.75H7.625V5.25H2.375V6.75H1.25V3.75C1.25 3.64062 1.28516 3.55078 1.35547 3.48047C1.42578 3.41016 1.51562 3.375 1.625 3.375ZM2 3.75C1.89844 3.75 1.80859 3.78906 1.73047 3.86719C1.66016 3.9375 1.625 4.02344 1.625 4.125C1.625 4.22656 1.66016 4.31641 1.73047 4.39453C1.80859 4.46484 1.89844 4.5 2 4.5C2.10156 4.5 2.1875 4.46484 2.25781 4.39453C2.33594 4.31641 2.375 4.22656 2.375 4.125C2.375 4.02344 2.33594 3.9375 2.25781 3.86719C2.1875 3.78906 2.10156 3.75 2 3.75ZM3.125 6H6.875V8.25H3.125V6Z" fill="#2D2248"/>
                                                </svg>
                                            </span> Cetak Laporan
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="kt_datatable"> 
                                        <thead>
                                            <tr>
                                                <th rowspan="2">NO</th>
                                                <th rowspan="2">KODE</th>
                                                <th rowspan="2" style="white-space: nowrap">NAMA OPD</th>
                                                <th rowspan="2">JUMLAH DANA / DPA (RP)</th>
                                                <th rowspan="2">BOBOT</th>
                                                <th rowspan="2">REALISASI KEUANGAN (RP)</th>
                                                <th colspan="2">REALISASI (%)</th>
                                                <th colspan="2">PERSENTASE TERTIMBANG</th>
                                                <th rowspan="2">PPTK PELAKASANA</th>
                                            </tr>
                                            <tr>
                                                <th>FISIK</th>
                                                <th>KEUANGAN</th>
                                                <th>FISIK (%)</th>
                                                <th>KEUANGAN (%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td rowspan="3">1</td>
                                                <td>5.01.0.00.0.00.0000</td>
                                                <td>Dinas Peternakan</td>
                                                <td>59.500.000</td>
                                                <td>59.500.000</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>5.01.0.00.0.00.0000</td>
                                                <td>Dinas Peternakan</td>
                                                <td>59.500.000</td>
                                                <td>59.500.000</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>5.01.0.00.0.00.0000</td>
                                                <td>Dinas Peternakan</td>
                                                <td>59.500.000</td>
                                                <td>59.500.000</td>
                                                <td>0.01</td>
                                                <td>800.000</td>
                                                <td>0</td>
                                                <td>13.43</td>
                                                <td>0</td>
                                                <td>800.000</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-right">JUMLAH</td>
                                                <td>59.500.000</td>
                                                <td>59.500.000</td>
                                                <td>0.01</td>
                                                <td>800.000</td>
                                                <td>0</td>
                                                <td>13.43</td>
                                                <td>0</td>
                                                <td>800.000</td>
                                            </tr>
                                        </tbody>
                                    </table>
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
    init: function() {
        demos(); 
    }
};
}();

jQuery(document).ready(function() {    
    KTBootstrapDatepicker.init();
});
    </script>
@endpush
