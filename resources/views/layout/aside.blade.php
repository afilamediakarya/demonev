@php
    $path = explode('/', Request::path())
@endphp

<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">
        <!--begin::Logo-->
        <a href="{{ url('dashboard') }}" class="brand-logo">
            <img alt="Logo" src="{{ URL::asset('assets/media/logos/logo.svg')}}"/>
        </a>
        <!--end::Logo-->
        <!--begin::Toggle-->
        <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
            <span class="svg-icon svg-icon svg-icon-xl">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                     height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <path
                            d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                            fill="#000000" fill-rule="nonzero"
                            transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)"/>
                        <path
                            d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                            fill="#000000" fill-rule="nonzero" opacity="0.3"
                            transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)"/>
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </button>
        <!--end::Toolbar-->
        <!-- <h4 class="menu-text">DINAS PEKERJAAN UMUM DAN PERUMAHAN RAKYAT</h4> -->
    </div>
    <!--end::Brand-->
    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
             data-menu-dropdown-timeout="500">
            <!--begin::Menu Nav-->
            <ul class="menu-nav">
                <li class="menu-section">
                    <h4 class="menu-text">{{hasRole('admin') ? 'DASHBOARD ADMIN' : auth()->user()->UnitKerja->nama_unit_kerja}}</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                <li class="menu-item {{ ($path[0] == 'dashboard' ? 'menu-item-active' : '') }}" aria-haspopup="true">
                    <a href="{{ url('dashboard') }}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <img
                                src="{{ ($path[0] == 'dashboard' ? url('assets/media/navsicon/dashboard-active.svg') : url('assets/media/navsicon/dashboard.svg')) }}"
                                alt="">
                        </span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                @if(hasAkses('kegiatan'))
                    <li class="menu-item menu-item-submenu {{ ($path[0] == 'renstra' ? 'menu-item-open' : '') }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <img
                                src="{{ ($path[0] == 'renstra' ? url('assets/media/navsicon/renstra-active.svg') : url('assets/media/navsicon/kegiatan.svg')) }}"
                                alt="">
                        </span>
                            <span class="menu-text">Renstra</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Applications</span>
                                </span>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'tujuan' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('renstra/tujuan')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Tujuan</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'sasaran' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('renstra/sasaran')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Sasaran</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'program' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('renstra/program')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Program</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'kegiatan' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('renstra/kegiatan')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Kegiatan</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'sub-kegiatan' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('renstra/sub-kegiatan')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text"> Sub Kegiatan</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'realisasi-sub-kegiatan' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('renstra/realisasi-sub-kegiatan')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text"> Realisasi Sub Kegiatan</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="menu-item menu-item-submenu {{ ($path[0] == 'kegiatan' ? 'menu-item-open' : '') }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <img
                                src="{{ ($path[0] == 'kegiatan' ? url('assets/media/navsicon/kegiatan-active.svg') : url('assets/media/navsicon/kegiatan.svg')) }}"
                                alt="">
                        </span>
                            <span class="menu-text">Kegiatan</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Applications</span>
                                </span>
                                </li>
                                {{-- <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'dpa' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('kegiatan/renstra')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Renstra</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'dpa' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('kegiatan/renja')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Renja</span>
                                    </a>
                                </li> --}}
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'dpa' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('kegiatan/dpa')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Input DPA</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'dak' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('kegiatan/dak')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Paket DAK FISIK</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'dak-non-fisik' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('kegiatan/dak-non-fisik')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Paket DAK-Non Fisik</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'pen' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('kegiatan/pen')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Paket PEN</span>
                                    </a>
                                </li>
                                <!-- <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'dak-apbn' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('kegiatan/dak-apbn')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Paket APBN</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'dak-apbd1' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('kegiatan/dak-apbd1')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Paket APBD I</span>
                                    </a>
                                </li> -->
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'dak-apbd2' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('kegiatan/dak-apbd2')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Paket APBD II</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'dau' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('kegiatan/dau')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Paket Belanja Hibah</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                @if(hasAkses('monitoring-dan-evaluasi'))
                    <li class="menu-item menu-item-submenu {{ ($path[0] == 'monitoring-dan-evaluasi' ? 'menu-item-open' : '') }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <img
                                src="{{ ($path[0] == 'monitoring-dan-evaluasi' ? url('assets/media/navsicon/monitoring-active.svg') : url('assets/media/navsicon/monitoring.svg')) }}"
                                alt="">
                        </span>
                            <span class="menu-text">Monitoring & Evaluasi</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Applications</span>
                                </span>
                                </li>
                                <li class="menu-item menu-item-submenu hide {{ (isset($path[1]) ? ($path[1] == 'target' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('monitoring-dan-evaluasi/target')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Target</span>
                                    </a>
                                </li>
                            	<li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'realisasi_dak' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('monitoring-dan-evaluasi/realisasi_dak')}}"
                                       class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Realisasi Paket DAK Fisik</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'realisasi_dak_non_fisik' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('monitoring-dan-evaluasi/realisasi_dak_non_fisik')}}"
                                       class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Realisasi Paket DAK Non Fisik</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'realisasi_dak_pen' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('monitoring-dan-evaluasi/realisasi_dak_pen')}}"
                                       class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Realisasi Paket PEN</span>
                                    </a>
                                </li>
                                <!-- <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'realisasi_dak_apbn' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('monitoring-dan-evaluasi/realisasi_dak_apbn')}}"
                                       class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Realisasi Paket APBN</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'realisasi_dak_apbd1' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('monitoring-dan-evaluasi/realisasi_dak_apbd1')}}"
                                       class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Realisasi Paket APBD I</span>
                                    </a>
                                </li> -->
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'realisasi_dak_apbd2' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('monitoring-dan-evaluasi/realisasi_dak_apbd2')}}"
                                       class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Realisasi Paket APBD II</span>
                                    </a>
                                </li>
                                
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'realisasi' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('monitoring-dan-evaluasi/realisasi')}}"
                                       class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Realisasi Sub Kegiatan</span>
                                    </a>
                                </li>

                        
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'rpjmd' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('monitoring-dan-evaluasi/rpjmd')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Evaluasi Renstra</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                @if(hasAkses('master-kegiatan'))
                    <li class="menu-item menu-item-submenu {{ ($path[0] == 'master-kegiatan' ? 'menu-item-open' : '') }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <img
                                src="{{ ($path[0] == 'master-kegiatan' ? url('assets/media/navsicon/kegiatan-active.svg') : url('assets/media/navsicon/kegiatan.svg')) }}"
                                alt="">
                        </span>
                            <span class="menu-text">Master Kegiatan</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Applications</span>
                                </span>
                                </li>
                                
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'rpjmd' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master-kegiatan/rpjmd')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">RPJMD</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'rkpd' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master-kegiatan/rkpd')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">RKPD</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'urusan' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master-kegiatan/urusan')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Urusan</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'bidang-urusan' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master-kegiatan/bidang-urusan')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Bidang Urusan</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'program' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master-kegiatan/program')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Program</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'kegiatan' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master-kegiatan/kegiatan')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Kegiatan</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'sub-kegiatan' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master-kegiatan/sub-kegiatan')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Sub Kegiatan</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="menu-item menu-item-submenu {{ ($path[0] == 'master-kegiatan-dak' ? 'menu-item-open' : '') }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <img
                                src="{{ ($path[0] == 'master-kegiatan' ? url('assets/media/navsicon/kegiatan-active.svg') : url('assets/media/navsicon/kegiatan.svg')) }}"
                                alt="">
                        </span>
                            <span class="menu-text">Master Kegiatan DAK</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Applications</span>
                                </span>
                                </li>
                          
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'bidang-dak' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master-kegiatan-dak/bidang-dak')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Bidang Dak</span>
                                    </a>
                                </li>

                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'sub-bidang-dak' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master-kegiatan-dak/sub-bidang-dak')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Sub Bidang Dak</span>
                                    </a>
                                </li>

                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'kegiatan-dak' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master-kegiatan-dak/kegiatan-dak')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Kegiatan Dak</span>
                                    </a>
                                </li>

                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'tematik-dak' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master-kegiatan-dak/tematik-dak')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Tematik Dak</span>
                                    </a>
                                </li>

                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'rincian-dak' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master-kegiatan-dak/rincian-dak')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Rincian Dak</span>
                                    </a>
                                </li>
                                
                               
                            </ul>
                        </div>
                    </li>
                @endif
                @if(hasAkses('laporan'))
                    <li class="menu-item menu-item-submenu {{ ($path[0] == 'laporan' ? 'menu-item-open' : '') }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <img
                                src="{{ ($path[0] == 'laporan' ? url('assets/media/navsicon/laporan-active.svg') : url('assets/media/navsicon/laporan.svg')) }}"
                                alt="">
                        </span>
                            <span class="menu-text">Laporan </span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Applications</span>
                                </span>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'realisasi' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('laporan/realisasi')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Realisasi Sub Kegiatan</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'kemajuan_dak' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('laporan/kemajuan_dak')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Realisasi Paket DAK FISIK</span>
                                    </a>
                                </li>
                                 <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'paket_dau' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('laporan/paket_dau')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Realisasi Paket APBD</span>
                                    </a>
                                </li>
                                @if(hasRole('opd'))
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'evaluasi' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('laporan/evaluasi_renja')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Evaluasi Renja</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasRole('admin'))
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'evaluasi' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('laporan/evaluasi_renja')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Evaluasi RKPD</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasRole('opd'))
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'evaluasi' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('laporan/evaluasi_renstra')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Evaluasi Renstra</span>
                                    </a>
                                </li>
                                @endif
                                @if(hasRole('admin'))
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'evaluasi' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('laporan/evaluasi_rpjmd')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Evaluasi RPJMD</span>
                                    </a>
                                </li>
                                @endif
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'evaluasi' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('laporan/daftar_alokasi')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Daftar Alokasi</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                @if(hasAkses('unit-kerja'))
                    <li class="menu-item menu-item-submenu {{ ($path[0] == 'unit-kerja' ? 'menu-item-open' : '') }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <img
                                src="{{ ($path[0] == 'unit-kerja' ? url('assets/media/navsicon/unitkerja-active.svg') : url('assets/media/navsicon/unitkerja.svg')) }}"
                                alt="">
                        </span>
                            <span class="menu-text">Unit Kerja </span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Applications</span>
                                </span>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'profil-unit-kerja' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{URL('unit-kerja/profil-unit-kerja')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Profil Unit Kerja</span>
                                    </a>
                                </li>
                                @if(hasRole('admin'))
                                    <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'daftar-unit-kerja' ? 'menu-item-active' : '' ) : '' ) }}"
                                        aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="{{URL('unit-kerja/daftar-unit-kerja')}}" class="menu-link menu-toggle">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Daftar Unit Kerja</span>
                                        </a>
                                    </li>
                                @endif
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'penanggung-jawab' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{URL('unit-kerja/penanggung-jawab')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Penanggung Jawab</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                @if(hasAkses('user'))
                    <li class="menu-item menu-item-submenu {{ ($path[0] == 'users' ? 'menu-item-open' : '') }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <img
                                src="{{ ($path[0] == 'users' ? url('assets/media/navsicon/user-active.svg') : url('assets/media/navsicon/user.svg')) }}"
                                alt="">
                        </span>
                            <span class="menu-text">Users </span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Applications</span>
                                </span>
                                </li>
                                {{--                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'daftar-pegawai' ? 'menu-item-active' : '' ) : '' ) }}"--}}
                                {{--                                    aria-haspopup="true" data-menu-toggle="hover">--}}
                                {{--                                    <a href="{{ url('users/daftar-pegawai') }}" class="menu-link menu-toggle">--}}
                                {{--                                        <i class="menu-bullet menu-bullet-line">--}}
                                {{--                                            <span></span>--}}
                                {{--                                        </i>--}}
                                {{--                                        <span class="menu-text">Daftar Pegawai</span>--}}
                                {{--                                    </a>--}}
                                {{--                                </li>--}}
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'daftar-user' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ url('users/daftar-user') }}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Daftar User</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'role' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ url('users/role') }}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Role User</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'hak-akses' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{ url('users/hak-akses') }}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Hak Akses</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                @if(hasAkses('master'))
                    <li class="menu-item menu-item-submenu {{ ($path[0] == 'master' ? 'menu-item-open' : '') }}"
                        aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <img
                                src="{{ ($path[0] == 'master' ? url('assets/media/navsicon/master-active.svg') : url('assets/media/navsicon/master.svg')) }}"
                                alt="">
                        </span>
                            <span class="menu-text">Master </span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                <span class="menu-link">
                                    <span class="menu-text">Applications</span>
                                </span>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'sumber-dana' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master/sumber-dana')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Sumber Dana</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'jenis-belanja' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master/jenis-belanja')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Jenis Belanja</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'metode-pelaksanaan' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master/metode-pelaksanaan')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Metode Pelaksanaan</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'satuan' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master/satuan')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Satuan</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'kecamatan' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master/kecamatan')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Kecamatan</span>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'desa' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('master/desa')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Desa</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                <li class="menu-item menu-item-submenu {{ ($path[0] == 'pengaturan' ? 'menu-item-open' : '') }}"
                    aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                            <img
                                src="{{ ($path[0] == 'pengaturan' ? url('assets/media/navsicon/pengaturan-active.svg') : url('assets/media/navsicon/pengaturan.svg')) }}"
                                alt="">
                        </span>
                        <span class="menu-text">Pengaturan </span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu">
                        <i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            @if(hasAkses('pengaturan'))
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'backupreport' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('pengaturan/backupreport')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Backup Laporan</span>
                                    </a>
                                </li>
                            @endif
                            @if(hasAkses('pengaturan'))
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'profile-daerah' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('pengaturan/profile-daerah')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Profile Daerah</span>
                                    </a>
                                </li>
                            @endif
                            <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'akun' ? 'menu-item-active' : '' ) : '' ) }}"
                                aria-haspopup="true" data-menu-toggle="hover">
                                <a href="{{url('pengaturan/akun')}}" class="menu-link menu-toggle">
                                    <i class="menu-bullet menu-bullet-line">
                                        <span></span>
                                    </i>
                                    <span class="menu-text">Akun</span>
                                </a>
                            </li>
                            @if(hasAkses('pengaturan'))
                                <li class="menu-item menu-item-submenu {{ (isset($path[1]) ? ($path[1] == 'jadwal-penginputan' ? 'menu-item-active' : '' ) : '' ) }}"
                                    aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="{{url('pengaturan/jadwal-penginputan')}}" class="menu-link menu-toggle">
                                        <i class="menu-bullet menu-bullet-line">
                                            <span></span>
                                        </i>
                                        <span class="menu-text">Jadwal Penginputan</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
                <!-- <li class="menu-item" aria-haspopup="true">
                    <a href="=#" class="menu-link" id="logout">
                        <span class="menu-icon fa fa-door-open">
                        </span>
                        <span class="menu-text">Keluar</span>
                    </a>
                </li> -->
            </ul>
            <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
    </div>
    <!--end::Aside Menu-->
    <form id="form-logout" style="display: none" action="{{route('logout')}}" method="post">
        {{csrf_field()}}
        <button type="submit">logout</button>
    </form>
</div>
@once
    @push('script')
        <script>
            $('#logout').click(function (e) {
                e.preventDefault();
                $('#form-logout').submit();
            })
        </script>
    @endpush
@endonce
