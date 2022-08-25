<?php


namespace App\Services;

use App\Models\Target;

class TargetServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Target $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'id_periode' => ($id ? 'filled' : 'required'),
            'target_keuangan' => ($id ? 'filled' : 'required') . '|numeric',
            'target_fisik' => ($id ? 'filled' : 'required') . '|numeric',
            'id_dpa' => ($id ? 'filled' : 'required') . '|numeric',
            'tahun' => ($id ? 'filled' : 'required') . '|numeric',
        ];
    }
}
