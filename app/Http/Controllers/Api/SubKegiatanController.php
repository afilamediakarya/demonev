<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\SubKegiatan;
use App\Services\SubKegiatanServices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubKegiatanController extends ApiController
{
    public function __construct(SubKegiatanServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $tahun = request('tahun', date('Y'));
        $data = SubKegiatan::query()
            ->join('kegiatan', 'sub_kegiatan.id_kegiatan', '=', 'kegiatan.id')
            ->join('program', 'kegiatan.id_program', '=', 'program.id')
            ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
            ->select('sub_kegiatan.*', 'kegiatan.kode_kegiatan', 'kegiatan.nama_kegiatan', 'program.kode_program', 'program.nama_program', 'bidang_urusan.kode_bidang_urusan', 'bidang_urusan.nama_bidang_urusan', 'urusan.kode_urusan', 'urusan.nama_urusan')
            ->orderBy('urusan.kode_urusan', 'asc')
            ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc')
            ->orderBy('program.kode_program', 'asc')
            ->orderBy('kegiatan.kode_kegiatan', 'asc');
            // ->where('sub_kegiatan.tahun', $tahun);
        return DataTables::of($data)
            ->addColumn('urusan', function ($model) {
                return '<span class="label label-lg label-warning label-inline m-1">' . $model->kode_urusan . ' - ' . $model->nama_urusan . '</span>
<span class="label label-lg label-info label-inline m-1">' . $model->kode_bidang_urusan . ' - ' . $model->nama_bidang_urusan . '</span>
<span class="label label-lg label-success label-inline m-1">' . $model->kode_program . ' - ' . $model->nama_program . '</span>
<span class="label label-lg label-primary label-inline m-1">' . $model->kode_kegiatan . ' - ' . $model->nama_kegiatan . '</span>';
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

    public function generateKode(Request $request)
    {
        return Response::json($this->services->generateKode($request->all()));
    }
}
