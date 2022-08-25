<?php


namespace App\Services;

use App\Models\Program;

class ProgramServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Program $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_program' => $id ? 'filled' : 'required',
            'nama_program' => $id ? 'filled' : 'required',
            'id_bidang_urusan' => $id ? 'filled' : 'required',
            'capaian_program' => ($id ? 'filled' : 'required'),
            'tahun' => ($id ? 'filled' : 'required') . '|numeric',
        ];
    }
}
