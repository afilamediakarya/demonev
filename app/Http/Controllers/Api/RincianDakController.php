<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\TematikDak;
use App\Models\KegiatanDak;
use App\Models\RincianDak;
use App\Services\RincianDakService;
use Yajra\DataTables\DataTables;
use DB;
class RincianDakController extends ApiController
{
    public function __construct(RincianDakService $services)
    {
        parent::__construct($services);
    } 

    public function dataTable()
    {

        // $data = DB::table('rincian_dak')->latest()->get();
        // return $data;
        // RincianDak::query()
        $data = DB::table('rincian_dak')
            ->join('kegiatan_dak', 'rincian_dak.id_kegiatan', '=', 'kegiatan_dak.id')
            ->join('tematik_dak', 'rincian_dak.id_tematik', '=', 'tematik_dak.id')
            ->select('rincian_dak.*', 'kegiatan_dak.kode_kegiatan', 'kegiatan_dak.kegiatan','tematik_dak.kode_tematik', 'tematik_dak.tematik')
            ->orderBy('kegiatan_dak.kode_kegiatan', 'asc')->get();
            // ->where('bidang_urusan.tahun', $tahun);
        return DataTables::of($data)
            ->addColumn('relation_', function ($model) {
                return '<span class="label label-lg label-warning label-inline m-1">' . $model->kode_kegiatan . ' - ' . $model->kegiatan . ' (Kegiatan) </span><span class="label label-lg label-info label-inline m-1">' . $model->kode_tematik . ' - ' . $model->tematik . ' (Tematik) </span>';
            })
            ->addColumn('action', function ($model){
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
            ->rawColumns(['relation_', 'action'])
            ->make(true);
    }


}
