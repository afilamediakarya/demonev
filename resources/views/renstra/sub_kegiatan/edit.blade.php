@extends('layout/app')

@section('title', 'Target')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Renstra</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{url('renstra/renstra-sub-kegiatan')}}" class="">Sub Kegiatan</a>
        </li>
        <li class="breadcrumb-item">
            <a href="" class="">Edit </a>
        </li>
    </ul>
@endsection
@section('style')
    <style type="text/css">

        .wrapper {
            padding-top: 65px !important;
        }

        .apexcharts-canvas {
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

        <!--end::Entry-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Card-->
                    <form id="data-form" action="{{route('api.renstra-sub-kegiatan.create')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="uuid" value="{{$uuid}}" >
                        <input type="hidden" name="anggaran" value="{{session('tahun_penganggaran')}}">
                        <div class="card card-custom card-fit card-border">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card border-0 card-fit">
                                        <div class="card-header border-0 pb-0">
                                            <div class="card-title">
                                                <h3 class="card-label">Detail Sub Kegiatan </h3>
                                            </div>
                                        </div>
                                        <div class="card-body py-0">
                                            <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <label for="">Pilih Sub Kegiatan</label>
                                                    <select name="id_sub_kegiatan" id="id_sub_kegiatan" class="form-control" required>
                                                            <option value="" selected disabled>Pilih Sub Kegiatan</option>
                                                                @foreach($sub_kegiatans AS $s)
                                                                    <option value="{{$s->id}}" data-indikator="{{$s->indikator}}" data-satuan="{{$s->satuan}}">{{$s->nama_sub_kegiatan}}</option>
                                                                @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">

                                        <div class="col-12">
                                            <div id="indikator" class="card card-custom border-0 card-fit"
                                                 style="box-shadow:none">
                                                <div class="card-header border-0 pb-0">
                                                    <div class="card-title">
                                                        <h3 class="card-label">Indikator</h3>
                                                    </div>
                                                    <div class="card-toolbar">
                                                        {{-- <a href="javascript:;" data-repeater-create="" id="btn-tambah-indikator"
                                                           class="btn btn-text-dark-50 btn-icon-primary btn-hover-icon-danger font-weight-bold btn-hover-bg-light mr-3">
                                                            <i class="flaticon2-plus-1"></i>Tambah Indikator</a> --}}
                                                    </div>
                                                </div>
                                                <div data-repeater-list="">
                                                    <div class="card-body py-0 row" data-repeater-item>
                                                        <div class="form-group col-12 col-lg-6">
                                                            <label>Indikator</label>
                                                            <textarea name="indikator" id="indikator_" class="form-control"
                                                                      placeholder="Masukkan narasi tolak ukur"
                                                                      required></textarea>
                                                        </div>
                                                        <div class="form-group col-5 col-lg-2" style="display:none">
                                                            <label>Total Akhir Renstra</label>
                                                            <input name="volume" id="volume_" type="number" class="form-control"
                                                                   min="0"
                                                                   placeholder="" required>
                                                        </div>
                                                        <div class="form-group col-6 col-lg-3">
                                                            <label for="">Satuan</label>
                                                            <input type="text" class="form-control" name="satuan" id="satuan_">
                                                        </div>
                                                        <div class="form-group col-6 col-lg-3">
                                                            <label for="">Capaian awal</label>
                                                            <input type="text" class="form-control" name="capaian_awal" id="capaian_awal_">
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
                                        <div class="col-12">
                                            <div class="card card-custom">
                                                    
                                                    <div class="card-body px-2">

                                                        <div class="card card-custom  mt-0"
                                                        style="background:#F7F7F7">
                                                        <div class="card-body pt-0 px-2 py-0">
                                                            <div class="row px-5">
                                                                
                                                                @for ($i=2019;$i<=2023;$i++)
                                                                   
                                                                    <div class="col-12 col-lg-2 ">
                                                                        <p class="mt-10 ">Tahun {{$i}}</p>
                                                                    </div>
                                                                    <input
                                                                            value=""
                                                                            name="[{{$i}}][tahun]"
                                                                            type="hidden" class="form-control"
                                                                            min="0"
                                                                            placeholder="0"
                                                                            required>
                                                                    <div class="form-group col-12 col-lg-3 ">
                                                                        <label style="font-size:0.8rem">Volume</label>
                                                                        <input
                                                                            value=""
                                                                            name="[{{$i}}][sb_vol]"
                                                                            type="number" class="form-control"
                                                                            min="0"
                                                                            placeholder=""
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group col-6 col-lg-3">
                                                                        <label style="font-size:0.8rem">Satuan</label>
                                                                        <input
                                                                            value=""
                                                                            name="[{{$i}}][sb_sat]"
                                                                            type="text" class="form-control satuan_"
                                                                            min="0"
                                                                            placeholder="0"
                                                                            required readonly>
                                                                    </div>
                                                                    <div class="form-group col-12 col-lg-3">
                                                                        <label style="font-size:0.8rem">Pagu (Rp)</label>
                                                                        <input
                                                                            value=""
                                                                            name="[{{$i}}][nilai_pagu]"
                                                                            type="number" class="form-control"
                                                                            min="0"
                                                                            placeholder="0"
                                                                            required>
                                                                    </div>
                                                               @endfor
                                                               <div class="col-12 col-lg-2 ">
                                                                    <p class="mt-10 ">Total Renstra</p>
                                                                </div>
                                                                <div class="form-group col-12 col-lg-3 ">
                                                                    <label style="font-size:0.8rem">Volume</label>
                                                                    <input
                                                                        value=""
                                                                        name="total_vol"
                                                                        type="number" class="form-control"
                                                                        min="0"
                                                                        placeholder="0"
                                                                        required readonly>
                                                                </div>
                                                                <div class="form-group col-6 col-lg-3">
                                                                    <label style="font-size:0.8rem">Satuan</label>
                                                                    <input
                                                                    value=""
                                                                    name="satuan_update"
                                                                    type="text" class="form-control"
                                                                    min="0"
                                                                    placeholder=""
                                                                    required readonly>
                                                                </div>
                                                                <div class="form-group col-12 col-lg-3">
                                                                    <label>Nilai Akhir Tahun Renstra</label>
                                                                    <input type="hidden" name="total_pagu_renstra" required>
                                                                    <input id="total_pagu_renstra" type="text" class="form-control"
                                                                        placeholder="Nilai Pagu" readonly required>
                                                                </div>
                                                               
                                                               
                                                           </div>
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
                                <a href="{{route('renstra.sub-kegiatan')}}" class="btn btn-sm btn-light-danger font-weight-bold">
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
                                </a>
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
            
            $('#satuan_update').change(function(){
                $('[name*=sb_sat]').val($(this).val());
            });

            $('#satuan').change(function(){
                $('[name*=sb_sat]').val($(this).val());
                $('[name=satuan_update]').val($(this).val());
            });

            $('#id_sub_kegiatan').select2();

            $('#id_sub_kegiatan').on('change',function () {
                let sub_kegiatan_val = $(this).val();
                $('#indikator_').val($(this).select2().find(":selected").data('indikator'));
                $('#satuan_').val($(this).select2().find(":selected").data('satuan'));
                $('.satuan_').val($(this).select2().find(":selected").data('satuan'));
            })

            webshim.activeLang('fi');
            webshims.setOptions('forms-ext', {
                replaceUI: 'auto',
                types: 'number'
            });
            webshims.polyfill('forms forms-ext');
            var initFvTolakukur = function (index){
                fv.addField('['+index+'][indikator]', {
                    validators: {
                        notEmpty: {
                            message: 'Indikator tidak boleh kosong'
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
                fv.addField('['+index+'][capaian_awal]', {
                    validators: {
                        notEmpty: {
                            message: 'Capaian awal boleh kosong'
                        }
                    }
                })
            }
            $('#indikator').repeater({
                initEmpty: false,

                defaultValues: {
                    'text-input': 'foo'
                },

                show: function () {
                    $(this).slideDown();
                    var index = $('#indikator [data-repeater-item]').length - 1;
                    initFvTolakukur(index)
                    $(this).updatePolyfill();
                },

                hide: function (deleteElement) {
                    var index = $('#indikator [data-repeater-item]').length - 1;
                    $(this).slideUp(deleteElement);
                    fv.removeField('['+index+'][indikator]')
                    fv.removeField('['+index+'][volume]')
                    fv.removeField('['+index+'][satuan]')
                    fv.removeField('['+index+'][capaian_awal]')
                    setTimeout(function (){
                        initFvTolakukur(index-1)
                    },500)
                },
                isFirstItemUndeletable: true
            });
            $(document).on('keyup mouseup input', '[name*="nilai_pagu"]', function () {
                var pagu = $('[name*="nilai_pagu');
                var total = 0;
                pagu.each(function (i, el) {
                    if ($(el).val() && $(el).val() > 0) {
                        total += parseFloat($(el).val());
                    } else {
                        $(el).val(0);
                    }
                })
                $('#total_pagu_renstra').val(total.toLocaleString('id-ID', {style: 'currency', currency: 'IDR'}));
                $('[name=total_pagu_renstra]').val(total);
            })
            
            $(document).on('keyup mouseup input', '[name*="sb_vol"]', function () {
                var volume = $('[name*="sb_vol');
                var total = 0;
                volume.each(function (i, el) {
                    if ($(el).val() && $(el).val() > 0) {
                        total += parseFloat($(el).val());
                    } else {
                        $(el).val(0);
                    }
                })
                $('#total_vol').val(total.toLocaleString('id-ID'));
                $('[name=total_vol]').val(total);
                $('#volume_').val(total);
            })

            @if (isset($uuid))
            axios.get('{{route('api.renstra-sub-kegiatan.find-uuid',[$uuid])}}')
                .then(function (res){
                    $('[name=id_sub_kegiatan]').val(res.data.response.id_sub_kegiatan).trigger('change');
                    $('[name=total_pagu_renstra]').val(res.data.response.total_pagu_renstra);
                    $('[name=total_vol]').val(res.data.response.total_volume.toLocaleString('id-ID'));
                    $('#total_vol').val(res.data.response.total_volume);
                    $('#total_pagu_renstra').val(res.data.response.total_pagu_renstra.toLocaleString('id-ID', {style: 'currency', currency: 'IDR'}));
                    
                    res.data.response.renstra_sub_kegiatan_target.forEach(function (val,i){
                        
                        for (var key in val){
                            $('[name="['+val['tahun']+']['+key+']"]').val(val[key])
                            if(key=='volume'){
                                $('[name="['+val['tahun']+'][sb_vol]"]').val(val[key])
                            }
                            if(key=='satuan'){
                                $('[name="['+val['tahun']+'][sb_sat]"]').val(val[key])
                                $('[name="satuan_update"]').val(val[key])
                            }
                            if(key=='pagu'){
                                $('[name="['+val['tahun']+'][nilai_pagu]"]').val(val[key])
                            }

                        }
                    })

                    res.data.response.renstra_sub_kegiatan_indikator.forEach(function (val,i){
                        if (i > 0){
                            $('#btn-tambah-indikator').click();
                        }
                        for (var key in val){
                            if ($('[name="['+i+']['+key+']"]').length)
                                $('[name="['+i+']['+key+']"]').val(val[key])
                        }
                    })
                })
            @endif

            var fv = FormValidation.formValidation(
                document.getElementById('data-form'),
                {
                    fields: {
                        id_sub_kegiatan: {
                            validators: {
                                notEmpty: {
                                    message: 'Sub Kegiatan tidak boleh kosong'
                                }
                            }
                        },
                        total_pagu_renstra: {
                            validators: {
                                notEmpty: {
                                    message: 'Total Pagu Renstra tidak boleh kosong'
                                }
                            }
                        },
                        '[2019][sb_sat]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Satuan tidak boleh kosong'
                                    }
                                }
                            },
                        '[2020][sb_sat]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Satuan tidak boleh kosong'
                                    }
                                }
                            },
                        '[2021][sb_sat]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Satuan tidak boleh kosong'
                                    }
                                }
                            },
                        '[2022][sb_sat]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Satuan tidak boleh kosong'
                                    }
                                }
                            },
                        '[2023][sb_sat]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Satuan tidak boleh kosong'
                                    }
                                }
                            },
                        '[2019][sb_vol]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Volume tidak boleh kosong'
                                    }
                                }
                            },
                        '[2020][sb_vol]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Volume tidak boleh kosong'
                                    }
                                }
                            },
                        '[2021][sb_vol]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Volume tidak boleh kosong'
                                    }
                                }
                            },
                        '[2022][sb_vol]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Volume tidak boleh kosong'
                                    }
                                }
                            },
                        '[2023][sb_vol]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Volume tidak boleh kosong'
                                    }
                                }
                            },
                        '[2019][nilai_pagu]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Nilai Pagu tidak boleh kosong'
                                    }
                                }
                            },
                        '[2020][nilai_pagu]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Nilai Pagu tidak boleh kosong'
                                    }
                                }
                            },
                        '[2021][nilai_pagu]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Nilai Pagu tidak boleh kosong'
                                    }
                                }
                            },
                        '[2022][nilai_pagu]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Nilai Pagu tidak boleh kosong'
                                    }
                                }
                            },
                        '[2023][nilai_pagu]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Nilai Pagu tidak boleh kosong'
                                    }
                                }
                            },
                        '[0][indikator]': {
                            validators: {
                                notEmpty: {
                                    message: 'Indikator tidak boleh kosong'
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
                                    message: 'Capaian awal boleh kosong'
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
                    additional_info = '<br>Mengupdate Data Sub Kegiatan';
                }
                Swal.fire({
                    title: 'Perhatian!!',
                    html: state + ' Data Sub Kegiatan?'+additional_info,
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: state,
                    icon: 'question'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var action = $('#data-form').attr('action')
                        var data = $('#data-form').serialize();



                        var el_tahun = $('[name*=tahun]');
                        el_tahun.each(function (i, el) {
                            data += '&tahun[' + i + ']=' + $(el).val()
                        })
                        
                        var el_sb_vol = $('[name*=sb_vol]');
                        el_sb_vol.each(function (i, el) {
                            data += '&sb_vol[' + i + ']=' + $(el).val()
                        })
                        var el_sb_sat = $('[name*=sb_sat]');
                        el_sb_sat.each(function (i, el) {
                            data += '&sb_sat[' + i + ']=' + $(el).val()
                        })
                        
                        var el_nilai_pagu = $('[name*=nilai_pagu]');
                        el_nilai_pagu.each(function (i, el) {
                            data += '&nilai_pagu[' + i + ']=' + $(el).val()
                        })
                        var el_indikator = $('[name*=indikator]');
                        el_indikator.each(function (i, el) {
                            data += '&indikator[' + i + ']=' + $(el).val()
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
                                Swal.fire('Sukses!', 'Berhasil Menyimpan Data Sub Kegiatan', 'success')
                                window.location.href = '{{route('renstra.sub-kegiatan')}}'
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
