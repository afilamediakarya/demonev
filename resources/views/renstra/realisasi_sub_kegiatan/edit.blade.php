@extends('layout/app')

@section('title', 'Target')
@section('breadcrumb')
    <h5 class="text-dark font-weight-bold my-1 mr-5">Renstra</h5>
    <!--end::Page Title-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{url('renstra/renstra-sub-kegiatan')}}" class="">Realisasi Sub Kegiatan</a>
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
                    <form id="data-form" action="{{route('api.renstra-realisasi-sub-kegiatan.create')}}" method="post">
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
                                            <div class="row w-100">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <p class="font-size-sm">Tujuan</p>
                                                        <p class="font-size-md font-weight-bold">
                                                            {{$data->tujuan}} </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p class="font-size-sm">Urusan</p>
                                                        <p class="font-size-md font-weight-bold">
                                                            {{$data->urusan}}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p class="font-size-sm">Program</p>
                                                        <p class="font-size-md font-weight-bold">
                                                            {{$data->program}} </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p class="font-size-sm">Sub Kegiatan</p>
                                                        <p class="font-size-md font-weight-bold">
                                                            {{$data->sub_kegiatan}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <p class="font-size-sm">Sasaran</p>
                                                        <p class="font-size-md font-weight-bold">
                                                            {{$data->sasaran}}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p class="font-size-sm">Bidang Urusan</p>
                                                        <p class="font-size-md font-weight-bold">
                                                            {{$data->bidang_urusan}} </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p class="font-size-sm">Kegiatan</p>
                                                        <p class="font-size-md font-weight-bold">
                                                            {{$data->kegiatan}}</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <p class="font-size-sm">Total Pagu Renstra</p>
                                                        <p class="font-size-md font-weight-bold">
                                                            {{'Rp ' . number_format($data->total_pagu_renstra, 2, ',', '.')}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                                
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card card-custom">
                                                    
                                                    <div class="card-body px-2">

                                                        <div class="card card-custom  mt-0"
                                                        style="background:#F7F7F7">
                                                        <div class="card-body pt-0 px-2 py-0">
                                                            <div class="row px-5">
                                                                <h5>Data Target</h5>
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center">TAHUN</th>
                                                                                <th class="text-right">TARGET KEUANGAN(Rp)</th>
                                                                                <th class="text-center">TARGET FISIK(%)</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                @php
                                                                                   $target= DB::table('renstra_sub_kegiatan_target')->where('id_renstra_sub_kegiatan',$data->id)->get();
                                                                                @endphp
                                                                                @foreach ($target as $dt)
                                                                                    <tr>
                                                                                        <td class="text-center">{{$dt->tahun}}</td>
                                                                                        <td class="text-right">{{numberToCurrency($dt->pagu)}}</td>
                                                                                        <td class="text-center">{{$dt->volume}}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tr>
                                                                        </tbody>

                                                                    </table>

                                                                </div>
                                                               
                                                           </div>
                                                       </div>
                                                   </div>
                                                </div>
                                            </div>
        
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card card-custom">
                                                    
                                                    <div class="card-body px-2">

                                                        <div class="card card-custom  mt-0"
                                                        style="background:#F7F7F7">
                                                        <div class="card-body pt-0 px-2 py-0">
                                                            <div class="row px-5">
                                                                @for ($i=2019;$i<=2020;$i++)
                                                                   
                                                                    <div class="col-12 col-lg-2 ">
                                                                        <p class="mt-10 ">Tahun {{$i}}</p>
                                                                    </div>
                                                                    <input
                                                                            value="{{$i}}"
                                                                            name="[{{$i}}][tahun]"
                                                                            type="hidden" class="form-control"
                                                                            min="0"
                                                                            placeholder="0"
                                                                            required>
                                                                    <div class="form-group col-12 col-lg-3 ">
                                                                        <label style="font-size:0.8rem">Volume</label>
                                                                        <input
                                                                            value=""
                                                                            name="[{{$i}}][volume]"
                                                                            type="number" class="form-control"
                                                                            min="0"
                                                                            placeholder="0"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group col-6 col-lg-3">
                                                                        <label style="font-size:0.8rem">Satuan</label>
                                                                        @php
                                                                            $get_satuan=DB::table('renstra_sub_kegiatan_target')->whereRaw("id_renstra_sub_kegiatan='$data->id' AND tahun='$i'")->first();
                                                                        @endphp
                                                                            {{-- @foreach($satuan AS $s) --}}
                                                                            @php
                                                                                // if ($get_satuan->satuan==$s->nama_satuan){
                                                                                //     $selected='selected';
                                                                                // }else{
                                                                                //     $selected='';
                                                                                // }
                                                                            @endphp
                                                                        <input type="text" name="[{{$i}}][satuan]" class="form-control" value="{{$get_satuan->satuan}}" readonly>
                                                                        {{-- <select name="[{{$i}}][satuan]" class="form-control" required readonly>
                                                                        <option value="" selected>Pilih Satuan</option>
                                                                        
                                                                            <option value="{{$s->nama_satuan}}" {{$selected}}>{{$s->nama_satuan}}</option>
                                                                           
                                                                                <option value="{{$s->nama_satuan}}" >{{$s->nama_satuan}}</option>
                                                                            @endforeach
                                                                        </select> --}}
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

                                                               

                                                                @php
                                                                    $cek_dpa=DB::table('dpa')->where('id_sub_kegiatan',$data->id_sub_kegiatan)->where('id_unit_kerja',$data->id_unit_kerja)->where('tahun','2021');
                                                                @endphp
                                                                    @if($cek_dpa->count()>0)
                                                                @php
                                                                        $id_dpa=$cek_dpa->first()->id;
                                                                @endphp

                                                                <div class="col-12 col-lg-2 ">
                                                                    <p class="mt-10 ">Tahun 2021 </p>
                                                                </div>
                                                                <input
                                                                        value="2021"
                                                                        name="rk2021"
                                                                        type="hidden" class="form-control"
                                                                        min="0"
                                                                        placeholder="0"
                                                                        required>
                                                                        @for($i=1;$i<=4;$i++)
                                                                        @php
                                                                            $realisasi_kinerja=DB::table('realisasi')->whereRaw("tahun='2021' AND id_dpa='$id_dpa' AND periode='$i'")->first()->realisasi_kinerja;
                                                                        @endphp
                                                                        <div class="form-group col-12 col-lg-2 ">
                                                                            <label style="font-size:0.8rem">Volume Triwulan {{ integerToRoman($i)}}</label>
                                                                            <input
                                                                                value="{{$realisasi_kinerja}}"
                                                                                name="rk2021_{{$i}}"
                                                                                type="number" class="form-control"
                                                                                min="0"
                                                                                placeholder="0"
                                                                                required>
                                                                        </div>
                                                                            
                                                                            
                                                                        @endfor
                                                                    @endif
                                                                
                                                                
                                                               
                                                               
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
                                <a href="{{route('renstra.realisasi-sub-kegiatan')}}" class="btn btn-sm btn-light-danger font-weight-bold">
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
            $('#id_sub_kegiatan').select2();
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
            }
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

            @if (isset($uuid))
            axios.get('{{route('api.renstra-sub-kegiatan.find-uuid',[$uuid])}}')
                .then(function (res){
                    $('[name=id_sub_kegiatan]').val(res.data.response.id_sub_kegiatan).trigger('change');
                    $('[name=total_pagu_renstra]').val(res.data.response.total_pagu_renstra)
                    $('#total_pagu_renstra').val(res.data.response.total_pagu_renstra.toLocaleString('id-ID', {style: 'currency', currency: 'IDR'}));
                    
                    res.data.response.renstra_realisasi_sub_kegiatan.forEach(function (val,i){
                        
                        for (var key in val){
                            if(key=='satuan'){
                                continue;
                            }
                            if(key=='realisasi_keuangan'){
                                $('[name="['+val['tahun']+'][nilai_pagu]"]').val(val[key])
                            }
                            if ($('[name="['+val['tahun']+']['+key+']"]').length)
                                $('[name="['+val['tahun']+']['+key+']"]').val(val[key])
                        }
                    })

                })
            @endif

            var fv = FormValidation.formValidation(
                document.getElementById('data-form'),
                {
                    fields: {
                        '[2019][satuan]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Satuan tidak boleh kosong'
                                    }
                                }
                            },
                        '[2020][satuan]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Satuan tidak boleh kosong'
                                    }
                                }
                            },
                        
                        '[2019][volume]': {
                            validators: {
                                    notEmpty: {
                                        message: 'Volume tidak boleh kosong'
                                    }
                                }
                            },
                        '[2020][volume]': {
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
                        
                        'rk2021_1': {
                            validators: {
                                    notEmpty: {
                                        message: 'Volume Triwulan I tidak boleh kosong'
                                    }
                                }
                            },
                        'rk2021_2': {
                            validators: {
                                    notEmpty: {
                                        message: 'Volume Triwulan II tidak boleh kosong'
                                    }
                                }
                            },
                        'rk2021_3': {
                            validators: {
                                    notEmpty: {
                                        message: 'Volume Triwulan III tidak boleh kosong'
                                    }
                                }
                            },
                        'rk2021_4': {
                            validators: {
                                    notEmpty: {
                                        message: 'Volume Triwulan IV tidak boleh kosong'
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
                        var el_volume = $('[name*=volume]');
                        el_volume.each(function (i, el) {
                            data += '&volume[' + i + ']=' + $(el).val()
                        })
                        var el_satuan = $('[name*=satuan]');
                        el_satuan.each(function (i, el) {
                            data += '&satuan[' + i + ']=' + $(el).val()
                        })
                        
                        var el_nilai_pagu = $('[name*=nilai_pagu]');
                        el_nilai_pagu.each(function (i, el) {
                            data += '&nilai_pagu[' + i + ']=' + $(el).val()
                        })
                        axios.post(action, data)
                            .then(function () {
                                Swal.fire('Sukses!', 'Berhasil Menyimpan Data Sub Kegiatan', 'success')
                                window.location.href = '{{route('renstra.realisasi-sub-kegiatan')}}'
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
