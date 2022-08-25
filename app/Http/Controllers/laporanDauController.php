<?php

namespace App\Http\Controllers;

use App\Models\BackupReport;
use App\Models\BidangUrusan;
use App\Models\JenisBelanja;
use App\Models\MetodePelaksanaan;
use App\Models\ProfileDaerah;
use App\Models\SumberDana;
use App\Models\Dpa;
use App\Models\PaketDak;
use App\Models\SubBidangDak;
use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;

class laporanDauController extends Controller
{

    public function paket_dau()
    {
        $unit_kerja_selected = $metode_pelaksanaan_selected = $jenis_belanja_selected = $tabel = '';
        // $sumber_dana = SumberDana::whereRaw("nama_sumber_dana LIKE '%DAK NON-FISIK%'")->whereRaw("nama_sumber_dana LIKE '%PEN%'")->whereRaw("nama_sumber_dana LIKE '%APB%'")->get();
        $sumber_dana = SumberDana::all()->except(['nama_sumber_dana','DAK FISIK']);
        // return $sumber_dana;
        $unit_kerja = UnitKerja::where(function ($q) {
            if (hasRole('opd'))
                $q->where('id', auth()->user()->id_unit_kerja);
        })->get();
        $jenis_belanja = JenisBelanja::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $sumber_dana_selected = request('sumber_dana', '');
        if (hasRole('admin')) {
            $unit_kerja_selected = request('unit_kerja', '');
        } else if (hasRole('opd')) {
            $unit_kerja_selected = auth()->user()->id_unit_kerja;
        }
        $periode_selected = request('periode', '');
        $jenis_belanja_selected = request('jenis_belanja', '');
        $metode_pelaksanaan_selected = request('metode_pelaksanaan', '');
        $tahun = session('tahun_penganggaran','');
        $data = new Collection();
        $total_pagu_keseluruhan = 0;
        $total_realisasi_keuangan = 0;

        
            //GET DATA CURRENT

            if ($periode_selected) {
                if (!$unit_kerja_selected) {
                    $data = UnitKerja::with(['Dpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->where('tahun', $tahun);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                                if ($periode_selected)
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                        });
                    }])->get();
                    $data = $data->map(function ($value) {
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
                    $total_pagu_keseluruhan = $data->reduce(function ($total, $value) {
                        return $total + $value->total_pagu;
                    });
                    $total_realisasi_keuangan = $data->reduce(function ($total, $value) {
                        return $total + $value->realisasi_keuangan;
                    });
                } else if (
                    //            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
                    //            &&
                $unit_kerja_selected) {
                    $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.Dpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected, $unit_kerja_selected) {
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                                if ($periode_selected)
                                    $q->where('periode', '<=', $periode_selected);
                            }]);

                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                        });
                    }])->where('id', $unit_kerja_selected)
                        ->whereHas('BidangUrusan.Program.Kegiatan.Dpa', function ($q) use ($tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                                if ($sumber_dana_selected) {
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }
                                if ($jenis_belanja_selected)
                                    $q->where('jenis_belanja', $jenis_belanja_selected);
                                if ($metode_pelaksanaan_selected)
                                    $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            });
                        })
                        ->first();
                    $non_urusan = BidangUrusan::with(['Program.Kegiatan.Dpa' => function ($q) use ($unit_kerja_selected, $sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                                if ($periode_selected)
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                        });
                    }])
                        ->where('kode_bidang_urusan', '00')
                        ->whereHas('Program.Kegiatan.Dpa', function ($q) use ($unit_kerja_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            $q->where('id_unit_kerja', $unit_kerja_selected);
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                                if ($sumber_dana_selected) {
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }
                                if ($jenis_belanja_selected)
                                    $q->where('jenis_belanja', $jenis_belanja_selected);
                                if ($metode_pelaksanaan_selected)
                                    $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            });
                        })
                        ->first();
                    if ($data) {
                        $data->BidangUrusan->push($non_urusan);
                    } else {
                        $data = UnitKerja::find($unit_kerja_selected);
                        $data->BidangUrusan = new Collection();
                        $data->BidangUrusan->push($non_urusan);
                    }
                    $bidang_urusan_unit_kerja_1 = $data->BidangUrusan()->with('Urusan')->first();
                    $data = $data->BidangUrusan->map(function ($value) use ($bidang_urusan_unit_kerja_1) {
                        if (isset($value->Program)) {
                            $value->Program = $value->Program->map(function ($value) use ($bidang_urusan_unit_kerja_1) {
                                $non_urusan = false;
                                if ($value->BidangUrusan->kode_bidang_urusan == '00') {
                                    $non_urusan = true;
                                    $kode_program = $bidang_urusan_unit_kerja_1->Urusan->kode_urusan . '.' . $bidang_urusan_unit_kerja_1->kode_bidang_urusan . '.' . $value->kode_program;
                                    $value->kode_program_baru = $kode_program;
                                } else {
                                    $kode_program = $value->BidangUrusan->Urusan->kode_urusan . '.' . $value->BidangUrusan->kode_bidang_urusan . '.' . $value->kode_program;
                                    $value->kode_program_baru = $kode_program;
                                }
                                $value->Kegiatan = $value->Kegiatan->map(function ($value) use ($kode_program, $non_urusan) {
                                    if ($value->Dpa->count()) {
                                        $kode_kegiatan_baru = $kode_program . '.' . $value->kode_kegiatan;
                                        $value->jumlah_sub_kegiatan = $value->Subkegiatan->count();
                                        $value->kode_kegiatan_baru = $kode_kegiatan_baru;
                                        $value->Dpa = $value->Dpa->map(function ($value) use ($kode_program, $non_urusan) {
                                            if ($non_urusan)
                                                $value->SubKegiatan->kode_sub_kegiatan = $kode_program . (substr($value->SubKegiatan->kode_sub_kegiatan, 4));
                                            $value->kode_sub_kegiatan = $kode_program . (substr($value->SubKegiatan->kode_sub_kegiatan, 4));
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
                                            $value->jumlah_sumber_dana = $value->SumberDanaDpa->count();
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
                                        $value->jumlah_sumber_dana = $value->Dpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_sumber_dana;
                                        });
                                        try {
                                            $value->realisasi_fisik = $value->Dpa->reduce(function ($total, $value) {
                                                    return $total + $value->realisasi_fisik;
                                                }) / $value->Dpa->count();
                                        } catch (\Exception $exception) {
                                            $value->realisasi_fisik = 0;
                                        }
                                        return $value;
                                    }
                                    return null;
                                });

                                // $value->total_dak_unit = 7;
                                $value->jumlah_tolak_ukur = $value->Kegiatan->reduce(function ($total, $value) {
                                    return $total + ($value->jumlah_tolak_ukur ?? 0);
                                });
                                $value->jumlah_sumber_dana = $value->Kegiatan->reduce(function ($total, $value) {
                                    return $total + ($value->jumlah_sumber_dana ?? 0);
                                });
                                $value->jumlah_sub_kegiatan = $value->Kegiatan->reduce(function ($total, $value) {
                                    return $total + ($value->jumlah_sub_kegiatan ?? 0);
                                });
                                $value->jumlah_kegiatan = $value->Kegiatan->filter(function ($value) {
                                    return $value !== null;
                                })->count();
                                $value->jumlah_kegiatan = $value->jumlah_kegiatan ? $value->jumlah_kegiatan + 1 : 0;
                                return $value;
                            });
                        }
                        return $value;
                    });
                    $new_data = new Collection();
                    foreach ($data as $row) {
                        if (isset($row->Program))
                            $new_data = $new_data->merge($row->Program);
                    }
                    $total_pagu_keseluruhan = $new_data->reduce(function ($total, $value) {
                        return $total + $value->Kegiatan->reduce(function ($total, $value) {
                                return $total + ($value->total_pagu ?? 0);
                            });
                    });
                    $total_realisasi_keuangan = $new_data->reduce(function ($total, $value) {
                        return $total + $value->Kegiatan->reduce(function ($total, $value) {
                                return $total + ($value->realisasi_keuangan ?? 0);
                            });
                    });
                    $data = $new_data;
                    $data = $data->sortBy('kode_program_baru')->values();
                }
                $sumber_dana_view = $sumber_dana_selected == '' ? 'index' : 'index';
                $tabel = view('Laporan.tabel_kemajuan_dak.' . Str::slug($sumber_dana_view . ($unit_kerja_selected ? ' dinas' : ''), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected', 'periode_selected'))->render();
            }
    
        return view('Laporan/laporan_dau', compact('sumber_dana', 'unit_kerja', 'periode_selected', 'sumber_dana_selected', 'unit_kerja_selected', 'tabel', 'metode_pelaksanaan', 'jenis_belanja', 'metode_pelaksanaan_selected', 'jenis_belanja_selected'));
    }

    public function export_paket_dau($tipe)
    {
        $unit_kerja_selected = $metode_pelaksanaan_selected = $jenis_belanja_selected = $tabel = '';
        $sumber_dana = SumberDana::whereRaw("nama_sumber_dana NOT LIKE '%DAK%'")->get();
        $unit_kerja = UnitKerja::where(function ($q) {
            if (hasRole('opd'))
                $q->where('id', auth()->user()->id_unit_kerja);
        })->get();
        $jenis_belanja = JenisBelanja::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $sumber_dana_selected = request('sumber_dana', '');
        if (hasRole('admin')) {
            $unit_kerja_selected = request('unit_kerja', '');
        } else if (hasRole('opd')) {
            $unit_kerja_selected = auth()->user()->id_unit_kerja;
        }
        $periode_selected = request('periode', '');
        $jenis_belanja_selected = request('jenis_belanja', '');
        $metode_pelaksanaan_selected = request('metode_pelaksanaan', '');
        $tahun = session('tahun_penganggaran','');
        $data = new Collection();
        $total_pagu_keseluruhan = 0;
        $total_realisasi_keuangan = 0;

        // return $unit_kerja;


            //GET DATA CURRENT

            if ($periode_selected) {
                if (!$unit_kerja_selected) {
                    $data = UnitKerja::with(['Dpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->where('tahun', $tahun);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                                if ($periode_selected)
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                        });
                    }])->get();
                    $data = $data->map(function ($value) {
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
                    $total_pagu_keseluruhan = $data->reduce(function ($total, $value) {
                        return $total + $value->total_pagu;
                    });
                    $total_realisasi_keuangan = $data->reduce(function ($total, $value) {
                        return $total + $value->realisasi_keuangan;
                    });
                } else if ($unit_kerja_selected) {
                    $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.Dpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected, $unit_kerja_selected) {
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                                if ($periode_selected)
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                        });
                    }])->where('id', $unit_kerja_selected)
                        ->whereHas('BidangUrusan.Program.Kegiatan.Dpa', function ($q) use ($tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                                if ($sumber_dana_selected) {
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }
                                if ($jenis_belanja_selected)
                                    $q->where('jenis_belanja', $jenis_belanja_selected);
                                if ($metode_pelaksanaan_selected)
                                    $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            });
                        })
                        ->first();
                    $non_urusan = BidangUrusan::with(['Program.Kegiatan.Dpa' => function ($q) use ($unit_kerja_selected, $sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                                if ($periode_selected)
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                        });
                    }])
                        ->where('kode_bidang_urusan', '00')
                        ->whereHas('Program.Kegiatan.Dpa', function ($q) use ($unit_kerja_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            $q->where('id_unit_kerja', $unit_kerja_selected);
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                                if ($sumber_dana_selected) {
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }
                                if ($jenis_belanja_selected)
                                    $q->where('jenis_belanja', $jenis_belanja_selected);
                                if ($metode_pelaksanaan_selected)
                                    $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            });
                        })
                        ->first();
                    if ($data) {
                        $data->BidangUrusan->push($non_urusan);
                    } else {
                        $data = UnitKerja::find($unit_kerja_selected);
                        $data->BidangUrusan = new Collection();
                        $data->BidangUrusan->push($non_urusan);
                    }
                    $bidang_urusan_unit_kerja_1 = $data->BidangUrusan()->with('Urusan')->first();
                    $data = $data->BidangUrusan->map(function ($value) use ($bidang_urusan_unit_kerja_1) {
                        if (isset($value->Program)) {
                            $value->Program = $value->Program->map(function ($value) use ($bidang_urusan_unit_kerja_1) {
                                $non_urusan = false;
                                if ($value->BidangUrusan->kode_bidang_urusan == '00') {
                                    $non_urusan = true;
                                    $kode_program = $bidang_urusan_unit_kerja_1->Urusan->kode_urusan . '.' . $bidang_urusan_unit_kerja_1->kode_bidang_urusan . '.' . $value->kode_program;
                                    $value->kode_program_baru = $kode_program;
                                } else {
                                    $kode_program = $value->BidangUrusan->Urusan->kode_urusan . '.' . $value->BidangUrusan->kode_bidang_urusan . '.' . $value->kode_program;
                                    $value->kode_program_baru = $kode_program;
                                }
                                $value->Kegiatan = $value->Kegiatan->map(function ($value) use ($kode_program, $non_urusan) {
                                    if ($value->Dpa->count()) {
                                        $kode_kegiatan_baru = $kode_program . '.' . $value->kode_kegiatan;
                                        $value->jumlah_sub_kegiatan = $value->Subkegiatan->count();
                                        $value->kode_kegiatan_baru = $kode_kegiatan_baru;
                                        $value->Dpa = $value->Dpa->map(function ($value) use ($kode_program, $non_urusan) {
                                            if ($non_urusan)
                                                $value->SubKegiatan->kode_sub_kegiatan = $kode_program . (substr($value->SubKegiatan->kode_sub_kegiatan, 4));
                                            $value->kode_sub_kegiatan = $kode_program . (substr($value->SubKegiatan->kode_sub_kegiatan, 4));
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
                                            $value->jumlah_sumber_dana = $value->SumberDanaDpa->count();
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
                                        $value->jumlah_sumber_dana = $value->Dpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_sumber_dana;
                                        });
                                        try {
                                            $value->realisasi_fisik = $value->Dpa->reduce(function ($total, $value) {
                                                    return $total + $value->realisasi_fisik;
                                                }) / $value->Dpa->count();
                                        } catch (\Exception $exception) {
                                            $value->realisasi_fisik = 0;
                                        }
                                        return $value;
                                    }
                                    return null;
                                });
                                $value->jumlah_tolak_ukur = $value->Kegiatan->reduce(function ($total, $value) {
                                    return $total + ($value->jumlah_tolak_ukur ?? 0);
                                });
                                $value->jumlah_sumber_dana = $value->Kegiatan->reduce(function ($total, $value) {
                                    return $total + ($value->jumlah_sumber_dana ?? 0);
                                });
                                $value->jumlah_sub_kegiatan = $value->Kegiatan->reduce(function ($total, $value) {
                                    return $total + ($value->jumlah_sub_kegiatan ?? 0);
                                });
                                $value->jumlah_kegiatan = $value->Kegiatan->filter(function ($value) {
                                    return $value !== null;
                                })->count();
                                $value->jumlah_kegiatan = $value->jumlah_kegiatan ? $value->jumlah_kegiatan + 1 : 0;
                                return $value;
                            });
                        }
                        return $value;
                    });
                    $new_data = new Collection();
                    foreach ($data as $row) {
                        if (isset($row->Program))
                            $new_data = $new_data->merge($row->Program);
                    }
                    $total_pagu_keseluruhan = $new_data->reduce(function ($total, $value) {
                        return $total + $value->Kegiatan->reduce(function ($total, $value) {
                                return $total + ($value->total_pagu ?? 0);
                            });
                    });
                    $total_realisasi_keuangan = $new_data->reduce(function ($total, $value) {
                        return $total + $value->Kegiatan->reduce(function ($total, $value) {
                                return $total + ($value->realisasi_keuangan ?? 0);
                            });
                    });
                    $data = $new_data;
                    $data = $data->sortBy('kode_program_baru')->values();
                }
                $sumber_dana_selected = $sumber_dana_selected == '' ? 'semua' : $sumber_dana_selected;
            }      
        

        $fungsi = Str::slug(($unit_kerja_selected ? 'semua unit kerja' : 'semua'), '_');
        $dinas = '';
        $periode = '';
        if ($unit_kerja_selected) {
            $dinas = UnitKerja::find($unit_kerja_selected)->nama_unit_kerja;
        }
        switch ($periode_selected) {
            case 1:
                $periode = 'I (Januari - Maret)';
                break;
            case 2:
                $periode = 'II (April - Juni)';
                break;
            case 3:
                $periode = 'III (Juli - September)';
                break;
            case 4:
                $periode = 'IV (Oktober - Desember)';
                break;
            default:
                break;
        }

      
        if ($fungsi) {
            $fungsi = "export_paket_dau_$fungsi";
        }
        return $this->{$fungsi}($tipe, $data, $total_pagu_keseluruhan, $total_realisasi_keuangan, $periode, $dinas, $tahun, $periode_selected, $sumber_dana_selected);
    }

    public function export_paket_dau_semua_unit_kerja($tipe, $data, $total_pagu_keseluruhan, $total_realisasi_keuangan, $periode, $dinas, $tahun, $periode_selected, $sumber_dana_selected, $query = [])
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('AFILA')
            ->setLastModifiedBy('AFILA')
            ->setTitle('Kemajuan Realisasi Paket'.$sumber_dana_selected.' '. $dinas . '')
            ->setSubject('Kemajuan Realisasi Paket'.$sumber_dana_selected.' '. $dinas . '')
            ->setDescription('Kemajuan Realisasi Paket'.$sumber_dana_selected.' '. $dinas . '')
            ->setKeywords('pdf php')
            ->setCategory('KEMAJUAN PAKET');
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
        if ($sumber_dana_selected == 'semua') {
            $sumber_dana_selected = 'APBD';
        } else {
            $sumber_dana_selected = strtoupper($sumber_dana_selected);
        }
        // Header Text
        $sheet->setCellValue('A1', 'LAPORAN KEMAJUAN PAKET PER TRIWULAN');
        $sheet->setCellValue('A2', strtoupper($dinas) . ' TAHUN ANGGARAN ' . $tahun . ' KEADAAN TRIWULAN' . strtoupper($periode));
        $sheet->setCellValue('A3', 'SUMBER DANA ' . $sumber_dana_selected);
        $sheet->mergeCells('A1:Q1');
        $sheet->mergeCells('A2:Q2');
        $sheet->mergeCells('A3:Q3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'KODE')->mergeCells('A5:A7');
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->setCellValue('B5', 'KEGIATAN')->mergeCells('B5:B7');
        $sheet->getColumnDimension('B')->setWidth(32);
        $sheet->setCellValue('C5', 'PERENCANAAN KEGIATAN')->mergeCells('C5:F5');
        $sheet->setCellValue('G5', 'MEKANISME PELAKSANAAN')->mergeCells('G5:K5');
        $sheet->setCellValue('L5', 'REALISASI')->mergeCells('L5:O5');
        $sheet->setCellValue('P5', 'Sisa Anggaran')->mergeCells('P5:P7')->getColumnDimension('P')->setWidth(18);
        $sheet->setCellValue('Q5', 'Kodefikasi Keterangan / Permasalahan')->mergeCells('Q5:Q7')->getColumnDimension('Q')->setWidth(10);
        
   

        $sheet->setCellValue('C6', 'Volume')->mergeCells('C6:C7')->getColumnDimension('C')->setWidth(8);
        $sheet->setCellValue('D6', 'Satuan')->mergeCells('D6:D7')->getColumnDimension('D')->setWidth(8);
        $sheet->setCellValue('E6', 'Penerima')->mergeCells('E6:E7')->getColumnDimension('E')->setWidth(8);
        $sheet->setCellValue('F6', 'PAGU')->mergeCells('F6:F7')->getColumnDimension('F')->setWidth(18);
        

        $sheet->setCellValue('G6', 'Swakelola')->mergeCells('G6:H6');
        $sheet->setCellValue('I6', 'Kontraktual')->mergeCells('I6:J6');
        $sheet->setCellValue('K6', 'Metode Pembayaran')->mergeCells('K6:K7')->getColumnDimension('K')->setWidth(12);
        
        $sheet->setCellValue('L6', 'Keaungan')->mergeCells('L6:M6');
        $sheet->setCellValue('N6', 'Fisik')->mergeCells('N6:O6');

        


        $sheet->setCellValue('G7', 'Volume')->getColumnDimension('G')->setWidth(8);
        $sheet->setCellValue('H7', 'Keu(Rp)')->getColumnDimension('H')->setWidth(18);


        $sheet->setCellValue('I7', 'Volume')->getColumnDimension('I')->setWidth(8);
        $sheet->setCellValue('J7', 'Keu(Rp)')->getColumnDimension('J')->setWidth(18);

        $sheet->setCellValue('L7', 'Keu(Rp)')->getColumnDimension('L')->setWidth(18);
        $sheet->setCellValue('M7', 'Keu(%)')->getColumnDimension('M')->setWidth(8);

        $sheet->setCellValue('N7', 'Volume')->getColumnDimension('N')->setWidth(8);
        $sheet->setCellValue('O7', '(%)')->getColumnDimension('O')->setWidth(8);




        $sheet->getStyle('A:Q')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:Q7')->getFont()->setBold(true);

        $sheet->getStyle('A5:Q7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('C6E0B4');

        $cell = 8;

        $tot_penerima_manfaat = 0;
        $tot_anggaran_dak = 0;

        $tot_volume_swakelola = 0;
        $tot_swakelola = 0;

        $tot_volume_kontrak = 0;
        $tot_kontrak = 0;

        $tot_realisasi_keuangan = 0;
        $tot_realisasi_fisik=0;
        $tot_realisasi_kinerja=0;


        $tot_sisa_anggaran=0;
        $tot_biaya=0;



        $i = 0;
        $no_program = 0;
        $kp = 0;
        $jumlah_paket = 0;


        foreach ($data as $index => $row) {
            if ($row->jumlah_tolak_ukur + $row->jumlah_sumber_dana > 0) {
                foreach ($row->Kegiatan as $kegiatan) {
                    if ($kegiatan) {
                        foreach ($kegiatan->Dpa->sortBy('kode_sub_kegiatan') as $dpa) {
                            foreach ($dpa->SumberDanaDpa as $sumber_dana) {
                                // $row->Dak_count = $sumber_dana->PaketDak;
                                foreach ($sumber_dana->PaketDak as $paket_dak) {

                                    $row->Dak_count = $paket_dak;
                                    $kegiatan->Dak_count = $paket_dak;
                                    $dpa->Dak_count = $paket_dak;

                                    $realisasi = $paket_dak->RealisasiDak->where('periode', '<=', $periode_selected);
                                    $keuangan = $realisasi->sum('realisasi_keuangan');
                                }
                            }
                        }
                    }
                }
            }
        }

        // return $data;


        foreach ($data as $index => $row) {
          if (isset($row->Dak_count)) {
            if ($row->jumlah_tolak_ukur + $row->jumlah_sumber_dana > 0) {
                $i++;

                $sheet->setCellValue('A' . $cell, $row->kode_program_baru);
                $sheet->setCellValue('B' . $cell, $row->nama_program);
                $sheet->getStyle('A' . $cell . ':Q' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('CC99FF');
                //$sheet->getStyle('B' . $cell . ':Q' . $cell)->getFont()->setBold(true);
                $cell++;
                $no_kegiatan = 0;
                foreach ($row->Kegiatan as $kegiatan) {
                    if ($kegiatan) {
                        if (isset($kegiatan->Dak_count)) {
                            $sheet->setCellValue('A' . $cell, $kegiatan->kode_kegiatan_baru);
                            $sheet->setCellValue('B' . $cell, $kegiatan->nama_kegiatan);
                            $sheet->getStyle('A' . $cell . ':Q' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('9BC2E6');
                            
                            $cell++;
                            $no_sub_kegiatan = 0;
                            foreach ($kegiatan->Dpa->sortBy('kode_sub_kegiatan') as $dpa) {
                              if (isset($dpa->Dak_count)) {
                                $kp = 1;
                                $sheet->setCellValue('A' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan);
                                $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan);
                                $sheet->getStyle('A' . $cell . ':Q' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('D9E1F2');
                                $sheet->getStyle('B' . $cell . ':Q' . $cell)->getFont()->setBold(true);
                                $cell++;




                                foreach ($dpa->SumberDanaDpa as $sumber_dana) {
                                    foreach ($sumber_dana->PaketDak as $paket_dak) {

                                        $realisasi = $paket_dak->RealisasiDak->where('periode', '<=', $periode_selected);
                                        
                                        $fisik = $realisasi->sum('realisasi_fisik');
                                        $keuangan = $realisasi->sum('realisasi_keuangan');
                                        $kinerja = $realisasi->sum('realisasi_kinerja');

                                        $realisasi_keuangan_persen=0;
                                        $sisa_anggaran=0;
                                        $total_biaya=0;
                                        

                                        $total_biaya=$paket_dak->swakelola+$paket_dak->kontrak;

                                        $jumlah_paket++;
                                        $tot_penerima_manfaat += $paket_dak->penerima_manfaat;
                                        $tot_anggaran_dak += $paket_dak->anggaran_dak;

                                        $tot_volume_swakelola += $paket_dak->volume_swakelola;
                                        $tot_swakelola += $paket_dak->swakelola;
                                        $tot_volume_kontrak += $paket_dak->volume_kontrak;
                                        $tot_kontrak += $paket_dak->kontrak;

                                        $tot_realisasi_keuangan += $keuangan;
                                        $tot_realisasi_fisik += $fisik;
                                        $tot_realisasi_kinerja += $kinerja;

                                        

                                        $tot_biaya+=$total_biaya;

                                        $realisasi_keuangan_persen = ($total_biaya ? $keuangan / $total_biaya * 100 : 0);
                                        $sisa_anggaran = ($paket_dak->anggaran_dak ? $paket_dak->anggaran_dak-$keuangan: 0);

                                        $tot_sisa_anggaran+=$sisa_anggaran;

                                        $real_data = $paket_dak->RealisasiDak->where('periode', $periode_selected);
                                        $permasalahan = $real_data->first()->permasalahan;
                                        
                                        
                                        $sheet->setCellValue('A' . $cell, sprintf("%02d", $kp++));
                                        $sheet->setCellValue('B' . $cell, $paket_dak->nama_paket);
                                        $sheet->setCellValue('C' . $cell, $paket_dak->volume);
                                        $sheet->setCellValue('D' . $cell, $paket_dak->satuan);
                                        $sheet->setCellValue('E' . $cell, $paket_dak->penerima_manfaat);
                                        $sheet->setCellValue('F' . $cell, $paket_dak->anggaran_dak);
                                        

                                        $sheet->setCellValue('G' . $cell, $paket_dak->volume_swakelola);
                                        $sheet->setCellValue('H' . $cell, $paket_dak->swakelola);
                                        $sheet->setCellValue('I' . $cell, $paket_dak->volume_kontrak);
                                        $sheet->setCellValue('J' . $cell, $paket_dak->kontrak);

                                        $sheet->setCellValue('K' . $cell, $paket_dak->metode_pembayaran);

                                        $sheet->setCellValue('L' . $cell, $keuangan);
                                        $sheet->setCellValue('M' . $cell, (pembulatanDuaDecimal($realisasi_keuangan_persen,2)));
                                        $sheet->setCellValue('N' . $cell, $kinerja);
                                        $sheet->setCellValue('O' . $cell, (pembulatanDuaDecimal($fisik,2)));
                                        $sheet->setCellValue('P' . $cell, $sisa_anggaran);
                                        $sheet->setCellValue('Q' . $cell, $permasalahan);

                                        //$sheet->getStyle('A' . $cell . ':Q' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('D9E1F2');

                                        $cell++;

                                    }
                                }
                            }
                         }

                        // return $data;
                       }
                    }
                }
            }
          }
        }


        $sheet->getStyle('A1:Q' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:Q' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A8:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('B8:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F8:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('H8:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('J8:J' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('L8:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('P8:P' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('Q8:Q' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        
        $sheet->getStyle('F8:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H8:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J8:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L8:L' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('P8:P' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        //$tot_fisik_keseluruhan = $jumlah_paket ? round(($tot_fisik / ($jumlah_paket)), 2) : 0;

        $sheet->setCellValue('A' . $cell, 'JUMLAH');
        $sheet->setCellValue('B' . $cell, '');

        $sheet->setCellValue('E' . $cell, $tot_penerima_manfaat);
        $sheet->setCellValue('F' . $cell, $tot_anggaran_dak);

        $sheet->setCellValue('G' . $cell, $tot_volume_swakelola);
        $sheet->setCellValue('H' . $cell, $tot_swakelola);
        $sheet->setCellValue('I' . $cell, $tot_volume_kontrak);
        $sheet->setCellValue('J' . $cell, $tot_kontrak);

        $sheet->setCellValue('L' . $cell, $tot_realisasi_keuangan);
        $sheet->setCellValue('M' . $cell, (pembulatanDuaDecimal(($tot_anggaran_dak ? $tot_realisasi_keuangan / $tot_anggaran_dak * 100 : 0),2)));
        $sheet->setCellValue('N' . $cell, $tot_realisasi_kinerja);
        $sheet->setCellValue('O' . $cell, (pembulatanDuaDecimal(($jumlah_paket ? $tot_realisasi_fisik / $jumlah_paket : 0),2)));
        $sheet->setCellValue('P' . $cell, $tot_sisa_anggaran);
        
        $sheet->getStyle('A'.$cell.':Q'. $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('C6E0B4');
        

        $sheet->getStyle('A' . $cell . ':Q' . $cell)->getFont()->setBold(true);
        $sheet->getRowDimension($cell)->setRowHeight(30);
        $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A5:Q' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak', date('d/m/Y')));
        if (hasRole('admin')) {
        } else if (hasRole('opd')) {
            $sheet->setCellValue('N' . ++$cell, optional($profile)->nama_daerah . ', ' . $tgl_cetak)->mergeCells('N' . $cell . ':Q' . $cell);
            $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('N' . ++$cell, request('nama_jabatan_kepala', ''))->mergeCells('N' . $cell . ':Q' . $cell);
            $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $cell = $cell + 3;
            $sheet->setCellValue('N' . ++$cell, request('nama', ''))->mergeCells('N' . $cell . ':Q' . $cell);
            $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('N' . ++$cell, 'Pangkat/Golongan : ' . request('jabatan', ''))->mergeCells('N' . $cell . ':Q' . $cell);
            $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('N' . ++$cell, 'NIP : ' . request('nip', ''))->mergeCells('N' . $cell . ':Q' . $cell);
            $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
        if ($tipe == 'excel') {
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="KEMAJUAN DINAS ' . $dinas . '.xlsx"');

        } else {
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui ' . url()->current())->mergeCells('A' . $cell . ':L' . $cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H' . url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }
        $writer->save('php://output');
        exit;
    }

    public function export_paket_dau_semua($tipe, $data, $total_pagu_keseluruhan, $total_realisasi_keuangan, $periode, $dinas, $tahun, $periode_selected, $sumber_dana_selected, $query = [])
    {
        // return $data;
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('AFILA')
            ->setLastModifiedBy('AFILA')
            ->setTitle('Kemajuan Realisasi Paket ' .$sumber_dana_selected . 'Enrekang')
            ->setSubject('Kemajuan Realisasi Paket ' .$sumber_dana_selected . 'Enrekang')
            ->setDescription('Kemajuan Realisasi Paket ' .$sumber_dana_selected . 'Enrekang')
            ->setKeywords('pdf php')
            ->setCategory('KEMAJUAN DAK');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(24);

        //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.6);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $profile = ProfileDaerah::first();
        // Header Text
        if ($sumber_dana_selected == 'semua') {
            $sumber_dana_selected = 'APBD';
        } else {
            $sumber_dana_selected = strtoupper($sumber_dana_selected);
        }
        $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN PAKET FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', 'SUMBER DANA ' . $sumber_dana_selected . ' DI KABUPATEN ' . strtoupper(optional($profile)->nama_daerah));
        $sheet->setCellValue('A3', 'TRIWULAN ' . strtoupper($periode) . ' TAHUN ' . $tahun);
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->mergeCells('A3:L3');

        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C5', 'PERENCANAAN KEGIATAN');
        $sheet->setCellValue('D5', 'BOBOT (%)')->mergeCells('D5:D6');
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->setCellValue('E5', 'PELAKSANAAN KEGIATAN')->mergeCells('E5:F5');
        $sheet->setCellValue('G5', 'REALISASI')->mergeCells('G5:I5');
        $sheet->setCellValue('J5', 'REALISASI TERTIMBANG')->mergeCells('J5:K5');
        $sheet->setCellValue('L5', 'KET')->mergeCells('L5:L6');
        $sheet->getColumnDimension('L')->setWidth(10);

        $sheet->setCellValue('C6', 'ANGGARAN(Rp)')->getColumnDimension('C')->setWidth(20);
        $sheet->setCellValue('E6', 'Kontrak(Rp)')->getColumnDimension('E')->setWidth(20);
        $sheet->setCellValue('F6', 'Swakelola(Rp)')->getColumnDimension('F')->setWidth(20);


        $sheet->setCellValue('G6', 'Keuangan(Rp)')->getColumnDimension('G')->setWidth(20);
        $sheet->setCellValue('H6', 'Keu(%)')->getColumnDimension('H')->setWidth(10);
        $sheet->setCellValue('I6', 'Fisik (%)')->getColumnDimension('I')->setWidth(10);

        $sheet->setCellValue('J6', 'Keu(%)')->getColumnDimension('J')->setWidth(10);
        $sheet->setCellValue('K6', 'Fisik (%)')->getColumnDimension('K')->setWidth(10);

        $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
        $sheet->getStyle('A1:L6')->getFont()->setBold(true);

        $cell = 7;
        $jumlah_bobot = 0;
        $jumlah_data = 0;

        $jumlah_dak = 0;
        $jumlah_pendampingan = 0;
        $jumlah_biaya = 0;
        $jumlah_swakelola = 0;
        $jumlah_kontrak = 0;
        $jumlah_keuangan = 0;
        $jumlah_persentase_fisik = 0;
        $jumlah_persentase_keuangan = 0;
        $jumlah_tertimbang_fisik = 0;
        $jumlah_tertimbang_keuangan = 0;


        foreach ($data as $index => $row) {
            $bobot[$index] = 0;
            $total_dak[$index] = 0;
            $total_pendampingan[$index] = 0;
            $total_biaya[$index] = 0;
            $total_swakelola[$index] = 0;
            $total_kontrak[$index] = 0;
            $total_fisik[$index] = 0;
            $total_keuangan[$index] = 0;

            $persentase_fisik[$index] = 0;
            $persentase_keuangan[$index] = 0;

            $tertimbang_fisik[$index] = 0;
            $tertimbang_keuangan[$index] = 0;

            $jumlah_paket[$index] = 0;


            foreach ($row->Dpa as $dpa) {
                foreach ($dpa->SumberDanaDpa as $sumber_dana) {
                    foreach ($sumber_dana->PaketDak as $paket_dak) {
                        $jumlah_paket[$index]++;

                        $total_dak[$index] += $paket_dak->anggaran_dak;
                        $total_pendampingan[$index] += $paket_dak->pendampingan;

                        $total_swakelola[$index] += $paket_dak->swakelola;
                        $total_kontrak[$index] += $paket_dak->kontrak;

                        $realisasi = $paket_dak->RealisasiDak->where('periode', '<=', $periode_selected);;

                        $fisik = $realisasi->sum('realisasi_fisik');
                        $keuangan = $realisasi->sum('realisasi_keuangan');

                        $total_fisik[$index] += $fisik;
                        $total_keuangan[$index] += $keuangan;

                        $persentase_fisik[$index] = $total_fisik[$index] / $jumlah_paket[$index];
                        $persentase_keuangan[$index] = $total_keuangan[$index] / $total_dak[$index] * 100;

                        
                    }
                    

                }
                

            }
            $jumlah_dak += $total_dak[$index];
            
            
        }


        foreach ($data as $index => $row) {

            if ($total_dak[$index] == 0 && $total_pendampingan[$index] == 0) {
                continue;
            } else {
                $jumlah_data++;
                $sheet->setCellValue('A' . $cell, $cell - 6);
                $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
                $sheet->setCellValue('C' . $cell, ($total_dak[$index]));
                $sheet->setCellValue('D' . $cell, pembulatanDuaDecimal($bobot[$index]=$total_dak[$index]/$jumlah_dak*100, 2));
                
                $sheet->setCellValue('E' . $cell, ($total_kontrak[$index]));
                $sheet->setCellValue('F' . $cell, ($total_swakelola[$index]));
                
                

                $sheet->setCellValue('G' . $cell, ($total_keuangan[$index]));
                $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($persentase_keuangan[$index], 2));
                $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($persentase_fisik[$index], 2));

                $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($tertimbang_keuangan[$index] = ($persentase_keuangan[$index] * $bobot[$index]) / 100, 2));
                $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_fisik[$index] = ($persentase_fisik[$index] * $bobot[$index]) / 100, 2));
                
                $sheet->setCellValue('L' . $cell, '-');
                $cell++;

                $jumlah_bobot += $bobot[$index];
                $jumlah_tertimbang_fisik += $tertimbang_fisik[$index];
                $jumlah_tertimbang_keuangan += $tertimbang_keuangan[$index];
                $jumlah_pendampingan += $total_pendampingan[$index];
                //$jumlah_biaya += $total_biaya[$index];
                $jumlah_swakelola += $total_swakelola[$index];
                $jumlah_kontrak += $total_kontrak[$index];
                $jumlah_keuangan += $total_keuangan[$index];
                $jumlah_persentase_fisik += $persentase_fisik[$index];
                $jumlah_persentase_keuangan += $persentase_keuangan[$index];
            }
            

            

        }


        $sheet->getStyle('A1:M' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('E7:E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('G7:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('E7:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        $sheet->getStyle('G7:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total


        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell, ($jumlah_dak));
        $sheet->setCellValue('D' . $cell, pembulatanDuaDecimal($jumlah_bobot, 2));
        
        $sheet->setCellValue('F' . $cell, ($jumlah_swakelola));
        $sheet->setCellValue('E' . $cell, ($jumlah_kontrak));

        $sheet->setCellValue('G' . $cell, ($jumlah_keuangan));

        if($jumlah_data == 0){
            $persentase_keuangan=0;
            $persentase_fisik=0;
        }else{
            $persentase_keuangan=$jumlah_persentase_keuangan / $jumlah_data;
            $persentase_fisik=$jumlah_persentase_fisik / $jumlah_data;
        }
        $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($jumlah_dak ? $jumlah_keuangan/$jumlah_dak * 100:0, 2));
        $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($persentase_fisik, 2));

        $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($jumlah_tertimbang_keuangan, 2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($jumlah_tertimbang_fisik, 2));

        $sheet->getStyle('A' . $cell . ':L' . $cell)->getFont()->setBold(true);
        $sheet->getRowDimension($cell)->setRowHeight(30);
        $sheet->getStyle('B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A5:L' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak', date('d/m/Y')));
        $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah . ', ' . $tgl_cetak)->mergeCells('I' . $cell . ':L' . $cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, request('nama_jabatan_kepala', ''))->mergeCells('I' . $cell . ':L' . $cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell + 3;
        $sheet->setCellValue('I' . ++$cell, request('nama', ''))->mergeCells('I' . $cell . ':L' . $cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : ' . request('jabatan', ''))->mergeCells('I' . $cell . ':L' . $cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'NIP : ' . request('nip', ''))->mergeCells('I' . $cell . ':L' . $cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        if ($tipe == 'excel') {
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="KEMAJUAN.xlsx"');
        } else {
            $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&H' . url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }
        $writer->save('php://output');
    }
   
}
