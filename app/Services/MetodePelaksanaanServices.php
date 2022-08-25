<?php


namespace App\Services;

use App\Models\MetodePelaksanaan;

class MetodePelaksanaanServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(MetodePelaksanaan $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama_metode_pelaksanaan' => $id ? 'filled' : 'required',
            'kode' => ($id ? 'filled' : 'required'),
        ];
    }
}
