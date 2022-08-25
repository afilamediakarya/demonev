<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\BidangUrusan;
use App\Models\Dpa;
use App\Models\PegawaiPenanggungJawab;
use App\Models\Program;
use App\Models\SubKegiatan;
use App\Services\DpaServices;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RenstraController extends ApiController
{
    public function __construct(DpaServices $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $tahun = request('tahun', date('Y'));
        $id_unit_kerja = auth()->user()->id_unit_kerja;
        $data = Dpa::query()
            ->with('TolakUkur')
            ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
            ->join('kegiatan', 'dpa.id_kegiatan', '=', 'kegiatan.id')
            ->join('program', 'dpa.id_program', '=', 'program.id')
            ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
//            ->join('tolak_ukur', 'dpa.id', '=', 'tolak_ukur.id_dpa')
            ->select('dpa.*',
//                'tolak_ukur.tolak_ukur',
//                'tolak_ukur.volume',
//                'tolak_ukur.satuan',
                'sub_kegiatan.kode_sub_kegiatan',
                'sub_kegiatan.nama_sub_kegiatan',
                'kegiatan.kode_kegiatan',
                'kegiatan.nama_kegiatan',
                'program.kode_program',
                'program.nama_program',
                'bidang_urusan.kode_bidang_urusan',
                'bidang_urusan.nama_bidang_urusan',
                'urusan.kode_urusan',
                'urusan.nama_urusan')
            ->orderBy('urusan.kode_urusan', 'asc')
            ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc')
            ->orderBy('program.kode_program', 'asc')
            ->orderBy('kegiatan.kode_kegiatan', 'asc')
            ->orderBy('sub_kegiatan.kode_sub_kegiatan', 'asc')
            ->where('dpa.tahun', $tahun)
            ->where('dpa.id_unit_kerja', $id_unit_kerja);
        return DataTables::of($data)
            ->filter(function ($q){
                if (request()->has('search')) {
                    if (request('search')['value']) {
                        $q->where(function ($q){
                            $q->where('kode_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nama_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nilai_pagu_dpa', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhereHas('TolakUkur',function ($q){
                                $q->where('tolak_ukur', 'like', '%' . request('search')['value'] . '%');
                                $q->orWhere('volume', 'like', '%' . request('search')['value'] . '%');
                                $q->orWhere('satuan', 'like', '%' . request('search')['value'] . '%');
                            });
                        });
                    }
                }
            })
            ->addColumn('tolak_ukur', function ($model) {
                return implode("<hr>", $model->TolakUkur->map(function ($value) {
                    return $value->tolak_ukur . " : " . $value->volume . " ({$value->satuan}) ";
                })->toArray());
            })
            ->editColumn('nilai_pagu_dpa', function ($model) {
                return 'Rp ' . number_format($model->nilai_pagu_dpa, 2, ',', '.');
            })
            ->editColumn('status_target', function ($model) {
                $target=$model->Target()->sum('persentase');
                if($target>=99.99){
                    $status='<span class="label label-lg label-success label-inline m-1">Selesai</span>';
                }else{
                    $status='<span class="label label-lg label-danger label-inline m-1">Belum</span>';
                }
                return $status;
            })
            ->editColumn('kode_sub_kegiatan', function ($model) {
                if ($model->is_non_urusan) {
                    $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                    return $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . substr($model->kode_sub_kegiatan, 4);
                }
                return $model->kode_sub_kegiatan;
            })
            ->addColumn('grouping', function ($model) {
                if ($model->is_non_urusan) {
                    $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                    if ($bidang_urusan) {
                        $model->kode_urusan = $bidang_urusan->Urusan->kode_urusan;
                        $model->nama_urusan = $bidang_urusan->Urusan->nama_urusan;
                        $model->kode_bidang_urusan = $bidang_urusan->kode_bidang_urusan;
                        $model->nama_bidang_urusan = $bidang_urusan->nama_bidang_urusan;
                    }
                }
                return '<span class="label label-lg label-warning label-inline m-1">' . $model->kode_urusan . ' - ' . $model->nama_urusan . '</span>
<span class="label label-lg label-info label-inline m-1">' . $model->kode_bidang_urusan . ' - ' . $model->nama_bidang_urusan . '</span>
<span class="label label-lg label-success label-inline m-1">' . $model->kode_program . ' - ' . $model->nama_program . '</span>
<span class="label label-lg label-primary label-inline m-1">' . $model->kode_kegiatan . ' - ' . $model->nama_kegiatan . '</span>';
            })
            ->addColumn('action', function ($model) use ($tahun) {
                // if ($tahun == date('Y')) {
                    $btn_text = 'Edit Outcome';
                    // $url = route('kegiatan.dpa.detail', [$model->uuid]);
                    $url = '#';
                    $disabled='';
                    $disabled2 = !cekJadwal('Kegiatan', 'Sub Kegiatan DPA Pokok') ? 'disabled' : '';
                    // if($disabled2==''){
                    //     $additional = '<a href="' . route('kegiatan.dpa.edit', [$model->uuid]) . '" class="btn btn-warning btn-sm font-weight-bolder m-1" ><span class="fa fa-edit"></span> Edit</a>
                    //     <a href="' . route('kegiatan.dpa.edit.tolak-ukur', [$model->uuid]) . '"  class="btn btn-info btn-sm font-weight-bolder m-1"><span class="fa fa-edit"></span> Edit Tolak Ukur</a>
                    //     <a href="#" class="btn btn-sm btn-danger font-weight-bolder m-1 button-delete" data-uuid="' . $model->uuid . '" >
                    //         <i class="flaticon-delete"></i> 
                    //     </a>';
                    // }else{
                    //     $additional=' <a href="#" class="btn btn-sm btn-danger font-weight-bolder mt-1">
                    //                     <span class="flaticon-lock"></span> 
                    //                 </a>';
                    // }
                    $additional=' ';

                    
                    if (request('type', '') === 'target') {
                        $btn_text = 'Set Target';
                        $url = cekJadwal('Target', 'Target DPA Pokok Triwulan I-IV') ? route('monitoring.target.atur', [$model->uuid]) : '#';
                        $disabled = !cekJadwal('Target', 'Target DPA Pokok Triwulan I-IV') ? 'disabled' : '';
                        $additional = '';
                    } elseif (request('type', '') === 'realisasi') {
                        $btn_text = 'Realisasi';
                        $url = cekJadwalInput('Realisasi|Realisasi Triwulan I', 'Realisasi|Realisasi Triwulan II', 'Realisasi|Realisasi Triwulan III', 'Realisasi|Realisasi Triwulan IV') ? route('monitoring.realisasi.atur', [$model->uuid]) : '#';
                        $disabled = !cekJadwalInput('Realisasi|Realisasi Triwulan I', 'Realisasi|Realisasi Triwulan II', 'Realisasi|Realisasi Triwulan III', 'Realisasi|Realisasi Triwulan IV') ? 'disabled' : '';
                        $additional = '';
                    }
                    return '<a href="' . $url . '" class="btn btn-sm btn-primary font-weight-bolder ' . $disabled . '">
                                                <span class="svg-icon svg-icon-sm">
                                                    <svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0 0.5V13.5H10V3.79688L9.85938 3.64062L6.85938 0.640625L6.70312 0.5H0ZM1 1.5H6V4.5H9V12.5H1V1.5ZM7 2.21875L8.28125 3.5H7V2.21875ZM2.5 5.5V6.5H7.5V5.5H2.5ZM2.5 7.5V8.5H7.5V7.5H2.5ZM2.5 9.5V10.5H7.5V9.5H2.5Z" fill="white"/>
                                                    </svg>
                                                </span>' . $btn_text . '
                                            </a>' . $additional;

                // }
                // return '';
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

    public function getSubKegiatan($id)
    {
        $sub_kegiatan = SubKegiatan::where('id_kegiatan', $id)->get();
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

    public function getSubKegiatanAll()
    {
        $unit_kerja = auth()->user()->UnitKerja;
        $unit_kerja->load('BidangUrusan.Program.Kegiatan.Subkegiatan');
        $sub_kegiatan_dpa = $unit_kerja->Dpa()->where(function ($q) {
            if (request()->has('uuid'))
                $q->where('uuid', '!=', request('uuid'));
        })->pluck('id_sub_kegiatan');
        $sub_kegiatan = new Collection();
        $non_urusan = BidangUrusan::where('kode_bidang_urusan', '00')->with('Program.Kegiatan.SubKegiatan')->first();
        $unit_kerja->BidangUrusan->push($non_urusan);
        foreach ($unit_kerja->BidangUrusan as $bidang) {
            foreach ($bidang->Program as $program) {
                foreach ($program->Kegiatan as $kegiatan) {
                    $sk = $kegiatan->SubKegiatan->whereNotIn('id', $sub_kegiatan_dpa)->values();
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

    // public function updateData(Request $request, $id)
    // {
    //     return $this->services->updateData($id, $request);
    // }

    public function updateTolakUkur(Request $request, $uuid){
        $validate = $this->services->validateUpdateTolakUkur($request->all());
        if ($validate->fails()) {
            return Response::validationError($validate->errors());
        }
        return Response::json($this->services->updateTolakUkur($validate->validated(),$uuid));
    }

}
