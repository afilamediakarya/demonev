<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\Pegawai;
use App\Services\PegawaiServices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PegawaiController extends ApiController
{
    public function __construct(PegawaiServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $data = Pegawai::query()->leftJoin('unit_kerja', 'pegawai.id_unit_kerja', '=', 'unit_kerja.id')->select('pegawai.*', 'unit_kerja.nama_unit_kerja AS unit_kerja');
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
