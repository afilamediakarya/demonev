<?php


namespace App\Services;

use App\Models\KegiatanDak;

class KegiatanDakService extends BaseServices
{
    const KODE_NON_KEGIATAN_DAK = 0;
    protected $allowSearch = [

    ];

    public function __construct(KegiatanDak $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_kegiatan' => $id ? 'filled' : 'required',
            'kegiatan' => $id ? 'filled' : 'required',
            'id_sub_bidang' => $id ? 'filled' : 'required'
        ];
    }

    public function get()
    {
        $this->model = $this->model->where('id_sub_bidang', '!=', self::KODE_NON_KEGIATAN_DAK);
        $data = parent::get();
        return $data->sortBy('kode_sub_bidang_dak')->sortBy('kode_kegiatan')->values()->all();
    }
}