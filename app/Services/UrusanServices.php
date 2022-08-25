<?php


namespace App\Services;

use App\Models\Urusan;

class UrusanServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Urusan $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_urusan' => ($id ? 'filled' : 'required') . '|unique:urusan,kode_urusan' . ($id ? ',' . $id : ''),
            'nama_urusan' => ($id ? 'filled' : 'required'),
            'tahun' => ($id ? 'filled' : 'required') . '|numeric',
        ];
    }

    public function rulesWithUuid($uuid = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_urusan' => ($uuid ? 'filled' : 'required') . '|unique:urusan,kode_urusan' . ($uuid ? ',' . $uuid . ',uuid' : ''),
            'nama_urusan' => ($uuid ? 'filled' : 'required'),
            'tahun' => ($uuid ? 'filled' : 'required') . '|numeric',
        ];
    }

    public function get()
    {
        $data = parent::get();
        return $data->sortBy('kode_urusan')->values()->all();
    }
}
