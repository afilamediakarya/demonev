<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\BidangDak;
use App\Models\SubBidangDak;
use App\Services\SubBidangDakService;
use Yajra\DataTables\DataTables;
use DB;
class SubBidangDakController extends ApiController
{
    public function __construct(SubBidangDakService $services)
    {
        parent::__construct($services);
    } 

    public function dataTable()
    {

        $data = DB::table('sub_bidang_dak')
            ->join('bidang_dak', 'sub_bidang_dak.id_bidang_dak', '=', 'bidang_dak.id')
            ->select('sub_bidang_dak.kode_sub_bidang_dak','sub_bidang_dak.sub_bidang','sub_bidang_dak.id','sub_bidang_dak.uuid', 'bidang_dak.kode_bidang_dak', 'bidang_dak.bidang')
            ->orderBy('bidang_dak.kode_bidang_dak', 'asc');
            // return $data;
            // ->where('bidang_urusan.tahun', $tahun);
        return DataTables::of($data)
            ->addColumn('bidang_dak', function ($model) {
                return '<span class="label label-lg label-warning label-inline m-1">' . $model->kode_bidang_dak . ' - ' . $model->bidang . '</span>';
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
            ->rawColumns(['bidang_dak', 'action'])
            ->make(true);
    }
}
