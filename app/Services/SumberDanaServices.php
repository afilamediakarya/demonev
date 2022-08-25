<?php


namespace App\Services;

use App\Models\SumberDana;

class SumberDanaServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(SumberDana $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama_sumber_dana' => ($id ? 'filled' : 'required'),
            'kode' => ($id ? 'filled' : 'required'),
        ];
    }
}
