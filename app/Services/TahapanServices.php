<?php


namespace App\Services;

use App\Models\Tahapan;

class TahapanServices extends BaseServices
{
    protected $allowSearch = [

    ];
    protected $isMasterTable = false;
    protected $hasUuid = false;

    public function __construct(Tahapan $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'tahapan' => $id ? 'filled' : 'required',
        ];
    }
}
