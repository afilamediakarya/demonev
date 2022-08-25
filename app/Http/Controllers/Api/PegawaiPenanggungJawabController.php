<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\PegawaiPenanggungJawab;
use App\Services\PegawaiPenanggungJawabServices;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PegawaiPenanggungJawabController extends ApiController
{
    public function __construct(PegawaiPenanggungJawabServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $data = PegawaiPenanggungJawab::query()
            ->leftJoin('unit_kerja', 'pegawai_penanggung_jawab.id_unit_kerja', '=', 'unit_kerja.id')
            ->select('pegawai_penanggung_jawab.uuid', 'pegawai_penanggung_jawab.status', 'pegawai_penanggung_jawab.nip', 'pegawai_penanggung_jawab.nama_lengkap', 'unit_kerja.nama_unit_kerja AS unit_kerja')
            ->where(function ($q) {
                if (auth()->check()) {
                    if (hasRole('opd')) {
                        if ($user = auth()->user()) {
                            $q->where('id_unit_kerja', $user->id_unit_kerja);
                        }
                    }
                }
            });
        return DataTables::of($data)
            ->filter(function ($q){
                if (request()->has('search')){
                    if (request('search')['value']) {
                        $q->where(function ($q){
                            $q->where('nip', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nama_lengkap', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nama_unit_kerja', 'like', '%' . request('search')['value'] . '%');
                        });
                    }
                }
            })
            ->orderColumn('unit_kerja', function ($query, $order) {
                $query->orderBy('nama_unit_kerja', $order);
            })
            ->orderColumn('penanggung_jawab', function ($query, $order) {
                $query->orderBy('nama_lengkap', $order);
            })
            ->addColumn('penanggung_jawab', function ($model) {
                return $model->nama_lengkap;
            })
            ->addColumn('unit_kerja', function ($model) {
                return $model->unit_kerja;
            })
            ->addColumn('action', function ($model) {
                return '<a href="#" class="btn btn-sm btn-success font-weight-bolder m-1 open-panel" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-edit-1"></i>
                            Edit
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-secondary font-weight-bolder m-1 button-status" data-status="' . ($model->status ? '1' : '0') . '" data-uuid="' . $model->uuid . '">
                            <i class="flaticon2-paper"></i>' . ($model->status ? 'Nonaktifkan' : 'Aktifkan') . '
                        </a>
                        <a href="#" class="btn btn-sm btn-danger font-weight-bolder m-1 button-delete" data-uuid="' . $model->uuid . '">
                            <i class="flaticon-delete"></i>
                        </a>';
            })
            ->make(true);
    }

    public function toggleStatus($uuid)
    {
        $pg = PegawaiPenanggungJawab::whereUuid($uuid)->first();
        $pg->status = $pg->status ? 0 : 1;
        $pg->save();
        return Response::json($pg);
    }

    public function create(Request $request)
    {
        if (hasRole('opd')) {
            $request->request->add([
                'id_unit_kerja' => auth()->user()->id_unit_kerja
            ]);
        }
        return parent::create($request);
    }

}
