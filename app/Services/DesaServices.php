<?php


namespace App\Services;

use App\Models\Desa;

class DesaServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Desa $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama' => ($id ? 'filled' : 'required'),
            'id_kecamatan' => ($id ? 'filled' : 'required'),
        ];
    }
}
