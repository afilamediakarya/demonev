<?php


namespace App\Services;

use App\Models\Satuan;

class SatuanServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Satuan $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama_satuan' => ($id ? 'filled' : 'required'),
            'kode' => ($id ? 'filled' : 'required'),
        ];
    }
}
