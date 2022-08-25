<?php


namespace App\Services;

use App\Models\Rkpd;

class RkpdServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Rkpd $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'target_rpjmd_keuangan' => ($id ? 'filled' : 'required') . '|numeric',
            'target_rpjmd_kinerja' => ($id ? 'filled' : 'required') . '|numeric',
            'realisasi_rkpd_lalu_keuangan' => ($id ? 'filled' : 'required') . '|numeric',
            'realisasi_rkpd_lalu_kinerja' => ($id ? 'filled' : 'required') . '|numeric',
            'target_rkpd_sekarang_keuangan' => ($id ? 'filled' : 'required') . '|numeric',
            'target_rkpd_sekarang_kinerja' => ($id ? 'filled' : 'required') . '|numeric',
            'semester' => ($id ? 'filled' : 'required') . '|numeric',
        ];
    }
}
