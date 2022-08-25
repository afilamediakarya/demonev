<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Services\ProgramServices;
use Yajra\DataTables\DataTables;

class ProgramController extends ApiController
{
    public function __construct(ProgramServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $tahun = request('tahun', date('Y'));
        $data = Program::query()
            ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
            ->select('program.*', 'bidang_urusan.kode_bidang_urusan', 'bidang_urusan.nama_bidang_urusan', 'urusan.kode_urusan', 'urusan.nama_urusan')
            ->orderBy('urusan.kode_urusan', 'asc')
            ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc');
            // ->where('program.tahun', $tahun);
        return DataTables::of($data)
            ->addColumn('urusan', function ($model) {
                return '<span class="label label-lg label-warning label-inline m-1">' . $model->kode_urusan . ' - ' . $model->nama_urusan . '</span><span class="label label-lg label-info label-inline">' . $model->kode_bidang_urusan . ' - ' . $model->nama_bidang_urusan . '</span>';
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

    public function getKegiatan($id)
    {
        $kegiatan = Kegiatan::where('id_program', $id)->get();
        return Response::json($kegiatan);
    }
}
