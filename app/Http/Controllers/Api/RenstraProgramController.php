<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\RenstraProgram;
use App\Models\RenstraProgramOutcome;
use App\Services\RenstraProgramServices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RenstraProgramController extends ApiController
{
    public function __construct(RenstraProgramServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $tahun = request('tahun', date('Y'));
        $id_unit_kerja = auth()->user()->id_unit_kerja;
        $data = RenstraProgram::join('sasaran','sasaran.id','=','renstra_program.id_sasaran')
        ->join('urusan','urusan.id','=','renstra_program.id_urusan')
        ->join('bidang_urusan','bidang_urusan.id','=','renstra_program.id_bidang_urusan')
        ->join('program','program.id','=','renstra_program.id_program')
        ->whereRaw("renstra_program.id_unit_kerja='$id_unit_kerja'")
        ->select('renstra_program.*','sasaran.sasaran','program.nama_program as program','sasaran.sasaran','program.nama_program as program','urusan.nama_urusan as urusan','urusan.kode_urusan','bidang_urusan.nama_bidang_urusan as bidang_urusan','bidang_urusan.kode_bidang_urusan');
        return DataTables::of($data)
        ->filter(function ($q){
            if (request()->has('search')) {
                if (request('search')['value']) {
                    $q->where(function ($q){
                        $q->where('program.kode_program', 'like', '%' . request('search')['value'] . '%');
                        $q->orWhere('program.nama_program', 'like', '%' . request('search')['value'] . '%');

                    });
                }
            }
        })
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
            ->addColumn('grouping', function ($model) {
                return '<span class="label label-lg label-primary label-inline m-1">' .$model->sasaran . '</span>
                <span class="label label-lg label-warning label-inline m-1">' . $model->kode_urusan . ' - ' . $model->urusan . '</span>
    <span class="label label-lg label-info label-inline m-1">' . $model->kode_bidang_urusan . ' - ' . $model->bidang_urusan . '</span>';
            })
            ->rawColumns(['grouping', 'action', 'tolak_ukur', 'target','status_target'])
            ->make(true);
    }

    public function create(Request $request)
    {
        // return $request;
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

    public function getRenstraProgramOutcome($id)
    {
        $result = RenstraProgramOutcome::where('id_renstra_program', $id)->orderBy('id')->get();
        return Response::json($result);
    }

}
