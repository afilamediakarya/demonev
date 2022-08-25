<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\KegiatanDak;
use App\Models\SubBidangDak;
use App\Services\KegiatanDakService;
use Yajra\DataTables\DataTables;


class KegiatanDakController extends ApiController
{
    public function __construct(KegiatanDakService $services)
    {
        parent::__construct($services);
    } 

    public function dataTable()
    {

        $data = KegiatanDak::query()
            ->join('sub_bidang_dak', 'kegiatan_dak.id_sub_bidang', '=', 'sub_bidang_dak.id')
            ->select('kegiatan_dak.kode_kegiatan','kegiatan_dak.kegiatan','kegiatan_dak.id','kegiatan_dak.uuid', 'sub_bidang_dak.kode_sub_bidang_dak', 'sub_bidang_dak.sub_bidang')
            ->orderBy('sub_bidang_dak.kode_sub_bidang_dak', 'asc');
            // ->where('bidang_urusan.tahun', $tahun);
        return DataTables::of($data)
            ->addColumn('sub_bidang_dak', function ($model) {
                return '<span class="label label-lg label-warning label-inline m-1">' . $model->kode_sub_bidang_dak . ' - ' . $model->sub_bidang . '</span>';
            })
            ->addColumn('action', function ($model){
                return '<a href="#" class="btn btn-sm btn-success font-weight-bolder m-1 open-panel" data-uuid="' . $model->uuid . '">
                        <i class="flaticon-edit-1"></i>
                        Edit
                    </a>
                    <a href="#" class="btn btn-sm btn-danger font-weight-bolder m-1 button-delete" data-uuid="' . $model->uuid . '">
                        <i class="flaticon-delete"></i>
                    </a>';
            })
            ->rawColumns(['sub_bidang_dak', 'action'])
            ->make(true);
    }

}
