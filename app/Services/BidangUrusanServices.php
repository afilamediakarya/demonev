<?php


namespace App\Services;

use App\Models\BidangUrusan;

class BidangUrusanServices extends BaseServices
{
    const KODE_NON_URUSAN = 1;
    protected $allowSearch = [

    ];

    public function __construct(BidangUrusan $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_bidang_urusan' => $id ? 'filled' : 'required',
            'nama_bidang_urusan' => $id ? 'filled' : 'required',
            'id_urusan' => $id ? 'filled' : 'required',
            'tahun' => ($id ? 'filled' : 'required') . '|numeric',
        ];
    }

    public function get()
    {
        $this->model = $this->model->where('id_urusan', '!=', self::KODE_NON_URUSAN);
        $data = parent::get();
        return $data->sortBy('kode_urusan')->sortBy('kode_bidang_urusan')->values()->all();
    }
}
