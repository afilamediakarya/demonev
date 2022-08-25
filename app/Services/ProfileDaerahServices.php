<?php


namespace App\Services;

use App\Models\ProfileDaerah;

class ProfileDaerahServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(ProfileDaerah $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama_daerah' => $id ? 'filled' : 'required',
            'pimpinan_daerah' => $id ? 'filled' : 'required',
            'alamat' => $id ? 'filled' : 'required',
            'email' => ($id ? 'filled' : 'required') . '|email',
            'no_telp' => $id ? 'filled' : 'required',
            'visi_daerah' => '',
            'misi_daerah' => '',
        ];
    }
}
