<?php


namespace App\Services;

use App\Models\Realisasi;

class RealisasiServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Realisasi $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'realisasi_keuangan' => ($id ? 'filled' : 'required') . '|numeric',
            'realisasi_fisik' => ($id ? 'filled' : 'required') . '|numeric',
            'id_pegawai_penanggung_jawab' => $id ? 'filled' : 'required',
            'permasalahan' => ($id ? 'filled' : 'required'),
            'id_periode' => ($id ? 'filled' : 'required'),
            'tahun' => ($id ? 'filled' : 'required') . '|numeric',
        ];
    }
}
