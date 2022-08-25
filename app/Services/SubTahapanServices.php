<?php


namespace App\Services;

use App\Models\SubTahapan;

class SubTahapanServices extends BaseServices
{
    protected $allowSearch = [

    ];
    protected $isMasterTable = false;
    protected $hasUuid = false;

    public function __construct(SubTahapan $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'id_tahapan' => $id ? 'filled' : 'required',
            'sub_tahapan' => $id ? 'filled' : 'required',
        ];
    }
}
