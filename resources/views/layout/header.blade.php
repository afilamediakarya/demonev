<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <!--begin::Header Menu-->
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <!--begin::Header Nav-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        @yield('breadcrumb')
                    </div>
                </div>
                <!--end::Header Nav-->
            </div>
            <!--end::Header Menu-->
        </div>
        <!--end::Header Menu Wrapper-->
        <!--begin::Topbar-->
        <div class="topbar">
            <!--begin::User-->
            <div class="d-flex align-items-center mr-5">
                <div class="input-group input-group-solid">
                    <input type="text" class="form-control" disabled aria-label="Text input with dropdown button"
                           value="Tahun Penganggaran">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            {{session('tahun_penganggaran')}}</button>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                            @php
                                $tahun_anggaran = session()->has('tahun_penganggaran') ? (int)session('tahun_penganggaran') : (int)date('Y');
                            @endphp
                            @for ($i = $tahun_anggaran - 3;$i <= $tahun_anggaran + 3; $i++)
                                <a class="dropdown-item"
                                   href="{{route('set-tahun-penganggaran',['tahun' => $i])}}">{{$i}}</a>
                            @endfor
                        </div>
                    </div>
                </div>
                <!-- <a href="#" class="btn btn-sm btn-light font-weight-bold mr-2" id="kt_dashboard_daterangepicker" data-toggle="tooltip" title="Select dashboard daterange" data-placement="left">
                    <span class="text-muted font-size-base font-weight-bold mr-2" id="kt_dashboard_daterangepicker_title">Today</span>
                    <span class="text-primary font-size-base font-weight-bolder" id="kt_dashboard_daterangepicker_date">Aug 16</span>
                </a> -->
            </div>
            <div class="topbar-item ml-5">
            <div class="dropdown">
                <div class="btn btn-icon btn-icon-mobile w-auto btn-clean btn-dropdown d-flex align-items-center btn-lg px-2"  data-toggle="dropdown">
                        <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                            <span class="symbol-label font-size-h5 font-weight-bold"><i class="fas fa-user-circle"></i></span>
                        </span>
                        <span>&nbsp;</span>
                        <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                        <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline ml-3 mr-3">{{auth()->user()->nama_lengkap}}</span>
                    </div>
									<div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
										<!--begin::Nav-->
										<ul class="navi navi-hover py-4">
											<!--begin::Item-->
											<li class="navi-item">
												<a href="{{url('pengaturan/akun')}}" class="navi-link">
													<span class="symbol symbol-20 mr-3">
														<i class="fas fa-user"></i>
													</span>
													<span class="navi-text">Profil</span>
												</a>
											</li>
                      <li class="navi-item">
												<a href="{{ asset('assets/media/panduan.pdf')}}" target="_blank" class="navi-link">
													<span class="symbol symbol-20 mr-3">
														<i class="fas fa-download"></i>
													</span>
													<span class="navi-text">Buku Panduan</span>
												</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="navi-item active">
												<a href="#" class="navi-link" id="logout">
													<span class="symbol symbol-20 mr-3">
														<i class="fas fa-sign-out-alt"></i>
													</span>
													<span class="navi-text">Keluar</span>
												</a>
											</li>
										</ul>
										<!--end::Nav-->
									</div>
									<!--end::Dropdown-->
								</div>

            </div>
            <!--end::User-->
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
