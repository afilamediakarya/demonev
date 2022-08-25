<?php


namespace App\Services;

use App\Models\PegawaiPenanggungJawab;

class PegawaiPenanggungJawabServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(PegawaiPenanggungJawab $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
//            'id_pegawai' => $id ? 'filled' : 'required',
            'nip' => $id ? 'filled' : 'required',
            'nama_lengkap' => $id ? 'filled' : 'required',
            'jabatan' => $id ? 'filled' : 'required',
            'no_telp' => $id ? 'filled' : 'required',
            'id_unit_kerja' => $id ? 'filled' : 'required',
            'status' => $id ? 'filled' : 'required',
        ];
    }
}
