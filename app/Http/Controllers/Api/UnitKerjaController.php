<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\BidangUrusan;
use App\Models\UnitKerja;
use App\Services\UnitKerjaServices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class UnitKerjaController extends ApiController
{
    public function __construct(UnitKerjaServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $tahun = request('tahun_anggaran', date('Y'));
        $data = UnitKerja::query()->with('BidangUrusan');
        return DataTables::of($data)
            ->filter(function ($q){
                if (request()->has('search')){
                    if (request('search')['value']) {
                        $q->where(function ($q){
                            $q->whereHas('BidangUrusan', function ($q) {
                                $q->where('nama_bidang_urusan', 'like', '%' . request('search')['value'] . '%');
                            });
                            $q->orWhere('max_pagu', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('kode_unit_kerja', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nama_unit_kerja', 'like', '%' . request('search')['value'] . '%');
                        });
                    }
                }
            })
            ->editColumn('bidang_urusan', function ($model) {
                return implode(' ,', $model->BidangUrusan->map(function ($value) {
                    return $value->nama_bidang_urusan;
                })->toArray());
            })
            ->editColumn('max_pagu',function ($model) use ($tahun){
                $get_pagu=DB::table('unit_kerja_pagu')->select('max_pagu_tahun')
                ->where('id_unit_kerja',$model->id)
                ->where('tahun',$tahun);
                if($get_pagu->count()>0){
                    $max_pagu=$get_pagu->first()->max_pagu_tahun;
                }else{
                    $max_pagu=0;
                }
                return "Rp ".numberToCurrency($max_pagu);
            })
            ->addColumn('action', function ($model) {
                return '<a href="#" class="btn btn-sm btn-success font-weight-bolder m-1 open-panel" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-edit-1"></i>
                            Edit
                        </a>
                        <a href="#" class="btn btn-sm btn-danger font-weight-bolder m-1 button-delete" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-delete"></i>
                        </a>';
            })
            ->make(true);
    }


    public function generateKode(Request $request)
    {
        $bidang_urusan = $request->input('bidang_urusan', []);
        $bidang_urusan = array_filter($bidang_urusan, function ($var) {
            return ($var !== NULL && $var !== FALSE && $var !== "" && $var !== 'null');
        });
        $bidang_urusan = array_unique($bidang_urusan);
        $kode = '';
        for ($i = 0; $i < 3; $i++) {
            if (isset($bidang_urusan[$i]) && $bidang_urusan[$i] !== null &&
                ($get_kode = BidangUrusan::with('Urusan')->find($bidang_urusan[$i]))) {
                $kode .= $get_kode->kode_urusan . '.' . $get_kode->kode_bidang_urusan . '.';
            } else {
                $kode .= '0.00.';
            }
        }
        $kode .= '00.00';
        return Response::json([
            'kode_sub_kegiatan' => $kode
        ]);
    }
}
