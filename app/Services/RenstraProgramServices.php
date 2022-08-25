<?php


namespace App\Services;

use App\Models\RenstraProgram;
use App\Models\Sasaran;
use App\Models\Program;
use App\Models\RenstraProgramOutcome;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RenstraProgramServices extends BaseServices
{
    protected $allowSearch = [

    ];

    protected $relation = [
        'RenstraProgramOutcome'
    ];

    public function __construct(RenstraProgram $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'id_sasaran' => ($id ? 'filled' : 'required'),
            'id_program' => ($id ? 'filled' : 'required') ,
            'out_uuid' => 'nullable|array',
            'outcome' => 'required|array|max:90',
            'outcome.*' => 'string',
            'volume' => 'required|array|max:90',
            'volume.*' => 'numeric',
            'satuan' => 'required|array|max:90',
            'satuan.*' => 'string',
            'capaian_awal' => 'required|array|max:90',
            'capaian_awal.*' => 'numeric',
        ];
    }

    public function rulesWithUuid($uuid = null): array
    {
        return [
            'uuid' => 'nullable',
            'id_sasaran' => ($uuid ? 'filled' : 'required'),
            'id_program' => ($uuid ? 'filled' : 'required') ,
            'out_uuid' => 'nullable|array',
            'outcome' => 'required|array|max:90',
            'outcome.*' => 'string',
            'volume' => 'required|array|max:90',
            'volume.*' => 'numeric',
            'satuan' => 'required|array|max:90',
            'satuan.*' => 'string',
            'capaian_awal' => 'required|array|max:90',
            'capaian_awal.*' => 'numeric',
        ];
    }

    public function create(array $attributes)
    {
        DB::beginTransaction();
        try {

            $id_unit_kerja=auth()->user()->id_unit_kerja;
            $sasaran = Sasaran::select('id','id_tujuan')->where('id',$attributes['id_sasaran'])->first();
            // $program = Program::join('bidang_urusan','bidang_urusan.id','=','program.id_bidang_urusan')
            // ->select('program.id','program.kode_program','program.id_bidang_urusan','bidang_urusan.id_urusan')->whereRaw('program.id',$attributes['id_program'])->first();
            $program1=Program::join('unit_kerja_bidang_urusan','unit_kerja_bidang_urusan.id_bidang_urusan','=','program.id_bidang_urusan')
            ->join('bidang_urusan','bidang_urusan.id','=','program.id_bidang_urusan')
            ->where('unit_kerja_bidang_urusan.id_unit_kerja',$id_unit_kerja)
            ->select('program.id','program.kode_program','program.id_bidang_urusan','bidang_urusan.id_urusan')
            ->where('program.id',$attributes['id_program'])
            ->groupBy('program.nama_program');
            $program=Program::
            join('bidang_urusan','bidang_urusan.id','=','program.id_bidang_urusan')
            ->where('bidang_urusan.kode_bidang_urusan','00')
            ->where('program.id',$attributes['id_program'])
            ->select('program.id','program.kode_program','program.id_bidang_urusan','bidang_urusan.id_urusan')
            ->union($program1)
            ->first();
            $data=RenstraProgram::where('uuid',$attributes['uuid']);
            if($data->count()>0){
                $get_id=$data->first()->id;
                $renstra_program=$data->update([
                    'id_tujuan' => $sasaran->id_tujuan,
                    'id_sasaran' => $sasaran->id,
                    'id_program' => $program->id,
                    'kode_program' => $program->kode_program,
                    'id_bidang_urusan' => $program->id_bidang_urusan,
                    'id_urusan' => $program->id_urusan,
                    'periode' => '2019-2023',
                    'id_unit_kerja' => auth()->user()->id_unit_kerja,

                    'user_insert' => auth()->user()->id
                ]);
            }else{
                $renstra_program=RenstraProgram::create([
                    'uuid' => Str::uuid()->toString(),
                    'id_tujuan' => $sasaran->id_tujuan,
                    'id_sasaran' => $sasaran->id,
                    'id_program' => $program->id,
                    'kode_program' => $program->kode_program,
                    'id_bidang_urusan' => $program->id_bidang_urusan,
                    'id_urusan' => $program->id_urusan,
                    'periode' => '2019-2023',
                    'id_unit_kerja' => auth()->user()->id_unit_kerja,

                    'user_insert' => auth()->user()->id
                    
                ]);
                $get_id=$renstra_program->id;
            }
            

            // RenstraProgramOutcome::where('id_renstra_program',$get_id)->delete();

            RenstraProgramOutcome::whereNotIn('uuid', $attributes['out_uuid'])->where('id_renstra_program',$get_id)->delete();
            foreach ($attributes['outcome'] as $index => $value) {
                $data_outcome=RenstraProgramOutcome::where('uuid',$attributes['out_uuid'][$index]);
                if($data_outcome->count()>0){
                    $data_outcome->update([
                        'id_renstra_program' => $get_id,
                        'outcome' => $value,
                        'volume' => $attributes['volume'][$index],
                        'satuan' => $attributes['satuan'][$index],
                        'capaian_awal' => $attributes['capaian_awal'][$index],
                        'user_insert' => auth()->user()->id
                    ]);
                }else{
                    RenstraProgramOutcome::create([
                        'uuid' => Str::uuid()->toString(),
                        'id_renstra_program' => $get_id,
                        'outcome' => $value,
                        'volume' => $attributes['volume'][$index],
                        'satuan' => $attributes['satuan'][$index],
                        'capaian_awal' => $attributes['capaian_awal'][$index],
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

    public function get()
    {
        $data = parent::get();
        return $data->sortBy('urutan')->values()->all();
    }

    public function deleteByUuid($uuid, $force = false)
    {
        DB::beginTransaction();
        $data = parent::findByUuid($uuid);
        $data->RenstraProgramOutcome()->delete();
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
