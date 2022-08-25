<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});
Route::get('login', 'AuthController@login')->name('login');
Route::post('login', 'AuthController@doLogin')->name('login.post');
Route::post('logout', 'AuthController@logout')->name('logout');
Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('dashboard/laporan/export_progress_opd/{tipe}', 'DashboardController@export');
        
    Route::group([
        'prefix' => 'monitoring-dan-evaluasi',
        'namespace' => 'MonitoringDanEvaluasi',
        'middleware' => 'has-access:monitoring-dan-evaluasi'
    ], function () {
        Route::group(['prefix' => 'target'], function () {
            Route::get('', 'TargetController@index');
            Route::get('atur-target-pelaksanaan/{uuid}', 'TargetController@aturTargetPelaksanaan')
                ->middleware('cek-jadwal:Target|Target DPA Pokok Triwulan I-IV')
                ->name('monitoring.target.atur');
        });
        Route::group(['prefix' => 'realisasi'], function () {
            Route::get('', 'RealisasiController@index');
            Route::get('realisasi-pelaksanaan/{uuid}', 'RealisasiController@realisasiPelaksanaan')
                ->middleware('cek-jadwal:Realisasi|Realisasi Triwulan I,Realisasi|Realisasi Triwulan II,Realisasi|Realisasi Triwulan III,Realisasi|Realisasi Triwulan IV')
                ->name('monitoring.realisasi.atur');
        });
        Route::group(['prefix' => 'rkpd'], function () {
            Route::get('', 'RkpdController@index');
            Route::get('atur-rkpd', 'RkpdController@aturRkpd');
        });
        Route::group(['prefix' => 'rpjmd'], function () {
            Route::get('', 'RpjmdController@index');
            Route::get('atur-rpjmd', 'RpjmdController@aturRpjmd');
        });
        Route::group(['prefix' => 'realisasi_dak'], function () {
            Route::get('', 'DakController@realisasi_dak')->name('index.realisasi-dak');
            Route::get('realisasi-dak/{uuid}', 'DakController@atur_realisasi_dak')->name('atur.realisasi-dak');
        });
    
        Route::group(['prefix' => 'realisasi_dak_non_fisik'], function () {
            Route::get('', 'DakController@realisasi_dak_non_fisik')->name('index.realisasi-dak-non-fisik');
            Route::get('realisasi-dak/{uuid}', 'DakController@atur_realisasi_dak_non_fisik')->name('atur.realisasi-dak-non-fisik');
        });

        Route::group(['prefix' => 'realisasi_dak_pen'], function () {
            Route::get('', 'DakController@realisasi_dak_pen')->name('index.realisasi-dak-pen');
            Route::get('realisasi-dak/{uuid}', 'DakController@atur_realisasi_dak_pen')->name('atur.realisasi-dak-pen');
        });

        Route::group(['prefix' => 'realisasi_dak_apbn'], function () {
            Route::get('', 'DakController@realisasi_dak_apbn')->name('index.realisasi-dak-apbn');
            Route::get('realisasi-dak/{uuid}', 'DakController@atur_realisasi_dak_apbn')->name('atur.realisasi-dak-apbn');
        });

        Route::group(['prefix' => 'realisasi_dak_apbd1'], function () {
            Route::get('', 'DakController@realisasi_dak_apbd1')->name('index.realisasi-dak-apbd1');
            Route::get('realisasi-dak/{uuid}', 'DakController@atur_realisasi_dak_apbd1')->name('atur.realisasi-dak-apbd1');
        });

        Route::group(['prefix' => 'realisasi_dak_apbd2'], function () {
            Route::get('', 'DakController@realisasi_dak_apbd2')->name('index.realisasi-dak-apbd2');
            Route::get('realisasi-dak/{uuid}', 'DakController@atur_realisasi_dak_apbd2')->name('atur.realisasi-dak-apbd2');
        });
        
        Route::group(['prefix' => 'realisasi_dau'], function () {
            Route::get('', 'DakController@realisasi_dau');
            Route::get('realisasi-dau/{uuid}', 'DakController@atur_realisasi_dau')->name('atur.realisasi-dau');
        });

    });
    Route::group([
        'prefix' => 'renstra',
        'namespace' => 'Renstra',
        'middleware' => 'has-access:kegiatan'
    ], function () {
        Route::group(['prefix' => 'tujuan'], function () {
            Route::get('', 'TujuanController@index');
        });
        Route::group(['prefix' => 'sasaran'], function () {
            Route::get('', 'SasaranController@index');
        });
        Route::group(['prefix' => 'program'], function () {
            Route::get('', 'RenstraProgramController@index');
        });
        Route::group(['prefix' => 'kegiatan'], function () {
            Route::get('', 'RenstraKegiatanController@index');
        });
        Route::group(['prefix' => 'sub-kegiatan'], function () {
            Route::get('', 'RenstraSubKegiatanController@index')->name('renstra.sub-kegiatan');
            Route::get('set-output', 'RenstraSubKegiatanController@setOutput');
            Route::get('{uuid}', 'RenstraSubKegiatanController@detail')->name('renstra.sub-kegiatan.detail');
            Route::get('{uuid}/edit', 'RenstraSubKegiatanController@edit')->name('renstra.sub-kegiatan.edit');
        });
        Route::group(['prefix' => 'realisasi-sub-kegiatan'], function () {
            Route::get('', 'RenstraRealisasiSubKegiatanController@index')->name('renstra.realisasi-sub-kegiatan');
            Route::get('set-output', 'RenstraRealisasiSubKegiatanController@setOutput');
            Route::get('{uuid}', 'RenstraRealisasiSubKegiatanController@detail')->name('renstra.realisasi-sub-kegiatan.detail');
            Route::get('{uuid}/edit', 'RenstraRealisasiSubKegiatanController@edit')->name('renstra.realisasi-sub-kegiatan.edit');
        });
    });
    Route::group([
        'prefix' => 'kegiatan',
        'namespace' => 'Kegiatan',
        'middleware' => 'has-access:kegiatan'
    ], function () {
        Route::group(['prefix' => 'dpa'], function () {
            Route::get('', 'DpaController@index')->name('kegiatan.dpa');
            Route::get('set-output', 'DpaController@setOutput')
            ->middleware('cek-jadwal:Kegiatan|Sub Kegiatan DPA Pokok');
            Route::get('{uuid}', 'DpaController@detail')->name('kegiatan.dpa.detail');
            Route::get('{uuid}/edit', 'DpaController@edit')->name('kegiatan.dpa.edit');
            Route::get('{uuid}/edit-tolak-ukur', 'DpaController@editTolakUkur')->name('kegiatan.dpa.edit.tolak-ukur');
        });
        Route::group(['prefix' => 'dak'], function  () {
            Route::get('', 'DpaController@paket_dak')->name('kegiatan.dak');
            Route::get('{uuid}', 'DpaController@perencanaan')->name('kegiatan.dak.perencanaan');
        });

        Route::group(['prefix' => 'dak-non-fisik'], function  () {
            Route::get('', 'DpaController@paket_dak_non_fisik')->name('kegiatan.dak_non_fisik');
            Route::get('{uuid}', 'DpaController@perencanaan_dak_non_fisik')->name('kegiatan.dak_non_fisik.perencanaan');
        });
        
        Route::group(['prefix' => 'pen'], function  () {
            Route::get('', 'DpaController@paket_dak_pen')->name('kegiatan.dak_pen');
            Route::get('{uuid}', 'DpaController@perencanaan_dak_pen')->name('kegiatan.dak_pen.perencanaan');
        });

        Route::group(['prefix' => 'dak-apbn'], function  () {
            Route::get('', 'DpaController@paket_dak_apbn')->name('kegiatan.dak_apbn');
            Route::get('{uuid}', 'DpaController@perencanaan_dak_apbn')->name('kegiatan.dak_apbn.perencanaan');
        });

        Route::group(['prefix' => 'dak-apbd1'], function  () {
            Route::get('', 'DpaController@paket_dak_apbd1')->name('kegiatan.dak_apbd1');
            Route::get('{uuid}', 'DpaController@perencanaan_dak_apbd1')->name('kegiatan.dak_apbd1.perencanaan');
        });

        Route::group(['prefix' => 'dak-apbd2'], function  () {
            Route::get('', 'DpaController@paket_dak_apbd2')->name('kegiatan.dak_apbd2');
            Route::get('{uuid}', 'DpaController@perencanaan_dak_apbd2')->name('kegiatan.dak_apbd2.perencanaan');
        });
        
        Route::group(['prefix' => 'dau'], function  () {
            Route::get('', 'DpaController@paket_dau')->name('kegiatan.dau');
            Route::get('{uuid}', 'DpaController@perencanaan_dau')->name('kegiatan.dau.perencanaan');
        });

        Route::group(['prefix' => 'renja'], function  () {
            Route::get('', 'RenjaController@index')->name('kegiatan.renja');
            Route::get('{uuid}', 'RenjaController@perencanaan')->name('kegiatan.renja.perencanaan');
        });
        Route::group(['prefix' => 'renstra'], function  () {
            Route::get('', 'RenstraController@index')->name('kegiatan.renstra');
            Route::get('{uuid}', 'RenstraController@perencanaan')->name('kegiatan.renstra.perencanaan');
        });
    });
    Route::group([
        'prefix' => 'master-kegiatan',
        'namespace' => 'MasterKegiatan',
        'middleware' => 'has-access:master-kegiatan'
    ], function () {
        Route::group(['prefix' => 'urusan'], function () {
            Route::get('', 'UrusanController@index');
        });
        
        Route::group(['prefix' => 'bidang-urusan'], function () {
            Route::get('', 'BidangUrusanController@index');
        });
        Route::group(['prefix' => 'program'], function () {
            Route::get('', 'ProgramController@index');
        });
        Route::group(['prefix' => 'kegiatan'], function () {
            Route::get('', 'KegiatanController@index');
        });
        Route::group(['prefix' => 'sub-kegiatan'], function () {
            Route::get('', 'SubKegiatanController@index');
        });

        Route::group(['prefix' => 'rpjmd'], function  () {
            Route::get('', 'RpjmdController@index')->name('master-kegiatan.rpjmd');
            Route::get('{uuid}', 'RpjmdController@perencanaan')->name('master-kegiatan.rpjmd.perencanaan');
        });

        Route::group(['prefix' => 'rkpd'], function  () {
            Route::get('', 'RkpdController@index')->name('master-kegiatan.rkpd');
            Route::get('{uuid}', 'RkpdController@perencanaan')->name('master-kegiatan.rkpd.perencanaan');
        });
    });
    Route::group([
        'prefix' => 'master-kegiatan-dak',
        'namespace' => 'MasterKegiatanDak',
        'middleware' => 'has-access:master-kegiatan'
    ], function () {
        Route::group(['prefix' => 'bidang-dak'], function () {
            Route::get('', 'BidangDakController@index');
        });
        Route::group(['prefix' => 'sub-bidang-dak'], function () {
            Route::get('', 'SubBidangDakController@index');
        });
        Route::group(['prefix' => 'kegiatan-dak'], function () {
            Route::get('', 'KegiatanDakController@index');
        });
        Route::group(['prefix' => 'tematik-dak'], function () {
            Route::get('', 'TematikDakController@index');
        });
        Route::group(['prefix' => 'rincian-dak'], function () {
            Route::get('', 'RincianDakController@index');
        });
    });
    Route::group([
        'prefix' => 'laporan',
        'middleware' => 'has-access:laporan'
    ], function () {
        Route::get('realisasi', 'LaporanController@realisasi');
        Route::get('kemajuan_dak', 'LaporanController@kemajuan_dak');
        Route::get('paket_dau', 'laporanDauController@paket_dau');
        Route::get('export_paket_dau/{tipe}','laporanDauController@export_paket_dau');
        Route::get('evaluasi', 'LaporanController@evaluasi');
        Route::get('evaluasi_renstra', 'LaporanController@evaluasi_renstra');
        Route::get('evaluasi_rkpd', 'LaporanController@evaluasi_rkpd');
        Route::get('evaluasi_rpjmd', 'LaporanController@evaluasi_rpjmd');
        Route::get('apbd', 'LaporanController@apbd');
        Route::get('apbn', 'LaporanController@apbn');
        Route::get('dak', 'LaporanController@dak');
        Route::get('anggaran', 'LaporanController@anggaran');
        Route::get('rkpd', 'LaporanController@rkpd');
        Route::get('rpjmd', 'LaporanController@rpjmd');
        Route::get('export/{tipe}','LaporanController@export');
        Route::get('export_kemajuan_dak/{tipe}','LaporanController@export_kemajuan_dak');
        Route::get('export_evaluasi_renstra/{tipe}','LaporanController@export_evaluasi_renstra');
        Route::get('export_evaluasi_rkpd/{tipe}','LaporanController@export_evaluasi_rkpd');
        Route::get('export_evaluasi_rpjmd/{tipe}','LaporanController@export_evaluasi_rpjmd');


        Route::get('daftar_alokasi', 'LaporanDaftarAlokasiController@index');
        Route::get('export_daftar_alokasi/{tipe}', 'LaporanDaftarAlokasiController@export');
        Route::get('evaluasi_renja', 'LaporanEvaluasiRenjaController@index');
        Route::get('export_evaluasi_renja/{tipe}','LaporanEvaluasiRenjaController@export');
        Route::get('/desaByKecamatan/{params}', 'LaporanDaftarAlokasiController@findByKecamatan')->name('api.desa.bykecamatan');

        
        Route::group(['prefix' => 'realisasi'], function () {
            Route::get('apbn/{tipe}', 'LaporanController@export_apbn');
            Route::get('apbd/{tipe}', 'LaporanController@export_apbd');
            Route::get('apbd2/{tipe}', 'LaporanController@export_apbd_ii');
            Route::get('dak-fisik/{tipe}', 'LaporanController@export_dak_fisik_unit_kerja');
            Route::get('dak-non-fisik/{tipe}', 'LaporanController@export_dak_non_fisik');
        });
        Route::group(['prefix' => 'unit-kerja'], function () {
            Route::get('apbn/{tipe}', 'LaporanController@export_apbn_all');
        });
    });
    Route::group([
        'prefix' => 'unit-kerja',
        'namespace' => 'UnitKerja',
        'middleware' => 'has-access:unit-kerja'
    ], function () {
        Route::group(['prefix' => 'daftar-unit-kerja'], function () {
            Route::get('', 'DaftarUnitKerjaController@index');
        });
        Route::group(['prefix' => 'penanggung-jawab'], function () {
            Route::get('', 'PenanggungJawabController@index');
        });
        Route::group(['prefix' => 'profil-unit-kerja'], function () {
            Route::get('', 'ProfilUnitKerjaController@index');
        });
    });
    Route::group([
        'prefix' => 'users',
        'namespace' => 'Users',
        'middleware' => 'has-access:user'
    ], function () {
        Route::group(['prefix' => 'daftar-pegawai'], function () {
            Route::get('', 'DaftarPegawaiController@index');
        });
        Route::group(['prefix' => 'daftar-user'], function () {
            Route::get('', 'DaftarUserController@index');
        });
        Route::group(['prefix' => 'role'], function () {
            Route::get('', 'RoleController@index');
        });
        Route::group(['prefix' => 'hak-akses'], function () {
            Route::get('', 'HakAksesController@index');
        });
    });
    Route::group([
        'prefix' => 'master',
        'namespace' => 'Master',
        'middleware' => 'has-access:master'
    ], function () {
        Route::group(['prefix' => 'sumber-dana'], function () {
            Route::get('', 'SumberDanaController@index');
        });
        Route::group(['prefix' => 'jenis-belanja'], function () {
            Route::get('', 'JenisBelanjaController@index');
        });
        Route::group(['prefix' => 'metode-pelaksanaan'], function () {
            Route::get('', 'MetodePelaksanaanController@index');
        });
        Route::group(['prefix' => 'satuan'], function () {
            Route::get('', 'SatuanController@index');
        });
        Route::group(['prefix' => 'kecamatan'], function () {
            Route::get('', 'KecamatanController@index');
        });

        Route::group(['prefix' => 'desa'], function () {
            Route::get('', 'DesaController@index');
        });
    });
    Route::group([
        'prefix' => 'pengaturan',
        'namespace' => 'Pengaturan',
    ], function () {
        Route::group(['prefix' => 'akun'], function () {
            Route::get('', 'AkunController@index');
        });
        Route::group(['middleware' => 'has-access:pengaturan'],function (){
            Route::group(['prefix' => 'profile-daerah'], function () {
                Route::get('', 'ProfileDaerahController@index');
            });
            Route::group(['prefix' => 'jadwal-penginputan'], function () {
                Route::get('', 'JadwalPenginputanController@index');
            });
            Route::group(['prefix' => 'backupreport'], function () {
                Route::get('', 'BackupReportController@index');
            });
        });
    });
    Route::get('set-tahun-penganggaran', 'Controller@setTahunAnggaran')->name('set-tahun-penganggaran');
});

