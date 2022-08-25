<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\BidangUrusan;
use App\Models\DetailRealisasi;
use App\Models\Dpa;
use App\Models\PaketDak;
use App\Models\PegawaiPenanggungJawab;
use App\Models\Program;
use App\Models\Realisasi;
use App\Models\RealisasiDak;
use App\Models\SubKegiatan;
use App\Models\SumberDanaDpa;
use App\Services\DakNonFisikService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DakNonFisikController extends ApiController
{
    public function __construct(DakNonFisikService $services)
    {
        parent::__construct($services);
    }

    public function dataTable()
    {
        $tahun = request('tahun', date('Y'));
        $id_unit_kerja = auth()->user()->id_unit_kerja;
        $data2 = Dpa::query()
            ->with('TolakUkur')
            ->join('sumber_dana_dpa', 'sumber_dana_dpa.id_dpa', '=', 'dpa.id')
            ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
            ->join('kegiatan', 'dpa.id_kegiatan', '=', 'kegiatan.id')
            ->join('program', 'dpa.id_program', '=', 'program.id')
            ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
            ->select('dpa.*',
                'sub_kegiatan.kode_sub_kegiatan',
                'sub_kegiatan.nama_sub_kegiatan',
                'kegiatan.kode_kegiatan',
                'kegiatan.nama_kegiatan',
                'program.kode_program',
                'program.nama_program',
                'bidang_urusan.kode_bidang_urusan',
                'bidang_urusan.nama_bidang_urusan',
                'urusan.kode_urusan',
                'urusan.nama_urusan',
                'sumber_dana_dpa.sumber_dana',
                'sumber_dana_dpa.jenis_belanja',
                'sumber_dana_dpa.id as id_sumber_dana_dpa',
                'sumber_dana_dpa.uuid as uuid_sd', 'sumber_dana_dpa.nilai_pagu as nilai_pagu_dak')
            ->orderBy('urusan.kode_urusan', 'asc')
            ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc')
            ->orderBy('program.kode_program', 'asc')
            ->orderBy('kegiatan.kode_kegiatan', 'asc')
            ->orderBy('sub_kegiatan.kode_sub_kegiatan', 'asc')
            ->where('sumber_dana_dpa.sumber_dana', 'LIKE', '%DAK NON-FISIK')
            ->where('dpa.tahun', $tahun)
            ->where('dpa.id_unit_kerja', $id_unit_kerja);


        $data = Dpa::query()
            ->with('TolakUkur')
            ->join('sumber_dana_dpa', 'sumber_dana_dpa.id_dpa', '=', 'dpa.id')
            ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
            ->join('kegiatan', 'dpa.id_kegiatan', '=', 'kegiatan.id')
            ->join('program', 'dpa.id_program', '=', 'program.id')
            ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
            ->select('dpa.*',
                'sub_kegiatan.kode_sub_kegiatan',
                'sub_kegiatan.nama_sub_kegiatan',
                'kegiatan.kode_kegiatan',
                'kegiatan.nama_kegiatan',
                'program.kode_program',
                'program.nama_program',
                'bidang_urusan.kode_bidang_urusan',
                'bidang_urusan.nama_bidang_urusan',
                'urusan.kode_urusan',
                'urusan.nama_urusan',
                'sumber_dana_dpa.sumber_dana',
                'sumber_dana_dpa.uuid as uuid_sd')
            ->orderBy('urusan.kode_urusan', 'asc')
            ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc')
            ->orderBy('program.kode_program', 'asc')
            ->orderBy('kegiatan.kode_kegiatan', 'asc')
            ->orderBy('sub_kegiatan.kode_sub_kegiatan', 'asc')
            ->where('dpa.tahun', $tahun)
            ->where('sumber_dana_dpa.sumber_dana', 'DAK FISIK')
            ->where('dpa.id_unit_kerja', $id_unit_kerja);


        return DataTables::of($data2)
            ->filter(function ($q) {
                if (request()->has('search')) {
                    if (request('search')['value']) {
                        $q->where(function ($q) {
                            $q->where('kode_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nama_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nilai_pagu_dpa', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhereHas('TolakUkur', function ($q) {
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
            ->addColumn('sumber_dana', function ($model) {
                return $model->sumber_dana.' - '.$model->jenis_belanja;
            })
            ->editColumn('nilai_pagu_dpa', function ($model) {
                return 'Rp.' . number_format($model->nilai_pagu_dak, 2, ',', '.');
            })
            ->editColumn('kode_sub_kegiatan', function ($model) {
                if ($model->is_non_urusan) {
                    $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                    return $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . substr($model->kode_sub_kegiatan, 4);
                }
                return $model->kode_sub_kegiatan;
            })
            ->editColumn('total_input', function ($model) {
                $anggaran = $model->PaketDak()->where('id_sumber_dana_dpa', $model->id_sumber_dana_dpa)->sum('anggaran_dak');
                $pendampingan = $model->PaketDak()->where('id_sumber_dana_dpa', $model->id_sumber_dana_dpa)->sum('pendampingan');
                $target = $anggaran + $pendampingan;
                return 'Rp.' . number_format($target, 2, ',', '.');

            })
            ->editColumn('status_input', function ($model) {
                $anggaran = $model->PaketDak()->where('id_sumber_dana_dpa', $model->id_sumber_dana_dpa)->sum('anggaran_dak');
                $pendampingan = $model->PaketDak()->where('id_sumber_dana_dpa', $model->id_sumber_dana_dpa)->sum('pendampingan');
                $target = $anggaran + $pendampingan;
                if ($model->nilai_pagu_dak == $target) {
                    $status = '<span class="label label-lg label-success label-inline m-1">Selesai</span>';
                    // $status='<span class="label label-lg label-success label-inline m-1">Selesai</span>';
                } else {
                    $status = '<span class="label label-lg label-danger label-inline m-1">Belum</span>';
                }


                return $status;

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

                    $disabled2 = !cekJadwal('Kegiatan', 'Sub Kegiatan DPA Pokok') ? 'disabled' : '';
                    if ($disabled2 == '') {
                        $btn_text = 'Perencanaan';
                        $url = cekJadwal('Kegiatan', 'Sub Kegiatan DPA Pokok') ? route('kegiatan.dak_non_fisik.perencanaan', $model->uuid) . '?uuid_sd=' . $model->uuid_sd : '#';
                        $disabled = !cekJadwal('Kegiatan', 'Sub Kegiatan DPA Pokok') ? 'disabled' : '';
                        $additional = '';
                        return '<a href="' . $url . '" class="btn btn-sm btn-primary font-weight-bolder ' . $disabled . '">
                                                <span class="svg-icon svg-icon-sm">
                                                    <svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0 0.5V13.5H10V3.79688L9.85938 3.64062L6.85938 0.640625L6.70312 0.5H0ZM1 1.5H6V4.5H9V12.5H1V1.5ZM7 2.21875L8.28125 3.5H7V2.21875ZM2.5 5.5V6.5H7.5V5.5H2.5ZM2.5 7.5V8.5H7.5V7.5H2.5ZM2.5 9.5V10.5H7.5V9.5H2.5Z" fill="white"/>
                                                    </svg>
                                                </span>' . $btn_text . '
                                            </a>' . $additional;
                    } else {
                        $btn_text = '';
                        $url = '';
                        $disabled = '';
                        $additional = ' <a href="#" class="btn btn-sm btn-danger font-weight-bolder mt-1">
                                        <span class="flaticon-lock"></span>
                                    </a>';
                        return $additional;
                    }


                // }
                // return '';
            })
            ->rawColumns(['grouping', 'action', 'tolak_ukur', 'target', 'status_input'])
            ->make(true);
    }

    public function dataTablePen($tahun,$keyword){
        
        // $tahun = request('tahun', date('Y'));
        $tahun = date('Y');
        $id_unit_kerja = auth()->user()->id_unit_kerja;
        $data2 = Dpa::query()
            ->with('TolakUkur')
            ->join('sumber_dana_dpa', 'sumber_dana_dpa.id_dpa', '=', 'dpa.id')
            ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
            ->join('kegiatan', 'dpa.id_kegiatan', '=', 'kegiatan.id')
            ->join('program', 'dpa.id_program', '=', 'program.id')
            ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
            ->select('dpa.*',
                'sub_kegiatan.kode_sub_kegiatan',
                'sub_kegiatan.nama_sub_kegiatan',
                'kegiatan.kode_kegiatan',
                'kegiatan.nama_kegiatan',
                'program.kode_program',
                'program.nama_program',
                'bidang_urusan.kode_bidang_urusan',
                'bidang_urusan.nama_bidang_urusan',
                'urusan.kode_urusan',
                'urusan.nama_urusan',
                'sumber_dana_dpa.sumber_dana',
                'sumber_dana_dpa.jenis_belanja',
                'sumber_dana_dpa.id as id_sumber_dana_dpa',
                'sumber_dana_dpa.uuid as uuid_sd', 'sumber_dana_dpa.nilai_pagu as nilai_pagu_dak')
            ->orderBy('urusan.kode_urusan', 'asc')
            ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc')
            ->orderBy('program.kode_program', 'asc')
            ->orderBy('kegiatan.kode_kegiatan', 'asc')
            ->orderBy('sub_kegiatan.kode_sub_kegiatan', 'asc')
            ->where('sumber_dana_dpa.sumber_dana', 'LIKE', '%'.$keyword)
            ->where('sumber_dana_dpa.jenis_belanja','Belanja Modal')
            ->where('dpa.tahun', $tahun)
            ->where('dpa.id_unit_kerja', $id_unit_kerja);


        $data = Dpa::query()
            ->with('TolakUkur')
            ->join('sumber_dana_dpa', 'sumber_dana_dpa.id_dpa', '=', 'dpa.id')
            ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
            ->join('kegiatan', 'dpa.id_kegiatan', '=', 'kegiatan.id')
            ->join('program', 'dpa.id_program', '=', 'program.id')
            ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
            ->select('dpa.*',
                'sub_kegiatan.kode_sub_kegiatan',
                'sub_kegiatan.nama_sub_kegiatan',
                'kegiatan.kode_kegiatan',
                'kegiatan.nama_kegiatan',
                'program.kode_program',
                'program.nama_program',
                'bidang_urusan.kode_bidang_urusan',
                'bidang_urusan.nama_bidang_urusan',
                'urusan.kode_urusan',
                'urusan.nama_urusan',
                'sumber_dana_dpa.sumber_dana',
                'sumber_dana_dpa.uuid as uuid_sd')
            ->orderBy('urusan.kode_urusan', 'asc')
            ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc')
            ->orderBy('program.kode_program', 'asc')
            ->orderBy('kegiatan.kode_kegiatan', 'asc')
            ->orderBy('sub_kegiatan.kode_sub_kegiatan', 'asc')
            ->where('dpa.tahun', $tahun)
            ->where('sumber_dana_dpa.sumber_dana', 'DAK FISIK')
            ->where('dpa.id_unit_kerja', $id_unit_kerja);


        return DataTables::of($data2)
            ->filter(function ($q) {
                if (request()->has('search')) {
                    if (request('search')['value']) {
                        $q->where(function ($q) {
                            $q->where('kode_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nama_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nilai_pagu_dpa', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhereHas('TolakUkur', function ($q) {
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
            ->addColumn('sumber_dana', function ($model) {
                return $model->sumber_dana.' - '.$model->jenis_belanja;
            })
            ->editColumn('nilai_pagu_dpa', function ($model) {
                return 'Rp.' . number_format($model->nilai_pagu_dak, 2, ',', '.');
            })
            ->editColumn('kode_sub_kegiatan', function ($model) {
                if ($model->is_non_urusan) {
                    $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                    return $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . substr($model->kode_sub_kegiatan, 4);
                }
                return $model->kode_sub_kegiatan;
            })
            ->editColumn('total_input', function ($model) {
                $anggaran = $model->PaketDak()->where('id_sumber_dana_dpa', $model->id_sumber_dana_dpa)->sum('anggaran_dak');
                $pendampingan = $model->PaketDak()->where('id_sumber_dana_dpa', $model->id_sumber_dana_dpa)->sum('pendampingan');
                $target = $anggaran + $pendampingan;
                return 'Rp.' . number_format($target, 2, ',', '.');

            })
            ->editColumn('status_input', function ($model) {
                $anggaran = $model->PaketDak()->where('id_sumber_dana_dpa', $model->id_sumber_dana_dpa)->sum('anggaran_dak');
                $pendampingan = $model->PaketDak()->where('id_sumber_dana_dpa', $model->id_sumber_dana_dpa)->sum('pendampingan');
                $target = $anggaran + $pendampingan;
                if ($model->nilai_pagu_dak == $target) {
                    $status = '<span class="label label-lg label-success label-inline m-1">Selesai</span>';
                    // $status='<span class="label label-lg label-success label-inline m-1">Selesai</span>';
                } else {
                    $status = '<span class="label label-lg label-danger label-inline m-1">Belum</span>';
                }


                return $status;

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
            ->addColumn('action', function ($model) use ($tahun,$keyword) {
                // if ($tahun == date('Y')) {

                    $disabled2 = !cekJadwal('Kegiatan', 'Sub Kegiatan DPA Pokok') ? 'disabled' : '';
                    if ($disabled2 == '') {
                        $route_action = '';
                        if ($keyword == 'PEN') {
                            $route_action = route('kegiatan.dak_pen.perencanaan', $model->uuid);
                        }else if($keyword == 'APBN'){
                            $route_action = route('kegiatan.dak_apbn.perencanaan', $model->uuid);
                        }else if($keyword == 'APBD I'){
                            $route_action = route('kegiatan.dak_apbd1.perencanaan', $model->uuid);
                        }else{
                            $route_action = route('kegiatan.dak_apbd2.perencanaan', $model->uuid);
                        }

                        $btn_text = 'Perencanaan';
                        $url = cekJadwal('Kegiatan', 'Sub Kegiatan DPA Pokok') ? $route_action . '?uuid_sd=' . $model->uuid_sd : '#';
                        $disabled = !cekJadwal('Kegiatan', 'Sub Kegiatan DPA Pokok') ? 'disabled' : '';
                        $additional = '';
                        return '<a href="' . $url . '" class="btn btn-sm btn-primary font-weight-bolder ' . $disabled . '">
                                                <span class="svg-icon svg-icon-sm">
                                                    <svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M0 0.5V13.5H10V3.79688L9.85938 3.64062L6.85938 0.640625L6.70312 0.5H0ZM1 1.5H6V4.5H9V12.5H1V1.5ZM7 2.21875L8.28125 3.5H7V2.21875ZM2.5 5.5V6.5H7.5V5.5H2.5ZM2.5 7.5V8.5H7.5V7.5H2.5ZM2.5 9.5V10.5H7.5V9.5H2.5Z" fill="white"/>
                                                    </svg>
                                                </span>' . $btn_text . '
                                            </a>' . $additional;
                    } else {
                        $btn_text = '';
                        $url = '';
                        $disabled = '';
                        $additional = ' <a href="#" class="btn btn-sm btn-danger font-weight-bolder mt-1">
                                        <span class="flaticon-lock"></span>
                                    </a>';
                        return $additional;
                    }


                // }
                // return '';
            })
            ->rawColumns(['grouping', 'action', 'tolak_ukur', 'target', 'status_input'])
            ->make(true);
    }

    public function dataTableRealisasi()
    {
        $tahun = request('tahun', date('Y'));
        $id_unit_kerja = auth()->user()->id_unit_kerja;
        $data2 = Dpa::query()
            ->with('TolakUkur')
            ->join('sumber_dana_dpa', 'sumber_dana_dpa.id_dpa', '=', 'dpa.id')
            ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
            ->join('kegiatan', 'dpa.id_kegiatan', '=', 'kegiatan.id')
            ->join('program', 'dpa.id_program', '=', 'program.id')
            ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
            ->select('dpa.*',
                'sub_kegiatan.kode_sub_kegiatan',
                'sub_kegiatan.nama_sub_kegiatan',
                'kegiatan.kode_kegiatan',
                'kegiatan.nama_kegiatan',
                'program.kode_program',
                'program.nama_program',
                'bidang_urusan.kode_bidang_urusan',
                'bidang_urusan.nama_bidang_urusan',
                'urusan.kode_urusan',
                'urusan.nama_urusan',
                'sumber_dana_dpa.sumber_dana',
                'sumber_dana_dpa.jenis_belanja',
                'sumber_dana_dpa.uuid as uuid_sd', 'sumber_dana_dpa.nilai_pagu as nilai_pagu_dak')
            ->orderBy('urusan.kode_urusan', 'asc')
            ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc')
            ->orderBy('program.kode_program', 'asc')
            ->orderBy('kegiatan.kode_kegiatan', 'asc')
            ->orderBy('sub_kegiatan.kode_sub_kegiatan', 'asc')
            ->where('sumber_dana_dpa.sumber_dana', 'LIKE', '%DAK NON-FISIK')
            ->where('dpa.tahun', $tahun)
            ->where('dpa.id_unit_kerja', $id_unit_kerja);


        $data = Dpa::query()
            ->with('TolakUkur')
            ->join('sumber_dana_dpa', 'sumber_dana_dpa.id_dpa', '=', 'dpa.id')
            ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
            ->join('kegiatan', 'dpa.id_kegiatan', '=', 'kegiatan.id')
            ->join('program', 'dpa.id_program', '=', 'program.id')
            ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
            ->select('dpa.*',
                'sub_kegiatan.kode_sub_kegiatan',
                'sub_kegiatan.nama_sub_kegiatan',
                'kegiatan.kode_kegiatan',
                'kegiatan.nama_kegiatan',
                'program.kode_program',
                'program.nama_program',
                'bidang_urusan.kode_bidang_urusan',
                'bidang_urusan.nama_bidang_urusan',
                'urusan.kode_urusan',
                'urusan.nama_urusan',
                'sumber_dana_dpa.sumber_dana',
                'sumber_dana_dpa.jenis_belanja',
                'sumber_dana_dpa.uuid as uuid_sd')
            ->orderBy('urusan.kode_urusan', 'asc')
            ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc')
            ->orderBy('program.kode_program', 'asc')
            ->orderBy('kegiatan.kode_kegiatan', 'asc')
            ->orderBy('sub_kegiatan.kode_sub_kegiatan', 'asc')
            ->where('dpa.tahun', $tahun)
            ->where('sumber_dana_dpa.sumber_dana', 'DAK FISIK')
            ->where('dpa.id_unit_kerja', $id_unit_kerja);


        return DataTables::of($data2)
            ->filter(function ($q) {
                if (request()->has('search')) {
                    if (request('search')['value']) {
                        $q->where(function ($q) {
                            $q->where('kode_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nama_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nilai_pagu_dpa', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhereHas('TolakUkur', function ($q) {
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
            ->addColumn('sumber_dana', function ($model) {
                return $model->sumber_dana.' - '.$model->jenis_belanja;
            })
            ->editColumn('nilai_pagu_dpa', function ($model) {
                return 'Rp ' . number_format($model->nilai_pagu_dak, 2, ',', '.');
            })
            ->editColumn('kode_sub_kegiatan', function ($model) {
                if ($model->is_non_urusan) {
                    $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                    return $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . substr($model->kode_sub_kegiatan, 4);
                }
                return $model->kode_sub_kegiatan;
            })
            ->editColumn('status_input', function ($model) {
                $anggaran = $model->PaketDak()->sum('anggaran_dak');
                $pendampingan = $model->PaketDak()->sum('pendampingan');
                $target = $anggaran + $pendampingan;
                if ($model->nilai_pagu_dak <= $target) {
                    $status = '<span class="label label-lg label-success label-inline m-1">Selesai</span>';
                } else {
                    $status = '<span class="label label-lg label-danger label-inline m-1">Belum</span>';
                }
                return $status;
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

                    $btn_text = 'Realisasi';
                    $url = route('atur.realisasi-dak-non-fisik', $model->uuid) . '?uuid_sd=' . $model->uuid_sd;
                    $disabled = '';
                    $additional = '';

                    $additional = '';

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
            ->rawColumns(['grouping', 'action', 'tolak_ukur', 'target', 'status_input'])
            ->make(true);
    }

    public function dataTableRealisasiPen($tahun,$keyword)
    {

        // $tahun = request('tahun', date('Y'));
        $tahun = date('Y');
        $id_unit_kerja = auth()->user()->id_unit_kerja;
        $data2 = Dpa::query()
            ->with('TolakUkur')
            ->join('sumber_dana_dpa', 'sumber_dana_dpa.id_dpa', '=', 'dpa.id')
            ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
            ->join('kegiatan', 'dpa.id_kegiatan', '=', 'kegiatan.id')
            ->join('program', 'dpa.id_program', '=', 'program.id')
            ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
            ->select('dpa.*',
                'sub_kegiatan.kode_sub_kegiatan',
                'sub_kegiatan.nama_sub_kegiatan',
                'kegiatan.kode_kegiatan',
                'kegiatan.nama_kegiatan',
                'program.kode_program',
                'program.nama_program',
                'bidang_urusan.kode_bidang_urusan',
                'bidang_urusan.nama_bidang_urusan',
                'urusan.kode_urusan',
                'urusan.nama_urusan',
                'sumber_dana_dpa.sumber_dana',
                'sumber_dana_dpa.jenis_belanja',
                'sumber_dana_dpa.uuid as uuid_sd', 'sumber_dana_dpa.nilai_pagu as nilai_pagu_dak')
            ->orderBy('urusan.kode_urusan', 'asc')
            ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc')
            ->orderBy('program.kode_program', 'asc')
            ->orderBy('kegiatan.kode_kegiatan', 'asc')
            ->orderBy('sub_kegiatan.kode_sub_kegiatan', 'asc')
            ->where('sumber_dana_dpa.sumber_dana', 'LIKE', '%'.$keyword)
            ->where('sumber_dana_dpa.jenis_belanja','Belanja Modal')
            ->where('dpa.tahun', $tahun)
            ->where('dpa.id_unit_kerja', $id_unit_kerja);


        $data = Dpa::query()
            ->with('TolakUkur')
            ->join('sumber_dana_dpa', 'sumber_dana_dpa.id_dpa', '=', 'dpa.id')
            ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
            ->join('kegiatan', 'dpa.id_kegiatan', '=', 'kegiatan.id')
            ->join('program', 'dpa.id_program', '=', 'program.id')
            ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
            ->select('dpa.*',
                'sub_kegiatan.kode_sub_kegiatan',
                'sub_kegiatan.nama_sub_kegiatan',
                'kegiatan.kode_kegiatan',
                'kegiatan.nama_kegiatan',
                'program.kode_program',
                'program.nama_program',
                'bidang_urusan.kode_bidang_urusan',
                'bidang_urusan.nama_bidang_urusan',
                'urusan.kode_urusan',
                'urusan.nama_urusan',
                'sumber_dana_dpa.sumber_dana',
                'sumber_dana_dpa.jenis_belanja',
                'sumber_dana_dpa.uuid as uuid_sd')
            ->orderBy('urusan.kode_urusan', 'asc')
            ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc')
            ->orderBy('program.kode_program', 'asc')
            ->orderBy('kegiatan.kode_kegiatan', 'asc')
            ->orderBy('sub_kegiatan.kode_sub_kegiatan', 'asc')
            ->where('dpa.tahun', $tahun)
            ->where('sumber_dana_dpa.sumber_dana', 'DAK FISIK')
            ->where('dpa.id_unit_kerja', $id_unit_kerja);


        return DataTables::of($data2)
            ->filter(function ($q) {
                if (request()->has('search')) {
                    if (request('search')['value']) {
                        $q->where(function ($q) {
                            $q->where('kode_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nama_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhere('nilai_pagu_dpa', 'like', '%' . request('search')['value'] . '%');
                            $q->orWhereHas('TolakUkur', function ($q) {
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
            ->addColumn('sumber_dana', function ($model) {
                return $model->sumber_dana.' - '.$model->jenis_belanja;
            })
            ->editColumn('nilai_pagu_dpa', function ($model) {
                return 'Rp ' . number_format($model->nilai_pagu_dak, 2, ',', '.');
            })
            ->editColumn('kode_sub_kegiatan', function ($model) {
                if ($model->is_non_urusan) {
                    $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
                    return $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . substr($model->kode_sub_kegiatan, 4);
                }
                return $model->kode_sub_kegiatan;
            })
            ->editColumn('status_input', function ($model) {
                $anggaran = $model->PaketDak()->sum('anggaran_dak');
                $pendampingan = $model->PaketDak()->sum('pendampingan');
                $target = $anggaran + $pendampingan;
                if ($model->nilai_pagu_dak <= $target) {
                    $status = '<span class="label label-lg label-success label-inline m-1">Selesai</span>';
                } else {
                    $status = '<span class="label label-lg label-danger label-inline m-1">Belum</span>';
                }
                return $status;
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
            ->addColumn('action', function ($model) use ($tahun,$keyword) {
                // if ($tahun == date('Y')) {

                    $btn_text = 'Realisasi';

                    $route_action = '';
                    if ($keyword == 'PEN') {
                        $route_action = route('atur.realisasi-dak-pen', $model->uuid);
                    }else if($keyword == 'APBN'){
                        $route_action = route('atur.realisasi-dak-apbn', $model->uuid);
                    }else if($keyword == 'APBD I'){
                        $route_action = route('atur.realisasi-dak-apbd1', $model->uuid);
                    }else{
                        $route_action = route('atur.realisasi-dak-apbd2', $model->uuid);
                    }

                    $url = $route_action . '?uuid_sd=' . $model->uuid_sd;
                    $disabled = '';
                    $additional = '';

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
            ->rawColumns(['grouping', 'action', 'tolak_ukur', 'target', 'status_input'])
            ->make(true);
    }

}
