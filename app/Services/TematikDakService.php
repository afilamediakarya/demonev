<?php


namespace App\Services;

use App\Models\TematikDak;

class TematikDakService extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(TematikDak $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_tematik' => ($id ? 'filled' : 'required') . '|unique:tematik_dak,kode_tematik' . ($id ? ',' . $id : ''),
            'tematik' => ($id ? 'filled' : 'required')
        ];
    }

    public function rulesWithUuid($uuid = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_tematik' => ($uuid ? 'filled' : 'required') . '|unique:tematik_dak,kode_tematik' . ($uuid ? ',' . $uuid . ',uuid' : ''),
            'tematik' => ($uuid ? 'filled' : 'required')
        ];
    }

    public function get()
    {
        $data = parent::get();
        return $data->sortBy('kode_tematik')->values()->all();
    }
}