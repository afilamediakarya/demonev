<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\BidangUrusan;
use App\Models\Program;
use App\Services\BidangUrusanServices;
use Yajra\DataTables\DataTables;

class BidangUrusanController extends ApiController
{
    public function __construct(BidangUrusanServices $services)
    {
        parent::__construct($services);
    } 

    public function dataTable()
    {
        $tahun = request('tahun', date('Y'));
        $data = BidangUrusan::query()
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
            ->select('bidang_urusan.*', 'urusan.kode_urusan', 'urusan.nama_urusan')
            ->orderBy('urusan.kode_urusan', 'asc');
            // ->where('bidang_urusan.tahun', $tahun);
        return DataTables::of($data)
            ->addColumn('urusan', function ($model) {
                return '<span class="label label-lg label-warning label-inline m-1">' . $model->kode_urusan . ' - ' . $model->nama_urusan . '</span>';
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
            })
            ->rawColumns(['urusan', 'action'])
            ->make(true);
    }

    public function getProgram($id)
    {
        $program = Program::where('id_bidang_urusan', $id)->orderBy('kode_program')->get();
        return Response::json($program);
    }
}
