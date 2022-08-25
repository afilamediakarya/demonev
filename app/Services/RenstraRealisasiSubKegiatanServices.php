<?php


namespace App\Services;

use App\Models\BidangUrusan;
use App\Models\DetailRealisasi;
use App\Models\RenstraKegiatan;
use App\Models\RenstraSubKegiatan;
use App\Models\RenstraSubKegiatanIndikator;
use App\Models\RenstraSubKegiatanTarget;
use App\Models\RenstraRealisasiSubKegiatan;
use App\Models\Jadwal;
use App\Models\Program;
use App\Models\Realisasi;
use App\Models\TolakUkur;
use App\Models\SubKegiatan;
use App\Models\SumberDanaRenstraSubKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RenstraRealisasiSubKegiatanServices extends BaseServices
{
    protected $allowSearch = [

    ];
    protected $relation = [
    //    'RenstraSubKegiatanTarget','RenstraSubKegiatanIndikator'
    //    'RenstraSubKegiatanTarget','RenstraSubKegiatanIndikator'
    ];

    public function __construct(RenstraSubKegiatan $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nilai_pagu' => 'required|array',
            'nilai_pagu.*' => 'numeric',
            'tahun' => 'required|array',
            'volume' => 'required|array',
            'volume.*' => 'numeric',
            'satuan' => 'required|array',
            'satuan.*' => 'string',
            'rk2021' => 'nullable',
            'rk2021_1' => 'nullable',
            'rk2021_2' => 'nullable',
            'rk2021_3' => 'nullable',
            'rk2021_4' => 'nullable',
        ];
    }

    public function rulesUpdateTolakUkur(){
        return [
            'tahun' => 'required',
            'indikator' => 'required|array',
            'indikator.*' => 'string',
            'volume' => 'required|array',
            'volume.*' => 'numeric',
            'satuan' => 'required|array',
            'satuan.*' => 'string',
            'rk2021_1' => 'nullable',
            'rk2021_2' => 'nullable',
            'rk2021_3' => 'nullable',
            'rk2021_4' => 'nullable',
        ];
    }

    public function validateUpdateTolakUkur(array $attributes){
        return Validator::make($attributes,$this->rulesUpdateTolakUkur());
    }

    public function create(array $attributes)
    {
        DB::beginTransaction();
        try {
            $data=RenstraSubKegiatan::where('uuid',$attributes['uuid'])->first();
            RenstraRealisasiSubKegiatan::where('id_renstra_sub_kegiatan',$data->id)->delete();
            foreach ($attributes['tahun'] as $index => $value) {
                RenstraRealisasiSubKegiatan::create([
                    'uuid' => Str::uuid()->toString(),
                    'id_renstra_sub_kegiatan' => $data->id,
                    'id_unit_kerja' => $data->id_unit_kerja,
                    'tahun' => $value,
                    'volume' => $attributes['volume'][$index],
                    'satuan' => $attributes['satuan'][$index],
                    'realisasi_keuangan' => $attributes['nilai_pagu'][$index],

                    'user_insert' => auth()->user()->id
                ]);
            }

            $id_unit_kerja=auth()->user()->id_unit_kerja;
            $cek_dpa=DB::table('dpa')->whereRaw("id_sub_kegiatan='$data->id_sub_kegiatan' AND id_unit_kerja='$id_unit_kerja' AND tahun='2021'");
            if($cek_dpa->count()>0){
                $id_dpa=$cek_dpa->first()->id;
                for($i=1;$i<=4;$i++){
                    DB::table('realisasi')->whereRaw("tahun='2021' AND id_dpa='$id_dpa' AND periode='$i'")->update([
                        'realisasi_kinerja'=>$attributes['rk2021_'.$i]
                    ]);
                }
            }
            

            
            DB::commit();
            return $data;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    public function updsate($id, array $attributes)
    {
        $sub_kegiatan = SubKegiatan::with('Kegiatan.Program')->find($attributes['id_sub_kegiatan']);
        $attributes['id_program'] = $sub_kegiatan->Kegiatan->Program->id;
        $attributes['id_kegiatan'] = $sub_kegiatan->Kegiatan->id;
        $kegiatan = Program::with('BidangUrusan')->find($attributes['id_program']);
        $attributes['is_non_urusan'] = $kegiatan->BidangUrusan->id_urusan === BidangUrusan::ID_NON_URUSAN;
        $attributes['id_unit_kerja'] = auth()->user()->id_unit_kerja;
        DB::beginTransaction();
        try {
            if (isset($attributes['uuid']) && $attributes['uuid'] != ''){
                $data = parent::updateByUuid($attributes['uuid'],$attributes);
                $data->SumberDanaRenstraSubKegiatan()->delete();
                $data->TolakUkur()->delete();


                $data->PaketDak()->delete();
                $data->Target()->delete();
                $data->Realisasi()->delete();
                $data->RealisasiDak()->delete();
                $data->DetailRealisasi()->delete();



            } else {

                $data = parent::create($attributes);

            }


            for($n = 1; $n <= 4; $n++){
                $data->Target()->create([
                    'uuid' => Str::uuid()->toString(),
                    'periode' => $n,
                    'tahun' => $attributes['tahun'],
                    'user_insert' => auth()->user()->id
                ]);
            }

            $total_pagu = 0;

            $sumber_dana_dpa = new Collection();

            foreach ($attributes['sb_vol'] as $index => $value) {
                if (isset($attributes['sumber_dana'][$index])
                    && $attributes['sumber_dana'][$index] != null
                    && isset($attributes['sb_sat'][$index])
                    && $attributes['sb_sat'][$index] != null
                    && isset($attributes['nilai_pagu'][$index])
                    && $attributes['nilai_pagu'][$index] != null
                ) {

                    if (isset($attributes['uuid'][$index]) && $attributes['uuid'] != ''){
                        $data = parent::updateByUuid($attributes['uuid'][$index],$attributes);
                    } else {
                        $sb = $data->SumberDanaRenstraSubKegiatan()->create([
                            'uuid' => Str::uuid()->toString(),
                            'sb_vol' => $value,
                            'sumber_dana' => $attributes['sumber_dana'][$index],
                            'sb_sat' => $attributes['sb_sat'][$index],
                            'nilai_pagu' => $attributes['nilai_pagu'][$index],
                            'tahun' => $attributes['tahun'],
                            'user_insert' => auth()->user()->id
                        ]);
                        $sumber_dana_dpa->push($sb);
                    }

                    $total_pagu += $attributes['nilai_pagu'][$index];
                }
            }

            if ($total_pagu !== $data->total_pagu_renstra){
                $data->total_pagu_renstra = $total_pagu;
                $data->save();
            }


             for ($n = 1; $n <= 4; $n++){
                    $realisasi = $data->Realisasi()->create([
                        'uuid' => Str::uuid()->toString(),
                        'periode' => $n,
                        'tahun' => $attributes['tahun'],
                        'user_insert' => auth()->user()->id
                    ]);
                    foreach ($sumber_dana_dpa AS $sdp){
                        $realisasi->Detail()->create([
                            'uuid' => Str::uuid()->toString(),
                            'tahun' => $attributes['tahun'],
                            'id_dpa' => $data->id,
                            'id_sumber_dana_dpa' => $sdp->id,
                            'periode' => $n,
                            'user_insert' => auth()->user()->id
                        ]);
                    }
                }


            foreach ($attributes['indikator'] AS $index => $value){
                if (isset($attributes['volume'][$index])
                    && $attributes['volume'][$index] != null
                    && isset($attributes['satuan'][$index])
                    && $attributes['satuan'][$index] != null
                ){

                    if (isset($attributes['uuid'][$index]) && $attributes['uuid'] != ''){
                        $data = parent::updateByUuid($attributes['uuid'][$index],$attributes);
                    } else {
                        $data->TolakUkur()->create([
                            'uuid' => Str::uuid()->toString(),
                            'tolak_sukur' => $value,
                            'volume' => $attributes['volume'][$index],
                            'satuan' => $attributes['satuan'][$index],
                            'tahun' => $attributes['tahun'],
                            'user_insert' => auth()->user()->id
                        ]);
                    }


                }
            }




            $data='x';
            DB::commit();
            return $data;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function updateTolakUkur(array $attributes, $uuid){
        $this->relation = [
            'TolakUkur'
        ];
        $data = $this->findByUuid($uuid);
        if ($data) {
            $data->TolakUkur()->delete();
            foreach ($attributes['indikator'] as $index => $value) {
                if (isset($attributes['volume'][$index])
                    && $attributes['volume'][$index] != null
                    && isset($attributes['satuan'][$index])
                    && $attributes['satuan'][$index] != null
                ) {
                    $data->TolakUkur()->create([
                        'uuid' => Str::uuid()->toString(),
                        'indikator' => $value,
                        'volume' => $attributes['volume'][$index],
                        'satuan' => $attributes['satuan'][$index],
                        'tahun' => $attributes['tahun'],
                        'user_insert' => auth()->user()->id
                    ]);
                }
            }
        }
        $data->refresh();
        return $data;
    }

    private function rulesTarget($uuid){
        $data = $this->findByUuid($uuid);
        return [
            'total_keuangan' => 'required|numeric|max:'.$data->total_pagu_renstra.'|min:0',
            //'total_persentase' => 'required|numeric|max:100.05|min:0',
            //'total_fisik' => 'required|numeric|max:100|min:0',
            'target_keuangan.*' => 'required|numeric',
            'persentase.*' => 'required|numeric',
            'target_fisik.*' => 'required|numeric',
        ];
    }

    public function validateTarget(array $attributes,$uuid){
        return Validator::make($attributes,$this->rulesTarget($uuid));
    }

    public function updateTarget(array $attributes, $uuid){
        $this->relation = ['Target'];
        $data = $this->findByUuid($uuid);
        if ($data){
            DB::beginTransaction();
            try {
                foreach ($attributes['target_keuangan'] as $periode => $target) {
                    $data->Target()->where('id_dpa', $data->id)->where('periode', $periode)->update([
                        'target_keuangan' => $target,
                        'persentase' => $attributes['persentase'][$periode],
                        'target_fisik' => $attributes['target_fisik'][$periode],
                        'user_update' => auth()->user()->id
                    ]);
                }
                DB::commit();
                return $data->refresh();
            } catch (\Exception $exception){
                DB::rollBack();
                throw $exception;
            }
        }
        return null;
    }

    private function rulesRealisasi($uuid){
        $this->relation = ['SumberDanaRenstraSubKegiatan'];
        $data = $this->findByUuid($uuid);
        $rule_sumber_dana = [];
        $rules = [];
        foreach ($data->SumberDanaRenstraSubKegiatan AS $sumber_dana){
            $rule_sumber_dana['sumber_dana_'.$sumber_dana->id] = 'required|numeric|min:0|max:'.$sumber_dana->nilai_pagu;
            $rule_sumber_dana['total_fisik_'.$sumber_dana->id] = 'required|numeric|min:0|max:100';
        }
        $periode = [
            '1' =>  cekJadwal('Realisasi','Realisasi Triwulan I'),
            '2' =>  cekJadwal('Realisasi','Realisasi Triwulan II'),
            '3' =>  cekJadwal('Realisasi','Realisasi Triwulan III'),
            '4' =>  cekJadwal('Realisasi','Realisasi Triwulan IV'),
        ];
        foreach ($periode AS $i => $value) {
            if ($value) {
                $rules['realisasi_keuangan.' . $i . '.*'] = 'nullable|numeric';
                $rules['realisasi_fisik.' . $i . '.*'] = 'nullable|numeric';
                $rules['permasalahan.' . $i] = 'nullable|string';
            }
        }
        return array_merge($rules,$rule_sumber_dana);
    }

    public function validateRealisasi(array $attributes, $uuid){
        return Validator::make($attributes,$this->rulesRealisasi($uuid));
    }

    public function updateRealisasi(array $attribute, $uuid){
        $this->relation = ['SumberDanaRenstraSubKegiatan','Realisasi.Detail'];
        $data = $this->findByUuid($uuid);
        if ($data){
            foreach($attribute['realisasi_keuangan'] AS $periode => $keuangan){
                $realisasi_keuangan = 0;
                foreach ($keuangan AS $id_sumber_dana => $value){
//                    $data->Realisasi()->where('periode',$periode)->orderBy('created_at','desc')->first()->Detail()->where('id_sumber_dana_dpa',$id_sumber_dana)->update([
//                        'realisasi_keuangan' => $value
//                    ]);
                    DetailRealisasi::where('periode',$periode)->where('id_dpa',$data->id)->where('id_sumber_dana_dpa',$id_sumber_dana)->update([
                        'realisasi_keuangan' => $value,
                        'user_update' => auth()->user()->id
                    ]);
                    $realisasi_keuangan += $value;
                }

//                $data->Realisasi()->where('periode',$periode)->update([
//                    'realisasi_keuangan' => $realisasi_keuangan
//                ]);
                Realisasi::where('id_dpa',$data->id)->where('periode',$periode)->update([
                    'realisasi_keuangan' => $realisasi_keuangan
                ]);
            }
            foreach($attribute['realisasi_fisik'] AS $periode => $fisik){
                $realisasi_fisik = 0;
                foreach ($fisik AS $id_sumber_dana => $value){
//                    $data->Realisasi()->where('periode',$periode)->orderBy('created_at','desc')->first()->Detail()->where('id_sumber_dana_dpa',$id_sumber_dana)->update([
//                        'realisasi_fisik' => $value,
//                        'user_update' => auth()->user()->id
//                    ]);
                    DetailRealisasi::where('periode',$periode)->where('id_dpa',$data->id)->where('id_sumber_dana_dpa',$id_sumber_dana)->update([
                        'realisasi_fisik' => $value,
                        'user_update' => auth()->user()->id
                    ]);
                    $realisasi_fisik += $value;
                }
//                $data->Realisasi()->where('periode',$periode)->update([
//                    'realisasi_fisik' => $realisasi_fisik / count($fisik),
//                    'permasalahan' => isset($attribute['permasalahan'][$periode]) ? $attribute['permasalahan'][$periode] : null,
//                    'user_update' => auth()->user()->id
//                ]);
                Realisasi::where('id_dpa',$data->id)->where('periode',$periode)->update([
                    'realisasi_fisik' => $realisasi_fisik / count($fisik),
                    'permasalahan' => isset($attribute['permasalahan'][$periode]) ? $attribute['permasalahan'][$periode] : null,
                    'user_update' => auth()->user()->id
                ]);
            }
            return $data->refresh();
        }
        return null;
    }

    public function deleteByUuid($uuid, $force = false)
    {
        DB::beginTransaction();
        $data = parent::findByUuid($uuid);
        $data->RenstraSubKegiatanIndikator()->delete();
        $data->RenstraSubKegiatanTarget()->delete();
        try {
            $delete = parent::deleteByUuid($uuid, $force);
            DB::commit();
        } catch (\Exception $exception){
            DB::rollBack();
            throw $exception;
        }
        return $delete;
    }
}
