<?php


namespace App\Services;

use App\Models\JenisBelanja;

class JenisBelanjaServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(JenisBelanja $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama_jenis_belanja' => $id ? 'filled' : 'required',
            'kode' => ($id ? 'filled' : 'required'),
        ];
    }
}
