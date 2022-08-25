<?php


namespace App\Services;

use App\Models\Sasaran;

class SasaranServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(Sasaran $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'urutan' => ($id ? 'filled' : 'required'),
            'sasaran' => ($id ? 'filled' : 'required'),
            'periode' => ($id ? 'filled' : 'required') ,
            'id_tujuan' => ($id ? 'filled' : 'required') ,
            'id_unit_kerja' => ($id ? 'filled' : 'required') ,
        ];
    }

    public function rulesWithUuid($uuid = null): array
    {
        return [
            'uuid' => 'nullable',
            'urutan' => ($uuid ? 'filled' : 'required'),
            'sasaran' => ($uuid ? 'filled' : 'required'),
            'periode' => ($uuid ? 'filled' : 'required') ,
            'id_tujuan' => ($uuid ? 'filled' : 'required') ,
            'id_unit_kerja' => ($uuid ? 'filled' : 'required') ,
        ];
    }

    public function get()
    {
        $data = parent::get();
        return $data->where('id_unit_kerja',auth()->user()->id_unit_kerja)->sortBy('urutan')->values()->all();
    }
}
