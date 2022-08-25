@extends('layout/app')

@section('title', 'Program')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Renstra</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="" class="">Program</a>
        </li>
    </ul>
@endsection
@section('style')
    <style type="text/css">.apexcharts-canvas {
            position: relative;
            user-select: none;
            /* cannot give overflow: hidden as it will crop tooltips which overflow outside chart area */
        }


        /* scrollbar is not visible by default for legend, hence forcing the visibility */
        .apexcharts-canvas ::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 6px;
        }

        .apexcharts-canvas ::-webkit-scrollbar-thumb {
            border-radius: 4px;
            background-color: rgba(0, 0, 0, .5);
            box-shadow: 0 0 1px rgba(255, 255, 255, .5);
            -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
        }


        .apexcharts-inner {
            position: relative;
        }

        .apexcharts-text tspan {
            font-family: inherit;
        }

        .legend-mouseover-inactive {
            transition: 0.15s ease all;
            opacity: 0.20;
        }

        .apexcharts-series-collapsed {
            opacity: 0;
        }

        .apexcharts-tooltip {
            border-radius: 5px;
            box-shadow: 2px 2px 6px -4px #999;
            cursor: default;
            font-size: 14px;
            left: 62px;
            opacity: 0;
            pointer-events: none;
            position: absolute;
            top: 20px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            white-space: nowrap;
            z-index: 12;
            transition: 0.15s ease all;
        }

        .apexcharts-tooltip.apexcharts-active {
            opacity: 1;
            transition: 0.15s ease all;
        }

        .apexcharts-tooltip.apexcharts-theme-light {
            border: 1px solid #e3e3e3;
            background: rgba(255, 255, 255, 0.96);
        }

        .apexcharts-tooltip.apexcharts-theme-dark {
            color: #fff;
            background: rgba(30, 30, 30, 0.8);
        }

        .apexcharts-tooltip * {
            font-family: inherit;
        }


        .apexcharts-tooltip-title {
            padding: 6px;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .apexcharts-tooltip.apexcharts-theme-light .apexcharts-tooltip-title {
            background: #ECEFF1;
            border-bottom: 1px solid #ddd;
        }

        .apexcharts-tooltip.apexcharts-theme-dark .apexcharts-tooltip-title {
            background: rgba(0, 0, 0, 0.7);
            border-bottom: 1px solid #333;
        }

        .apexcharts-tooltip-text-value,
        .apexcharts-tooltip-text-z-value {
            display: inline-block;
            font-weight: 600;
            margin-left: 5px;
        }

        .apexcharts-tooltip-text-z-label:empty,
        .apexcharts-tooltip-text-z-value:empty {
            display: none;
        }

        .apexcharts-tooltip-text-value,
        .apexcharts-tooltip-text-z-value {
            font-weight: 600;
        }

        .apexcharts-tooltip-marker {
            width: 12px;
            height: 12px;
            position: relative;
            top: 0px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .apexcharts-tooltip-series-group {
            padding: 0 10px;
            display: none;
            text-align: left;
            justify-content: left;
            align-items: center;
        }

        .apexcharts-tooltip-series-group.apexcharts-active .apexcharts-tooltip-marker {
            opacity: 1;
        }

        .apexcharts-tooltip-series-group.apexcharts-active,
        .apexcharts-tooltip-series-group:last-child {
            padding-bottom: 4px;
        }

        .apexcharts-tooltip-series-group-hidden {
            opacity: 0;
            height: 0;
            line-height: 0;
            padding: 0 !important;
        }

        .apexcharts-tooltip-y-group {
            padding: 6px 0 5px;
        }

        .apexcharts-tooltip-candlestick {
            padding: 4px 8px;
        }

        .apexcharts-tooltip-candlestick > div {
            margin: 4px 0;
        }

        .apexcharts-tooltip-candlestick span.value {
            font-weight: bold;
        }

        .apexcharts-tooltip-rangebar {
            padding: 5px 8px;
        }

        .apexcharts-tooltip-rangebar .category {
            font-weight: 600;
            color: #777;
        }

        .apexcharts-tooltip-rangebar .series-name {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .apexcharts-xaxistooltip {
            opacity: 0;
            padding: 9px 10px;
            pointer-events: none;
            color: #373d3f;
            font-size: 13px;
            text-align: center;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
            background: #ECEFF1;
            border: 1px solid #90A4AE;
            transition: 0.15s ease all;
        }

        .apexcharts-xaxistooltip.apexcharts-theme-dark {
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.5);
            color: #fff;
        }

        .apexcharts-xaxistooltip:after,
        .apexcharts-xaxistooltip:before {
            left: 50%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .apexcharts-xaxistooltip:after {
            border-color: rgba(236, 239, 241, 0);
            border-width: 6px;
            margin-left: -6px;
        }

        .apexcharts-xaxistooltip:before {
            border-color: rgba(144, 164, 174, 0);
            border-width: 7px;
            margin-left: -7px;
        }

        .apexcharts-xaxistooltip-bottom:after,
        .apexcharts-xaxistooltip-bottom:before {
            bottom: 100%;
        }

        .apexcharts-xaxistooltip-top:after,
        .apexcharts-xaxistooltip-top:before {
            top: 100%;
        }

        .apexcharts-xaxistooltip-bottom:after {
            border-bottom-color: #ECEFF1;
        }

        .apexcharts-xaxistooltip-bottom:before {
            border-bottom-color: #90A4AE;
        }

        .apexcharts-xaxistooltip-bottom.apexcharts-theme-dark:after {
            border-bottom-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-xaxistooltip-bottom.apexcharts-theme-dark:before {
            border-bottom-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-xaxistooltip-top:after {
            border-top-color: #ECEFF1
        }

        .apexcharts-xaxistooltip-top:before {
            border-top-color: #90A4AE;
        }

        .apexcharts-xaxistooltip-top.apexcharts-theme-dark:after {
            border-top-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-xaxistooltip-top.apexcharts-theme-dark:before {
            border-top-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-xaxistooltip.apexcharts-active {
            opacity: 1;
            transition: 0.15s ease all;
        }

        .apexcharts-yaxistooltip {
            opacity: 0;
            padding: 4px 10px;
            pointer-events: none;
            color: #373d3f;
            font-size: 13px;
            text-align: center;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
            background: #ECEFF1;
            border: 1px solid #90A4AE;
        }

        .apexcharts-yaxistooltip.apexcharts-theme-dark {
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.5);
            color: #fff;
        }

        .apexcharts-yaxistooltip:after,
        .apexcharts-yaxistooltip:before {
            top: 50%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .apexcharts-yaxistooltip:after {
            border-color: rgba(236, 239, 241, 0);
            border-width: 6px;
            margin-top: -6px;
        }

        .apexcharts-yaxistooltip:before {
            border-color: rgba(144, 164, 174, 0);
            border-width: 7px;
            margin-top: -7px;
        }

        .apexcharts-yaxistooltip-left:after,
        .apexcharts-yaxistooltip-left:before {
            left: 100%;
        }

        .apexcharts-yaxistooltip-right:after,
        .apexcharts-yaxistooltip-right:before {
            right: 100%;
        }

        .apexcharts-yaxistooltip-left:after {
            border-left-color: #ECEFF1;
        }

        .apexcharts-yaxistooltip-left:before {
            border-left-color: #90A4AE;
        }

        .apexcharts-yaxistooltip-left.apexcharts-theme-dark:after {
            border-left-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-yaxistooltip-left.apexcharts-theme-dark:before {
            border-left-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-yaxistooltip-right:after {
            border-right-color: #ECEFF1;
        }

        .apexcharts-yaxistooltip-right:before {
            border-right-color: #90A4AE;
        }

        .apexcharts-yaxistooltip-right.apexcharts-theme-dark:after {
            border-right-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-yaxistooltip-right.apexcharts-theme-dark:before {
            border-right-color: rgba(0, 0, 0, 0.5);
        }

        .apexcharts-yaxistooltip.apexcharts-active {
            opacity: 1;
        }

        .apexcharts-yaxistooltip-hidden {
            display: none;
        }

        .apexcharts-xcrosshairs,
        .apexcharts-ycrosshairs {
            pointer-events: none;
            opacity: 0;
            transition: 0.15s ease all;
        }

        .apexcharts-xcrosshairs.apexcharts-active,
        .apexcharts-ycrosshairs.apexcharts-active {
            opacity: 1;
            transition: 0.15s ease all;
        }

        .apexcharts-ycrosshairs-hidden {
            opacity: 0;
        }

        .apexcharts-selection-rect {
            cursor: move;
        }

        .svg_select_boundingRect, .svg_select_points_rot {
            pointer-events: none;
            opacity: 0;
            visibility: hidden;
        }

        .apexcharts-selection-rect + g .svg_select_boundingRect,
        .apexcharts-selection-rect + g .svg_select_points_rot {
            opacity: 0;
            visibility: hidden;
        }

        .apexcharts-selection-rect + g .svg_select_points_l,
        .apexcharts-selection-rect + g .svg_select_points_r {
            cursor: ew-resize;
            opacity: 1;
            visibility: visible;
        }

        .svg_select_points {
            fill: #efefef;
            stroke: #333;
            rx: 2;
        }

        .apexcharts-svg.apexcharts-zoomable.hovering-zoom {
            cursor: crosshair
        }

        .apexcharts-svg.apexcharts-zoomable.hovering-pan {
            cursor: move
        }

        .apexcharts-zoom-icon,
        .apexcharts-zoomin-icon,
        .apexcharts-zoomout-icon,
        .apexcharts-reset-icon,
        .apexcharts-pan-icon,
        .apexcharts-selection-icon,
        .apexcharts-menu-icon,
        .apexcharts-toolbar-custom-icon {
            cursor: pointer;
            width: 20px;
            height: 20px;
            line-height: 24px;
            color: #6E8192;
            text-align: center;
        }

        .apexcharts-zoom-icon svg,
        .apexcharts-zoomin-icon svg,
        .apexcharts-zoomout-icon svg,
        .apexcharts-reset-icon svg,
        .apexcharts-menu-icon svg {
            fill: #6E8192;
        }

        .apexcharts-selection-icon svg {
            fill: #444;
            transform: scale(0.76)
        }

        .apexcharts-theme-dark .apexcharts-zoom-icon svg,
        .apexcharts-theme-dark .apexcharts-zoomin-icon svg,
        .apexcharts-theme-dark .apexcharts-zoomout-icon svg,
        .apexcharts-theme-dark .apexcharts-reset-icon svg,
        .apexcharts-theme-dark .apexcharts-pan-icon svg,
        .apexcharts-theme-dark .apexcharts-selection-icon svg,
        .apexcharts-theme-dark .apexcharts-menu-icon svg,
        .apexcharts-theme-dark .apexcharts-toolbar-custom-icon svg {
            fill: #f3f4f5;
        }

        .apexcharts-canvas .apexcharts-zoom-icon.apexcharts-selected svg,
        .apexcharts-canvas .apexcharts-selection-icon.apexcharts-selected svg,
        .apexcharts-canvas .apexcharts-reset-zoom-icon.apexcharts-selected svg {
            fill: #008FFB;
        }

        .apexcharts-theme-light .apexcharts-selection-icon:not(.apexcharts-selected):hover svg,
        .apexcharts-theme-light .apexcharts-zoom-icon:not(.apexcharts-selected):hover svg,
        .apexcharts-theme-light .apexcharts-zoomin-icon:hover svg,
        .apexcharts-theme-light .apexcharts-zoomout-icon:hover svg,
        .apexcharts-theme-light .apexcharts-reset-icon:hover svg,
        .apexcharts-theme-light .apexcharts-menu-icon:hover svg {
            fill: #333;
        }

        .apexcharts-selection-icon,
        .apexcharts-menu-icon {
            position: relative;
        }

        .apexcharts-reset-icon {
            margin-left: 5px;
        }

        .apexcharts-zoom-icon,
        .apexcharts-reset-icon,
        .apexcharts-menu-icon {
            transform: scale(0.85);
        }

        .apexcharts-zoomin-icon,
        .apexcharts-zoomout-icon {
            transform: scale(0.7)
        }

        .apexcharts-zoomout-icon {
            margin-right: 3px;
        }

        .apexcharts-pan-icon {
            transform: scale(0.62);
            position: relative;
            left: 1px;
            top: 0px;
        }

        .apexcharts-pan-icon svg {
            fill: #fff;
            stroke: #6E8192;
            stroke-width: 2;
        }

        .apexcharts-pan-icon.apexcharts-selected svg {
            stroke: #008FFB;
        }

        .apexcharts-pan-icon:not(.apexcharts-selected):hover svg {
            stroke: #333;
        }

        .apexcharts-toolbar {
            position: absolute;
            z-index: 11;
            max-width: 176px;
            text-align: right;
            border-radius: 3px;
            padding: 0px 6px 2px 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .apexcharts-menu {
            background: #fff;
            position: absolute;
            top: 100%;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 3px;
            right: 10px;
            opacity: 0;
            min-width: 110px;
            transition: 0.15s ease all;
            pointer-events: none;
        }

        .apexcharts-menu.apexcharts-menu-open {
            opacity: 1;
            pointer-events: all;
            transition: 0.15s ease all;
        }

        .apexcharts-menu-item {
            padding: 6px 7px;
            font-size: 12px;
            cursor: pointer;
        }

        .apexcharts-theme-light .apexcharts-menu-item:hover {
            background: #eee;
        }

        .apexcharts-theme-dark .apexcharts-menu {
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
        }

        @media screen and (min-width: 768px) {
            .apexcharts-canvas:hover .apexcharts-toolbar {
                opacity: 1;
            }
        }

        .apexcharts-datalabel.apexcharts-element-hidden {
            opacity: 0;
        }

        .apexcharts-pie-label,
        .apexcharts-datalabels,
        .apexcharts-datalabel,
        .apexcharts-datalabel-label,
        .apexcharts-datalabel-value {
            cursor: default;
            pointer-events: none;
        }

        .apexcharts-pie-label-delay {
            opacity: 0;
            animation-name: opaque;
            animation-duration: 0.3s;
            animation-fill-mode: forwards;
            animation-timing-function: ease;
        }

        .apexcharts-canvas .apexcharts-element-hidden {
            opacity: 0;
        }

        .apexcharts-hide .apexcharts-series-points {
            opacity: 0;
        }

        .apexcharts-gridline,
        .apexcharts-annotation-rect,
        .apexcharts-tooltip .apexcharts-marker,
        .apexcharts-area-series .apexcharts-area,
        .apexcharts-line,
        .apexcharts-zoom-rect,
        .apexcharts-toolbar svg,
        .apexcharts-area-series .apexcharts-series-markers .apexcharts-marker.no-pointer-events,
        .apexcharts-line-series .apexcharts-series-markers .apexcharts-marker.no-pointer-events,
        .apexcharts-radar-series path,
        .apexcharts-radar-series polygon {
            pointer-events: none;
        }


        /* markers */

        .apexcharts-marker {
            transition: 0.15s ease all;
        }

        @keyframes opaque {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }


        /* Resize generated styles */

        @keyframes resizeanim {
            from {
                opacity: 0;
            }
            to {
                opacity: 0;
            }
        }

        .resize-triggers {
            animation: 1ms resizeanim;
            visibility: hidden;
            opacity: 0;
        }

        .resize-triggers,
        .resize-triggers > div,
        .contract-trigger:before {
            content: " ";
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        .resize-triggers > div {
            background: #eee;
            overflow: auto;
        }

        .contract-trigger:before {
            width: 200%;
            height: 200%;
        }
    </style>
@endsection


@section('main_page')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <a href="#" class="btn btn-primary font-weight-bolder" id="kt_quick_user_toggle">
                    <i class="flaticon-plus"></i>
                    Tambah Program
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
                    <div class="card card-custom">
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-checkable" id="kt_datatable"
                                       style="margin-top: 13px !important">
                                    <thead>
                                    <tr>
                                        <th>KODE</th>
                                        <th>GROUPING</th>
                                        <th>PROGRAM</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
    
                                    </tbody>
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
            <h4 class="font-weight-bold m-0">Tambah Program</h4>
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content">
            <!--begin::Wrapper-->
            <form id="data-form" action="{{route('api.renstra-program.create')}}" method="post">
                <input type="hidden" name="uuid">
                <input type="hidden" name="periode" value="2019-2023">
                <div class="offcanvas-wrapper mb-5 scroll-pull">
                    <div class="form-group">
                        <label>Sasaran
                            <span class="text-danger">*</span></label>
                        <select name="id_sasaran" id="id_sasaran" class="form-control" required>
                            <option value="">Pilih Sasaran</option>
                            @foreach($sasarans AS $s)
                                <option value="{{$s->id}}">{{$s->sasaran}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Program
                            <span class="text-danger">*</span></label>
                        <select name="id_program" id="id_program" class="form-control" required>
                            <option value="">Pilih Program</option>
                            @foreach($programs AS $s)
                                <option value="{{$s->id}}">{{$s->nama_program}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row p-0">
                        <div class="col-12 p-0">
                            <div class="row  p-0">
                                <div class="col-12 p-0">
                                    <div id="outcome" class="card card-custom border-0 card-fit"
                                        style="box-shadow:none">
                                        <div class="card-header border-0 pb-0">
                                            <div class="card-title">
                                                <h3 class="card-label">Outcome</h3>
                                            </div>
                                            <div class="card-toolbar">
                                                <a href="javascript:;" data-repeater-create="" id="btn-tambah-outcome"
                                                class="btn btn-text-dark-50 btn-icon-primary btn-hover-icon-danger font-weight-bold btn-hover-bg-light mr-3">
                                                    <i class="flaticon2-plus-1"></i>Tambah Outcome</a>
                                            </div>
                                        </div>
                                        <div data-repeater-list="">
                                            <div class="card-body py-0 row" data-repeater-item>

                                                <input name="out_uuid" type="hidden"
                                                        class="form-control"
                                                        placeholder="" required>
                                                <div class="form-group col-12 col-lg-12">
                                                    <label>Outcome</label>
                                                    <input name="outcome" type="text"
                                                        class="form-control"
                                                        placeholder="" required>
                                                </div>
                                                <div class="form-group col-6 col-lg-4">
                                                    <label>Volume</label>
                                                    <input name="volume" type="text"
                                                        class="form-control"
                                                        placeholder="" required>
                                                </div>
                                                <div class="form-group col-6 col-lg-6">
                                                    <label for="">Satuan</label>
                                                    <select name="satuan" class="form-control" required>
                                                        <option value="" selected disabled>Pilih Satuan</option>
                                                        
                                                            <option value="%">%</option>
                                                        
                                                    </select>
                                                </div>

                                                <div class="form-group col-6 col-lg-5">
                                                    <label>Capaian awal</label>
                                                    <input name="capaian_awal" type="text"
                                                        class="form-control"
                                                        placeholder="" required>
                                                </div>
                                            

                                                <div class="col-1 d-flex flex-column justify-content-center align-items-center">
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
            $("#id_sasaran").select2();
            $("#id_program").select2();
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
                    url: '{{route('api.renstra-program.data-table')}}',
                    type: "GET",
                    headers: {'X-XSRF-TOKEN': Cookies.get("XSRF-TOKEN")},
                },
                columns: [
                    {data: 'kode_program', name: 'kode_program'},
                    {data: 'grouping', name: 'grouping', orderable: false, visible: false},
                    {data: 'program', name: 'program'},
                    {data: 'action', name: 'action', orderable: false, width: '15%'},
                ],
                rowGroup : {
                    dataSrc : 'grouping'
                },
            });
            $('#kt_quick_user_toggle').click(function () {
                $('#kt_quick_user [name]').val('');
                $('[name=tahun]').val('{{session('tahun_penganggaran')}}')
                $('[name=periode]').val('2019-2023')
                $("#id_sasaran").val('').trigger('change');
                $("#id_program").val('').trigger('change');
                $('[data-repeater-item]').slice(1).remove();
            })
            $('body').on('click', '.open-panel', function (e) {
                e.preventDefault();
                var uuid = $(this).data('uuid')
                $('.form-group.fv-plugins-icon-container').removeClass('has-danger').addClass('has-success')
                $('.fv-plugins-message-container').html('')

                $('[data-repeater-item]').slice(1).remove();
                axios.get('{{route('api.renstra-program')}}/uuid/' + uuid)
                    .then(function (res) {
                        for (key in res.data.response) {
                            var el = $('[name=' + key + ']');
                            if (el.length) {
                                el.val(res.data.response[key])
                            }

                            if(key=='id_sasaran'){

                                $("#id_sasaran").val(res.data.response[key]).trigger('change');
                            }
                            if(key=='id_program'){

                                $("#id_program").val(res.data.response[key]).trigger('change');
                            }
                        }
                        
                        res.data.response.renstra_program_outcome.forEach(function (val,i){
                            if (i > 0){
                                $('#btn-tambah-outcome').click();
                            }
                            for (var key in val){
                                if(key=='uuid'){
                                    $('#outcome [name="['+i+'][out_uuid]"]').val(val[key])
                                }
                                if ($('#outcome [name="['+i+']['+key+']"]').length)
                                    $('#outcome [name="['+i+']['+key+']"]').val(val[key])
                            }
                        })

                    })
                _sidePanel.show();
            })

            webshim.activeLang('fi');
            webshims.setOptions('forms-ext', {
                replaceUI: 'auto',
                types: 'number'
            });
            webshims.polyfill('forms forms-ext');
            var initFvPaketDak = function (index){
                fv.addField('['+index+'][outcome]', {
                    validators: {
                        notEmpty: {
                            message: 'Outcome tidak boleh kosong'
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
                fv.addField('['+index+'][capaian_awal]', {
                    validators: {
                        notEmpty: {
                            message: 'Capaian awal tidak boleh kosong'
                        }
                    }
                })
                
            }

            axios.get('{{route('api.dak.find-paket','sdfs')}}')
            .then(function (res){
                for (key in res.data.response) {
                    var el = $('[name=' + key + ']');
                    if (el.length) {
                        el.val(res.data.response[key])
                    }
                }
                res.data.response.paket_dak.forEach(function (val,i){
                    if (i > 0){
                        $('#btn-tambah-outcome').click();
                    }
                    for (var key in val){
                        if ($('#outcome [name="['+i+']['+key+']"]').length)
                            $('#outcome [name="['+i+']['+key+']"]').val(val[key])
                    }
                })
            })

            $('#outcome').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function () {
                    $(this).slideDown();

                    var index = $('#outcome [data-repeater-item]').length - 1;

                    initFvPaketDak(index)
                    $(this).updatePolyfill();
                },

                hide: function (deleteElement) {
                    var index = $('#outcome [data-repeater-item]').length - 1;
                    $(this).slideUp(deleteElement);
                    fv.removeField('['+index+'][outcome]')
                    fv.removeField('['+index+'][volume]')
                    fv.removeField('['+index+'][satuan]')
                    fv.removeField('['+index+'][capaian_awal]')
                    setTimeout(function (){
                        initFvPaketDak(index-1)
                    },500)
                },
                isFirstItemUndeletable: true
            });

            

            $('body').on('click', '.button-delete', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Perhatian!!',
                    text: 'Hapus Program?',
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
                        axios.delete('{{route('api.renstra-program')}}/uuid/' + uuid)
                            .then(function () {
                                _mainTable.ajax.reload();
                                Swal.fire('Sukses!', 'Berhasil Menghapus Program', 'success')
                            })
                            .catch(function () {
                                Swal.fire('Perhatian!', 'Terjadi kesalahan saat menghapus data', 'error')
                            })
                    }
                })

            })
            $('.close-panel').click(function () {
                _sidePanel.hide();
            })
            var fv = FormValidation.formValidation(
                document.getElementById('data-form'),
                {
                    fields: {
                        id_sasaran: {
                            validators: {
                                notEmpty: {
                                    message: 'Sasaran tidak boleh kosong'
                                }
                            }
                        },
                        id_program: {
                            validators: {
                                notEmpty: {
                                    message: 'Program tidak boleh kosong'
                                }
                            }
                        },
                        '[0][outcome]': {
                            validators: {
                                notEmpty: {
                                    message: 'Outcome tidak boleh kosong'
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
                        '[0][capaian_awal]': {
                            validators: {
                                notEmpty: {
                                    message: 'Capaian awal tidak boleh kosong'
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
                    text: state + ' Program?',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: state,
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var action = $('#data-form').attr('action')
                        var data = $('#data-form').serialize();
                        var el_uuid_pd = $('#outcome [name*=uuid]');
                        el_uuid_pd.each(function (i, el) {
                            data += '&uuid_pd[' + i + ']=' + $(el).val()
                        })
                        var el_out_uuid = $('[name*=out_uuid]');
                        el_out_uuid.each(function (i, el) {
                            data += '&out_uuid[' + i + ']=' + $(el).val()
                        })
                        var el_outcome = $('[name*=outcome]');
                        el_outcome.each(function (i, el) {
                            data += '&outcome[' + i + ']=' + $(el).val()
                        })
                        var el_volume = $('[name*=volume]');
                        el_volume.each(function (i, el) {
                            data += '&volume[' + i + ']=' + $(el).val()
                        })
                        var el_satuan = $('[name*=satuan]');
                        el_satuan.each(function (i, el) {
                            data += '&satuan[' + i + ']=' + $(el).val()
                        })
                        var el_capaian_awal = $('[name*=capaian_awal]');
                        el_capaian_awal.each(function (i, el) {
                            data += '&capaian_awal[' + i + ']=' + $(el).val()
                        })
                        axios.post(action, data)
                            .then(function () {
                                _mainTable.ajax.reload();
                                _sidePanel.hide();
                                Swal.fire('Sukses!', 'Berhasil Menyimpan Data Program', 'success')
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
        });
    </script>
@endpush

