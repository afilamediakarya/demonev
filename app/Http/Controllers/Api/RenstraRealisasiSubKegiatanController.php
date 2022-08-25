<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\BidangUrusan;
use App\Models\RenstraSubKegiatan;
use App\Models\RenstraRealisasiSubKegiatan;
use App\Models\PegawaiPenanggungJawab;
use App\Models\Program;
use App\Models\RealisasiSubKegiatan;
use App\Services\RenstraRealisasiSubKegiatanServices;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RenstraRealisasiSubKegiatanController extends ApiController
{
    public function __construct(RenstraRealisasiSubKegiatanServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $tahun = request('tahun', date('Y'));
        $id_unit_kerja = auth()->user()->id_unit_kerja;
        $tahun = request('tahun', date('Y'));
        $data = RenstraSubKegiatan::join('sasaran','sasaran.id','=','renstra_sub_kegiatan.id_sasaran')
        ->join('urusan','urusan.id','=','renstra_sub_kegiatan.id_urusan')
        ->join('bidang_urusan','bidang_urusan.id','=','renstra_sub_kegiatan.id_bidang_urusan')
        ->join('program','program.id','=','renstra_sub_kegiatan.id_program')
        ->join('kegiatan','kegiatan.id','=','renstra_sub_kegiatan.id_kegiatan')
        ->join('sub_kegiatan','sub_kegiatan.id','=','renstra_sub_kegiatan.id_sub_kegiatan')
        //->join('dpa','dpa.id_sub_kegiatan','=','sub_kegiatan.id')
        ->whereRaw("renstra_sub_kegiatan.id_unit_kerja='$id_unit_kerja'")
        ->select('renstra_sub_kegiatan.*','sub_kegiatan.kode_sub_kegiatan','sub_kegiatan.nama_sub_kegiatan','sasaran.sasaran','program.nama_program as program','urusan.nama_urusan as urusan','urusan.kode_urusan','bidang_urusan.nama_bidang_urusan as bidang_urusan','bidang_urusan.kode_bidang_urusan','kegiatan.nama_kegiatan as kegiatan','kegiatan.kode_kegiatan')->orderBy('sub_kegiatan.kode_sub_kegiatan');
        return DataTables::of($data)
        ->filter(function ($q){
            if (request()->has('search')) {
                if (request('search')['value']) {
                    $q->where(function ($q){
                        $q->where('sub_kegiatan.kode_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
                        $q->orWhere('sub_kegiatan.nama_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');

                    });
                }
            }
        })
        ->editColumn('kode_sub_kegiatan', function ($model) {
            if ($model->is_non_urusan) {
                $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                return $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . substr($model->kode_sub_kegiatan, 4);
            }
            return $model->kode_sub_kegiatan;
        })
        ->editColumn('total_pagu_renstra', function ($model) {
            return 'Rp ' . number_format($model->total_pagu_renstra, 2, ',', '.');
        })
            ->addColumn('action', function ($model) use ($tahun) {
                // if ($tahun == date('Y'))
                    return '<a href="' . route('renstra.realisasi-sub-kegiatan.edit', [$model->uuid]) . '" class="btn btn-warning btn-sm font-weight-bolder m-1" ><span class="fa fa-edit"></span> Realisasi</a>
                        ';
                // return '';
            }
            )
            ->addColumn('grouping', function ($model) {
                return '<span class="label label-lg label-primary label-inline m-1">' .$model->sasaran . '</span>
                <span class="label label-lg label-warning label-inline m-1">' . $model->kode_urusan . ' - ' . $model->urusan . '</span>
    <span class="label label-lg label-info label-inline m-1">' . $model->kode_bidang_urusan . ' - ' . $model->bidang_urusan . '</span>
    <span class="label label-lg label-success label-inline m-1">' . $model->kode_program . ' - ' . $model->program . '</span>
    <span class="label label-lg label-success label-inline m-1">' . $model->kode_kegiatan . ' - ' . $model->kegiatan . '</span>';
            })
            ->rawColumns(['grouping', 'action', 'tolak_ukur', 'target','status_target'])
            ->make(true);
    }

    public function getProgram()
    {
        $program = [];
        if (auth()->check()) {
            if (hasRole('opd'))
                if ($user = auth()->user()) {
                    $get_bidang_urusan = optional($user->UnitKerja)->BidangUrusan;
                    $get_id_bidang_urusan = optional($get_bidang_urusan)->pluck('id')->toArray();
                    $get_id_bidang_urusan_non_urusan = BidangUrusan::where('id_urusan', BidangUrusan::ID_NON_URUSAN)->pluck('id')->toArray();
                    $get_id_bidang_urusan = array_merge($get_id_bidang_urusan, $get_id_bidang_urusan_non_urusan);
                    $program = Program::whereIn('id_bidang_urusan', $get_id_bidang_urusan)->get();
                }
        }
        return Response::json($program);
    }

    public function getKegiatan()
    {

    }

    public function getRealisasiSubKegiatan($id)
    {
        $sub_kegiatan = RealisasiSubKegiatan::where('id_kegiatan', $id)->get();
        return Response::json($sub_kegiatan);
    }

    public function getPenanggungJawab()
    {
        $pj = PegawaiPenanggungJawab::where(function ($q) {
            if (auth()->check()) {
                if (hasRole('opd'))
                    if ($user = auth()->user()) {
                        $q->where('id_unit_kerja', $user->id_unit_kerja);
                    }
            }
        })->get();
        return Response::json($pj);
    }

    public function updateTarget(Request $request, $uuid)
    {
        $target_keuangan = $request->input('target_keuangan', []);
        $persentase = $request->input('persentase', []);
        $target_fisik = $request->input('target_fisik', []);
        $request->request->add([
            'total_keuangan' => array_reduce($target_keuangan, function ($total, $value) {
                return $total + $value;
            }),
            'total_persentase' => array_reduce($persentase, function ($total, $value) {
                return $total + $value;
            }),
            'total_fisik' => array_reduce($target_fisik, function ($total, $value) {
                return $total + $value;
            }),
        ]);
        $validate = $this->services->validateTarget($request->all(), $uuid);
        if ($validate->fails()) {
            return Response::validationError($validate->errors());
        }
        return Response::json($this->services->updateTarget($validate->validated(), $uuid));
    }

    public function updateRealisasi(Request $request, $uuid)
    {
        $keuangan = $request->input('realisasi_keuangan', []);
        $fisik = $request->input('realisasi_fisik', []);
        $total_keuangan = [];
        $total_fisik = [];
        foreach ($keuangan as $k) {
            if (is_array($k)) {
                foreach ($k as $index => $value) {
                    if (!isset($total_keuangan[$index])) {
                        $total_keuangan[$index] = $value;
                    } else {
                        $total_keuangan[$index] += $value;
                    }
                }
            }
        }
        foreach ($fisik as $f) {
            if (is_array($f)) {
                foreach ($f as $index => $value) {
                    if (!isset($total_fisik[$index])) {
                        $total_fisik[$index] = $value;
                    } else {
                        $total_fisik[$index] += $value;
                    }
                }
            }
        }
        foreach ($total_keuangan as $key => $tk) {
            $request->request->add([
                'sumber_dana_' . $key => $tk
            ]);
        }
        foreach ($total_fisik as $key => $tf) {
            $request->request->add([
                'total_fisik_' . $key => $tf
            ]);
        }
        $validate = $this->services->validateRealisasi($request->all(), $uuid);
        if ($validate->fails()) {
            return Response::validationError($validate->errors());
        }
        return Response::json($this->services->updateRealisasi($validate->validated(), $uuid));
    }

    public function getRealisasiSubKegiatanAll()
    {
        $unit_kerja = auth()->user()->UnitKerja;
        $unit_kerja->load('BidangUrusan.Program.Kegiatan.Subkegiatan');
        $sub_kegiatan_dpa = $unit_kerja->RenstraRealisasiSubKegiatan()->where(function ($q) {
            if (request()->has('uuid'))
                $q->where('uuid', '!=', request('uuid'));
        })->pluck('id_sub_kegiatan');
        $sub_kegiatan = new Collection();
        $non_urusan = BidangUrusan::where('kode_bidang_urusan', '00')->with('Program.Kegiatan.RealisasiSubKegiatan')->first();
        $unit_kerja->BidangUrusan->push($non_urusan);
        foreach ($unit_kerja->BidangUrusan as $bidang) {
            foreach ($bidang->Program as $program) {
                foreach ($program->Kegiatan as $kegiatan) {
                    $sk = $kegiatan->RealisasiSubKegiatan->whereNotIn('id', $sub_kegiatan_dpa)->values();
                    if ($sk->count())
                        $sub_kegiatan = $sub_kegiatan->merge($sk);
                }
            }
        }
        $sub_kegiatan = $sub_kegiatan->sortBy('kode_sub_kegiatan')->values();
        return Response::json($sub_kegiatan);
    }

    public function create(Request $request)
    {
        return parent::create($request);
    }
    

    public function updateTolakUkur(Request $request, $uuid){
        $validate = $this->services->validateUpdateTolakUkur($request->all());
        if ($validate->fails()) {
            return Response::validationError($validate->errors());
        }
        return Response::json($this->services->updateTolakUkur($validate->validated(),$uuid));
    }

}
