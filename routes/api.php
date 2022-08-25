<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'Api'], function () {
    Route::post('token', 'ApiPassportController@issueToken')->name('api.token');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('role-akses', 'ApiPassportController@getRoleAkses')->name('api.role-akses');
        Route::group(['middleware' => 'has-access:kegiatan'], function () {
            Route::group(['prefix' => 'dpa'], function () {
                Route::get('', 'DpaController@get')->name('api.dpa');
                Route::get('data-table', 'DpaController@dataTable')->name('api.dpa.data-table');
                Route::get('{id}', 'DpaController@find')->name('api.dpa.find');
                Route::get('uuid/{uuid}', 'DpaController@findByUuid')->name('api.dpa.find-uuid');
                Route::post('', 'DpaController@create')->name('api.dpa.create');
                Route::put('{uuid}', 'DpaController@updateTolakUkur')->name('api.dpa.update-tolak-ukur');
                Route::put('update/{id}', 'DpaController@update')->name('api.dpa.update');
                Route::delete('{id}', 'DpaController@delete')->name('api.dpa.delete');
                Route::post('target/{uuid}','DpaController@updateTarget')->name('api.dpa.target.update');
                Route::post('realisasi/{uuid}','DpaController@updateRealisasi')->name('api.dpa.realisasi.update');
                Route::delete('uuid/{uuid}', 'DpaController@deleteByUuid')->name('api.dpa.delete');
                Route::group(['prefix' => 'option'],function (){
                    Route::get('program','DpaController@getProgram')->name('api.dpa.opsi.program');
                    Route::get('kegiatan', 'DpaController@getKegiatan')->name('api.dpa.opsi.kegiatan');
                    Route::get('sub-kegiatan','DpaController@getSubKegiatanAll')->name('api.dpa.opsi.sub-kegiatan');
                    Route::get('penanggung-jawab', 'DpaController@getPenanggungJawab')->name('api.dpa.opsi.pj');
                    Route::get('program/{id}/kegiatan', 'ProgramController@getKegiatan')->name('api.dpa.opsi.program.kegiatan');
                    Route::get('kegiatan/{id}/sub-kegiatan', 'DpaController@getSubKegiatan')->name('api.dpa.opsi.kegiatan.sub-kegiatan');
                });
            });

            Route::group(['prefix' => 'renja'], function () {
                Route::get('', 'RenjaController@get')->name('api.renja');
                Route::get('data-table', 'RenjaController@dataTable')->name('api.renja.data-table');
                Route::get('{id}', 'RenjaController@find')->name('api.renja.find');
                Route::get('uuid/{uuid}', 'RenjaController@findByUuid')->name('api.renja.find-uuid');
                Route::post('', 'RenjaController@create')->name('api.renja.create');
                Route::put('{uuid}', 'RenjaController@updateTolakUkur')->name('api.renja.update-tolak-ukur');
                Route::put('update/{id}', 'RenjaController@update')->name('api.renja.update');
                Route::delete('{id}', 'RenjaController@delete')->name('api.renja.delete');
                Route::post('target/{uuid}','RenjaController@updateTarget')->name('api.renja.target.update');
                Route::post('realisasi/{uuid}','RenjaController@updateRealisasi')->name('api.renja.realisasi.update');
                Route::delete('uuid/{uuid}', 'RenjaController@deleteByUuid')->name('api.renja.delete');
                Route::group(['prefix' => 'option'],function (){
                    Route::get('program','RenjaController@getProgram')->name('api.renja.opsi.program');
                    Route::get('kegiatan', 'RenjaController@getKegiatan')->name('api.renja.opsi.kegiatan');
                    Route::get('sub-kegiatan','RenjaController@getSubKegiatanAll')->name('api.renja.opsi.sub-kegiatan');
                    Route::get('penanggung-jawab', 'RenjaController@getPenanggungJawab')->name('api.renja.opsi.pj');
                    Route::get('program/{id}/kegiatan', 'ProgramController@getKegiatan')->name('api.renja.opsi.program.kegiatan');
                    Route::get('kegiatan/{id}/sub-kegiatan', 'RenjaController@getSubKegiatan')->name('api.renja.opsi.kegiatan.sub-kegiatan');
                });
            });
            
            Route::group(['prefix' => 'renstra'], function () {
                Route::get('', 'RenstraController@get')->name('api.renstra');
                Route::get('data-table', 'RenstraController@dataTable')->name('api.renstra.data-table');
                Route::get('{id}', 'RenstraController@find')->name('api.renstra.find');
                Route::get('uuid/{uuid}', 'RenstraController@findByUuid')->name('api.renstra.find-uuid');
                Route::post('', 'RenstraController@create')->name('api.renstra.create');
                Route::put('{uuid}', 'RenstraController@updateTolakUkur')->name('api.renstra.update-tolak-ukur');
                Route::put('update/{id}', 'RenstraController@update')->name('api.renstra.update');
                Route::delete('{id}', 'RenstraController@delete')->name('api.renstra.delete');
                Route::post('target/{uuid}','RenstraController@updateTarget')->name('api.renstra.target.update');
                Route::post('realisasi/{uuid}','RenstraController@updateRealisasi')->name('api.renstra.realisasi.update');
                Route::delete('uuid/{uuid}', 'RenstraController@deleteByUuid')->name('api.renstra.delete');
                Route::group(['prefix' => 'option'],function (){
                    Route::get('program','RenstraController@getProgram')->name('api.renstra.opsi.program');
                    Route::get('kegiatan', 'RenstraController@getKegiatan')->name('api.renstra.opsi.kegiatan');
                    Route::get('sub-kegiatan','RenstraController@getSubKegiatanAll')->name('api.renstra.opsi.sub-kegiatan');
                    Route::get('penanggung-jawab', 'RenstraController@getPenanggungJawab')->name('api.renstra.opsi.pj');
                    Route::get('program/{id}/kegiatan', 'ProgramController@getKegiatan')->name('api.renstra.opsi.program.kegiatan');
                    Route::get('kegiatan/{id}/sub-kegiatan', 'RenstraController@getSubKegiatan')->name('api.renstra.opsi.kegiatan.sub-kegiatan');
                });
            });
            
            

            Route::group(['prefix' => 'dak'], function () {
                Route::get('', 'DakController@get')->name('api.dak');
                Route::get('data-table', 'DakController@dataTable')->name('api.dak.data-table');
                Route::get('perencanaan/{uuid}', 'DakController@perencanaan')->name('api.dak.perencanaan');
                Route::post('', 'DakController@create')->name('api.dak.create');
                Route::get('uuid/{uuid}', 'DakController@findByUuid')->name('api.dak.find-paket');
                Route::post('realisasi_dak/{uuid}','DakController@updateRealisasi')->name('api.dak.realisasi.update');
                Route::get('data-table-realisasi', 'DakController@dataTableRealisasi')->name('api.dak.realisasi.data-table');
            });

            Route::group(['prefix' => 'dak_non_fisik'], function () {
                Route::get('data-table', 'DakNonFisikController@dataTable')->name('api.dak_non_fisik.data-table');
                Route::post('', 'DakNonFisikController@create')->name('api.dak_non_fisik.create');
                Route::get('perencanaan/{uuid}', 'DakNonFisikController@perencanaan')->name('api.dak_non_fisik.perencanaan');
                Route::get('uuid/{uuid}', 'DakNonFisikController@findByUuid')->name('api.dak_non_fisik.find-paket');
                // Route::post('realisasi_dak/{uuid}','DakNonFisikController@updateRealisasi')->name('api.dak.realisasi.update');
                Route::get('data-table-realisasi', 'DakNonFisikController@dataTableRealisasi')->name('api.dak_non_fisik.realisasi.data-table');
            });

            Route::group(['prefix' => 'pen'], function () {
                Route::get('data-table/{tahun}/{keyword}', 'DakNonFisikController@dataTablePen')->name('api.pen.data-table');
                Route::get('data-table-realisasi-pen/{tahun}/{keyword}', 'DakNonFisikController@dataTableRealisasiPen')->name('api.dakSame.data-table');
            });
            
            Route::group(['prefix' => 'dau'], function () {
                Route::get('', 'DauController@get')->name('api.dau');
                Route::get('data-table', 'DauController@dataTable')->name('api.dau.data-table');
                Route::get('perencanaan/{uuid}', 'DauController@perencanaan')->name('api.dau.perencanaan');
                Route::post('', 'DauController@create')->name('api.dau.create');
                Route::get('uuid/{uuid}', 'DauController@findByUuid')->name('api.dau.find-paket');
                Route::post('realisasi_dau/{uuid}','DauController@updateRealisasi')->name('api.dau.realisasi.update');
                Route::get('data-table-realisasi', 'DauController@dataTableRealisasi')->name('api.dau.realisasi.data-table');
            });

            Route::group(['prefix' => 'tujuan'], function () {
                Route::get('', 'TujuanController@get')->name('api.tujuan');
                Route::get('data-table', 'TujuanController@dataTable')->name('api.tujuan.data-table');
                Route::get('{id}', 'TujuanController@find')->name('api.tujuan.find');
                Route::get('uuid/{uuid}', 'TujuanController@findByUuid')->name('api.tujuan.find-uuid');
                Route::post('', 'TujuanController@create')->name('api.tujuan.create');
                Route::put('{id}', 'TujuanController@update')->name('api.tujuan.update');
                Route::delete('{id}', 'TujuanController@delete')->name('api.tujuan.delete');
                Route::delete('uuid/{uuid}', 'TujuanController@deleteByUuid')->name('api.tujuan.delete');
                Route::get('{id}/bidang-tujuan', 'TujuanController@getBidangUrusan')->name('api.tujuan.find.bidang-urusan');
            });
            Route::group(['prefix' => 'sasaran'], function () {
                Route::get('', 'SasaranController@get')->name('api.sasaran');
                Route::get('data-table', 'SasaranController@dataTable')->name('api.sasaran.data-table');
                Route::get('{id}', 'SasaranController@find')->name('api.sasaran.find');
                Route::get('uuid/{uuid}', 'SasaranController@findByUuid')->name('api.sasaran.find-uuid');
                Route::post('', 'SasaranController@create')->name('api.sasaran.create');
                Route::put('{id}', 'SasaranController@update')->name('api.sasaran.update');
                Route::delete('{id}', 'SasaranController@delete')->name('api.sasaran.delete');
                Route::delete('uuid/{uuid}', 'SasaranController@deleteByUuid')->name('api.sasaran.delete');
                Route::get('{id}/bidang-sasaran', 'SasaranController@getBidangUrusan')->name('api.sasaran.find.bidang-urusan');
            });
            
            Route::group(['prefix' => 'renstra-program'], function () {
                Route::get('', 'RenstraProgramController@get')->name('api.renstra-program');
                Route::get('data-table', 'RenstraProgramController@dataTable')->name('api.renstra-program.data-table');
                Route::get('{id}', 'RenstraProgramController@find')->name('api.renstra-program.find');
                Route::get('uuid/{uuid}', 'RenstraProgramController@findByUuid')->name('api.renstra-program.find-uuid');
                Route::post('', 'RenstraProgramController@create')->name('api.renstra-program.create');
                Route::put('{id}', 'RenstraProgramController@update')->name('api.renstra-program.update');
                Route::delete('{id}', 'RenstraProgramController@delete')->name('api.renstra-program.delete');
                Route::delete('uuid/{uuid}', 'RenstraProgramController@deleteByUuid')->name('api.renstra-program.delete');
                Route::get('{id}/outcome-renstra-program', 'RenstraProgramController@getRenstraProgramOutcome')->name('api.renstra-program.find.renstra-program-outcome');
            });
            
            Route::group(['prefix' => 'renstra-kegiatan'], function () {
                Route::get('', 'RenstraKegiatanController@get')->name('api.renstra-kegiatan');
                Route::get('data-table', 'RenstraKegiatanController@dataTable')->name('api.renstra-kegiatan.data-table');
                Route::get('{id}', 'RenstraKegiatanController@find')->name('api.renstra-kegiatan.find');
                Route::get('uuid/{uuid}', 'RenstraKegiatanController@findByUuid')->name('api.renstra-kegiatan.find-uuid');
                Route::post('', 'RenstraKegiatanController@create')->name('api.renstra-kegiatan.create');
                Route::put('{id}', 'RenstraKegiatanController@update')->name('api.renstra-kegiatan.update');
                Route::delete('{id}', 'RenstraKegiatanController@delete')->name('api.renstra-kegiatan.delete');
                Route::delete('uuid/{uuid}', 'RenstraKegiatanController@deleteByUuid')->name('api.renstra-kegiatan.delete');
                Route::get('{id}/bidang-renstra-kegiatan', 'RenstraKegiatanController@getBidangUrusan')->name('api.renstra-kegiatan.find.bidang-urusan');
            });

            Route::group(['prefix' => 'renstra-sub-kegiatan'], function () {
                Route::get('', 'RenstraSubKegiatanController@get')->name('api.renstra-sub-kegiatan');
                Route::get('data-table', 'RenstraSubKegiatanController@dataTable')->name('api.renstra-sub-kegiatan.data-table');
                Route::get('{id}', 'RenstraSubKegiatanController@find')->name('api.renstra-sub-kegiatan.find');
                Route::get('uuid/{uuid}', 'RenstraSubKegiatanController@findByUuid')->name('api.renstra-sub-kegiatan.find-uuid');
                Route::post('', 'RenstraSubKegiatanController@create')->name('api.renstra-sub-kegiatan.create');
                Route::get('{uuid}', 'RenstraSubKegiatanController@edit')->name('api.renstra-sub-kegiatan.edit');
                Route::put('{uuid}', 'RenstraSubKegiatanController@updateTolakUkur')->name('api.renstra-sub-kegiatan.update-tolak-ukur');
                Route::post('update', 'RenstraSubKegiatanController@updateData')->name('api.renstra-sub-kegiatan.update');
                Route::delete('uuid/{uuid}', 'RenstraSubKegiatanController@deleteByUuid')->name('api.renstra-sub-kegiatan.delete');
            });
            
            Route::group(['prefix' => 'renstra-realisasi-sub-kegiatan'], function () {
                Route::get('', 'RenstraRealisasiSubKegiatanController@get')->name('api.renstra-realisasi-sub-kegiatan');
                Route::get('data-table', 'RenstraRealisasiSubKegiatanController@dataTable')->name('api.renstra-realisasi-sub-kegiatan.data-table');
                Route::get('{id}', 'RenstraRealisasiSubKegiatanController@find')->name('api.renstra-realisasi-sub-kegiatan.find');
                Route::get('uuid/{uuid}', 'RenstraRealisasiSubKegiatanController@findByUuid')->name('api.renstra-realisasi-sub-kegiatan.find-uuid');
                Route::post('', 'RenstraRealisasiSubKegiatanController@create')->name('api.renstra-realisasi-sub-kegiatan.create');
                Route::get('{uuid}', 'RenstraRealisasiSubKegiatanController@edit')->name('api.renstra-realisasi-sub-kegiatan.edit');
                Route::put('{uuid}', 'RenstraRealisasiSubKegiatanController@updateTolakUkur')->name('api.renstra-realisasi-sub-kegiatan.update-tolak-ukur');
                Route::post('update', 'RenstraRealisasiSubKegiatanController@updateData')->name('api.renstra-realisasi-sub-kegiatan.update');
                Route::delete('uuid/{uuid}', 'RenstraRealisasiSubKegiatanController@deleteByUuid')->name('api.renstra-realisasi-sub-kegiatan.delete');
            });
        });
        Route::group(['middleware' => 'has-access:master-kegiatan'], function () {
            Route::group(['prefix' => 'urusan'], function () {
                Route::get('', 'UrusanController@get')->name('api.urusan');
                Route::get('data-table', 'UrusanController@dataTable')->name('api.urusan.data-table');
                Route::get('{id}', 'UrusanController@find')->name('api.urusan.find');
                Route::get('uuid/{uuid}', 'UrusanController@findByUuid')->name('api.urusan.find-uuid');
                Route::post('', 'UrusanController@create')->name('api.urusan.create');
                Route::put('{id}', 'UrusanController@update')->name('api.urusan.update');
                Route::delete('{id}', 'UrusanController@delete')->name('api.urusan.delete');
                Route::delete('uuid/{uuid}', 'UrusanController@deleteByUuid')->name('api.urusan.delete');
                Route::get('{id}/bidang-urusan', 'UrusanController@getBidangUrusan')->name('api.urusan.find.bidang-urusan');
            });
            Route::group(['prefix' => 'bidang-urusan'], function () {
                Route::get('', 'BidangUrusanController@get')->name('api.bidang-urusan');
                Route::get('data-table', 'BidangUrusanController@dataTable')->name('api.bidang-urusan.data-table');
                Route::get('{id}', 'BidangUrusanController@find')->name('api.bidang-urusan.find');
                Route::get('uuid/{uuid}', 'BidangUrusanController@findByUuid')->name('api.bidang-urusan.find-uuid');
                Route::post('', 'BidangUrusanController@create')->name('api.bidang-urusan.create');
                Route::put('{id}', 'BidangUrusanController@update')->name('api.bidang-urusan.update');
                Route::delete('{id}', 'BidangUrusanController@delete')->name('api.bidang-urusan.delete');
                Route::delete('uuid/{uuid}', 'BidangUrusanController@deleteByUuid')->name('api.bidang-urusan.delete');
                Route::get('{id}/program', 'BidangUrusanController@getProgram')->name('api.bidang-urusan.find.program');

            });
            Route::group(['prefix' => 'kegiatan'], function () {
                Route::get('', 'KegiatanController@get')->name('api.kegiatan');
                Route::get('data-table', 'KegiatanController@dataTable')->name('api.kegiatan.data-table');
                Route::get('{id}', 'KegiatanController@find')->name('api.kegiatan.find');
                Route::get('uuid/{uuid}', 'KegiatanController@findByUuid')->name('api.kegiatan.find-uuid');
                Route::post('', 'KegiatanController@create')->name('api.kegiatan.create');
                Route::put('{id}', 'KegiatanController@update')->name('api.kegiatan.update');
                Route::delete('{id}', 'KegiatanController@delete')->name('api.kegiatan.delete');
                Route::delete('uuid/{uuid}', 'KegiatanController@deleteByUuid')->name('api.kegiatan.delete');

            });
            Route::group(['prefix' => 'sub-kegiatan'], function () {
                Route::get('', 'SubKegiatanController@get')->name('api.sub-kegiatan');
                Route::get('data-table', 'SubKegiatanController@dataTable')->name('api.sub-kegiatan.data-table');
                Route::get('{id}', 'SubKegiatanController@find')->name('api.sub-kegiatan.find');
                Route::get('uuid/{uuid}', 'SubKegiatanController@findByUuid')->name('api.sub-kegiatan.find-uuid');
                Route::post('', 'SubKegiatanController@create')->name('api.sub-kegiatan.create');
                Route::put('{id}', 'SubKegiatanController@update')->name('api.sub-kegiatan.update');
                Route::delete('{id}', 'SubKegiatanController@delete')->name('api.sub-kegiatan.delete');
                Route::delete('uuid/{uuid}', 'SubKegiatanController@deleteByUuid')->name('api.sub-kegiatan.delete');
                Route::post('generate-kode', 'SubKegiatanController@generateKode')->name('api.sub-kegiatan.generate-kode');
            });

          

            Route::group(['prefix' => 'rpjmd'], function () {
                Route::get('', 'RpjmdController@get')->name('api.rpjmd');
                Route::get('data-table', 'RpjmdController@dataTable')->name('api.rpjmd.data-table');
                Route::get('{id}', 'RpjmdController@find')->name('api.rpjmd.find');
                Route::get('uuid/{uuid}', 'RpjmdController@findByUuid')->name('api.rpjmd.find-uuid');
                Route::post('', 'RpjmdController@create')->name('api.rpjmd.create');
                Route::put('{uuid}', 'RpjmdController@updateTolakUkur')->name('api.rpjmd.update-tolak-ukur');
                Route::put('update/{id}', 'RpjmdController@update')->name('api.rpjmd.update');
                Route::delete('{id}', 'RpjmdController@delete')->name('api.rpjmd.delete');
                Route::post('target/{uuid}','RpjmdController@updateTarget')->name('api.rpjmd.target.update');
                Route::post('realisasi/{uuid}','RpjmdController@updateRealisasi')->name('api.rpjmd.realisasi.update');
                Route::delete('uuid/{uuid}', 'RpjmdController@deleteByUuid')->name('api.rpjmd.delete');
                Route::group(['prefix' => 'option'],function (){
                    Route::get('program','RpjmdController@getProgram')->name('api.rpjmd.opsi.program');
                    Route::get('kegiatan', 'RpjmdController@getKegiatan')->name('api.rpjmd.opsi.kegiatan');
                    Route::get('sub-kegiatan','RpjmdController@getSubKegiatanAll')->name('api.rpjmd.opsi.sub-kegiatan');
                    Route::get('penanggung-jawab', 'RpjmdController@getPenanggungJawab')->name('api.rpjmd.opsi.pj');
                    Route::get('program/{id}/kegiatan', 'ProgramController@getKegiatan')->name('api.rpjmd.opsi.program.kegiatan');
                    Route::get('kegiatan/{id}/sub-kegiatan', 'RpjmdController@getSubKegiatan')->name('api.rpjmd.opsi.kegiatan.sub-kegiatan');
                });
            });
            
            Route::group(['prefix' => 'rkpd'], function () {
                Route::get('', 'RkpdController@get')->name('api.rkpd');
                Route::get('data-table', 'RkpdController@dataTable')->name('api.rkpd.data-table');
                Route::get('{id}', 'RkpdController@find')->name('api.rkpd.find');
                Route::get('uuid/{uuid}', 'RkpdController@findByUuid')->name('api.rkpd.find-uuid');
                Route::post('', 'RkpdController@create')->name('api.rkpd.create');
                Route::put('{uuid}', 'RkpdController@updateTolakUkur')->name('api.rkpd.update-tolak-ukur');
                Route::put('update/{id}', 'RkpdController@update')->name('api.rkpd.update');
                Route::delete('{id}', 'RkpdController@delete')->name('api.rkpd.delete');
                Route::post('target/{uuid}','RkpdController@updateTarget')->name('api.rkpd.target.update');
                Route::post('realisasi/{uuid}','RkpdController@updateRealisasi')->name('api.rkpd.realisasi.update');
                Route::delete('uuid/{uuid}', 'RkpdController@deleteByUuid')->name('api.rkpd.delete');
                Route::group(['prefix' => 'option'],function (){
                    Route::get('program','RkpdController@getProgram')->name('api.rkpd.opsi.program');
                    Route::get('kegiatan', 'RkpdController@getKegiatan')->name('api.rkpd.opsi.kegiatan');
                    Route::get('sub-kegiatan','RkpdController@getSubKegiatanAll')->name('api.rkpd.opsi.sub-kegiatan');
                    Route::get('penanggung-jawab', 'RkpdController@getPenanggungJawab')->name('api.rkpd.opsi.pj');
                    Route::get('program/{id}/kegiatan', 'ProgramController@getKegiatan')->name('api.rkpd.opsi.program.kegiatan');
                    Route::get('kegiatan/{id}/sub-kegiatan', 'RkpdController@getSubKegiatan')->name('api.rkpd.opsi.kegiatan.sub-kegiatan');
                });
            });
            
        });
        
        Route::group(['middleware' => 'has-access:master-kegiatan'], function () {
            Route::group(['prefix' => 'bidang-dak'], function () {
                Route::get('', 'BidangDakController@get')->name('api.bidangdak');
                Route::get('data-table', 'BidangDakController@dataTable')->name('api.bidangdak.data-table');
                Route::post('', 'BidangDakController@create')->name('api.bidangdak.create');
                Route::get('uuid/{uuid}', 'BidangDakController@findByUuid')->name('api.bidangdak.find-uuid');
                Route::delete('uuid/{uuid}', 'BidangDakController@deleteByUuid')->name('api.bidangdak.delete');
            });
            Route::group(['prefix' => 'sub-bidang-dak'], function () {
                Route::get('', 'SubBidangDakController@get')->name('api.subbidangdak');
                Route::get('data-table', 'SubBidangDakController@dataTable')->name('api.subbidangdak.data-table');
                Route::post('', 'SubBidangDakController@create')->name('api.subbidangdak.create');
                Route::get('uuid/{uuid}', 'SubBidangDakController@findByUuid')->name('api.subbidangdak.find-uuid');
                Route::delete('uuid/{uuid}', 'SubBidangDakController@deleteByUuid')->name('api.subbidangdak.delete');
            });
            Route::group(['prefix' => 'kegiatan-dak'], function () {
                Route::get('', 'KegiatanDakController@get')->name('api.kegiatandak');
                Route::get('data-table', 'KegiatanDakController@dataTable')->name('api.kegiatandak.data-table');
                Route::post('', 'KegiatanDakController@create')->name('api.kegiatandak.create');
                Route::get('uuid/{uuid}', 'KegiatanDakController@findByUuid')->name('api.kegiatandak.find-uuid');
                Route::delete('uuid/{uuid}', 'KegiatanDakController@deleteByUuid')->name('api.kegiatandak.delete');
            });
            Route::group(['prefix' => 'tematik-dak'], function () {
                Route::get('', 'TematikDakController@get')->name('api.tematikdak');
                Route::get('data-table', 'TematikDakController@dataTable')->name('api.tematikdak.data-table');
                Route::post('', 'TematikDakController@create')->name('api.tematikdak.create');
                Route::get('uuid/{uuid}', 'TematikDakController@findByUuid')->name('api.tematikdak.find-uuid');
                Route::delete('uuid/{uuid}', 'TematikDakController@deleteByUuid')->name('api.tematikdak.delete');
            });
            Route::group(['prefix' => 'rincian-dak'], function () {
                Route::get('', 'RincianDakController@get')->name('api.rinciandak');
                Route::get('data-table', 'RincianDakController@dataTable')->name('api.rinciandak.data-table');
                Route::post('', 'RincianDakController@create')->name('api.rinciandak.create');
                Route::get('uuid/{uuid}', 'RincianDakController@findByUuid')->name('api.rinciandak.find-uuid');
                Route::delete('uuid/{uuid}', 'RincianDakController@deleteByUuid')->name('api.rinciandak.delete');
            });
        });

        Route::group(['middleware' => 'has-access:laporan'], function () {
            
        });
        Route::group(['middleware' => 'has-access:master'], function () {
           
            Route::group(['prefix' => 'program'], function () {
                Route::get('', 'ProgramController@get')->name('api.program');
                Route::get('data-table', 'ProgramController@dataTable')->name('api.program.data-table');
                Route::get('{id}', 'ProgramController@find')->name('api.program.find');
                Route::get('uuid/{uuid}', 'ProgramController@findByUuid')->name('api.program.find-uuid');
                Route::post('', 'ProgramController@create')->name('api.program.create');
                Route::put('{id}', 'ProgramController@update')->name('api.program.update');
                Route::delete('{id}', 'ProgramController@delete')->name('api.program.delete');
                Route::delete('uuid/{uuid}', 'ProgramController@deleteByUuid')->name('api.program.delete');
                Route::get('{id}/kegiatan', 'ProgramController@getKegiatan')->name('api.program.find.kegiatan');
            });
            
            Route::group(['prefix' => 'sumber-dana'], function () {
                Route::get('', 'SumberDanaController@get')->name('api.sumber-dana');
                Route::get('data-table', 'SumberDanaController@dataTable')->name('api.sumber-dana.data-table');
                Route::get('{id}', 'SumberDanaController@find')->name('api.sumber-dana.find');
                Route::get('uuid/{uuid}', 'SumberDanaController@findByUuid')->name('api.sumber-dana.find-uuid');
                Route::post('', 'SumberDanaController@create')->name('api.sumber-dana.create');
                Route::put('{id}', 'SumberDanaController@update')->name('api.sumber-dana.update');
                Route::delete('{id}', 'SumberDanaController@delete')->name('api.sumber-dana.delete');
                Route::delete('uuid/{uuid}', 'SumberDanaController@deleteByUuid')->name('api.sumber-dana.delete');
            });
            Route::group(['prefix' => 'satuan'], function () {
                Route::get('', 'SatuanController@get')->name('api.satuan');
                Route::get('data-table', 'SatuanController@dataTable')->name('api.satuan.data-table');
                Route::get('{id}', 'SatuanController@find')->name('api.satuan.find');
                Route::get('uuid/{uuid}', 'SatuanController@findByUuid')->name('api.satuan.find-uuid');
                Route::post('', 'SatuanController@create')->name('api.satuan.create');
                Route::put('{id}', 'SatuanController@update')->name('api.satuan.update');
                Route::delete('{id}', 'SatuanController@delete')->name('api.satuan.delete');
                Route::delete('uuid/{uuid}', 'SatuanController@deleteByUuid')->name('api.satuan.delete');
            });

            Route::group(['prefix' => 'kecamatan'], function () {
                Route::get('', 'KecamatanController@get')->name('api.kecamatan');
                Route::get('data-table', 'KecamatanController@dataTable')->name('api.kecamatan.data-table');
                Route::get('{id}', 'KecamatanController@find')->name('api.kecamatan.find');
                Route::get('uuid/{uuid}', 'KecamatanController@findByUuid')->name('api.kecamatan.find-uuid');
                Route::post('', 'KecamatanController@create')->name('api.kecamatan.create');
                Route::put('{id}', 'KecamatanController@update')->name('api.kecamatan.update');
                Route::delete('{id}', 'KecamatanController@delete')->name('api.kecamatan.delete');
                Route::delete('uuid/{uuid}', 'KecamatanController@deleteByUuid')->name('api.kecamatan.delete');
            });
            
            Route::group(['prefix' => 'desa'], function () {
                Route::get('', 'DesaController@get')->name('api.desa');
                Route::get('data-table', 'DesaController@dataTable')->name('api.desa.data-table');
                Route::get('{id}', 'DesaController@find')->name('api.desa.find');
                Route::get('uuid/{uuid}', 'DesaController@findByUuid')->name('api.desa.find-uuid');
                Route::post('', 'DesaController@create')->name('api.desa.create');
                Route::put('{id}', 'DesaController@update')->name('api.desa.update');
                Route::delete('{id}', 'DesaController@delete')->name('api.desa.delete');
                Route::delete('uuid/{uuid}', 'DesaController@deleteByUuid')->name('api.desa.delete');
            });
            Route::group(['prefix' => 'metode-pelaksanaan'], function () {
                Route::get('', 'MetodePelaksanaanController@get')->name('api.metode-pelaksanaan');
                Route::get('data-table', 'MetodePelaksanaanController@dataTable')->name('api.metode-pelaksanaan.data-table');
                Route::get('{id}', 'MetodePelaksanaanController@find')->name('api.metode-pelaksanaan.find');
                Route::get('uuid/{uuid}', 'MetodePelaksanaanController@findByUuid')->name('api.metode-pelaksanaan.find-uuid');
                Route::post('', 'MetodePelaksanaanController@create')->name('api.metode-pelaksanaan.create');
                Route::put('{id}', 'MetodePelaksanaanController@update')->name('api.metode-pelaksanaan.update');
                Route::delete('{id}', 'MetodePelaksanaanController@delete')->name('api.metode-pelaksanaan.delete');
                Route::delete('uuid/{uuid}', 'MetodePelaksanaanController@deleteByUuid')->name('api.metode-pelaksanaan.delete');
            });
            Route::group(['prefix' => 'jenis-belanja'], function () {
                Route::get('', 'JenisBelanjaController@get')->name('api.jenis-belanja');
                Route::get('data-table', 'JenisBelanjaController@dataTable')->name('api.jenis-belanja.data-table');
                Route::get('{id}', 'JenisBelanjaController@find')->name('api.jenis-belanja.find');
                Route::get('uuid/{uuid}', 'JenisBelanjaController@findByUuid')->name('api.jenis-belanja.find-uuid');
                Route::post('', 'JenisBelanjaController@create')->name('api.jenis-belanja.create');
                Route::put('{id}', 'JenisBelanjaController@update')->name('api.jenis-belanja.update');
                Route::delete('{id}', 'JenisBelanjaController@delete')->name('api.jenis-belanja.delete');
                Route::delete('uuid/{uuid}', 'JenisBelanjaController@deleteByUuid')->name('api.jenis-belanja.delete');
            });
            Route::group(['prefix' => 'jabatan'], function () {
                Route::get('', 'JabatanController@get')->name('api.jabatan');
                Route::get('{id}', 'JabatanController@find')->name('api.jabatan.find');
                Route::post('', 'JabatanController@create')->name('api.jabatan.create');
                Route::put('{id}', 'JabatanController@update')->name('api.jabatan.update');
                Route::delete('{id}', 'JabatanController@delete')->name('api.jabatan.delete');
            });
        });
        Route::group(['middleware' => 'has-access:monitoring-dan-evaluasi'], function () {
            Route::group(['prefix' => 'realisasi'], function () {
                Route::get('', 'RealisasiController@get')->name('api.realisasi');
                Route::get('{id}', 'RealisasiController@find')->name('api.realisasi.find');
                Route::post('', 'RealisasiController@create')->name('api.realisasi.create');
                Route::put('{id}', 'RealisasiController@update')->name('api.realisasi.update');
                Route::delete('{id}', 'RealisasiController@delete')->name('api.realisasi.delete');
            });
            Route::group(['prefix' => 'rkpd'], function () {
                Route::get('', 'RkpdController@get')->name('api.rkpd');
                Route::get('{id}', 'RkpdController@find')->name('api.rkpd.find');
                Route::post('', 'RkpdController@create')->name('api.rkpd.create');
                Route::put('{id}', 'RkpdController@update')->name('api.rkpd.update');
                Route::delete('{id}', 'RkpdController@delete')->name('api.rkpd.delete');
            });
            Route::group(['prefix' => 'target'], function () {
                Route::get('', 'TargetController@get')->name('api.target');
                Route::get('{id}', 'TargetController@find')->name('api.target.find');
                Route::post('', 'TargetController@create')->name('api.target.create');
                Route::put('{id}', 'TargetController@update')->name('api.target.update');
                Route::delete('{id}', 'TargetController@delete')->name('api.target.delete');
            });
        });
        Route::post('akun','UserController@updateAkun')->name('api.akun.update');
        Route::group(['middleware' => 'has-access:pengaturan'], function () {
            Route::group(['prefix' => 'jadwal'], function () {
                Route::get('', 'JadwalController@get')->name('api.jadwal');
                Route::get('data-table', 'JadwalController@dataTable')->name('api.jadwal.data-table');
                Route::get('{id}', 'JadwalController@find')->name('api.jadwal.find');
                Route::get('uuid/{uuid}', 'JadwalController@findByUuid')->name('api.jadwal.find-uuid');
                Route::post('', 'JadwalController@create')->name('api.jadwal.create');
                Route::put('{id}', 'JadwalController@update')->name('api.jadwal.update');
                Route::delete('{id}', 'JadwalController@delete')->name('api.jadwal.delete');
                Route::delete('uuid/{uuid}', 'JadwalController@deleteByUuid')->name('api.jadwal.delete');
            });
            Route::group(['prefix' => 'backupreport'], function () {
                Route::get('', 'BackupReportController@get')->name('api.backupreport');
                Route::get('data-table', 'BackupReportController@dataTable')->name('api.backupreport.data-table');
                Route::get('{id}', 'BackupReportController@find')->name('api.backupreport.find');
                Route::get('uuid/{uuid}', 'BackupReportController@findByUuid')->name('api.backupreport.find-uuid');
                Route::post('', 'BackupReportController@create')->name('api.backupreport.create');
                Route::put('{id}', 'BackupReportController@update')->name('api.backupreport.update');
                Route::delete('{id}', 'BackupReportController@delete')->name('api.backupreport.delete');
                Route::delete('uuid/{uuid}', 'BackupReportController@deleteByUuid')->name('api.backupreport.delete');
            });
            Route::group(['prefix' => 'periode'], function () {
                Route::get('', 'PeriodeController@get')->name('api.periode');
                Route::get('{id}', 'PeriodeController@find')->name('api.periode.find');
                Route::post('', 'PeriodeController@create')->name('api.periode.create');
                Route::put('{id}', 'PeriodeController@update')->name('api.periode.update');
                Route::delete('{id}', 'PeriodeController@delete')->name('api.periode.delete');
            });
            Route::group(['prefix' => 'tahapan'], function () {
                Route::get('', 'TahapanController@get')->name('api.tahapan');
                Route::get('{id}', 'TahapanController@find')->name('api.tahapan.find');
                Route::get('{tahapan}/sub-tahapan', 'TahapanController@getSubTahapan')->name('api.tahapan.find.sub-tahapan');
            });
            Route::group(['prefix' => 'sub-tahapan'], function () {
                Route::get('', 'SubTahapanController@get')->name('api.sub-tahapan');
                Route::get('{id}', 'SubTahapanController@find')->name('api.sub-tahapan.find');
            });
        });
        Route::group(['middleware' => 'has-access:unit-kerja'], function () {
            Route::group(['prefix' => 'profile-daerah'], function () {
                Route::get('', 'ProfileDaerahController@get')->name('api.profile-daerah');
                Route::get('{id}', 'ProfileDaerahController@find')->name('api.profile-daerah.find');
                Route::post('', 'ProfileDaerahController@create')->name('api.profile-daerah.create');
                Route::put('{id}', 'ProfileDaerahController@update')->name('api.profile-daerah.update');
                Route::delete('{id}', 'ProfileDaerahController@delete')->name('api.profile-daerah.delete');
            });
            Route::group(['prefix' => 'pegawai-penanggung-jawab'], function () {
                Route::get('', 'PegawaiPenanggungJawabController@get')->name('api.pegawai-penanggung-jawab');
                Route::get('data-table', 'PegawaiPenanggungJawabController@dataTable')->name('api.pegawai-penanggung-jawab.data-table');
                Route::get('{id}', 'PegawaiPenanggungJawabController@find')->name('api.pegawai-penanggung-jawab.find');
                Route::get('uuid/{uuid}', 'PegawaiPenanggungJawabController@findByUuid')->name('api.pegawai-penanggung-jawab.find-uuid');
                Route::post('', 'PegawaiPenanggungJawabController@create')->name('api.pegawai-penanggung-jawab.create');
                Route::put('{id}', 'PegawaiPenanggungJawabController@update')->name('api.pegawai-penanggung-jawab.update');
                Route::delete('{id}', 'PegawaiPenanggungJawabController@delete')->name('api.pegawai-penanggung-jawab.delete');
                Route::delete('uuid/{uuid}', 'PegawaiPenanggungJawabController@deleteByUuid')->name('api.pegawai-penanggung-jawab.delete');
                Route::post('toggle-status/{uuid}', 'PegawaiPenanggungJawabController@toggleStatus')->name('api.egawai-penanggung-jawab.toggle-status');
            });
            Route::group(['prefix' => 'unit-kerja'], function () {
                Route::get('', 'UnitKerjaController@get')->name('api.unit-kerja');
                Route::get('data-table', 'UnitKerjaController@dataTable')->name('api.unit-kerja.data-table');
                Route::get('{id}', 'UnitKerjaController@find')->name('api.unit-kerja.find');
                Route::get('uuid/{uuid}', 'UnitKerjaController@findByUuid')->name('api.unit-kerja.find-uuid');
                Route::post('', 'UnitKerjaController@create')->name('api.unit-kerja.create');
                Route::put('{id}', 'UnitKerjaController@update')->name('api.unit-kerja.update');
                Route::delete('{id}', 'UnitKerjaController@delete')->name('api.unit-kerja.delete');
                Route::delete('uuid/{uuid}', 'UnitKerjaController@deleteByUuid')->name('api.unit-kerja.delete');
                Route::post('generate-kode', 'UnitKerjaController@generateKode')->name('api.unit-kerja.generate-kode');
            });
        });
        Route::get('pegawai', 'PegawaiController@get')->name('api.pegawai');
        Route::group(['middleware' => 'has-access:user'], function () {
            Route::group(['prefix' => 'akses'], function () {
                Route::get('', 'AksesController@get')->name('api.akses');
                Route::get('data-table', 'AksesController@dataTable')->name('api.akses.data-table');
                Route::get('{id}', 'AksesController@find')->name('api.akses.find');
                Route::get('uuid/{uuid}', 'AksesController@findByUuid')->name('api.akses.find-uuid');
                Route::post('', 'AksesController@create')->name('api.akses.create');
                Route::put('{id}', 'AksesController@update')->name('api.akses.update');
                Route::delete('{id}', 'AksesController@delete')->name('api.akses.delete');
                Route::delete('uuid/{uuid}', 'AksesController@deleteByUuid')->name('api.akses.delete');
            });
            Route::group(['prefix' => 'pegawai'], function () {
                Route::get('data-table', 'PegawaiController@dataTable')->name('api.pegawai.data-table');
                Route::get('{id}', 'PegawaiController@find')->name('api.pegawai.find');
                Route::get('uuid/{uuid}', 'PegawaiController@findByUuid')->name('api.pegawai.find-uuid');
                Route::post('', 'PegawaiController@create')->name('api.pegawai.create');
                Route::put('{id}', 'PegawaiController@update')->name('api.pegawai.update');
                Route::delete('{id}', 'PegawaiController@delete')->name('api.pegawai.delete');
                Route::delete('uuid/{uuid}', 'PegawaiController@deleteByUuid')->name('api.pegawai.delete');
            });
            Route::group(['prefix' => 'role'], function () {
                Route::get('', 'RoleController@get')->name('api.role');
                Route::get('data-table', 'RoleController@dataTable')->name('api.role.data-table');
                Route::get('{id}', 'RoleController@find')->name('api.role.find');
                Route::get('uuid/{uuid}', 'RoleController@findByUuid')->name('api.role.find-uuid');
                Route::post('', 'RoleController@create')->name('api.role.create');
                Route::put('{id}', 'RoleController@update')->name('api.role.update');
                Route::delete('{id}', 'RoleController@delete')->name('api.role.delete');
                Route::delete('uuid/{uuid}', 'RoleController@deleteByUuid')->name('api.role.delete');
            });
            Route::group(['prefix' => 'user'], function () {
                Route::get('', 'UserController@get')->name('api.user');
                Route::get('data-table', 'UserController@dataTable')->name('api.user.data-table');
                Route::get('{id}', 'UserController@find')->name('api.user.find');
                Route::get('uuid/{uuid}', 'UserController@findByUuid')->name('api.user.find-uuid');
                Route::post('', 'UserController@create')->name('api.user.create');
                Route::put('{id}', 'UserController@update')->name('api.user.update');
                Route::delete('{id}', 'UserController@delete')->name('api.user.delete');
                Route::delete('uuid/{uuid}', 'UserController@deleteByUuid')->name('api.user.delete');
                Route::post('toggle-status/{uuid}', 'UserController@toggleStatus')->name('api.user.toggle-status');
            });

        });
        Route::post('logout', 'ApiPassportController@logout')->name('api.logout');
    });
});
