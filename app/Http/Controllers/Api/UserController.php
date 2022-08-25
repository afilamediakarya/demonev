<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends ApiController
{
    public function __construct(UserServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $data = User::query()
            ->join('role', 'user.id_role', '=', 'role.id')
            ->leftJoin('unit_kerja', 'user.id_unit_kerja', '=', 'unit_kerja.id')
            ->select('user.username', 'user.status', 'user.uuid', 'user.nama_lengkap', 'user.nip', 'unit_kerja.nama_unit_kerja AS unit_kerja', 'role.nama_role AS role')
            ->where('user.id', '!=', auth()->user()->id);
        return DataTables::of($data)
            ->filter(function ($q) {
                if (request()->has('search')) {
                    if (request('search')['value']) {
                        $q->where(function ($q){
                            $q->where('nama_role', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('username', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nama_lengkap', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nip', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nama_unit_kerja', 'like', '%' . request('search')['value'] . '%');
                        });
                    }
                }
            })
            ->addColumn('action', function ($model) {
                return '<a href="#" class="btn btn-sm btn-success font-weight-bolder m-1 open-panel" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-edit-1"></i>
                            Edit
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-secondary font-weight-bolder m-1 button-status" data-status="' . ($model->status ? '1' : '0') . '" data-uuid="' . $model->uuid . '">
                            <i class="flaticon2-paper"></i>' . ($model->status ? 'Nonaktifkan' : 'Aktifkan') . '
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

    public function toggleStatus($uuid)
    {
        $user = User::whereUuid($uuid)->first();
        $user->status = $user->status ? 0 : 1;
        $user->save();
        return Response::json($user);
    }

    public function updateAkun(Request $request)
    {
        $validate = $this->services->validateUpdate($request->all());
        if ($validate->fails()) {
            return Response::validationError($validate->errors());
        }
        return Response::json($this->services->update(auth()->user()->id, $validate->validated()));
    }
}
