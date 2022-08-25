<?php

namespace App\Http\Controllers\Api;

use App\Models\Desa;
use App\Services\DesaServices;
use Yajra\DataTables\DataTables;

class DesaController extends ApiController
{
    public function __construct(DesaServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $data = Desa::join('kecamatan','kecamatan.id','=','desa.id_kecamatan')
        ->select('desa.*','kecamatan.nama as kecamatan')->sortBy('nama')->get();
        return DataTables::of($data)
            ->addColumn('action', function ($model) {
                return '<a href="#" class="btn btn-sm btn-success font-weight-bolder m-1 open-panel" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-edit-1"></i>
                            Edit
                        </a>
                        <a href="#" class="btn btn-sm btn-danger font-weight-bolder m-1 button-delete" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-delete"></i>
                        </a>';
            })
            ->make(true);
    }

}
