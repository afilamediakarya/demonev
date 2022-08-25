<?php


namespace App\Services;

use App\Models\BidangDak;

class BidangDakService extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(BidangDak $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_bidang_dak' => ($id ? 'filled' : 'required') . '|unique:bidang_dak,kode_bidang_dak' . ($id ? ',' . $id : ''),
            'bidang' => ($id ? 'filled' : 'required')
        ];
    }

    public function rulesWithUuid($uuid = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_bidang_dak' => ($uuid ? 'filled' : 'required') . '|unique:bidang_dak,kode_bidang_dak' . ($uuid ? ',' . $uuid . ',uuid' : ''),
            'bidang' => ($uuid ? 'filled' : 'required')
        ];
    }

    public function get()
    {
        $data = parent::get();
        return $data->sortBy('kode_bidang_dak')->values()->all();
    }
}