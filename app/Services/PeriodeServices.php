<?php


namespace App\Services;

use App\Models\Periode;

class PeriodeServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Periode $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama_periode' => $id ? 'filled' : 'required',
        ];
    }
}
