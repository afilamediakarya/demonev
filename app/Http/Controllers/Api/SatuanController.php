<?php

namespace App\Http\Controllers\Api;

use App\Models\Satuan;
use App\Services\SatuanServices;
use Yajra\DataTables\DataTables;

class SatuanController extends ApiController
{
    public function __construct(SatuanServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $data = Satuan::query();
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
