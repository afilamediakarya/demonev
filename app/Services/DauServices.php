<?php


namespace App\Services;

use App\Models\SumberDanaDpa;
use App\Models\PaketDau;
use App\Models\PaketDauLokasi;
use App\Models\RealisasiDau;
use App\Models\Desa;
use App\Models\DetailRealisasiDau;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class DauServices extends BaseServices
{
    protected $allowSearch = [

    ];
    protected $relation = [
        'PaketDau.PaketDauLokasi'
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
            'pagu' => 'required|array|max:90',
            'pagu.*' => 'numeric',
            'keterangan' => 'array',
            // 'keterangan.*' => 'string',
            
        ];
    }

    public function rulesUpdatePaketDau(){
        return [
            'nama_paket' => 'required|array|max:90',
            'nama_paket.*' => 'string',
            'volume' => 'required|array|max:90',
            'volume.*' => 'numeric',
            'satuan' => 'required|array|max:90',
            'satuan.*' => 'string',
            'keterangan' => 'array',
            // 'keterangan.*' => 'string',
            'pagu' => 'required|array|max:90',
            'pagu.*' => 'numeric',
            
        ];
    }

    public function validateUpdatePaketDau(array $attributes){
        return Validator::make($attributes,$this->rulesUpdatePaketDau());
    }

    public function create(array $attributes)
    {
       
 
        $keterangan = '';
        DB::beginTransaction();
        try {
            $uuid_sd=$attributes['uuid_sd'];
            $id_sumber_dana = SumberDanaDpa::select('id','id_dpa')->whereRaw("uuid='$uuid_sd'")->first();
            $paket_dau=PaketDau::whereRaw("id_sumber_dana_dpa='$id_sumber_dana->id' AND id_dpa='$id_sumber_dana->id_dpa'");
            if($paket_dau->count()>0){
                foreach($paket_dau->get() as $dt){
                    PaketDauLokasi::where('id_paket_dau',$dt->id)->delete();
                }
                $paket_dau->delete();
                
            }
            foreach ($attributes['volume'] as $index => $value) {

                if(isset($attributes['keterangan'][$index])){
                    $keterangan = $attributes['keterangan'][$index];
                }else{
                    $keterangan = NULL;
                }
                    $sb = PaketDau::create([
                        'uuid' => Str::uuid()->toString(),
                        'nama_paket' => $attributes['nama_paket'][$index],
                        'keterangan' => $keterangan,
                        'volume' => $attributes['volume'][$index],
                        'satuan' => $attributes['satuan'][$index],
                        'pagu' => $attributes['pagu'][$index],
                        'tahun' => $attributes['tahun'],
                        'user_insert' => auth()->user()->id,
                        'id_dpa' => $id_sumber_dana->id_dpa,
                        'id_sumber_dana_dpa' => $id_sumber_dana->id,
                        'id_unit_kerja' => $id_sumber_dana->id,
                        'user_insert' => auth()->user()->id
                    ]);

                foreach ($attributes['id_desa'][$index] as $x => $value) {
                    $id_kecamatan=Desa::where('id',$attributes['id_desa'][$index][$x])->first()->id_kecamatan;
                    PaketDauLokasi::create([
                        'uuid' => Str::uuid()->toString(),
                        'id_paket_dau' => $sb->id,
                        'id_desa' => $attributes['id_desa'][$index][$x],
                        'id_kecamatan' => $id_kecamatan,
                        'user_insert' => auth()->user()->id
                    ]);
                }
            }
            DB::commit();
            return 'sukses';
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
            foreach ($attributes['tolak_ukur'] as $index => $value) {
                if (isset($attributes['volume'][$index])
                    && $attributes['volume'][$index] != null
                    && isset($attributes['satuan'][$index])
                    && $attributes['satuan'][$index] != null
                ) {
                    $data->TolakUkur()->create([
                        'uuid' => Str::uuid()->toString(),
                        'tolak_ukur' => $value,
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
            'total_keuangan' => 'required|numeric|max:'.$data->nilai_pagu_dpa.'|min:0',
            'total_persentase' => 'required|numeric|max:100.01|min:0',
            'total_fisik' => 'required|numeric|max:100|min:0',
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
        $rule_sumber_dana = [];
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
                $rules['kecamatan.'.$i] = '';
                $rules['kontrak.'.$i] = '';
            }
        }
        return array_merge($rules,$rule_sumber_dana);
    }

    public function validateRealisasi(array $attributes, $uuid){
        return Validator::make($attributes,$this->rulesRealisasi($uuid));
    }

    public function updateRealisasi(array $attributes, $uuid){
        $id_paket_dau = PaketDau::select('id')->where('uuid',$uuid)->first();
        foreach ($attributes['realisasi_keuangan'] as $index => $value) {
//            $id_paket_dau->update([
//                'kecamatan' => $attributes['kecamatan'][$index],
//                'desa' => $attributes['desa'][$index],
//            ]);
            RealisasiDau::whereRaw("periode='$index' AND id_paket_dau='$id_paket_dau'")->update([
                'realisasi_keuangan' => $attributes['realisasi_keuangan'][$index],
                'realisasi_fisik' => $attributes['realisasi_fisik'][$index]
            ]);
        }
        return null;
    }

    public function deleteByUuid($uuid, $force = false)
    {
        DB::beginTransaction();
        $data = parent::findByUuid($uuid);
        $data->SumberDanaDpa()->delete();
        $data->Realisasi()->delete();
        $data->Target()->delete();
        $data->TolakUkur()->delete();
        $data->DetailRealisasi()->delete();
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
