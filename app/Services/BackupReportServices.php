<?php


namespace App\Services;

use App\Models\BackupReport;
use App\Models\BackupReportDetailRealisasi;
use App\Models\BackupReportDpa;
use App\Models\BackupReportPaketDak;
use App\Models\BackupReportRealisasi;
use App\Models\BackupReportRealisasiDak;
use App\Models\BackupReportSumberDanaDpa;
use App\Models\BackupReportTarget;
use App\Models\BackupReportTolakUkur;
use App\Models\Dpa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BackupReportServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(BackupReport $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'triwulan' => $id ? 'filled' : 'required',
            'tahun' => ($id ? 'filled' : 'required') . '|numeric',
        ];
    }

    public function cekBackupReportEksist(array $attributes)
    {
        return $this->model->where(function ($q) use ($attributes) {
                foreach ($attributes as $key => $value) {
                    if ($key != 'uuid')
                    $q->where($key,$value);
                }
                if (isset($attributes['uuid'])){
                    $q->where('uuid','!=',$attributes['uuid']);
                }
            })
                ->first() !== null;
    }

    public function create(array $attributes)
    {
        DB::beginTransaction();
        try {
            $cek = BackupReport::whereRaw("tahun='$attributes[tahun]' AND triwulan='$attributes[triwulan]'")->count();
            if ($cek>0) {
                $response = [
                    'msg' => 'found'
                ];
            }else{
                $response = [
                    'msg' => 'No tfound'
                ];

                //DPA
                $dpa = Dpa::with('SumberDanaDpa','TolakUkur','Target','Realisasi','RealisasiDak','PaketDak','DetailRealisasi')->get()->toArray();
                foreach ($dpa AS $row){
                    $sumber_dana = $row['sumber_dana_dpa'];
                    $tolak_ukur = $row['tolak_ukur'];
                    $target = $row['target'];
                    $realisasi = $row['realisasi'];
                    $realisasi_dak = $row['realisasi_dak'];
                    $paket_dak = $row['paket_dak'];
                    $detail_realisasi = $row['detail_realisasi'];
                    $row['triwulan'] = $attributes['triwulan'];
                    DB::beginTransaction();
                    try {
                        $backup_dpa = BackupReportDpa::create($row);
                        foreach ($tolak_ukur as $row_tolak_ukur) {
                            $row_tolak_ukur['triwulan'] = $attributes['triwulan'];
                            $row_tolak_ukur['id_dpa_backup'] = $backup_dpa->key;
                            BackupReportTolakUkur::create($row_tolak_ukur);
                        }
                        foreach ($sumber_dana as $row_sumber_dana) {
                            $row_sumber_dana['triwulan'] = $attributes['triwulan'];
                            $row_sumber_dana['id_dpa_backup'] = $backup_dpa->key;
                            BackupReportSumberDanaDpa::create($row_sumber_dana);
                        }
                        foreach ($target as $row_target) {
                            $row_target['triwulan'] = $attributes['triwulan'];
                            $row_target['id_dpa_backup'] = $backup_dpa->key;
                            BackupReportTarget::create($row_target);
                        }
                        foreach ($realisasi as $row_realisasi) {
                            $row_realisasi['triwulan'] = $attributes['triwulan'];
                            $row_realisasi['id_dpa_backup'] = $backup_dpa->key;
                            BackupReportRealisasi::create($row_realisasi);
                        }
                        foreach ($realisasi_dak as $row_realisasi_dak) {
                            $row_realisasi_dak['triwulan'] = $attributes['triwulan'];
                            $row_realisasi_dak['id_dpa_backup'] = $backup_dpa->key;
                            BackupReportRealisasiDak::create($row_realisasi_dak);
                        }
                        foreach ($paket_dak as $row_paket_dak) {
                            $row_paket_dak['triwulan'] = $attributes['triwulan'];
                            $row_paket_dak['id_dpa_backup'] = $backup_dpa->key;
                            BackupReportPaketDak::create($row_paket_dak);
                        }
                        foreach ($detail_realisasi as $row_detail_realisasi) {
                            $row_detail_realisasi['triwulan'] = $attributes['triwulan'];
                            $row_detail_realisasi['id_dpa_backup'] = $backup_dpa->key;
                            BackupReportDetailRealisasi::create($row_detail_realisasi);
                        }
                    } catch (\Exception $exception){
                        DB::rollBack();
                        throw $exception;
                    }
                    DB::commit();
                }
//                DB::insert("INSERT INTO `backup_report_dpa`( `id`,`triwulan`, `uuid`, `is_non_urusan`, `id_program`, `id_kegiatan`, `id_sub_kegiatan`, `id_pegawai_penanggung_jawab`, `nilai_pagu_dpa`, `tahun`, `created_at`, `updated_at`, `user_insert`, `user_update`, `id_unit_kerja`) SELECT  `id`,'$attributes[triwulan]', `uuid`, `is_non_urusan`, `id_program`, `id_kegiatan`, `id_sub_kegiatan`, `id_pegawai_penanggung_jawab`, `nilai_pagu_dpa`, `tahun`, `created_at`, `updated_at`, `user_insert`, `user_update`, `id_unit_kerja` FROM dpa");
                //DPA END

                //TOLAK UKUR
//                DB::insert("INSERT INTO `backup_report_tolak_ukur`( `id`,`triwulan`, `uuid`, `id_dpa`, `tolak_ukur`, `volume`, `satuan`, `tahun`, `created_at`, `updated_at`, `user_insert`, `user_update`) SELECT  `id`,'$attributes[triwulan]', `uuid`, `id_dpa`, `tolak_ukur`, `volume`, `satuan`, `tahun`, `created_at`, `updated_at`, `user_insert`, `user_update` FROM tolak_ukur");
                //TOLAK UKUR END

                //PAKET DAK
//                DB::insert("INSERT INTO `backup_report_paket_dak`( `id`,`triwulan`, `uuid`, `nama_paket`, `volume`, `satuan`, `penerima_manfaat`, `anggaran_dak`, `pendampingan`, `total_biaya`, `swakelola`, `kontrak`, `tahun`, `id_sumber_dana_dpa`, `kesesuaian_rkpd`, `kesesuaian_dpa_skpd`, `id_dpa`, `created_at`, `updated_at`, `user_insert`, `user_update`) SELECT  `id`,'$attributes[triwulan]', `uuid`, `nama_paket`, `volume`, `satuan`, `penerima_manfaat`, `anggaran_dak`, `pendampingan`, `total_biaya`, `swakelola`, `kontrak`, `tahun`, `id_sumber_dana_dpa`, `kesesuaian_rkpd`, `kesesuaian_dpa_skpd`, `id_dpa`, `created_at`, `updated_at`, `user_insert`, `user_update` FROM paket_dak");
                //PAKET DAK END

                //TARGET
//                DB::insert("INSERT INTO `backup_report_target`( `id`,`triwulan`, `uuid`, `periode`, `target_keuangan`, `target_fisik`, `persentase`, `id_dpa`, `tahun`, `created_at`, `updated_at`, `user_insert`, `user_update`) SELECT  `id`,'$attributes[triwulan]', `uuid`, `periode`, `target_keuangan`, `target_fisik`, `persentase`, `id_dpa`, `tahun`, `created_at`, `updated_at`, `user_insert`, `user_update` FROM target");
                //TARGET END

                //REALISASI DAK
//                DB::insert("INSERT INTO `backup_report_realisasi_dak`(`id`,`triwulan`, `uuid`, `id_paket_dak`, `periode`, `realisasi_keuangan`, `realisasi_fisik`, `total_keuangan`, `total_fisik`, `tahun`, `id_dpa`, `permasalahan`, `created_at`, `updated_at`, `user_insert`, `user_update`) SELECT `id`,'$attributes[triwulan]', `uuid`, `id_paket_dak`, `periode`, `realisasi_keuangan`, `realisasi_fisik`, `total_keuangan`, `total_fisik`, `tahun`, `id_dpa`, `permasalahan`, `created_at`, `updated_at`, `user_insert`, `user_update` FROM realisasi_dak");
                //REALISASI DAK END

                //REALISASI
//                DB::insert("INSERT INTO `backup_report_realisasi`( `id`,`triwulan`, `uuid`, `periode`, `realisasi_keuangan`, `realisasi_fisik`, `tahun`, `id_dpa`, `permasalahan`, `created_at`, `updated_at`, `user_insert`, `user_update`) SELECT  `id`,'$attributes[triwulan]', `uuid`, `periode`, `realisasi_keuangan`, `realisasi_fisik`, `tahun`, `id_dpa`, `permasalahan`, `created_at`, `updated_at`, `user_insert`, `user_update` FROM realisasi");
                //REALISASI END

                //DETAIL REALISASI
//                DB::insert("INSERT INTO `backup_report_detail_realisasi`( `id`,`triwulan`, `uuid`, `id_realisasi`, `tahun`, `id_dpa`, `id_sumber_dana_dpa`, `realisasi_keuangan`, `realisasi_fisik`, `periode`, `created_at`, `updated_at`, `user_insert`, `user_update`) SELECT  `id`,'$attributes[triwulan]', `uuid`, `id_realisasi`, `tahun`, `id_dpa`, `id_sumber_dana_dpa`, `realisasi_keuangan`, `realisasi_fisik`, `periode`, `created_at`, `updated_at`, `user_insert`, `user_update` FROM detail_realisasi");
                //DETAIL REALISASI END

                //SUMBER DANA DPA
//                DB::insert("INSERT INTO `backup_report_sumber_dana_dpa`( `id`,`triwulan`, `uuid`, `jenis_belanja`, `sumber_dana`, `metode_pelaksanaan`, `nilai_pagu`, `tahun`, `id_dpa`, `created_at`, `updated_at`, `user_insert`, `user_update`) SELECT  `id`,'$attributes[triwulan]', `uuid`, `jenis_belanja`, `sumber_dana`, `metode_pelaksanaan`, `nilai_pagu`, `tahun`, `id_dpa`, `created_at`, `updated_at`, `user_insert`, `user_update` FROM sumber_dana_dpa");
                //SUMBER DANA DPA END

                DB::table('backup_report')->insert([
                    'uuid' => Str::uuid()->toString(),
                    'triwulan' => $attributes['triwulan'],
                    'tahun' => $attributes['tahun'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'user_insert' => auth()->user()->id
                ]);
                DB::commit();
            }



            return response()->json($response);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }



}


