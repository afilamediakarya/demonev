<?php


namespace App\Services;

use App\Models\Kecamatan;

class KecamatanServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Kecamatan $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama' => ($id ? 'filled' : 'required'),
        ];
    }
}
