<?php


namespace App\Services;

use App\Models\Jadwal;

class JadwalServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Jadwal $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'tahapan' => $id ? 'filled' : 'required',
            'sub_tahapan' => $id ? 'filled' : 'required',
            'jadwal_mulai' => ($id ? 'filled' : 'required') . '|date|before:jadwal_selesai',
            'jadwal_selesai' => ($id ? 'filled' : 'required') . '|date|after:jadwal_mulai',
            'tahun' => ($id ? 'filled' : 'required') . '|numeric',
            'status' => 'nullable',
        ];
    }

    public function cekJadwalEksist(array $attributes)
    {
        return $this->model->where(function ($q) use ($attributes) {
                foreach ($attributes as $key => $value) {
                    if ($key != 'uuid')
                    $q->where($key,$value);
                }
                if (isset($attributes['uuid'])){
                    $q->where('uuid','!=',$attributes['uuid']);
                }
            })
                ->first() !== null;
    }
}
