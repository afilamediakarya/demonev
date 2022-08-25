<?php


namespace App\Services;

use App\Models\UnitKerja;
use App\Models\UnitKerjaPagu;
use Illuminate\Support\Facades\DB;

class UnitKerjaServices extends BaseServices
{
    protected $allowSearch = [

    ];
    protected $relation = [
        'BidangUrusan','UnitKerjaPagu'
    ];

    public function __construct(UnitKerja $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama_unit_kerja' => ($id ? 'filled' : 'required'),
            'kode_unit_kerja' => ($id ? 'filled' : 'required'),
            'max_pagu' => ($id ? 'filled' : 'required').'|numeric|min:0',
            'tahun' => ($id ? 'filled' : 'required').'|numeric|min:0',
            'nama_kepala' => ($id ? 'filled' : 'required'),
            'nama_jabatan_kepala' => ($id ? 'filled' : 'required'),
            'nip_kepala' => ($id ? 'filled' : 'required'),
            'pangkat_kepala' => ($id ? 'filled' : 'required'),
            'status_kepala' => ($id ? 'filled' : 'required'),
            'bidang_urusan' => 'array'
        ];
    }

    public function create(array $attributes)
    {
        DB::beginTransaction();
        try {
            $unit_kerja = parent::create($attributes);
            $cek=UnitKerjaPagu::where('id_unit_kerja',$unit_kerja->id)->where('tahun',$attributes['tahun'])->count();
            if($cek>0){
                UnitKerjaPagu::where('id_unit_kerja',$unit_kerja->id)->where('tahun',$attributes['tahun'])
                ->update([
                    'max_pagu_tahun' => $attributes['max_pagu']
                ]);
            }else{
                UnitKerjaPagu::create([
                    'id_unit_kerja' => $unit_kerja->id,
                    'tahun' => $attributes['tahun'],
                    'max_pagu_tahun' => $attributes['max_pagu']
                ]);
            }
            
            $unit_kerja->BidangUrusan()->detach();
            if (isset($attributes['bidang_urusan']))
                $unit_kerja->BidangUrusan()->attach(array_unique($attributes['bidang_urusan']));
            DB::commit();
            return $unit_kerja;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
