<?php

namespace App\Http\Controllers\Api;

use App\Models\Akses;
use App\Services\AksesServices;
use Yajra\DataTables\DataTables;

class AksesController extends ApiController
{
    public function __construct(AksesServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $data = Akses::query();
        return DataTables::of($data)
            ->editColumn('route', function ($model) {
                return url($model->route);
            })
            ->addColumn('action', function ($model) {
                return '<a href="#" class="btn btn-sm btn-success font-weight-bolder m-1 open-panel" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-edit-1"></i>
                            Edit
                        </a>
                        ';
            })
            ->make(true);
    }

}
