<?php


namespace App\Services;

use App\Models\Akses;

class AksesServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Akses $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama_akses' => $id ? 'filled' : 'required',
            'route' => $id ? 'filled' : '',
        ];
    }
}
