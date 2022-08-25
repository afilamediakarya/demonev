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
use App\Services\DakServices;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DakController extends ApiController
{
    public function __construct(DakServices $services)
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
            ->where('sumber_dana_dpa.sumber_dana', 'LIKE', '%DAK FISIK%')
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
                        $url = cekJadwal('Kegiatan', 'Sub Kegiatan DPA Pokok') ? route('kegiatan.dak.perencanaan', $model->uuid) . '?uuid_sd=' . $model->uuid_sd : '#';
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
            ->where('sumber_dana_dpa.sumber_dana', 'LIKE', '%DAK FISIK')
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
                    $url = route('atur.realisasi-dak', $model->uuid) . '?uuid_sd=' . $model->uuid_sd;
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


    public function dataTableRealisasi2()
    {
        $tahun = request('tahun', date('Y'));
        $id_unit_kerja = auth()->user()->id_unit_kerja;
        $data2 = SumberDanaDpa::query()
            ->join('paket_dak', 'paket_dak.id_sumber_dana_dpa', '=', 'sumber_dana_dpa.id')
            ->join('dpa', 'sumber_dana_dpa.id_dpa', '=', 'dpa.id')
            ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
            ->join('kegiatan', 'dpa.id_kegiatan', '=', 'kegiatan.id')
            ->join('program', 'dpa.id_program', '=', 'program.id')
            ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
            ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
            ->select('dpa.*', 'paket_dak.nama_paket',
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
                'paket_dak.uuid as uuid_sd')
            ->orderBy('urusan.kode_urusan', 'asc')
            ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc')
            ->orderBy('program.kode_program', 'asc')
            ->orderBy('kegiatan.kode_kegiatan', 'asc')
            ->orderBy('sub_kegiatan.kode_sub_kegiatan', 'asc')
            ->where('sumber_dana_dpa.sumber_dana', 'LIKE', 'DAK%')
            ->where('dpa.tahun', $tahun)
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
            ->editColumn('nilai_pagu_dpa', function ($model) {
                return 'Rp ' . number_format($model->nilai_pagu_dpa, 2, ',', '.');
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
                    $btn_text = 'Realisasi';
                    $url = route('atur.realisasi-dak', $model->uuid) . '?uuid_sd=' . $model->uuid_sd;
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
            ->rawColumns(['grouping', 'action', 'tolak_ukur', 'target'])
            ->make(true);
    }
    // public function dataTableRealisasi()
    // {
    //     $tahun = request('tahun', date('Y'));
    //     $id_unit_kerja = auth()->user()->id_unit_kerja;
    //     $data2 = PaketDak::query()
    //             ->join('sumber_dana_dpa', 'sumber_dana_dpa.id', '=', 'paket_dak.id_sumber_dana_dpa')
    //             ->join('dpa', 'sumber_dana_dpa.id_dpa', '=', 'dpa.id')
    //             ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
    //             ->join('kegiatan', 'dpa.id_kegiatan', '=', 'kegiatan.id')
    //             ->join('program', 'dpa.id_program', '=', 'program.id')
    //             ->join('bidang_urusan', 'program.id_bidang_urusan', '=', 'bidang_urusan.id')
    //             ->join('urusan', 'bidang_urusan.id_urusan', '=', 'urusan.id')
    //             ->select('dpa.*','paket_dak.nama_paket',
    //                 'sub_kegiatan.kode_sub_kegiatan',
    //                 'sub_kegiatan.nama_sub_kegiatan',
    //                 'kegiatan.kode_kegiatan',
    //                 'kegiatan.nama_kegiatan',
    //                 'program.kode_program',
    //                 'program.nama_program',
    //                 'bidang_urusan.kode_bidang_urusan',
    //                 'bidang_urusan.nama_bidang_urusan',
    //                 'urusan.kode_urusan',
    //                 'urusan.nama_urusan',
    //                 'sumber_dana_dpa.sumber_dana',
    //                 'paket_dak.uuid as uuid_sd')
    //             ->orderBy('urusan.kode_urusan', 'asc')
    //             ->orderBy('bidang_urusan.kode_bidang_urusan', 'asc')
    //             ->orderBy('program.kode_program', 'asc')
    //             ->orderBy('kegiatan.kode_kegiatan', 'asc')
    //             ->orderBy('sub_kegiatan.kode_sub_kegiatan', 'asc')
    //             ->where('sumber_dana_dpa.sumber_dana', 'LIKE', 'DAK%')
    //             ->where('dpa.tahun', $tahun)
    //             ->where('dpa.id_unit_kerja', $id_unit_kerja);


    //         return DataTables::of($data2)
    //         ->filter(function ($q){
    //             if (request()->has('search')) {
    //                 if (request('search')['value']) {
    //                     $q->where(function ($q){
    //                         $q->where('kode_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
    //                         $q->orWhere('nama_sub_kegiatan', 'like', '%' . request('search')['value'] . '%');
    //                         $q->orWhere('nilai_pagu_dpa', 'like', '%' . request('search')['value'] . '%');
    //                         $q->orWhereHas('TolakUkur',function ($q){
    //                             $q->where('tolak_ukur', 'like', '%' . request('search')['value'] . '%');
    //                             $q->orWhere('volume', 'like', '%' . request('search')['value'] . '%');
    //                             $q->orWhere('satuan', 'like', '%' . request('search')['value'] . '%');
    //                         });
    //                     });
    //                 }
    //             }
    //         })
    //         ->editColumn('nilai_pagu_dpa', function ($model) {
    //             return 'Rp ' . number_format($model->nilai_pagu_dpa, 2, ',', '.');
    //         })
    //         ->editColumn('kode_sub_kegiatan', function ($model) {
    //             if ($model->is_non_urusan) {
    //                 $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
    //                 return $bidang_urusan->Urusan->kode_urusan . '.' . $bidang_urusan->kode_bidang_urusan . substr($model->kode_sub_kegiatan, 4);
    //             }
    //             return $model->kode_sub_kegiatan;
    //         })
    //         ->addColumn('grouping', function ($model) {
    //             if ($model->is_non_urusan) {
    //                 $bidang_urusan = optional(optional(auth()->user())->UnitKerja)->BidangUrusan()->with('Urusan')->first();
    //                 if ($bidang_urusan) {
    //                     $model->kode_urusan = $bidang_urusan->Urusan->kode_urusan;
    //                     $model->nama_urusan = $bidang_urusan->Urusan->nama_urusan;
    //                     $model->kode_bidang_urusan = $bidang_urusan->kode_bidang_urusan;
    //                     $model->nama_bidang_urusan = $bidang_urusan->nama_bidang_urusan;
    //                 }
    //             }
    //             return '<span class="label label-lg label-warning label-inline m-1">' . $model->kode_urusan . ' - ' . $model->nama_urusan . '</span>
    //             <span class="label label-lg label-info label-inline m-1">' . $model->kode_bidang_urusan . ' - ' . $model->nama_bidang_urusan . '</span>
    //             <span class="label label-lg label-success label-inline m-1">' . $model->kode_program . ' - ' . $model->nama_program . '</span>
    //             <span class="label label-lg label-primary label-inline m-1">' . $model->kode_kegiatan . ' - ' . $model->nama_kegiatan . '</span>';
    //         })
    //         ->addColumn('action', function ($model) use ($tahun) {
    //             if ($tahun == date('Y')) {
    //                 $btn_text = 'Realisasi';
    //                 $url = route('atur.realisasi-dak', $model->uuid).'?uuid_sd='.$model->uuid_sd;
    //                 $disabled = '';
    //                 $additional = '';

    //                 return '<a href="' . $url . '" class="btn btn-sm btn-primary font-weight-bolder ' . $disabled . '">
    //                                             <span class="svg-icon svg-icon-sm">
    //                                                 <svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">
    //                                                     <path d="M0 0.5V13.5H10V3.79688L9.85938 3.64062L6.85938 0.640625L6.70312 0.5H0ZM1 1.5H6V4.5H9V12.5H1V1.5ZM7 2.21875L8.28125 3.5H7V2.21875ZM2.5 5.5V6.5H7.5V5.5H2.5ZM2.5 7.5V8.5H7.5V7.5H2.5ZM2.5 9.5V10.5H7.5V9.5H2.5Z" fill="white"/>
    //                                                 </svg>
    //                                             </span>' . $btn_text . '
    //                                         </a>' . $additional;

    //             }
    //             return '';
    //         })
    //         ->rawColumns(['grouping', 'action', 'tolak_ukur', 'target'])
    //         ->make(true);
    // }


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
      
        $tahun_anggaran = $request->tahun_anggaran;
        $keuangan = $request->input('realisasi_keuangan_periode', []);
        $fisik = $request->input('realisasi_fisik', []);
        $sumber_dana = SumberDanaDpa::select('id_dpa', 'id')->where('uuid', $uuid)->first();
        $paket_daks = PaketDak::select('id', 'id_sumber_dana_dpa','kecamatan','desa')->where('id_sumber_dana_dpa', $sumber_dana->id)->get();
        
        foreach ($keuangan as $index => $value) {
            foreach ($paket_daks as $paket_dak) {
                $id_sumber_dana_dpa = $sumber_dana->id;
                $paket_dak->update([
                    
                    'kontrak' => $request->kontrak[$index][$paket_dak->id],
                    'volume_kontrak' => $request->volume_kontrak[$index][$paket_dak->id],
                    'swakelola' => $request->swakelola[$index][$paket_dak->id],
                    'volume_swakelola' => $request->volume_swakelola[$index][$paket_dak->id],
                    'metode_pembayaran' => $request->metode_pembayaran[$index][$paket_dak->id],
                    'permasalahan' => $request->permasalahan_[$index][$paket_dak->id]
                ]);
                RealisasiDak::whereRaw("periode='$index' AND id_paket_dak='$paket_dak->id' AND tahun='$tahun_anggaran'")->update([
                    'realisasi_keuangan' => $request->realisasi_keuangan[$index][$paket_dak->id],
                    'realisasi_fisik' => $request->realisasi_fisik[$index][$paket_dak->id],
                    'realisasi_kinerja' => $request->realisasi_kinerja[$index][$paket_dak->id],
                    'total_keuangan' => $request->tot_res[$paket_dak->id],
                    'total_fisik' => $request->tot_fis[$paket_dak->id],
                    'total_kinerja' => $request->tot_kin[$paket_dak->id],
                    'permasalahan' => $request->permasalahan[$index],
                    'user_update' => auth()->user()->id
                ]);
                //For Detail Realisasi -> id_dpa, tahun, periode, id_sumber_dana_dpa :: update->realisasi_keuangan, realsasi_fisik
                DetailRealisasi::whereRaw("periode='$index' AND id_dpa='$sumber_dana->id_dpa' AND tahun='$tahun_anggaran' AND id_sumber_dana_dpa='$id_sumber_dana_dpa'")->update([
                    'realisasi_keuangan' => $request->realisasi_keuangan_periode[$index],
                    'realisasi_fisik' => $request->realisasi_fisik_periode[$index],
                    'realisasi_kinerja' => $request->realisasi_kinerja_periode[$index],
                    'user_update' => auth()->user()->id
                ]);

                //For Realisasi -> id_dpa, tahun, periode :: update->realisasi_keuangan, realsasi_fisik
                $realisasi_detail = DetailRealisasi::whereRaw("periode='$index' AND id_dpa='$sumber_dana->id_dpa' AND tahun='$tahun_anggaran'");
                $count = $realisasi_detail->count();
                $real_keu = ($realisasi_detail->sum('realisasi_keuangan'));
                $real_fis = ($realisasi_detail->sum('realisasi_fisik')) / $count;

                Realisasi::whereRaw("periode='$index' AND id_dpa='$sumber_dana->id_dpa' AND tahun='$tahun_anggaran'")->update([
                    'realisasi_keuangan' => $real_keu,
                    'realisasi_fisik' => $real_fis,
                    'user_update' => auth()->user()->id
                ]);

            }


        }


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
        // return $request;
        return parent::create($request);
    }

    public function updateTolakUkur(Request $request, $uuid)
    {
        $validate = $this->services->validateUpdateTolakUkur($request->all());
        if ($validate->fails()) {
            return Response::validationError($validate->errors());
        }
        return Response::json($this->services->updateTolakUkur($validate->validated(), $uuid));
    }

}
