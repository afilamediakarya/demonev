<?php


namespace App\Services;

use App\Models\Jabatan;

class JabatanServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Jabatan $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'jabatan' => $id ? 'filled' : 'required',
        ];
    }
}
