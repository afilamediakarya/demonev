<?php


namespace App\Services;

use App\Models\SumberDanaDpa;
use App\Models\PaketDak;
use App\Models\Desa;
use App\Models\PaketDakLokasi;
use App\Models\RealisasiDak;
use App\Models\DetailRealisasiDak;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DakNonFisikService extends BaseServices
{
    protected $allowSearch = [

    ];
    protected $relation = [
        'PaketDak.PaketDakLokasi'
    ];

    public function __construct(SumberDanaDpa $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'uuid_sd' => 'required',
            'uuid_pd' => 'array|max:90',
            'tahun' => ($id ? 'filled' : 'required') . '|numeric',
            'nama_paket' => 'required|array|max:90',
            'nama_paket.*' => 'string',
            'id_desa' => 'array',
            'volume' => 'required|array|max:90',
            'volume.*' => 'numeric',
            'satuan' => 'required|array|max:90',
            'satuan.*' => 'string',
            'penerima_manfaat' => 'required|array|max:90',
            'penerima_manfaat.*' => 'string',
            'anggaran_dak' => 'required|array|max:90',
            'anggaran_dak.*' => 'numeric',
//            'pendampingan' => 'required|array|max:90',
            'pendampingan' => 'array|max:90|nullable',
            'pendampingan.*' => 'numeric|nullable',
            'swakelola' => 'array|max:90|nullable',
            'swakelola.*' => 'numeric|nullable',
            'kontrak' => 'array|max:90|nullable',
            'kontrak.*' => 'numeric|nullable',
            'kesesuaian_rkpd' => 'required|array|max:90',
            'kesesuaian_dpa_skpd' => 'required|array|max:90',
            'kecamatan' => '',
            'desa' => ''
        ];
    }

    public function rulesUpdatePaketDak(){
        return [
            'nama_paket' => 'required|array|max:90',
            'nama_paket.*' => 'string',
            'volume' => 'required|array|max:90',
            'volume.*' => 'numeric',
            'satuan' => 'required|array|max:90',
            'satuan.*' => 'string',
            'penerima_manfaat' => 'required|array|max:90',
            'penerima_manfaat.*' => 'string',
            'anggaran_dak' => 'required|array|max:90',
            'anggaran_dak.*' => 'numeric',
            'pendampingan' => 'array|max:90|nullable',
            'pendampingan.*' => 'numeric|nullable',
            'swakelola' => 'array|max:90|nullable',
            'swakelola.*' => 'numeric|nullable',
            'kontrak' => 'array|max:90|nullable',
            'kontrak.*' => 'numeric|nullable',
            'kesesuaian_rkpd' => 'required|array|max:90',
            'kesesuaian_dpa_skpd' => 'required|array|max:90',
            'kecamatan' => '',
            'desa' => ''
        ];
    }

    public function validateUpdatePaketDak(array $attributes){
        return Validator::make($attributes,$this->rulesUpdatePaketDak());
    }

    public function create(array $attributes)
    {
        DB::beginTransaction();
        try {
            $id_sumber_dana = SumberDanaDpa::select('id','id_dpa')->where('uuid',($attributes['uuid_sd']))->first();
            $paket_dak=PaketDak::whereRaw("id_sumber_dana_dpa='$id_sumber_dana->id' AND id_dpa='$id_sumber_dana->id_dpa'");
            if($paket_dak->count()>0){
                foreach($paket_dak->get() as $dt){
                    PaketDakLokasi::where('id_paket_dak',$dt->id)->delete();
                    // RealisasiDak::where('id_paket_dak',$dt->id)->delete();
                }
                // $paket_dak->delete();
                
            }
            $paket_dak = [];
            foreach ($attributes['nama_paket'] as $index => $value) {
                if ( true
//                    isset($attributes['volume'][$index])
//                    && $attributes['volume'][$index] != null
//                    && isset($attributes['satuan'][$index])
//                    && $attributes['satuan'][$index] != null
//                    && isset($attributes['penerima_manfaat'][$index])
//                    && $attributes['penerima_manfaat'][$index] != null
//                    && isset($attributes['anggaran_dak'][$index])
//                    && $attributes['anggaran_dak'][$index] != null
//                    && isset($attributes['pendampingan'][$index])
//                    && $attributes['pendampingan'][$index] != null
//                    && isset($attributes['swakelola'][$index])
//                    && $attributes['swakelola'][$index] != null
//                    && isset($attributes['kontrak'][$index])
//                    && $attributes['kontrak'][$index] != null
//                    && isset($attributes['kesesuaian_rkpd'][$index])
//                    && $attributes['kesesuaian_rkpd'][$index] != null
//                    && isset($attributes['kesesuaian_dpa_skpd'][$index])
//                    && $attributes['kesesuaian_dpa_skpd'][$index] != null
                ) {
                    if (isset($attributes['uuid_pd'][$index])){
                        // echo $attributes['uuid_pd'][$index];
                        // print_r($attributes);
                        $dak = PaketDak::where('uuid', $attributes['uuid_pd'][$index])->first();
                        if ($dak){
                            $paket_dak[] = $dak->id;
                            $id_paket_dak=$dak->id;
                            $dak->update([
                                'nama_paket' => $value,
                                // 'id_rincian' => $attributes['id_rincian'][$index],
                                'volume' => $attributes['volume'][$index],
                                'satuan' => $attributes['satuan'][$index],
                                'penerima_manfaat' => $attributes['penerima_manfaat'][$index],
                                'anggaran_dak' => $attributes['anggaran_dak'][$index],
                                'pendampingan' => $attributes['pendampingan'][$index] ?? 0,
                                'total_biaya' => $attributes['pendampingan'][$index] + $attributes['anggaran_dak'][$index],
                                'swakelola' => $attributes['swakelola'][$index] ?? 0,
                                'kontrak' => $attributes['kontrak'][$index] ?? 0,
                                'tahun' => $attributes['tahun'],
                                'kesesuaian_rkpd' => $attributes['kesesuaian_rkpd'][$index],
                                'kesesuaian_dpa_skpd' => $attributes['kesesuaian_dpa_skpd'][$index],
                                'kecamatan' => $attributes['kecamatan'][$index] ?? null,
                                'desa' => $attributes['desa'][$index] ?? null,
                                'user_insert' => auth()->user()->id,
                                'id_dpa' => $id_sumber_dana->id_dpa,
                                'id_sumber_dana_dpa' => $id_sumber_dana->id,
                                
                            ]);
                        }
                        $x= 'edit';
                    }else{
                        $sb = PaketDak::create([
                            'uuid' => Str::uuid()->toString(),
                            'nama_paket' => $value,
                            'volume' => $attributes['volume'][$index],
                            // 'id_rincian' => $attributes['id_rincian'][$index],
                            'satuan' => $attributes['satuan'][$index],
                            'penerima_manfaat' => $attributes['penerima_manfaat'][$index],
                            'anggaran_dak' => $attributes['anggaran_dak'][$index],
                            'pendampingan' => $attributes['pendampingan'][$index] ?? 0,
                            'total_biaya' => $attributes['pendampingan'][$index] + $attributes['anggaran_dak'][$index],
                            'swakelola' => $attributes['swakelola'][$index] ?? 0,
                            'kontrak' => $attributes['kontrak'][$index] ?? 0,
                            'tahun' => $attributes['tahun'],
                            'kesesuaian_rkpd' => $attributes['kesesuaian_rkpd'][$index],
                            'kesesuaian_dpa_skpd' => $attributes['kesesuaian_dpa_skpd'][$index],
                            'kecamatan' => $attributes['kecamatan'][$index] ?? null,
                            'desa' => $attributes['desa'][$index] ?? null,
                            'user_insert' => auth()->user()->id,
                            'id_dpa' => $id_sumber_dana->id_dpa,
                            'id_sumber_dana_dpa' => $id_sumber_dana->id
                        ]);
                        $paket_dak[] = $sb->id;
                        $id_paket_dak=$sb->id;
                        for ($n = 1; $n <= 4; $n++){
                            RealisasiDak::create([
                                'uuid' => Str::uuid()->toString(),
                                'periode' => $n,
                                'id_paket_dak' => $sb->id,
                                'realisasi_keuangan' => 0,
                                'realisasi_fisik' => 0,
                                'realisasi_fisik' => 0,
                                'tahun' => $attributes['tahun'],
                                'id_dpa' => $id_sumber_dana->id_dpa,
                                'id_sumber_dana_dpa' => $id_sumber_dana->id,
                                'user_insert' => auth()->user()->id
                            ]);
                        }
                        $x='create';
                    }
                    foreach ($attributes['id_desa'][$index] as $x => $value) {
                        $id_kecamatan=Desa::where('id',$attributes['id_desa'][$index][$x])->first()->id_kecamatan;
                        PaketDakLokasi::create([
                            'uuid' => Str::uuid()->toString(),
                            'id_paket_dak' => $id_paket_dak,
                            'id_desa' => $attributes['id_desa'][$index][$x],
                            'id_kecamatan' => $id_kecamatan,
                            'user_insert' => auth()->user()->id
                        ]);
                    }
                }
            }
            if (count($paket_dak)){
                /*Paket DAK yg mau di hapus*/
                PaketDak::whereNotIn('id',$paket_dak)
                    ->where([
                        'id_dpa' => $id_sumber_dana->id_dpa,
                        'id_sumber_dana_dpa' => $id_sumber_dana->id
                    ])
                    ->delete();
            }
            DB::commit();
            return 'sukses';
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    // public function updateTolakUkur(array $attributes, $uuid){
    //     $this->relation = [
    //         'TolakUkur'
    //     ];
    //     $data = $this->findByUuid($uuid);
    //     if ($data) {
    //         $data->TolakUkur()->delete();
    //         foreach ($attributes['tolak_ukur'] as $index => $value) {
    //             if (isset($attributes['volume'][$index])
    //                 && $attributes['volume'][$index] != null
    //                 && isset($attributes['satuan'][$index])
    //                 && $attributes['satuan'][$index] != null
    //             ) {
    //                 $data->TolakUkur()->create([
    //                     'uuid' => Str::uuid()->toString(),
    //                     'tolak_ukur' => $value,
    //                     'volume' => $attributes['volume'][$index],
    //                     'satuan' => $attributes['satuan'][$index],
    //                     'tahun' => $attributes['tahun'],
    //                     'user_insert' => auth()->user()->id
    //                 ]);
    //             }
    //         }
    //     }
    //     $data->refresh();
    //     return $data;
    // }

    // private function rulesTarget($uuid){
    //     $data = $this->findByUuid($uuid);
    //     return [
    //         'total_keuangan' => 'required|numeric|max:'.$data->nilai_pagu_dpa.'|min:0',
    //         'total_persentase' => 'required|numeric|max:100.01|min:0',
    //         'total_fisik' => 'required|numeric|max:100|min:0',
    //         'target_keuangan.*' => 'required|numeric',
    //         'persentase.*' => 'required|numeric',
    //         'target_fisik.*' => 'required|numeric',
    //     ];
    // }

    // public function validateTarget(array $attributes,$uuid){
    //     return Validator::make($attributes,$this->rulesTarget($uuid));
    // }

    // public function updateTarget(array $attributes, $uuid){
    //     $this->relation = ['Target'];
    //     $data = $this->findByUuid($uuid);
    //     if ($data){
    //         DB::beginTransaction();
    //         try {
    //             foreach ($attributes['target_keuangan'] as $periode => $target) {
    //                 $data->Target()->where('id_dpa', $data->id)->where('periode', $periode)->update([
    //                     'target_keuangan' => $target,
    //                     'persentase' => $attributes['persentase'][$periode],
    //                     'target_fisik' => $attributes['target_fisik'][$periode],
    //                     'user_update' => auth()->user()->id
    //                 ]);
    //             }
    //             DB::commit();
    //             return $data->refresh();
    //         } catch (\Exception $exception){
    //             DB::rollBack();
    //             throw $exception;
    //         }
    //     }
    //     return null;
    // }

    // private function rulesRealisasi($uuid){
    //     $rule_sumber_dana = [];
    //     $periode = [
    //         '1' =>  cekJadwal('Realisasi','Realisasi Triwulan I'),
    //         '2' =>  cekJadwal('Realisasi','Realisasi Triwulan II'),
    //         '3' =>  cekJadwal('Realisasi','Realisasi Triwulan III'),
    //         '4' =>  cekJadwal('Realisasi','Realisasi Triwulan IV'),
    //     ];
    //     foreach ($periode AS $i => $value) {
    //         if ($value) {
    //             $rules['realisasi_keuangan.' . $i . '.*'] = 'nullable|numeric';
    //             $rules['realisasi_fisik.' . $i . '.*'] = 'nullable|numeric';
    //             $rules['permasalahan.' . $i] = 'nullable|string';
    //             $rules['kecamatan.'.$i] = '';
    //             $rules['desa.'.$i] = '';
    //             $rules['kontrak.'.$i] = '';
    //         }
    //     }
    //     return array_merge($rules,$rule_sumber_dana);
    // }

    // public function validateRealisasi(array $attributes, $uuid){
    //     return Validator::make($attributes,$this->rulesRealisasi($uuid));
    // }

    // public function updateRealisasi(array $attributes, $uuid){
    //     $id_paket_dak = PaketDak::select('id')->where('uuid',$uuid)->first();
    //     foreach ($attributes['realisasi_keuangan'] as $index => $value) {
    //         RealisasiDak::whereRaw("periode='$index' AND id_paket_dak='$id_paket_dak'")->update([
    //             'realisasi_keuangan' => $attributes['realisasi_keuangan'][$index],
    //             'realisasi_fisik' => $attributes['realisasi_fisik'][$index]
    //         ]);
    //     }
    //     return null;
    // }

    // public function deleteByUuid($uuid, $force = false)
    // {
    //     DB::beginTransaction();
    //     $data = parent::findByUuid($uuid);
    //     $data->SumberDanaDpa()->delete();
    //     $data->Realisasi()->delete();
    //     $data->Target()->delete();
    //     $data->TolakUkur()->delete();
    //     $data->DetailRealisasi()->delete();
    //     try {
    //         $delete = parent::deleteByUuid($uuid, $force);
    //         DB::commit();
    //     } catch (\Exception $exception){
    //         DB::rollBack();
    //         throw $exception;
    //     }
    //     return $delete;
    // }
}
