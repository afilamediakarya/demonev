<?php


namespace App\Services;

use App\Models\SubBidangDak;

class SubBidangDakService extends BaseServices
{
    const KODE_NON_BIDANG_DAK = 0;
    protected $allowSearch = [

    ];

    public function __construct(SubBidangDak $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_sub_bidang_dak' => $id ? 'filled' : 'required',
            'sub_bidang' => $id ? 'filled' : 'required',
            'id_bidang_dak' => $id ? 'filled' : 'required'
        ];
    }

    public function get()
    {
        $this->model = $this->model->where('id_bidang_dak', '!=', self::KODE_NON_BIDANG_DAK);
        $data = parent::get();
        return $data->sortBy('kode_bidang_dak')->sortBy('kode_sub_bidang_dak')->values()->all();
    }
}