<?php

namespace App\Http\Controllers\Api;

use App\Models\MetodePelaksanaan;
use App\Services\MetodePelaksanaanServices;
use Yajra\DataTables\DataTables;

class MetodePelaksanaanController extends ApiController
{
    public function __construct(MetodePelaksanaanServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $data = MetodePelaksanaan::query();
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
