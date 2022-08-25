<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\BackupReport;
use App\Services\BackupReportServices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class BackupReportController extends ApiController
{
    public function __construct(BackupReportServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $tahun = request('tahun', date('Y'));
        $data = BackupReport::query()->where('tahun', $tahun);
        return DataTables::of($data)
            ->orderColumn('created_at', function ($query, $order) {
                $query->orderBy('created_at', 'desc');
            })
            ->addColumn('created_at', function ($model) {
                return $model->created_at->format('d M Y H:i:s');
            })
            ->addColumn('action', function ($model) use ($tahun) {
                // if ($tahun == date('Y'))
                    return '
                        <a href="#" class="btn btn-sm btn-danger font-weight-bolder m-1 button-delete" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-delete"></i>
                        </a>';
                // return '';
            })
            ->make(true);
    }

    public function create(Request $request)
    {
        return parent::create($request);
    }

    public function deleteByUuid($uuid)
    {
        $item=BackupReport::where('uuid',$uuid)->first();
        //DPA
        DB::delete("DELETE FROM `backup_report_dpa` WHERE triwulan='$item->triwulan' AND tahun='$item->tahun'");
        //DPA END

        //TOLAK UKUR
        DB::delete("DELETE FROM `backup_report_tolak_ukur` WHERE triwulan='$item->triwulan' AND tahun='$item->tahun'");
        //TOLAK UKUR END
        
        //PAKET DAK
        DB::delete("DELETE FROM `backup_report_paket_dak` WHERE triwulan='$item->triwulan' AND tahun='$item->tahun'");
        //PAKET DAK END
        
        //TARGET
        DB::delete("DELETE FROM `backup_report_target` WHERE triwulan='$item->triwulan' AND tahun='$item->tahun'");
        //TARGET END
        
        //REALISASI DAK
        DB::delete("DELETE FROM `backup_report_realisasi_dak` WHERE triwulan='$item->triwulan' AND tahun='$item->tahun'");
        //REALISASI DAK END

        //REALISASI
        DB::delete("DELETE FROM `backup_report_realisasi` WHERE triwulan='$item->triwulan' AND tahun='$item->tahun'");
        //REALISASI END

        //DETAIL REALISASI
        DB::delete("DELETE FROM `backup_report_detail_realisasi` WHERE triwulan='$item->triwulan' AND tahun='$item->tahun'");
        //DETAIL REALISASI END

        //SUMBER DANA DPA
        DB::delete("DELETE FROM `backup_report_sumber_dana_dpa` WHERE triwulan='$item->triwulan' AND tahun='$item->tahun'");
        //SUMBER DANA DPA END

        BackupReport::where('uuid',$uuid)->delete();

        $response = [
            'msg' => 'No tfound'
        ];
        return response()->json($response);
    }

}
