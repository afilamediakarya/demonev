<?php

namespace App\Http\Controllers\Api;

use App\Models\JenisBelanja;
use App\Services\JenisBelanjaServices;
use Yajra\DataTables\DataTables;

class JenisBelanjaController extends ApiController
{
    public function __construct(JenisBelanjaServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $data = JenisBelanja::query();
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
