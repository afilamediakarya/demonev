<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\RenstraKegiatan;
use App\Models\RenstraKegiatanOutput;
use App\Services\RenstraKegiatanServices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RenstraKegiatanController extends ApiController
{
    public function __construct(RenstraKegiatanServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $tahun = request('tahun', date('Y'));
        $id_unit_kerja = auth()->user()->id_unit_kerja;
        $data = RenstraKegiatan::join('sasaran','sasaran.id','=','renstra_kegiatan.id_sasaran')
        ->join('urusan','urusan.id','=','renstra_kegiatan.id_urusan')
        ->join('bidang_urusan','bidang_urusan.id','=','renstra_kegiatan.id_bidang_urusan')
        ->join('program','program.id','=','renstra_kegiatan.id_program')
        ->join('kegiatan','kegiatan.id','=','renstra_kegiatan.id_kegiatan')
        ->whereRaw("renstra_kegiatan.id_unit_kerja='$id_unit_kerja'")
        ->select('renstra_kegiatan.*','sasaran.sasaran','program.nama_program as program','urusan.nama_urusan as urusan','urusan.kode_urusan','bidang_urusan.nama_bidang_urusan as bidang_urusan','bidang_urusan.kode_bidang_urusan','kegiatan.nama_kegiatan as kegiatan','kegiatan.kode_kegiatan')->orderBy('renstra_kegiatan.id_sasaran')->orderBy('kegiatan.kode_kegiatan');
        return DataTables::of($data)
        ->filter(function ($q){
            if (request()->has('search')) {
                if (request('search')['value']) {
                    $q->where(function ($q){
                        $q->where('kegiatan.kode_kegiatan', 'like', '%' . request('search')['value'] . '%');
                        $q->orWhere('kegiatan.nama_kegiatan', 'like', '%' . request('search')['value'] . '%');

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
<span class="label label-lg label-info label-inline m-1">' . $model->kode_bidang_urusan . ' - ' . $model->bidang_urusan . '</span>
<span class="label label-lg label-success label-inline m-1">' . $model->kode_program . ' - ' . $model->program . '</span>';
        })
        ->rawColumns(['grouping', 'action', 'tolak_ukur', 'target','status_target'])
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

    public function getRenstraKegiatanOutput($id)
    {
        $bidang_tujuan = RenstraKegiatanOutput::where('id_renstra_kegiatan', $id)->orderBy('id')->get();
        return Response::json($bidang_tujuan);
    }

}
