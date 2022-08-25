<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\BidangTujuan;
use App\Models\Tujuan;
use App\Services\TujuanServices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TujuanController extends ApiController
{
    public function __construct(TujuanServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $tahun = request('tahun', date('Y'));
        $id_unit_kerja = auth()->user()->id_unit_kerja;
        $data = Tujuan::where('id_unit_kerja',$id_unit_kerja)->get();
        return DataTables::of($data)
            ->addColumn('action', function ($model) use ($tahun) {
                // if ($tahun == date('Y'))
                    return '<a href="#" class="btn btn-sm btn-success font-weight-bolder m-1 open-panel" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-edit-1"></i>
                            Edit
                        </a>
                        <a href="#" class="btn btn-sm btn-danger font-weight-bolder m-1 button-delete" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-delete"></i>
                        </a>';
                // return '';
            }
            )
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

    public function getBidangTujuan($id)
    {
        $bidang_tujuan = BidangTujuan::where('id_tujuan', $id)->orderBy('kode_bidang_tujuan')->get();
        return Response::json($bidang_tujuan);
    }
}
