<?php


namespace App\Services;

use App\Models\RincianDak;

class RincianDakService extends BaseServices
{
    const KODE_NON_KEGIATAN_DAK = 1;
    const KODE_NON_TEMATIK_DAK = 1;
    protected $allowSearch = [

    ];

    public function __construct(RincianDak $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_rincian' => $id ? 'filled' : 'required',
            'rincian' => $id ? 'filled' : 'required',
            'jenis' => $id ? 'filled' : 'required',
            'id_kegiatan' => $id ? 'filled' : 'required',
            'id_tematik' => $id ? 'filled' : 'required'
        ];
    }

    public function get()
    {
        $this->model = $this->model->where('id_kegiatan', '!=', self::KODE_NON_KEGIATAN_DAK);
        $data = parent::get();
        return $data->sortBy('kode_kegiatan')->sortBy('kode_rincian')->values()->all();
    }
}