<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\Role;
use App\Services\RoleServices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoleController extends ApiController
{
    public function __construct(RoleServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $data = Role::query()->with('Akses');
        return DataTables::of($data)
            ->addColumn('akses_', function ($model) {
                return implode(' ', $model->Akses->map(function ($value) {
                    return '<span class="btn btn-sm btn-warning">' . $value->nama_akses . '</span>';
                })->toArray());
            })
            ->addColumn('action', function ($model) {
                return '<a href="#" class="btn btn-sm btn-success font-weight-bolder m-1 open-panel" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-edit-1"></i>
                            Edit
                        </a>
                        <a href="#" class="btn btn-sm btn-danger font-weight-bolder m-1 button-delete" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-delete"></i>
                        </a>';
            })
            ->rawColumns(['akses_', 'action'])
            ->make(true);
    }

    public function create(Request $request)
    {
        if ($request->has('uuid')) {
            $validate = $this->services->validateWithUuid($request->all(), $request->uuid);
        } else {
            $validate = $this->services->validate($request->all());
        }
        if ($validate->fails()) {
            return Response::validationError($validate->errors());
        }
        return Response::json($this->services->create($validate->validated()));
    }

}
