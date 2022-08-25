<?php


namespace App\Services;

use App\Models\RenstraKegiatan;
use App\Models\Sasaran;
use App\Models\Kegiatan;
use App\Models\RenstraProgram;
use App\Models\RenstraKegiatanOutput;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RenstraKegiatanServices extends BaseServices
{
    protected $allowSearch = [

    ];

    protected $relation = [
        'RenstraKegiatanOutput'
    ];

    public function __construct(RenstraKegiatan $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'id_kegiatan' => ($id ? 'filled' : 'required'),
            'id_program' => ($id ? 'filled' : 'required'),
            'id_renstra_program_outcome' => ($id ? 'filled' : 'required'),
            'out_uuid' => 'nullable|array',
            'output' => 'required|array|max:90',
            'output.*' => 'string',
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
            'id_kegiatan' => ($uuid ? 'filled' : 'required'),
            'id_program' => ($uuid ? 'filled' : 'required'),
            'id_renstra_program_outcome' => ($uuid ? 'filled' : 'required'),
            'out_uuid' => 'nullable|array',
            'output' => 'required|array|max:90',
            'output.*' => 'string',
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
            $kegiatan = Kegiatan::select('id','id_program')->where('id',$attributes['id_kegiatan'])->first();
            $program = RenstraProgram::select('renstra_program.*')->whereRaw("renstra_program.id_program='$kegiatan->id_program' AND renstra_program.id_unit_kerja='$id_unit_kerja'")->first();
            // $program1=RenstraProgram::
            // join('program','program.id','=','renstra_program.id_program')
            // ->join('unit_kerja_bidang_urusan','unit_kerja_bidang_urusan.id_bidang_urusan','=','program.id_bidang_urusan')
            // ->join('bidang_urusan','bidang_urusan.id','=','program.id_bidang_urusan')
            // ->where('unit_kerja_bidang_urusan.id_unit_kerja',$id_unit_kerja)
            // ->select('renstra_program.*')
            // ->whereRaw("renstra_program.id_program='$kegiatan->id_program' AND renstra_program.id_unit_kerja='$id_unit_kerja'")
            // ->groupBy('program.nama_program');
            // $program=RenstraProgram::
            // join('program','program.id','=','renstra_program.id_program')
            // ->join('bidang_urusan','bidang_urusan.id','=','program.id_bidang_urusan')
            // ->where('bidang_urusan.kode_bidang_urusan','00')
            // ->whereRaw("renstra_program.id_program='$kegiatan->id_program' AND renstra_program.id_unit_kerja='$id_unit_kerja'")
            // ->select('renstra_program.*')
            // ->union($program1)
            // ->first();

            $data=RenstraKegiatan::where('uuid',$attributes['uuid']);
            if($data->count()>0){
                $get_id=$data->first()->id;
                $renstra_program=$data->update([
                    'id_kegiatan' => $attributes['id_kegiatan'],
                    'id_tujuan' => $program->id_tujuan,
                    'id_sasaran' => $program->id_sasaran,
                    'id_program' => $program->id_program,
                    'id_renstra_program' => $program->id,
                    'id_renstra_program_outcome' => $attributes['id_renstra_program_outcome'],
                    'kode_program' => $program->kode_program,
                    'id_bidang_urusan' => $program->id_bidang_urusan,
                    'id_urusan' => $program->id_urusan,
                    'periode' => '2019-2023',
                    'id_unit_kerja' => auth()->user()->id_unit_kerja,
                    'user_insert' => auth()->user()->id
                ]);
            }else{
                $renstra_program=RenstraKegiatan::create([
                    'uuid' => Str::uuid()->toString(),
                    'id_kegiatan' => $attributes['id_kegiatan'],
                    'id_tujuan' => $program->id_tujuan,
                    'id_sasaran' => $program->id_sasaran,
                    'id_program' => $program->id_program,
                    'id_renstra_program' => $program->id,
                    'id_renstra_program_outcome' => $attributes['id_renstra_program_outcome'],
                    'kode_program' => $program->kode_program,
                    'id_bidang_urusan' => $program->id_bidang_urusan,
                    'id_urusan' => $program->id_urusan,
                    'periode' => '2019-2023',
                    'id_unit_kerja' => auth()->user()->id_unit_kerja,
                    'user_insert' => auth()->user()->id
                ]);
                $get_id=$renstra_program->id;
            }
            

            RenstraKegiatanOutput::whereNotIn('uuid', $attributes['out_uuid'])->where('id_renstra_kegiatan',$get_id)->delete();
            // foreach ($attributes['output'] as $index => $value) {
            //     RenstraKegiatanOutput::create([
            //         'uuid' => Str::uuid()->toString(),
            //         'id_renstra_kegiatan' => $get_id,
            //         'output' => $value,
            //         'volume' => $attributes['volume'][$index],
            //         'satuan' => $attributes['satuan'][$index],
            //         'user_insert' => auth()->user()->id
            //     ]);
            // }

            foreach ($attributes['output'] as $index => $value) {
                $data_output=RenstraKegiatanOutput::where('uuid',$attributes['out_uuid'][$index]);
                if($data_output->count()>0){
                    $data_output->update([
                        'id_renstra_kegiatan' => $get_id,
                        'output' => $value,
                        'volume' => $attributes['volume'][$index],
                        'satuan' => $attributes['satuan'][$index],
                        'capaian_awal' => $attributes['capaian_awal'][$index],
                        'user_insert' => auth()->user()->id
                    ]);
                }else{
                    RenstraKegiatanOutput::create([
                        'uuid' => Str::uuid()->toString(),
                        'id_renstra_kegiatan' => $get_id,
                        'output' => $value,
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
        $data->RenstraKegiatanOutput()->delete();
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
