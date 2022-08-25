<?php


namespace App\Services;

use App\Models\Kegiatan;

class KegiatanServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Kegiatan $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_kegiatan' => $id ? 'filled' : 'required',
            'nama_kegiatan' => ($id ? 'filled' : 'required'),
            'id_program' => ($id ? 'filled' : 'required'),
            'hasil_kegiatan' => ($id ? 'filled' : 'required'),
            'tahun' => ($id ? 'filled' : 'required') . '|numeric',
        ];
    }
}
