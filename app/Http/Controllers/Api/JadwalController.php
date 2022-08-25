<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\Jadwal;
use App\Services\JadwalServices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class JadwalController extends ApiController
{
    public function __construct(JadwalServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $tahun = request('tahun', date('Y'));
        $data = Jadwal::query()->where('tahun', $tahun);
        return DataTables::of($data)
            ->orderColumn('jadwal', function ($query, $order) {
                $query->orderBy('jadwal_mulai', $order);
            })
            ->addColumn('jadwal', function ($model) {
                return $model->jadwal_mulai->format('d M Y') . ' s/d ' . $model->jadwal_selesai->format('d M Y');
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
            ->make(true);
    }

    public function create(Request $request)
    {
        if ($this->services->cekJadwalEksist($request->only(['tahapan', 'sub_tahapan', 'tahun','uuid']))) {
            return Response::validationError([
                'jadwal' => ['jadwal dengan format tersebut telah di input']
            ]);
        }
        return parent::create($request);
    }

}
