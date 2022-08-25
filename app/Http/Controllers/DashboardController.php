<?php

namespace App\Http\Controllers;

use App\Models\Dpa;
use App\Models\Jadwal;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\SubKegiatan;
use App\Models\SumberDana;
use App\Models\SumberDanaDpa;
use App\Models\ProfileDaerah;
use App\Models\UnitKerja;
use App\Models\UnitKerjaPagu;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = new \stdClass();
        $tahun = session('tahun_penganggaran');
        $id_unit_kerja = $id_dpa_opd = null;
        if (hasRole('admin')) {
            // $unit_kerja = UnitKerja::with('Dpa.Realisasi')->get();
            $unit_kerja = UnitKerja::with(['Dpa' => function ($q) use ($tahun) {
                $q->where('tahun', $tahun);
            }])->get();
            $data->progress_opd = $unit_kerja->map(function ($value) use ($tahun) {
                $total_saat_ini = $value->Dpa->reduce(function ($total, $value) {
                    return $total + $value->nilai_pagu_dpa;
                });

                $selisih = $value->max_pagu - $total_saat_ini;
                $status = 'Proses';
                $status_color = 'btn-warning';
                if ($value->max_pagu > $total_saat_ini) {
                    $status = 'Proses';
                    $status_color = 'btn-warning';
                } else if ($value->max_pagu < $total_saat_ini) {
                    $status = 'Lebih';
                    $status_color = 'btn-danger';
                } else if ($value->max_pagu == $total_saat_ini) {
                    $status = 'Selesai DPA';
                    $status_color = 'btn-success';
                }
                return [
                    'nama_opd' => $value->nama_unit_kerja,
                    'jumlah_sub_kegiatan' => $value->Dpa->where('tahun', $tahun)->count(),
                    'jumlah_kegiatan' => $value->Dpa->where('tahun', $tahun)->groupBy('id_kegiatan')->count('id_kegiatan'),
                    'jumlah_program' => $value->Dpa->where('tahun', $tahun)->groupBy('id_program')->count('id_program'),
                    'max_pagu' => numberToCurrency($value->max_pagu),
                    'total_saat_ini' => numberToCurrency($total_saat_ini),
                    'selisih' => numberToCurrency($selisih),
                    'realisasi_keuangan' => numberToCurrency($value->Dpa->where('tahun', $tahun)->reduce(function ($total, $value) {
                        return $total + $value->Realisasi->reduce(function ($total, $value) {
                                return $total + $value->realisasi_keuangan;
                            });
                    })),
                    'realisasi_fisik' => numberToCurrency($value->Dpa->where('tahun', $tahun)->count() ? $value->Dpa->where('tahun', $tahun)->reduce(function ($total, $value) {
                            return $total + $value->Realisasi->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                });
                        }) / $value->Dpa->where('tahun', $tahun)->count() : 0),
                    'status' => $status,
                    'status_color' => $status_color
                ];
            });
            $data->jumlah_kegiatan = $data->progress_opd->reduce(function ($total, $value) {
                return $total + $value['jumlah_kegiatan'];
            });
            $data->jumlah_sub_kegiatan = $data->progress_opd->reduce(function ($total, $value) {
                return $total + $value['jumlah_sub_kegiatan'];
            });
            $data->jumlah_program = $data->progress_opd->reduce(function ($total, $value) {
                return $total + $value['jumlah_program'];
            });
        } else if (hasRole('opd')) {
            $id_unit_kerja = auth()->user()->id_unit_kerja;
            $id_dpa_opd = Dpa::where('tahun', $tahun)->where('id_unit_kerja', $id_unit_kerja)->pluck('id')->toArray();
            $data->jumlah_kegiatan = Kegiatan::where(function ($q) use ($tahun, $id_unit_kerja) {
                $q->whereHas('Dpa', function ($q) use ($tahun, $id_unit_kerja) {
                    $q->where('tahun', $tahun);
                    if ($id_unit_kerja)
                        $q->where('id_unit_kerja', $id_unit_kerja);
                });
            })->count();
            $data->jumlah_sub_kegiatan = SubKegiatan::where(function ($q) use ($tahun, $id_unit_kerja) {
                $q->whereHas('Dpa', function ($q) use ($tahun, $id_unit_kerja) {
                    $q->where('tahun', $tahun);
                    if ($id_unit_kerja)
                        $q->where('id_unit_kerja', $id_unit_kerja);
                });
            })->count();
            $data->jumlah_program = Program::where(function ($q) use ($tahun, $id_unit_kerja) {
                $q->whereHas('Dpa', function ($q) use ($tahun, $id_unit_kerja) {
                    $q->where('tahun', $tahun);
                    if ($id_unit_kerja)
                        $q->where('id_unit_kerja', $id_unit_kerja);
                });
            })->count();
        }
        $data->jumlah_opd = UnitKerja::count();
        $data->sumber_dana = SumberDana::pluck('nama_sumber_dana');
        // $data->max_pagu = UnitKerja::where(function ($q) use ($id_unit_kerja) {
        //     if ($id_unit_kerja)
        //         $q->where('id', $id_unit_kerja);
        // })->sum('max_pagu');

        $where_max_pagu="";
        if(!empty($id_unit_kerja)){
            $where_max_pagu.=" AND id_unit_kerja='$id_unit_kerja' ";
        }

        $data->max_pagu = UnitKerjaPagu::whereRaw("tahun='$tahun' $where_max_pagu")->sum('max_pagu_tahun');

        // $data->max_pagu = UnitKerjaPagu::where('tahun', $tahun);
        // if(!empty($id_unit_kerja)){
        //     $data->max_pagu->where('id_unit_kerja', $id_unit_kerja);
        // }
        // $data->max_pagu->sum('max_pagu_tahun');
        $data_unit_kerja = UnitKerja::with(['Dpa' => function ($q) use ($tahun) {
            $q->where('tahun', $tahun);
            $q->with(['SumberDanaDpa' => function ($q) use ($tahun) {
                $q->where('tahun', $tahun);
                $q->with(['DetailRealisasi']);
            }, 'TolakUkur', 'PegawaiPenanggungJawab']);
            $q->whereHas('SumberDanaDpa');
        }])->when($id_unit_kerja, function ($q) use ($id_unit_kerja) {
            $q->where('id', $id_unit_kerja);
        })->get();
        $data_unit_kerja = $data_unit_kerja->map(function ($value) {
            $value->Dpa = $value->Dpa->map(function ($value) {
                $value->nilai_pagu_dpa = $value->SumberDanaDpa->reduce(function ($total, $value) {
                    return $total + $value->nilai_pagu;
                });
                $value->realisasi_keuangan = $value->SumberDanaDpa->reduce(function ($total, $value) {
                    return $total + $value->DetailRealisasi->reduce(function ($total, $value) {
                            return $total + $value->realisasi_keuangan;
                        });
                });
                $value->jumlah_realisasi = $value->SumberDanaDpa->count();
                $value->jumlah_tolak_ukur = $value->TolakUkur->count();
                try {
                    $value->realisasi_fisik = $value->SumberDanaDpa->reduce(function ($total, $value) {
                            return $total + $value->DetailRealisasi->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                });
                        }) / $value->jumlah_realisasi;
                } catch (\Exception $exception) {
                    $value->realisasi_fisik = 0;
                }
                return $value;
            });
            $value->total_pagu = $value->Dpa->reduce(function ($total, $value) {
                return $total + $value->nilai_pagu_dpa;
            });
            $value->realisasi_keuangan = $value->Dpa->reduce(function ($total, $value) {
                return $total + $value->realisasi_keuangan;
            });
            $value->jumlah_tolak_ukur = $value->Dpa->reduce(function ($total, $value) {
                return $total + $value->jumlah_tolak_ukur;
            });
            try {
                $value->realisasi_fisik = $value->Dpa->reduce(function ($total, $value) {
                        return $total + $value->realisasi_fisik;
                    }) / $value->Dpa->count();
            } catch (\Exception $exception) {
                $value->realisasi_fisik = 0;
            }
            return $value;
        });
        $data->realisasi_keuangan = $data_unit_kerja->reduce(function ($total, $value) {
            return $total + $value->realisasi_keuangan;
        });
        $jumlah_kegiatan = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $data->total_saat_ini = Dpa::where('tahun', $tahun)->where(function ($q) use ($id_unit_kerja) {
            if ($id_unit_kerja)
                $q->where('id_unit_kerja', $id_unit_kerja);
        })->sum('nilai_pagu_dpa');
        foreach ($data_unit_kerja AS $row){
            $jumlah_kegiatan_dpa = 0;
            $dpa_keuangan = 0;
            $dpa_fisik = 0;
            $jumlah_kegiatan++;
            foreach ($row->Dpa AS $dpa){
                $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
                $dpa_keuangan += $persentase_keuangan;
                //$dpa_fisik += $dpa->realisasi_fisik;
                $jumlah_kegiatan_dpa++;
                
                $dpa_fisik += $data->total_saat_ini? $dpa->realisasi_fisik * ($dpa->nilai_pagu_dpa / $data->total_saat_ini * 100) / 100 : 0;
            }
            $dpa_total_fisik = $jumlah_kegiatan_dpa ? $dpa_fisik : 0;
            $dpa_total_keuangan = $jumlah_kegiatan_dpa ? $dpa_keuangan/$jumlah_kegiatan_dpa : 0;
            $total_keuangan += $dpa_total_keuangan;
            $total_fisik += $dpa_total_fisik;
        }
        
        $data->persentase_realisasi_keuangan = pembulatanDuaDecimal($data->total_saat_ini ? $data->realisasi_keuangan/$data->total_saat_ini * 100: 0);
        $data->realisasi_fisik = pembulatanDuaDecimal($jumlah_kegiatan_dpa ? $total_fisik : 0);
        
        $data->selisih = $data->max_pagu - $data->total_saat_ini;

        $data->sumber_dana_terpakai = SumberDanaDpa::where('tahun', $tahun)->where(function ($q) use ($id_unit_kerja, $id_dpa_opd) {
            if ($id_unit_kerja)
                $q->whereIn('id_dpa', $id_dpa_opd);
        })->select(DB::raw('count(sumber_dana) AS jumlah'), 'sumber_dana')->groupBy('sumber_dana')->get();
        $data->data_sumber_dana = [];
        foreach ($data->sumber_dana as $sumber_dana) {
            $jumlah = optional($data->sumber_dana_terpakai->where('sumber_dana', $sumber_dana)->first())->jumlah;
            $data->data_sumber_dana[] = [
                'sector' => $sumber_dana,
                'size' => $jumlah ?? 0
            ];
        }
        $j_kegiatan = Jadwal::whereRaw("tahapan='Kegiatan' AND tahun='$tahun'")->first();
        if (!$j_kegiatan) {
            $jadwal_kegiatan = '<span class="label label-lg label-danger label-inline m-1">Belum diset</span>';
        } else {
            $jadwal_kegiatan = tglIndo(date('d/m/Y', strtotime($j_kegiatan->jadwal_mulai))) . '<br> s/d <br>' . tglIndo(date('d/m/Y', strtotime($j_kegiatan->jadwal_selesai)));
        }

        $j_target = Jadwal::whereRaw("tahapan='Target' AND tahun='$tahun'")->first();
        if (!$j_target) {
            $jadwal_target = '<span class="label label-lg label-danger label-inline m-1">Belum diset</span>';
        } else {
            $jadwal_target = tglIndo(date('d/m/Y', strtotime($j_target->jadwal_mulai))) . '<br> s/d <br>' . tglIndo(date('d/m/Y', strtotime($j_target->jadwal_selesai)));
        }
        $j_rkpd = Jadwal::whereRaw("tahapan='RKPD' AND tahun='$tahun'")->first();
        if (!$j_rkpd) {
            $jadwal_rkpd = '<span class="label label-lg label-danger label-inline m-1">Belum diset</span>';
        } else {
            $jadwal_rkpd = tglIndo(date('d/m/Y', strtotime($j_rkpd->jadwal_mulai))) . '<br> s/d <br>' . tglIndo(date('d/m/Y', strtotime($j_rkpd->jadwal_selesai)));
        }
        $j_rpjmd = Jadwal::whereRaw("tahapan='RPJMD' AND tahun='$tahun'")->first();
        if (!$j_rpjmd) {
            $jadwal_rpjmd = '<span class="label label-lg label-danger label-inline m-1">Belum diset</span>';
        } else {
            $jadwal_rpjmd = tglIndo(date('d/m/Y', strtotime($j_rpjmd->jadwal_mulai))) . '<br> s/d <br>' . tglIndo(date('d/m/Y', strtotime($j_rpjmd->jadwal_selesai)));
        }
        $j_realisasi = Jadwal::whereRaw("tahapan='Realisasi' AND tahun='$tahun' AND (DATE(jadwal_mulai) <= CURDATE() AND DATE(jadwal_selesai) >= CURDATE())")->first();
        if (!$j_realisasi) {
            $jadwal_realisasi = '<span class="label label-lg label-danger label-inline m-1">Belum diset</span>';
        } else {
            $jadwal_realisasi = tglIndo(date('d/m/Y', strtotime($j_realisasi->jadwal_mulai))) . '<br> s/d <br>' . tglIndo(date('d/m/Y', strtotime($j_realisasi->jadwal_selesai)));
        }
        $data->jadwal_kegiatan = $jadwal_kegiatan;
        $data->jadwal_target = $jadwal_target;
        $data->jadwal_realisasi = $jadwal_realisasi;
        $data->jadwal_rkpd = $jadwal_rkpd;
        $data->jadwal_rpjmd = $jadwal_rpjmd;
        return view('dashboard', compact('data'));
    }

    public function export($tipe)
    {
        $data = new \stdClass();
        $tahun = session('tahun_penganggaran');
        $id_unit_kerja = $id_dpa_opd = null;
        if (hasRole('admin')) {
            // $unit_kerja = UnitKerja::with('Dpa.Realisasi')->get();
            $unit_kerja = UnitKerja::with(['Dpa' => function ($q) use ($tahun) {
                $q->where('tahun', $tahun);
            }])->get();
            $data->progress_opd = $unit_kerja->map(function ($value) use ($tahun) {
                $total_saat_ini = $value->Dpa->reduce(function ($total, $value) {
                    return $total + $value->nilai_pagu_dpa;
                });

                $selisih = $value->max_pagu - $total_saat_ini;
                $status = 'Proses';
                $status_color = 'btn-warning';
                if ($value->max_pagu > $total_saat_ini) {
                    $status = 'Proses';
                    $status_color = 'btn-warning';
                } else if ($value->max_pagu < $total_saat_ini) {
                    $status = 'Lebih';
                    $status_color = 'btn-danger';
                } else if ($value->max_pagu == $total_saat_ini) {
                    $status = 'Selesai DPA';
                    $status_color = 'btn-success';
                }
                return [
                    'nama_opd' => $value->nama_unit_kerja,
                    'jumlah_sub_kegiatan' => $value->Dpa->where('tahun', $tahun)->count(),
                    'jumlah_kegiatan' => $value->Dpa->where('tahun', $tahun)->groupBy('id_kegiatan')->count('id_kegiatan'),
                    'jumlah_program' => $value->Dpa->where('tahun', $tahun)->groupBy('id_program')->count('id_program'),
                    'max_pagu' => numberToCurrency($value->max_pagu),
                    'total_saat_ini' => numberToCurrency($total_saat_ini),
                    'selisih' => numberToCurrency($selisih),
                    'realisasi_keuangan' => numberToCurrency($value->Dpa->where('tahun', $tahun)->reduce(function ($total, $value) {
                        return $total + $value->Realisasi->reduce(function ($total, $value) {
                                return $total + $value->realisasi_keuangan;
                            });
                    })),
                    'realisasi_fisik' => numberToCurrency($value->Dpa->where('tahun', $tahun)->count() ? $value->Dpa->where('tahun', $tahun)->reduce(function ($total, $value) {
                            return $total + $value->Realisasi->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                });
                        }) / $value->Dpa->where('tahun', $tahun)->count() : 0),
                    'status' => $status,
                    'status_color' => $status_color
                ];
            });
            $data->jumlah_kegiatan = $data->progress_opd->reduce(function ($total, $value) {
                return $total + $value['jumlah_kegiatan'];
            });
            $data->jumlah_sub_kegiatan = $data->progress_opd->reduce(function ($total, $value) {
                return $total + $value['jumlah_sub_kegiatan'];
            });
            $data->jumlah_program = $data->progress_opd->reduce(function ($total, $value) {
                return $total + $value['jumlah_program'];
            });
        } else if (hasRole('opd')) {
            $id_unit_kerja = auth()->user()->id_unit_kerja;
            $id_dpa_opd = Dpa::where('tahun', $tahun)->where('id_unit_kerja', $id_unit_kerja)->pluck('id')->toArray();
            $data->jumlah_kegiatan = Kegiatan::where(function ($q) use ($tahun, $id_unit_kerja) {
                $q->whereHas('Dpa', function ($q) use ($tahun, $id_unit_kerja) {
                    $q->where('tahun', $tahun);
                    if ($id_unit_kerja)
                        $q->where('id_unit_kerja', $id_unit_kerja);
                });
            })->count();
            $data->jumlah_sub_kegiatan = SubKegiatan::where(function ($q) use ($tahun, $id_unit_kerja) {
                $q->whereHas('Dpa', function ($q) use ($tahun, $id_unit_kerja) {
                    $q->where('tahun', $tahun);
                    if ($id_unit_kerja)
                        $q->where('id_unit_kerja', $id_unit_kerja);
                });
            })->count();
            $data->jumlah_program = Program::where(function ($q) use ($tahun, $id_unit_kerja) {
                $q->whereHas('Dpa', function ($q) use ($tahun, $id_unit_kerja) {
                    $q->where('tahun', $tahun);
                    if ($id_unit_kerja)
                        $q->where('id_unit_kerja', $id_unit_kerja);
                });
            })->count();
        }
        $data->jumlah_opd = UnitKerja::count();
        $data->sumber_dana = SumberDana::pluck('nama_sumber_dana');
        // $data->max_pagu = UnitKerja::where(function ($q) use ($id_unit_kerja) {
        //     if ($id_unit_kerja)
        //         $q->where('id', $id_unit_kerja);
        // })->sum('max_pagu');
        $data->max_pagu = UnitKerja::with(['Dpa' => function ($q) use ($tahun,$id_unit_kerja) {
            $q->where('tahun', $tahun);
            if ($id_unit_kerja)
                $q->where('id', $id_unit_kerja);
        }])->sum('max_pagu');
        $data_unit_kerja = UnitKerja::with(['Dpa' => function ($q) use ($tahun) {
            $q->where('tahun', $tahun);
            $q->with(['SumberDanaDpa' => function ($q) use ($tahun) {
                $q->where('tahun', $tahun);
                $q->with(['DetailRealisasi']);
            }, 'TolakUkur', 'PegawaiPenanggungJawab']);
            $q->whereHas('SumberDanaDpa');
        }])->when($id_unit_kerja, function ($q) use ($id_unit_kerja) {
            $q->where('id', $id_unit_kerja);
        })->get();
        $data_unit_kerja = $data_unit_kerja->map(function ($value) {
            $value->Dpa = $value->Dpa->map(function ($value) {
                $value->nilai_pagu_dpa = $value->SumberDanaDpa->reduce(function ($total, $value) {
                    return $total + $value->nilai_pagu;
                });
                $value->realisasi_keuangan = $value->SumberDanaDpa->reduce(function ($total, $value) {
                    return $total + $value->DetailRealisasi->reduce(function ($total, $value) {
                            return $total + $value->realisasi_keuangan;
                        });
                });
                $value->jumlah_realisasi = $value->SumberDanaDpa->count();
                $value->jumlah_tolak_ukur = $value->TolakUkur->count();
                try {
                    $value->realisasi_fisik = $value->SumberDanaDpa->reduce(function ($total, $value) {
                            return $total + $value->DetailRealisasi->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                });
                        }) / $value->jumlah_realisasi;
                } catch (\Exception $exception) {
                    $value->realisasi_fisik = 0;
                }
                return $value;
            });
            $value->total_pagu = $value->Dpa->reduce(function ($total, $value) {
                return $total + $value->nilai_pagu_dpa;
            });
            $value->realisasi_keuangan = $value->Dpa->reduce(function ($total, $value) {
                return $total + $value->realisasi_keuangan;
            });
            $value->jumlah_tolak_ukur = $value->Dpa->reduce(function ($total, $value) {
                return $total + $value->jumlah_tolak_ukur;
            });
            try {
                $value->realisasi_fisik = $value->Dpa->reduce(function ($total, $value) {
                        return $total + $value->realisasi_fisik;
                    }) / $value->Dpa->count();
            } catch (\Exception $exception) {
                $value->realisasi_fisik = 0;
            }
            return $value;
        });
        $data->realisasi_keuangan = $data_unit_kerja->reduce(function ($total, $value) {
            return $total + $value->realisasi_keuangan;
        });
        $data->total_saat_ini = Dpa::where('tahun', $tahun)->where(function ($q) use ($id_unit_kerja) {
            if ($id_unit_kerja)
                $q->where('id_unit_kerja', $id_unit_kerja);
        })->sum('nilai_pagu_dpa');
        $jumlah_kegiatan = 0;
        $total_fisik = 0;
        $total_keuangan = 0;

        foreach ($data_unit_kerja AS $row){
            $jumlah_kegiatan_dpa = 0;
            $dpa_keuangan = 0;
            $dpa_fisik = 0;
            $jumlah_kegiatan++;
            foreach ($row->Dpa AS $dpa){
                $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
                $dpa_keuangan += $persentase_keuangan;
                //$dpa_fisik += $dpa->realisasi_fisik;
                $jumlah_kegiatan_dpa++;
                $dpa_fisik += $data->total_saat_ini? $dpa->realisasi_fisik * ($dpa->nilai_pagu_dpa / $data->total_saat_ini * 100) / 100 : 0;
            }

            $dpa_total_fisik = $jumlah_kegiatan_dpa ? $dpa_fisik : 0;
            $dpa_total_keuangan = $jumlah_kegiatan_dpa ? $dpa_keuangan/$jumlah_kegiatan_dpa : 0;
            $total_keuangan += $dpa_total_keuangan;
            $total_fisik += $dpa_total_fisik;
        }
        $data->persentase_realisasi_keuangan = pembulatanDuaDecimal($jumlah_kegiatan ? $total_keuangan/$jumlah_kegiatan : 0);
        
        $data->realisasi_fisik = pembulatanDuaDecimal($jumlah_kegiatan_dpa ? $total_fisik : 0);
        $data->selisih = $data->max_pagu - $data->total_saat_ini;

        $data->sumber_dana_terpakai = SumberDanaDpa::where('tahun', $tahun)->where(function ($q) use ($id_unit_kerja, $id_dpa_opd) {
            if ($id_unit_kerja)
                $q->whereIn('id_dpa', $id_dpa_opd);
        })->select(DB::raw('count(sumber_dana) AS jumlah'), 'sumber_dana')->groupBy('sumber_dana')->get();
        $data->data_sumber_dana = [];
        foreach ($data->sumber_dana as $sumber_dana) {
            $jumlah = optional($data->sumber_dana_terpakai->where('sumber_dana', $sumber_dana)->first())->jumlah;
            $data->data_sumber_dana[] = [
                'sector' => $sumber_dana,
                'size' => $jumlah ?? 0
            ];
        }
        $j_kegiatan = Jadwal::whereRaw("tahapan='Kegiatan' AND tahun='$tahun'")->first();
        if (!$j_kegiatan) {
            $jadwal_kegiatan = '<span class="label label-lg label-danger label-inline m-1">Belum diset</span>';
        } else {
            $jadwal_kegiatan = tglIndo(date('d/m/Y', strtotime($j_kegiatan->jadwal_mulai))) . '<br> s/d <br>' . tglIndo(date('d/m/Y', strtotime($j_kegiatan->jadwal_selesai)));
        }

        $j_target = Jadwal::whereRaw("tahapan='Target' AND tahun='$tahun'")->first();
        if (!$j_target) {
            $jadwal_target = '<span class="label label-lg label-danger label-inline m-1">Belum diset</span>';
        } else {
            $jadwal_target = tglIndo(date('d/m/Y', strtotime($j_target->jadwal_mulai))) . '<br> s/d <br>' . tglIndo(date('d/m/Y', strtotime($j_target->jadwal_selesai)));
        }
        $j_rkpd = Jadwal::whereRaw("tahapan='RKPD' AND tahun='$tahun'")->first();
        if (!$j_rkpd) {
            $jadwal_rkpd = '<span class="label label-lg label-danger label-inline m-1">Belum diset</span>';
        } else {
            $jadwal_rkpd = tglIndo(date('d/m/Y', strtotime($j_rkpd->jadwal_mulai))) . '<br> s/d <br>' . tglIndo(date('d/m/Y', strtotime($j_rkpd->jadwal_selesai)));
        }
        $j_rpjmd = Jadwal::whereRaw("tahapan='RPJMD' AND tahun='$tahun'")->first();
        if (!$j_rpjmd) {
            $jadwal_rpjmd = '<span class="label label-lg label-danger label-inline m-1">Belum diset</span>';
        } else {
            $jadwal_rpjmd = tglIndo(date('d/m/Y', strtotime($j_rpjmd->jadwal_mulai))) . '<br> s/d <br>' . tglIndo(date('d/m/Y', strtotime($j_rpjmd->jadwal_selesai)));
        }
        $j_realisasi = Jadwal::whereRaw("tahapan='Realisasi' AND tahun='$tahun' AND (DATE(jadwal_mulai) <= CURDATE() AND DATE(jadwal_selesai) >= CURDATE())")->first();
        if (!$j_realisasi) {
            $jadwal_realisasi = '<span class="label label-lg label-danger label-inline m-1">Belum diset</span>';
        } else {
            $jadwal_realisasi = tglIndo(date('d/m/Y', strtotime($j_realisasi->jadwal_mulai))) . '<br> s/d <br>' . tglIndo(date('d/m/Y', strtotime($j_realisasi->jadwal_selesai)));
        }
        $data->jadwal_kegiatan = $jadwal_kegiatan;
        $data->jadwal_target = $jadwal_target;
        $data->jadwal_realisasi = $jadwal_realisasi;
        $data->jadwal_rkpd = $jadwal_rkpd;
        $data->jadwal_rpjmd = $jadwal_rpjmd;

        // switch ($periode_selected) {
        //     case 1:
        //         $periode = 'Januari - Maret';
        //         break;
        //     case 2:
        //         $periode = 'April - Juni';
        //         break;
        //     case 3:
        //         $periode = 'Juli - September';
        //         break;
        //     case 4:
        //         $periode = 'Oktober - Desember';
        //         break;
        //     default:
        //         break;
        // }
            $fungsi = "export_progress_opd";
        return $this->{$fungsi}($tipe, $data);
    }


    public function export_progress_opd($tipe, $data)
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('AFILA')
            ->setLastModifiedBy('AFILA')
            ->setTitle('PROGRESS OPD ' )
            ->setSubject('PROGRESS OPD ' )
            ->setDescription('PROGRESS OPD ' )
            ->setKeywords('pdf php')
            ->setCategory('KEMAJUAN');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);
        // Header Text
        $sheet->setCellValue('A1', 'PROGRESS OPD');
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        

        $sheet->getStyle('A:K')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:K5')->getFont()->setBold(true);

        $cell = 6;
        

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A5');
        $sheet->setCellValue('B5', 'NAMA OPD')->mergeCells('B5:B5');
        $sheet->setCellValue('C5', 'JUMLAH PROGRAM')->mergeCells('C5:C5');
        $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D5');
        $sheet->setCellValue('E5', 'JUMLAH SUB KEGIATAN')->mergeCells('E5:E5');
        $sheet->setCellValue('F5', 'MAX PAGU (RP)')->mergeCells('F5:F5');
        $sheet->setCellValue('G5', 'TOTAL SAAT INI (RP)')->mergeCells('G5:G5');
        $sheet->setCellValue('H5', 'SELISIH (RP)')->mergeCells('H5:H5');
        $sheet->setCellValue('I5', 'REALISASI KEUANGAN (RP)')->mergeCells('I5:I5');
        $sheet->setCellValue('J5', 'REALISASI FISIK (%)')->mergeCells('J5:J5');
        $sheet->setCellValue('K5', 'STATUS')->mergeCells('K5:K5');

        $i = 0;
        foreach ($data->progress_opd AS $progress){
            // $sheet->getStyle('A'.$cell.':I'.$cell)->getFont()->setBold(true);
            $sheet->setCellValue('A' . $cell, ++$i);
            $sheet->setCellValue('B' . $cell, $progress['nama_opd'])->getColumnDimension('B')->setWidth(60);
            $sheet->setCellValue('C' . $cell, $progress['jumlah_program']);
            $sheet->setCellValue('D' . $cell, $progress['jumlah_kegiatan']);
            $sheet->setCellValue('E' . $cell, $progress['jumlah_sub_kegiatan']);
            $sheet->setCellValue('F' . $cell, $progress['max_pagu'])->getColumnDimension('F')->setWidth(28);
            $sheet->setCellValue('G' . $cell, $progress['total_saat_ini'])->getColumnDimension('G')->setWidth(28);
            $sheet->setCellValue('H' . $cell, $progress['selisih'])->getColumnDimension('H')->setWidth(28);
            $sheet->setCellValue('I' . $cell, $progress['realisasi_keuangan'])->getColumnDimension('I')->setWidth(28);
            $sheet->setCellValue('J' . $cell, $progress['realisasi_fisik']);
            $sheet->setCellValue('K' . $cell, $progress['status']);
            $cell++;

            
        }

        

        
       


        $sheet->getStyle('A1:K' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('C6:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D6:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E6:E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('A6:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('B6:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C6:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('G6:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('H6:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('I6:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('L6:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('M6:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('R6:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);


       
        // $sheet->getStyle('A' . $cell . ':K' . $cell)->getFont()->setBold(true);
        // $sheet->getRowDimension($cell)->setRowHeight(30);
        $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $profile = ProfileDaerah::first();
        $sheet->getStyle('A5:K' . $cell)->applyFromArray($border);
        $cell++;
        $tgl_cetak = tglIndo(request('tgl_cetak', date('d/m/Y')));
        if (hasRole('admin')) {
        } else if (hasRole('opd')) {
            $sheet->setCellValue('E' . ++$cell, optional($profile)->nama_daerah . ', ' . $tgl_cetak)->mergeCells('E' . $cell . ':I' . $cell);
            $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('E' . ++$cell, request('nama_jabatan_kepala', ''))->mergeCells('E' . $cell . ':I' . $cell);
            $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $cell = $cell + 3;
            $sheet->setCellValue('E' . ++$cell, request('nama', ''))->mergeCells('E' . $cell . ':I' . $cell);
            $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('E' . ++$cell, 'Pangkat/Golongan : ' . request('jabatan', ''))->mergeCells('E' . $cell . ':I' . $cell);
            $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('E' . ++$cell, 'NIP : ' . request('nip', ''))->mergeCells('E' . $cell . ':I' . $cell);
            $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
        if ($tipe == 'excel') {
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="PROGRESS OPD.xlsx"');

        } else {
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui ' . url()->current())->mergeCells('A' . $cell . ':L' . $cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H' . url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            // header('Content-Disposition: attachment;filename="PROGRESS OPD '.$dinas.'.pdf"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }
        $writer->save('php://output');
        exit;
    }
}
