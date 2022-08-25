<?php

namespace App\Http\Controllers;

use App\Models\BidangUrusan;
use App\Models\JenisBelanja;
use App\Models\MetodePelaksanaan;
use App\Models\ProfileDaerah;
use App\Models\SumberDana;
use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class LaporanController extends Controller
{
    public function realisasi()
    {
        $unit_kerja_selected = $metode_pelaksanaan_selected = $jenis_belanja_selected = $tabel = '';
        $sumber_dana = SumberDana::get();
        $unit_kerja = UnitKerja::where(function ($q){
            if (hasRole('opd'))
                $q->where('id',auth()->user()->id_unit_kerja);
        })->get();
        $jenis_belanja = JenisBelanja::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $sumber_dana_selected = request('sumber_dana','');
        if (hasRole('admin')){
            $unit_kerja_selected = request('unit_kerja', '');
        } else if (hasRole('opd')){
            $unit_kerja_selected = auth()->user()->id_unit_kerja;
        }
        $periode_selected = request('periode', '');
        $jenis_belanja_selected = request('jenis_belanja', '');
        $metode_pelaksanaan_selected = request('metode_pelaksanaan', '');
        $tahun = request('tahun', date('Y'));
        $data = new Collection();
        $total_pagu_keseluruhan = 0;
        $total_realisasi_keuangan = 0;
        if ($periode_selected) {
            if (
//            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
//            &&
            !$unit_kerja_selected) {
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
                $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.Dpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
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
                            $value->Kegiatan = $value->Kegiatan->map(function ($value) use ($kode_program, $non_urusan){
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
            } else if (($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK') && !$unit_kerja_selected) {
                $data = UnitKerja::with(['Dpa' => function ($q) use ($periode_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                    $q->where('tahun', $tahun);
                    $q->with(['SumberDanaDpa' => function ($q) use ($periode_selected, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                            if ($periode_selected)
                                $q->where('periode', '<=', $periode_selected);
                        }]);
                        if ($sumber_dana_selected) {
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }
                        if ($jenis_belanja_selected)
                            $q->where('jenis_belanja', $jenis_belanja_selected);
                        if ($metode_pelaksanaan_selected)
                            $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                    }]);
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
                    $value->dak = $value->Dpa->reduce(function ($total, $value) {
                        return $total + $value->nilai_pagu_dpa;
                    });
                    $value->realisasi_keuangan = $value->Dpa->reduce(function ($total, $value) {
                        return $total + $value->realisasi_keuangan;
                    });
                    $value->persentase_realisasi_keuangan = $value->dak ? $value->realisasi_keuangan / $value->dak * 100 : 0;
                    $value->jumlah_realisasi = $value->Dpa->reduce(function ($total, $value) {
                        return $total + $value->jumlah_realisasi;
                    });
                    try {
                        $value->realisasi_fisik = $value->Dpa->reduce(function ($total, $value) {
                                return $total + $value->realisasi_fisik;
                            }) / $value->Dpa->count();
                    } catch (\Exception $exception) {
                        $value->realisasi_fisik = 0;
                    }
                    $value->swakelola = $value->Dpa->reduce(function ($total, $value) {
                        return $total + $value->SumberDanaDpa->whereIn('metode_pelaksanaan', SumberDana::TIPE_SWAKELOLA)->reduce(function ($total, $value) {
                                return $total + $value->nilai_pagu;
                            });
                    });
                    $value->kontrak = $value->Dpa->reduce(function ($total, $value) {
                        return $total + $value->SumberDanaDpa->whereIn('metode_pelaksanaan', SumberDana::TIPE_KONTRAK)->reduce(function ($total, $value) {
                                return $total + $value->nilai_pagu;
                            });
                    });
                    return $value;
                });
                $total_pagu_keseluruhan = $data->reduce(function ($total, $value) {
                    return $total + $value->dak;
                });
                $total_realisasi_keuangan = $data->reduce(function ($total, $value) {
                    return $total + $value->realisasi_keuangan;
                });
                $data->each(function ($value) use ($total_pagu_keseluruhan) {
                    $value->bobot = $total_pagu_keseluruhan ? $value->dak / $total_pagu_keseluruhan * 100 : 0;
                    $value->tertimbang_fisik = $total_pagu_keseluruhan ? $value->realisasi_fisik * $value->dak / $total_pagu_keseluruhan : 0;
                    $value->tertimbang_keuangan = $total_pagu_keseluruhan ? $value->realisasi_keuangan / $total_pagu_keseluruhan * 100 : 0;
                });
            } else if (($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK') && $unit_kerja_selected) {
                $data = UnitKerja::with(['Dpa' => function ($q) use ($periode_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                    $q->where('id_unit_kerja', $unit_kerja_selected);
                    $q->where('tahun', $tahun);
                    $q->with(['SumberDanaDpa' => function ($q) use ($periode_selected, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                            if ($periode_selected)
                                $q->where('periode', '<=', $periode_selected);
                        }]);
                        if ($sumber_dana_selected) {
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }
                        if ($jenis_belanja_selected)
                            $q->where('jenis_belanja', $jenis_belanja_selected);
                        if ($metode_pelaksanaan_selected)
                            $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                    }, 'TolakUkur', 'SubKegiatan']);
                    $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected) {
                        if ($sumber_dana_selected) {
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }
                    });
                }])
                    ->find($unit_kerja_selected);
                $data->Dpa = $data->Dpa->map(function ($value) {
                    $value->nilai_pagu_dpa = $value->SumberDanaDpa->reduce(function ($total, $value) {
                        return $total + $value->nilai_pagu;
                    });
                    $value->dak = $value->nilai_pagu_dpa;
                    $value->realisasi_keuangan = $value->SumberDanaDpa->reduce(function ($total, $value) {
                        return $total + $value->DetailRealisasi->reduce(function ($total, $value) {
                                return $total + $value->realisasi_keuangan;
                            });
                    });
                    $value->jumlah_realisasi = $value->SumberDanaDpa->reduce(function ($total, $value) {
                        return $total + $value->DetailRealisasi->count();
                    });
                    $value->swakelola = $value->SumberDanaDpa->whereIn('metode_pelaksanaan', SumberDana::TIPE_SWAKELOLA)->reduce(function ($total, $value) {
                        return $total + $value->nilai_pagu;
                    });
                    $value->kontrak = $value->SumberDanaDpa->whereIn('metode_pelaksanaan', SumberDana::TIPE_KONTRAK)->reduce(function ($total, $value) {
                        return $total + $value->nilai_pagu;
                    });
                    $value->persentase_realisasi_keuangan = $value->dak ? $value->realisasi_keuangan / $value->dak * 100 : 0;
                    $value->jumlah_tolak_ukur = $value->TolakUkur->count();
                    $value->realisasi_fisik = $value->SumberDanaDpa->count() ? $value->SumberDanaDpa->reduce(function ($total, $value) {
                            return $total + $value->DetailRealisasi->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                });
                        }) / $value->SumberDanaDpa->count() : 0;
                    return $value;
                });
                $data->total_dak = $data->Dpa->reduce(function ($total, $value) {
                    return $total + $value->nilai_pagu_dpa;
                });
                $data->jumlah_realisasi = $data->Dpa->reduce(function ($total, $value) {
                    return $total + $value->jumlah_realisasi;
                });
                $data->total_realisasi_keuangan = $data->Dpa->reduce(function ($total, $value) {
                    return $total + $value->realisasi_keuangan;
                });
                $data->persentase_realisasi_keuangan = $data->Dpa->count() ? $data->Dpa->reduce(function ($total, $value) {
                        return $total + $value->persentase_realisasi_keuangan;
                    }) / $data->Dpa->count() : 0;

                $data->realisasi_fisik = $data->Dpa->count() ? $data->Dpa->reduce(function ($total, $value) {
                        return $total + $value->realisasi_fisik;
                    }) / $data->Dpa->count() : 0;

                $data->swakelola = $data->Dpa->reduce(function ($total, $value) {
                    return $total + $value->swakelola;
                });
                $data->kontrak = $data->Dpa->reduce(function ($total, $value) {
                    return $total + $value->kontrak;
                });
                $data->Dpa->each(function ($value) use ($data) {
                    $value->bobot = $data->total_dak ? $value->dak / $data->total_dak * 100 : 0;
                    $value->tertimbang_fisik = $data->total_dak ? $value->realisasi_fisik * $value->dak / $data->total_dak : 0;
                    $value->tertimbang_keuangan = $data->total_dak ? $value->realisasi_keuangan / $data->total_dak * 100 : 0;
                });
            }
            $sumber_dana_selected = $sumber_dana_selected == '' ? 'index' : $sumber_dana_selected;
            $tabel = view('Laporan.tabel_realisasi.' . Str::slug($sumber_dana_selected . ($unit_kerja_selected ? ' dinas' : ''), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected'))->render();
        }
        return view('Laporan/laporan_realisasi', compact('sumber_dana', 'unit_kerja', 'periode_selected', 'sumber_dana_selected', 'unit_kerja_selected', 'tabel', 'metode_pelaksanaan', 'jenis_belanja', 'metode_pelaksanaan_selected', 'jenis_belanja_selected'));
    }


    public function kemajuan_dak()
    {
        $unit_kerja_selected = $metode_pelaksanaan_selected = $jenis_belanja_selected = $tabel = '';
        $sumber_dana = SumberDana::whereRaw("nama_sumber_dana LIKE '%DAK%'")->get();
        $unit_kerja = UnitKerja::where(function ($q){
            if (hasRole('opd'))
                $q->where('id',auth()->user()->id_unit_kerja);
        })->get();
        $jenis_belanja = JenisBelanja::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $sumber_dana_selected = request('sumber_dana','');
        if (hasRole('admin')){
            $unit_kerja_selected = request('unit_kerja', '');
        } else if (hasRole('opd')){
            $unit_kerja_selected = auth()->user()->id_unit_kerja;
        }
        $periode_selected = request('periode', '');
        $jenis_belanja_selected = request('jenis_belanja', '');
        $metode_pelaksanaan_selected = request('metode_pelaksanaan', '');
        $tahun = request('tahun', date('Y'));
        $data = new Collection();
        $total_pagu_keseluruhan = 0;
        $total_realisasi_keuangan = 0;
        if ($periode_selected) {
            if (
//            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
//            &&
            !$unit_kerja_selected) {
                $data = UnitKerja::with(['Dpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                    $q->where('tahun', $tahun);
                    $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        if ($sumber_dana_selected) {
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }else{
                            $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
                        }else{
                            $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
                $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.Dpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                    $q->where('id_unit_kerja', $unit_kerja_selected);
                    $q->where('tahun', $tahun);
                    $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        if ($sumber_dana_selected) {
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }else{
                            $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
                        }else{
                            $q->whereRaw("sumber_dana LIKE '%DAK%'");
                        }
                    });
                }])->where('id', $unit_kerja_selected)
                    ->whereHas('BidangUrusan.Program.Kegiatan.Dpa', function ($q) use ($tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->where('tahun', $tahun);
                        $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
                        }else{
                            $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
                        }else{
                            $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
                            }else{
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
            $sumber_dana_view = $sumber_dana_selected == '' ? 'index' :'index';
            $tabel = view('Laporan.tabel_kemajuan_dak.' . Str::slug($sumber_dana_view . ($unit_kerja_selected ? ' dinas' : ''), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected','periode_selected'))->render();
        }
        return view('Laporan/laporan_kemajuan_dak', compact('sumber_dana', 'unit_kerja', 'periode_selected', 'sumber_dana_selected', 'unit_kerja_selected', 'tabel', 'metode_pelaksanaan', 'jenis_belanja', 'metode_pelaksanaan_selected', 'jenis_belanja_selected'));
    }

    public function evaluasi()
    {
        return view('Laporan/laporan_evaluasi');
    }

    public function apbd()
    {
        return view('Laporan/laporan_apbd');
    }

    public function apbn()
    {
        return view('Laporan/laporan_apbn');
    }

    public function dak()
    {
        return view('Laporan/laporan_dak');
    }

    public function anggaran()
    {
        return view('Laporan/laporan_anggaran');
    }

    public function rkpd()
    {
        return view('Laporan/laporan_rkpd');
    }

    public function rpjmd()
    {
        return view('Laporan/laporan_rpjmd');
    }

	
	
    public function export($tipe){
        $unit_kerja_selected = $metode_pelaksanaan_selected = $jenis_belanja_selected = $tabel = '';
        $sumber_dana = SumberDana::get();
        $unit_kerja = UnitKerja::where(function ($q){
            if (hasRole('opd'))
                $q->where('id',auth()->user()->id_unit_kerja);
        })->get();
        $jenis_belanja = JenisBelanja::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $sumber_dana_selected = request('sumber_dana','');
        if (hasRole('admin')){
            $unit_kerja_selected = request('unit_kerja', '');
        } else if (hasRole('opd')){
            $unit_kerja_selected = auth()->user()->id_unit_kerja;
        }
        $periode_selected = request('periode', '');
        $jenis_belanja_selected = request('jenis_belanja', '');
        $metode_pelaksanaan_selected = request('metode_pelaksanaan', '');
        $tahun = request('tahun', date('Y'));
        $data = new Collection();
        $total_pagu_keseluruhan = 0;
        $total_realisasi_keuangan = 0;
        if ($periode_selected) {
            if (
//            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
//            &&
            !$unit_kerja_selected) {
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
                $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.Dpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
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
            } else if (($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK') && !$unit_kerja_selected) {
                $data = UnitKerja::with(['Dpa' => function ($q) use ($periode_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                    $q->where('tahun', $tahun);
                    $q->with(['SumberDanaDpa' => function ($q) use ($periode_selected, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                            if ($periode_selected)
                                $q->where('periode', '<=', $periode_selected);
                        }]);
                        if ($sumber_dana_selected) {
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }
                        if ($jenis_belanja_selected)
                            $q->where('jenis_belanja', $jenis_belanja_selected);
                        if ($metode_pelaksanaan_selected)
                            $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                    }]);
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
                    $value->dak = $value->Dpa->reduce(function ($total, $value) {
                        return $total + $value->nilai_pagu_dpa;
                    });
                    $value->realisasi_keuangan = $value->Dpa->reduce(function ($total, $value) {
                        return $total + $value->realisasi_keuangan;
                    });
                    $value->persentase_realisasi_keuangan = $value->dak ? $value->realisasi_keuangan / $value->dak * 100 : 0;
                    $value->jumlah_realisasi = $value->Dpa->reduce(function ($total, $value) {
                        return $total + $value->jumlah_realisasi;
                    });
                    try {
                        $value->realisasi_fisik = $value->Dpa->reduce(function ($total, $value) {
                                return $total + $value->realisasi_fisik;
                            }) / $value->Dpa->count();
                    } catch (\Exception $exception) {
                        $value->realisasi_fisik = 0;
                    }
                    $value->swakelola = $value->Dpa->reduce(function ($total, $value) {
                        return $total + $value->SumberDanaDpa->whereIn('metode_pelaksanaan', SumberDana::TIPE_SWAKELOLA)->reduce(function ($total, $value) {
                                return $total + $value->nilai_pagu;
                            });
                    });
                    $value->kontrak = $value->Dpa->reduce(function ($total, $value) {
                        return $total + $value->SumberDanaDpa->whereIn('metode_pelaksanaan', SumberDana::TIPE_KONTRAK)->reduce(function ($total, $value) {
                                return $total + $value->nilai_pagu;
                            });
                    });
                    return $value;
                });
                $total_pagu_keseluruhan = $data->reduce(function ($total, $value) {
                    return $total + $value->dak;
                });
                $total_realisasi_keuangan = $data->reduce(function ($total, $value) {
                    return $total + $value->realisasi_keuangan;
                });
                $data->each(function ($value) use ($total_pagu_keseluruhan) {
                    $value->bobot = $total_pagu_keseluruhan ? $value->dak / $total_pagu_keseluruhan * 100 : 0;
                    $value->tertimbang_fisik = $total_pagu_keseluruhan ? $value->realisasi_fisik * $value->dak / $total_pagu_keseluruhan : 0;
                    $value->tertimbang_keuangan = $total_pagu_keseluruhan ? $value->realisasi_keuangan / $total_pagu_keseluruhan * 100 : 0;
                });
            } else if (($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK') && $unit_kerja_selected) {
                $data = UnitKerja::with(['Dpa' => function ($q) use ($periode_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                    $q->where('id_unit_kerja', $unit_kerja_selected);
                    $q->where('tahun', $tahun);
                    $q->with(['SumberDanaDpa' => function ($q) use ($periode_selected, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                            if ($periode_selected)
                                $q->where('periode', '<=', $periode_selected);
                        }]);
                        if ($sumber_dana_selected) {
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }
                        if ($jenis_belanja_selected)
                            $q->where('jenis_belanja', $jenis_belanja_selected);
                        if ($metode_pelaksanaan_selected)
                            $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                    }, 'TolakUkur', 'SubKegiatan']);
                    $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected) {
                        if ($sumber_dana_selected) {
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }
                    });
                }])
                    ->find($unit_kerja_selected);
                $data->Dpa = $data->Dpa->map(function ($value) {
                    $value->nilai_pagu_dpa = $value->SumberDanaDpa->reduce(function ($total, $value) {
                        return $total + $value->nilai_pagu;
                    });
                    $value->dak = $value->nilai_pagu_dpa;
                    $value->realisasi_keuangan = $value->SumberDanaDpa->reduce(function ($total, $value) {
                        return $total + $value->DetailRealisasi->reduce(function ($total, $value) {
                                return $total + $value->realisasi_keuangan;
                            });
                    });
                    $value->jumlah_realisasi = $value->SumberDanaDpa->reduce(function ($total, $value) {
                        return $total + $value->DetailRealisasi->count();
                    });
                    $value->swakelola = $value->SumberDanaDpa->whereIn('metode_pelaksanaan', SumberDana::TIPE_SWAKELOLA)->reduce(function ($total, $value) {
                        return $total + $value->nilai_pagu;
                    });
                    $value->kontrak = $value->SumberDanaDpa->whereIn('metode_pelaksanaan', SumberDana::TIPE_KONTRAK)->reduce(function ($total, $value) {
                        return $total + $value->nilai_pagu;
                    });
                    $value->persentase_realisasi_keuangan = $value->dak ? $value->realisasi_keuangan / $value->dak * 100 : 0;
                    $value->jumlah_tolak_ukur = $value->TolakUkur->count();
                    $value->realisasi_fisik = $value->SumberDanaDpa->count() ? $value->SumberDanaDpa->reduce(function ($total, $value) {
                            return $total + $value->DetailRealisasi->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                });
                        }) / $value->SumberDanaDpa->count() : 0;
                    return $value;
                });
                $data->total_dak = $data->Dpa->reduce(function ($total, $value) {
                    return $total + $value->nilai_pagu_dpa;
                });
                $data->jumlah_realisasi = $data->Dpa->reduce(function ($total, $value) {
                    return $total + $value->jumlah_realisasi;
                });
                $data->total_realisasi_keuangan = $data->Dpa->reduce(function ($total, $value) {
                    return $total + $value->realisasi_keuangan;
                });
                $data->persentase_realisasi_keuangan = $data->Dpa->count() ? $data->Dpa->reduce(function ($total, $value) {
                        return $total + $value->persentase_realisasi_keuangan;
                    }) / $data->Dpa->count() : 0;

                $data->realisasi_fisik = $data->Dpa->count() ? $data->Dpa->reduce(function ($total, $value) {
                        return $total + $value->realisasi_fisik;
                    }) / $data->Dpa->count() : 0;

                $data->swakelola = $data->Dpa->reduce(function ($total, $value) {
                    return $total + $value->swakelola;
                });
                $data->kontrak = $data->Dpa->reduce(function ($total, $value) {
                    return $total + $value->kontrak;
                });
                $data->Dpa->each(function ($value) use ($data) {
                    $value->bobot = $data->total_dak ? $value->dak / $data->total_dak * 100 : 0;
                    $value->tertimbang_fisik = $data->total_dak ? $value->realisasi_fisik * $value->dak / $data->total_dak : 0;
                    $value->tertimbang_keuangan = $data->total_dak ? $value->realisasi_keuangan / $data->total_dak * 100 : 0;
                });
            }
            $sumber_dana_selected = $sumber_dana_selected == '' ? 'semua' : $sumber_dana_selected;
        }
        $fungsi = Str::slug($sumber_dana_selected . ($unit_kerja_selected ? ' unit kerja' : ''), '_');
        $dinas = '';
        $periode = '';
        if ($unit_kerja_selected){
            $dinas = UnitKerja::find($unit_kerja_selected)->nama_unit_kerja;
        }
        switch ($periode_selected){
            case 1:
                $periode = 'Januari - Maret';
                break;
            case 2:
                $periode = 'April - Juni';
                break;
            case 3:
                $periode = 'Juli - September';
                break;
            case 4:
                $periode = 'Oktober - Desember';
                break;
            default:
                break;
        }
        if ($fungsi){
            $fungsi = "export_$fungsi";
        }
        return $this->{$fungsi}($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun);
    }
    


    
    public function export_kemajuan_dak($tipe){
        $unit_kerja_selected = $metode_pelaksanaan_selected = $jenis_belanja_selected = $tabel = '';
        $sumber_dana = SumberDana::whereRaw("nama_sumber_dana LIKE '%DAK%'")->get();
        $unit_kerja = UnitKerja::where(function ($q){
            if (hasRole('opd'))
                $q->where('id',auth()->user()->id_unit_kerja);
        })->get();
        $jenis_belanja = JenisBelanja::get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $sumber_dana_selected = request('sumber_dana','');
        if (hasRole('admin')){
            $unit_kerja_selected = request('unit_kerja', '');
        } else if (hasRole('opd')){
            $unit_kerja_selected = auth()->user()->id_unit_kerja;
        }
        $periode_selected = request('periode', '');
        $jenis_belanja_selected = request('jenis_belanja', '');
        $metode_pelaksanaan_selected = request('metode_pelaksanaan', '');
        $tahun = request('tahun', date('Y'));
        $data = new Collection();
        $total_pagu_keseluruhan = 0;
        $total_realisasi_keuangan = 0;
        if ($periode_selected) {
            if (
//            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
//            &&
            !$unit_kerja_selected) {
                $data = UnitKerja::with(['Dpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                    $q->where('tahun', $tahun);
                    $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        if ($sumber_dana_selected) {
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }else{
                            $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
                        }else{
                            $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
                $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.Dpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                    $q->where('id_unit_kerja', $unit_kerja_selected);
                    $q->where('tahun', $tahun);
                    $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        if ($sumber_dana_selected) {
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }else{
                            $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
                        }else{
                            $q->whereRaw("sumber_dana LIKE '%DAK%'");
                        }
                    });
                }])->where('id', $unit_kerja_selected)
                    ->whereHas('BidangUrusan.Program.Kegiatan.Dpa', function ($q) use ($tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->where('tahun', $tahun);
                        $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
                        }else{
                            $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
                        }else{
                            $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
                            }else{
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
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
        if ($unit_kerja_selected){
            $dinas = UnitKerja::find($unit_kerja_selected)->nama_unit_kerja;
        }
        switch ($periode_selected){
            case 1:
                $periode = 'Januari - Maret';
                break;
            case 2:
                $periode = 'April - Juni';
                break;
            case 3:
                $periode = 'Juli - September';
                break;
            case 4:
                $periode = 'Oktober - Desember';
                break;
            default:
                break;
        }
        if ($fungsi){
            $fungsi = "export_kemajuan_dak_$fungsi";
        }
        return $this->{$fungsi}($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected);
    }


    public function export_kemajuan_dak_semua_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected)
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('AFILA')
        ->setLastModifiedBy('AFILA')
        ->setTitle('KEMAJUAN DINAS '.$dinas.'')
        ->setSubject('KEMAJUAN DINAS '.$dinas.'')
        ->setDescription('KEMAJUAN DINAS '.$dinas.'')
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
        $sheet->setCellValue('A1', 'LAPORAN KEMAJUAN PER TRIWULAN');
        $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
        $sheet->setCellValue('A3', 'SUMBER DANA DAK FISIK & NON FISIK');
        $sheet->mergeCells('A1:R1');
        $sheet->mergeCells('A2:R2');
        $sheet->mergeCells('A3:R3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A7');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'KODE')->mergeCells('B5:B7');
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->setCellValue('C5', 'JENIS KEGIATAN')->mergeCells('C5:C7');
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->setCellValue('D5', 'PERENCANAAN KEGIATAN')->mergeCells('D5:I5');
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->setCellValue('J5', 'PELAKSANA KEGIATAN')->mergeCells('J5:K6');
        $sheet->getColumnDimension('J')->setWidth(30);

        $sheet->setCellValue('L5', 'REALISASI')->mergeCells('L5:M6');
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->setCellValue('N5', 'Kesesuaian Sasaran dan Lokasi dgn RKPD')->mergeCells('N5:O6');
        $sheet->getColumnDimension('N')->setWidth(30);
        $sheet->setCellValue('P5', 'Kesesuaian Antara DPA SKPD dgn Petunjuk Teknis DAK')->mergeCells('P5:Q6');
        $sheet->getColumnDimension('P')->setWidth(30);
        $sheet->setCellValue('R5', 'Modifikasi Masalah')->mergeCells('R5:R7');
        $sheet->getColumnDimension('R')->setWidth(30);

        $sheet->setCellValue('D6', 'Satuan')->mergeCells('D6:D7')->getColumnDimension('D')->setWidth(8);
        $sheet->setCellValue('E6', 'Volume')->mergeCells('E6:E7')->getColumnDimension('E')->setWidth(12);
        $sheet->setCellValue('F6', 'Jml Peneriman Manfaat')->mergeCells('F6:F7')->getColumnDimension('F')->setWidth(12);
        $sheet->setCellValue('G6', 'Jumlah')->mergeCells('G6:I6')->getColumnDimension('G')->setWidth(12);
        
 
        $sheet->setCellValue('G7', 'Jumlah')->mergeCells('G7:G7')->getColumnDimension('G')->setWidth(12);
        $sheet->setCellValue('H7', 'Non Pendamping')->mergeCells('H7:H7')->getColumnDimension('H')->setWidth(12);
        $sheet->setCellValue('I7', 'Total Biaya')->mergeCells('I7:I7')->getColumnDimension('I')->setWidth(12);

        $sheet->setCellValue('J7', 'Swakelola')->mergeCells('J7:J7')->getColumnDimension('J')->setWidth(12);
        $sheet->setCellValue('K7', 'Kontrak')->mergeCells('K7:K7')->getColumnDimension('K')->setWidth(12);
        
        $sheet->setCellValue('L7', 'Fisik (%)')->mergeCells('L7:L7')->getColumnDimension('L')->setWidth(12);
        $sheet->setCellValue('M7', 'Keuangan (Rp)')->mergeCells('M7:M7')->getColumnDimension('M')->setWidth(12);
        
        $sheet->setCellValue('N7', 'Ya')->mergeCells('N7:N7')->getColumnDimension('N')->setWidth(12);
        $sheet->setCellValue('O7', 'Tidak')->mergeCells('O7:O7')->getColumnDimension('O')->setWidth(12);
        $sheet->setCellValue('P7', 'Ya')->mergeCells('P7:P7')->getColumnDimension('P')->setWidth(12);
        $sheet->setCellValue('Q7', 'Tidak')->mergeCells('Q7:Q7')->getColumnDimension('Q')->setWidth(12);


        $sheet->getStyle('A:R')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:R7')->getFont()->setBold(true);

        $cell = 8;
        $tot_swakelola=0;
        $tot_kontrak=0;
        $tot_fisik=0;
        $tot_fisik_keseluruhan=0;
        $tot_keuangan=0;
        $tot_penerima_manfaat=0;

        $total_anggaran_dak=0;
        $total_pendampingan=0;
        $total_total_biaya=0;
        $i=0;
        $no_program=0;
		$kp=0;
        foreach ($data AS $index => $row){
            if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
                $i++;

                // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));
                // $sheet->setCellValue('B' . $cell, $row->kode_program_baru);
                // $sheet->setCellValue('C' . $cell, $row->nama_program);
                // $sheet->setCellValue('D' . $cell, '');
                // $sheet->setCellValue('E' . $cell, '');
                // $sheet->setCellValue('F' . $cell, '');
                // $sheet->setCellValue('G' . $cell, '');
                // $sheet->setCellValue('H' . $cell, '');
                // $sheet->setCellValue('I' . $cell, '');
                // $sheet->setCellValue('J' . $cell, '');
                // $sheet->setCellValue('K' . $cell, '');
                // $sheet->setCellValue('L' . $cell, '');
                // $sheet->setCellValue('M' . $cell, '');
                // $sheet->setCellValue('N' . $cell, '');
                // $sheet->setCellValue('O' . $cell, '');
                // $sheet->setCellValue('P' . $cell, '');
                // $sheet->setCellValue('Q' . $cell, '');
                // $sheet->setCellValue('R' . $cell, '');
                // $sheet->getStyle('B' . $cell . ':R' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
                // $cell++;
                foreach($row->Kegiatan AS $kegiatan){
                    if ($kegiatan){
                        // $sheet->setCellValue('B' . $cell, $kegiatan->kode_kegiatan_baru);
                        // $sheet->setCellValue('C' . $cell, $kegiatan->nama_kegiatan);
                        // $sheet->setCellValue('D' . $cell,'');
                        // $sheet->setCellValue('E' . $cell, '');
                        // $sheet->setCellValue('F' . $cell, '');
                        // $sheet->setCellValue('G' . $cell, '');
                        // $sheet->setCellValue('H' . $cell, '');
                        // $sheet->setCellValue('I' . $cell, '');
                        // $sheet->setCellValue('J' . $cell, '');
                        // $sheet->setCellValue('K' . $cell, '');
                        // $sheet->setCellValue('L' . $cell, '');
                        // $sheet->setCellValue('M' . $cell, '');
                        // $sheet->setCellValue('N' . $cell, '');
                        // $sheet->setCellValue('O' . $cell, '');
                        // $sheet->setCellValue('P' . $cell, '');
                        // $sheet->setCellValue('Q' . $cell, '');
                        // $sheet->setCellValue('R' . $cell, '');
                        // $sheet->getStyle('B' . $cell . ':R' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                        // $cell++;
                        $kp=1;
                        foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
                            // $tot_swakelola=0;
                            // $tot_kontrak=0;
                            // $tot_fisik=0;
                            // $tot_keuangan=0;
                            // $tot_penerima_manfaat=0;

                            // $total_anggaran_dak=0;
                            // $total_pendampingan=0;
                            // $total_total_biaya=0;
                            $kp=1;
                            

                            $sheet->setCellValue('A' . $cell, $i);
                            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan);
                            $sheet->setCellValue('C' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan);
                            $sheet->setCellValue('D' . $cell,'');
                            $sheet->setCellValue('E' . $cell, '');
                            $sheet->setCellValue('F' . $cell, '');
                            $sheet->setCellValue('G' . $cell, '');
                            $sheet->setCellValue('H' . $cell, '');
                            $sheet->setCellValue('I' . $cell, '');
                            $sheet->setCellValue('J' . $cell, '');
                            $sheet->setCellValue('K' . $cell, '');
                            $sheet->setCellValue('L' . $cell, '');
                            $sheet->setCellValue('M' . $cell, '');
                            $sheet->setCellValue('N' . $cell, '');
                            $sheet->setCellValue('O' . $cell, '');
                            $sheet->setCellValue('P' . $cell, '');
                            $sheet->setCellValue('Q' . $cell, '');
                            $sheet->setCellValue('R' . $cell, '');
                            $sheet->getStyle('B' . $cell . ':R' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                            $sheet->getStyle('B' . $cell . ':R' . $cell)->getFont()->setBold(true);
                            $cell++;
							
                            foreach($dpa->SumberDanaDpa AS $sumber_dana){
                                
                                foreach($sumber_dana->PaketDak AS $paket_dak){
                                    $tot_swakelola+=$paket_dak->swakelola;
                                    $tot_kontrak+=$paket_dak->kontrak;
                                    $tot_penerima_manfaat+=$paket_dak->penerima_manfaat;
                                    
                                    $anggaran_dak=$paket_dak->anggaran_dak;
                                    $pendampingan=$paket_dak->pendampingan;
                                    $total_biaya=$anggaran_dak+$pendampingan;

                                    $total_anggaran_dak+=$anggaran_dak;
                                    $total_pendampingan+=$pendampingan;
                                    $total_total_biaya+=$total_biaya;

                                    $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan.'.'.sprintf("%02d", $kp++));
                                    $sheet->setCellValue('C' . $cell, $paket_dak->nama_paket);
                                    $sheet->setCellValue('D' . $cell,$paket_dak->satuan);
                                    $sheet->setCellValue('E' . $cell,$paket_dak->volume);
                                    $sheet->setCellValue('F' . $cell, $paket_dak->penerima_manfaat);
                                    $sheet->setCellValue('G' . $cell, $anggaran_dak);
                                    $sheet->setCellValue('H' . $cell, $pendampingan);
                                    $sheet->setCellValue('I' . $cell, $total_biaya);
                                    $sheet->setCellValue('J' . $cell, ($paket_dak->swakelola));
                                    $sheet->setCellValue('K' . $cell, ($paket_dak->kontrak));

                                    $realisasi=$paket_dak->RealisasiDak->where('periode','<=',$periode_selected);
                                    $fisik=$realisasi->sum('realisasi_fisik');
                                    $keuangan=$realisasi->sum('realisasi_keuangan');
                                    $tot_fisik+=$fisik;
                                    $tot_keuangan+=$keuangan;
                                    $real_data=$paket_dak->RealisasiDak->where('periode',$periode_selected);
                                    $kes_rkpd=$paket_dak->kesesuaian_rkpd;
                                    $kes_skpd=$paket_dak->kesesuaian_dpa_skpd;
                                    $permasalahan=$real_data->first()->permasalahan;


                                    $sheet->setCellValue('L' . $cell, ($fisik));
                                    $sheet->setCellValue('M' . $cell, ($keuangan));
                                    if($kes_rkpd=='Y'){
                                        $sheet->setCellValue('N' . $cell, 'V');
                                        $sheet->setCellValue('O' . $cell, '');
                                    }else{
                                        $sheet->setCellValue('N' . $cell, '');
                                        $sheet->setCellValue('O' . $cell, 'V');
                                    }
                                    if($kes_skpd=='Y'){
                                        $sheet->setCellValue('P' . $cell, 'V');
                                        $sheet->setCellValue('Q' . $cell, '');
                                    }else{
                                        $sheet->setCellValue('P' . $cell, '');
                                        $sheet->setCellValue('Q' . $cell, 'V');
                                    }
                                    
                                    $sheet->setCellValue('R' . $cell, $permasalahan);
                                    $cell++;

                                }
                                
                            }
                        }
                    }
                }
            }
        }

        $sheet->getStyle('A1:R' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:R' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('B8:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C8:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('G8:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('H8:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('I8:I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('J8:J' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('K8:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('D8:D' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F8:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J8:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('K8:K' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('M8:M' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G8:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H8:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('I8:I' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $tot_fisik_keseluruhan=round(($tot_fisik/($kp+1)),2);

        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell,'');
        $sheet->setCellValue('D' . $cell,'');
        $sheet->setCellValue('E' . $cell, '');
        $sheet->setCellValue('F' . $cell, $tot_penerima_manfaat);
        $sheet->setCellValue('G' . $cell, $total_anggaran_dak);
        $sheet->setCellValue('H' . $cell, $total_pendampingan);
        $sheet->setCellValue('I' . $cell, $total_total_biaya);
        $sheet->setCellValue('J' . $cell, ($tot_swakelola));
        $sheet->setCellValue('K' . $cell, ($tot_kontrak));
        $sheet->setCellValue('L' . $cell, ($tot_fisik_keseluruhan));
        $sheet->setCellValue('M' . $cell, ($tot_keuangan));
        $sheet->setCellValue('N' . $cell, '');
        $sheet->setCellValue('O' . $cell, '');
        $sheet->setCellValue('P' . $cell, '');
        $sheet->setCellValue('Q' . $cell, '');
        $sheet->setCellValue('R' . $cell, '');
        $sheet->getStyle('A' . $cell . ':R' . $cell)->getFont()->setBold(true);
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

        $sheet->getStyle('A5:R' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('O' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('O'.$cell.':Q'.$cell);
        $sheet->getStyle('O' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('O' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('O'.$cell.':Q'.$cell);
        $sheet->getStyle('O' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('O' . ++$cell, request('nama',''))->mergeCells('O'.$cell.':Q'.$cell);
        $sheet->getStyle('O' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('O' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('O'.$cell.':Q'.$cell);
        $sheet->getStyle('O' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('O' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('O'.$cell.':Q'.$cell);
        $sheet->getStyle('O' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.xlsx"');
            
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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

    public function export_kemajuan_dak_semua($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('AFILA')
        ->setLastModifiedBy('AFILA')
        ->setTitle('KEMAJUAN DAK DINAS '.$dinas.'')
        ->setSubject('KEMAJUAN DAK DINAS '.$dinas.'')
        ->setDescription('KEMAJUAN DAK DINAS '.$dinas.'')
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
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

        //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $profile = ProfileDaerah::first();
        // Header Text
        $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', 'SUMBER DANA DAK FISIK & NON FISIK DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
        $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
        $sheet->mergeCells('A1:M1');
        $sheet->mergeCells('A2:M2');
        $sheet->mergeCells('A3:M3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C5', 'PERENCANAAN KEGIATAN')->mergeCells('C5:D5');
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->setCellValue('E5', 'BOBOT(%)')->mergeCells('E5:E6');
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->setCellValue('F5', 'PELAKSANAAN KEGIATAN')->mergeCells('F5:G5');
        $sheet->getColumnDimension('F')->setWidth(40);
        $sheet->setCellValue('H5', 'REALISASI')->mergeCells('H5:J5');
        $sheet->getColumnDimension('H')->setWidth(60);
        $sheet->setCellValue('K5', 'REALISASI TERTIMBANG')->mergeCells('K5:L5');
        $sheet->getColumnDimension('K')->setWidth(40);
        $sheet->setCellValue('M5', 'KET')->mergeCells('M5:M6');
        $sheet->getColumnDimension('M')->setWidth(40);

        $sheet->setCellValue('C6', 'DAK(Rp)')->getColumnDimension('C')->setWidth(20);
        $sheet->setCellValue('D6', 'Pendampingan(Rp)')->getColumnDimension('D')->setWidth(20);

        $sheet->setCellValue('F6', 'Swakelola(Rp)')->getColumnDimension('F')->setWidth(20);
        $sheet->setCellValue('G6', 'Kontrak(Rp)')->getColumnDimension('G')->setWidth(20);

        $sheet->setCellValue('H6', 'Keuangan(Rp)')->getColumnDimension('H')->setWidth(20);
        $sheet->setCellValue('I6', 'Fisik(Rp)')->getColumnDimension('I')->setWidth(20);
        $sheet->setCellValue('J6', 'Keuangan(%)')->getColumnDimension('J')->setWidth(20);

        $sheet->setCellValue('K6', 'Fisik(Rp)')->getColumnDimension('K')->setWidth(20);
        $sheet->setCellValue('L6', 'Keuangan(%)')->getColumnDimension('L')->setWidth(20);

        $sheet->getStyle('A:M')->getAlignment()->setIndent(1)->setWrapText(true);
        $sheet->getStyle('A1:M6')->getFont()->setBold(true);

        $cell = 7;
        $total_bobot = 0;
        $total_kegiatan = 0;
        $jumlah_kegiatan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        $total_dak_keseluruhan=0;
        $total_pendampingan_keseluruhan=0;
        $total_swakelola_keseluruhan=0;
        $total_kontrak_keseluruhan=0;
        $total_fisik_keseluruhan=0;
        $total_keuangan_keseluruhan=0;
        $total_keuangan_persen=0;
        $total_tertimbang_keu=0;
        $total_tertimbang_fis=0;
        foreach ($data AS $index => $row) {
            $jumlah_kegiatan++;
            $dpa_bobot = 0;
            $dpa_fisik = 0;
            $dpa_keuangan = 0;
            $jumlah_kegiatan_dpa = 0;
            $dpa_tertimbang_fisik = 0;
            $dpa_tertimbang_keuangan = 0;
            $dpa_total_pagu = 0;
            $dpa_realisasi_keuangan = 0;

            $total_dak[$index]=0;
            $total_pendampingan[$index]=0;
            $total_swakelola[$index]=0;
            $total_kontrak[$index]=0;
            $total_fisik[$index]=0;
            $total_keuangan[$index]=0;
            foreach($row->Dpa As $dpa){
                foreach($dpa->SumberDanaDpa AS $sumber_dana){
                    foreach($sumber_dana->PaketDak AS $paket_dak){
                        $total_dak[$index]+=$paket_dak->anggaran_dak;
                        $total_pendampingan[$index]+=$paket_dak->pendampingan;
                        $total_swakelola[$index]+=$paket_dak->swakelola;
                        $total_kontrak[$index]+=$paket_dak->kontrak;

                        $realisasi=$paket_dak->RealisasiDak->where('periode','<=',$periode_selected);
                        $fisik=$realisasi->sum('realisasi_fisik');
                        $keuangan=$realisasi->sum('realisasi_keuangan');

                        $total_fisik[$index]+=$fisik;
                        $total_keuangan[$index]+=$keuangan;
                    }
                }
            }
            $total_dak_keseluruhan+=$total_dak[$index];
            $total_pendampingan_keseluruhan+=$total_pendampingan[$index];
            $total_swakelola_keseluruhan+=$total_swakelola[$index];
            $total_kontrak_keseluruhan+=$total_kontrak[$index];
            $total_fisik_keseluruhan+=$total_fisik[$index];
            $total_keuangan_keseluruhan+=$total_keuangan[$index];

            
        }


        foreach ($data AS $index => $row){
            $total_per_kegiatan_keseluruhan=($total_dak_keseluruhan+$total_pendampingan_keseluruhan);
            if(!$total_per_kegiatan_keseluruhan){$total_per_kegiatan_keseluruhan=1;}
            $total_per_kegiatan=($total_dak[$index]+$total_pendampingan[$index]);
            if(!$total_per_kegiatan){$total_per_kegiatan=0;}

            $bobot=($total_per_kegiatan/$total_per_kegiatan_keseluruhan)*100;
            $total_bobot+=$bobot;
            if($total_keuangan_keseluruhan==0){
                $total_keuangan_keseluruhan=1;
            }
            if($total_fisik_keseluruhan==0){
                $total_fisik_keseluruhan=1;
            }
            $keuangan_persen=($total_keuangan[$index]/$total_keuangan_keseluruhan)*100;
            $total_keuangan_persen+=$keuangan_persen;

            $tertimbang_keu=($total_keuangan[$index]/$total_per_kegiatan_keseluruhan)*100;
            $total_tertimbang_keu+=$tertimbang_keu;
            $tertimbang_fisik=($total_fisik[$index]/$total_fisik_keseluruhan)*100;
            $total_tertimbang_fis+=$tertimbang_fisik;

            $sheet->setCellValue('A' . $cell, $cell - 6);

                
            $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
            $sheet->setCellValue('C' . $cell, ($total_dak[$index]));
            $sheet->setCellValue('D' . $cell, ($total_pendampingan[$index]));
            $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($bobot,2));
            $sheet->setCellValue('F' . $cell, ($total_swakelola[$index]));
            $sheet->setCellValue('G' . $cell, ($total_kontrak[$index]));
            $sheet->setCellValue('H' . $cell, ($total_keuangan[$index]));
            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_fisik[$index],2));
            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($keuangan_persen,2));
            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2));
            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($tertimbang_keu,2));
            $sheet->setCellValue('M' . $cell, '-');
            $cell++;
        }

        $sheet->getStyle('A1:M' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('D7:D' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('E7:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G7:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H7:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('I7:I' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J7:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('K7:K' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L7:L' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('M7:M' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('N7:N' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('O7:O' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total

        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell, ($total_dak_keseluruhan));
        $sheet->setCellValue('D' . $cell, ($total_pendampingan_keseluruhan));
        $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('F' . $cell, ($total_swakelola_keseluruhan));
        $sheet->setCellValue('G' . $cell, ($total_kontrak_keseluruhan));
        $sheet->setCellValue('H' . $cell, ($total_keuangan_keseluruhan));
        $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_fisik_keseluruhan,2));
        $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_keuangan_persen,2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_fis,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($total_tertimbang_keu,2));
        $sheet->getStyle('A' . $cell . ':M' . $cell)->getFont()->setBold(true);
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

        $sheet->getStyle('A5:M' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="KEMAJUAN.xlsx"');
        }else{
          $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&H'.url()->current());
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

	
	
    public function export_semua($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator('AFILA')
        ->setLastModifiedBy('AFILA')
        ->setTitle('REALISASI DINAS '.$dinas.'')
        ->setSubject('REALISASI DINAS '.$dinas.'')
        ->setDescription('REALISASI DINAS '.$dinas.'')
        ->setKeywords('pdf php')
        ->setCategory('REALISASI');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

        //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $profile = ProfileDaerah::first();
        // Header Text
        $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', 'SUMBER DANA APBN, APBD I, APBD II, DAK & PEN DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
        $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('A2:N2');
        $sheet->mergeCells('A3:N3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
        $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
        $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
        $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

        $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
        $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
        $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
        $sheet->getStyle('A1:L6')->getFont()->setBold(true);

        $cell = 7;
		$total_data = 0;
		$total_anggaran = 0;
		$total_kegiatan = 0;
        $total_bobot = 0;
		$total_realisasi = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        foreach ($data AS $index => $row) {
			$dpa_anggaran = 0;
			$dpa_kegiatan = 0;
			$dpa_bobot = 0;
			$dpa_realisasi = 0;
			$dpa_fisik = 0;
			$dpa_total_fisik = 0;
			$dpa_total_keuangan = 0;
			$bobot = 0;
			$dpa_tertimbang_fisik = 0;
			$dpa_tertimbang_keuangan = 0;
			
			foreach($row->Dpa As $DPA1){
                $dpa_anggaran += $DPA1->nilai_pagu_dpa;
            }
			
            foreach($row->Dpa As $dpa){
				$dpa_kegiatan ++;
				$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
				$dpa_realisasi += $dpa->realisasi_keuangan;
				$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
				$dpa_bobot+= $bobot;
				
            }
			
            
			
            if($dpa_anggaran==0){
                continue;
            }
			else
			{
				$total_data++;
				$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
				$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;
			
				$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
				$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;
			
			
				$total_anggaran += $dpa_anggaran;
				$total_kegiatan += $dpa_kegiatan;
				$total_bobot += $dpa_bobot;
				$total_realisasi += $dpa_realisasi;
				$total_fisik += $dpa_total_fisik;
				$total_keuangan += $dpa_total_keuangan;
				$total_tertimbang_fisik += $dpa_tertimbang_fisik;
				$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
			}

            $sheet->setCellValue('A' . $cell, $total_data);
            $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
            $sheet->setCellValue('C' . $cell, $dpa_anggaran);
            $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
            $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
            $sheet->setCellValue('F' . $cell, $dpa_realisasi);
            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
            $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
            $sheet->setCellValue('K' . $cell, $row->nama_kepala);
            $sheet->setCellValue('L' . $cell, '-');
            $cell++;
        }

        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell, $total_anggaran);
        $sheet->setCellValue('D' . $cell, $total_kegiatan);
        $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('F' . $cell, $total_realisasi);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
        $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
        $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
		$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
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
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI.xlsx"');
        }else{
          $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&H'.url()->current());
          $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B &RPage &P of &N');
          $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
          $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
          \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
          header('Content-Type: application/pdf');
          // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
          header('Cache-Control: max-age=0');
          $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }
        $writer->save('php://output');
    }

    public function export_apbn($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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

        $profile = ProfileDaerah::first();
        // Header Text
        $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', 'SUMBER DANA APBN DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
        $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->mergeCells('A3:L3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
        $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
        $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
        $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

        $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
        $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
        $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
        $sheet->getStyle('A1:L6')->getFont()->setBold(true);

        $cell = 7;
		$total_data = 0;
		$total_anggaran = 0;
		$total_kegiatan = 0;
        $total_bobot = 0;
		$total_realisasi = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        foreach ($data AS $index => $row) {
			$dpa_anggaran = 0;
			$dpa_kegiatan = 0;
			$dpa_bobot = 0;
			$dpa_realisasi = 0;
			$dpa_fisik = 0;
			$dpa_total_fisik = 0;
			$dpa_total_keuangan = 0;
			$bobot = 0;
			$dpa_tertimbang_fisik = 0;
			$dpa_tertimbang_keuangan = 0;
			
			foreach($row->Dpa As $DPA1){
                $dpa_anggaran += $DPA1->nilai_pagu_dpa;
            }
			
            foreach($row->Dpa As $dpa){
				$dpa_kegiatan ++;
				$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
				$dpa_realisasi += $dpa->realisasi_keuangan;
				$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
				$dpa_bobot+= $bobot;
				
            }
			
            
			
            if($dpa_anggaran==0){
                continue;
            }
			else
			{
				$total_data++;
				$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
				$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;
			
				$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
				$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;
			
			
				$total_anggaran += $dpa_anggaran;
				$total_kegiatan += $dpa_kegiatan;
				$total_bobot += $dpa_bobot;
				$total_realisasi += $dpa_realisasi;
				$total_fisik += $dpa_total_fisik;
				$total_keuangan += $dpa_total_keuangan;
				$total_tertimbang_fisik += $dpa_tertimbang_fisik;
				$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
			}

            $sheet->setCellValue('A' . $cell, $total_data);
            $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
            $sheet->setCellValue('C' . $cell, $dpa_anggaran);
            $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
            $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
            $sheet->setCellValue('F' . $cell, $dpa_realisasi);
            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
            $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
            $sheet->setCellValue('K' . $cell, $row->nama_kepala);
            $sheet->setCellValue('L' . $cell, '-');
            $cell++;
        }

        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell, $total_anggaran);
        $sheet->setCellValue('D' . $cell, $total_kegiatan);
        $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('F' . $cell, $total_realisasi);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
        $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
        $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
		$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
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
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // $spreadsheet->getActiveSheet()->getStyle('A:L')->getAlignment()->setIndent(9);

        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI APBN.xlsx"');
        }else{
            $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&H'.url()->current());
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

    public function export_pen($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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

        $profile = ProfileDaerah::first();
        // Header Text
        $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', 'SUMBER DANA PEN DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
        $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->mergeCells('A3:L3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
        $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
        $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
        $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

        $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
        $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
        $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
        $sheet->getStyle('A1:L6')->getFont()->setBold(true);

        $cell = 7;
		$total_data = 0;
		$total_anggaran = 0;
		$total_kegiatan = 0;
        $total_bobot = 0;
		$total_realisasi = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        foreach ($data AS $index => $row) {
			$dpa_anggaran = 0;
			$dpa_kegiatan = 0;
			$dpa_bobot = 0;
			$dpa_realisasi = 0;
			$dpa_fisik = 0;
			$dpa_total_fisik = 0;
			$dpa_total_keuangan = 0;
			$bobot = 0;
			$dpa_tertimbang_fisik = 0;
			$dpa_tertimbang_keuangan = 0;
			
			foreach($row->Dpa As $DPA1){
                $dpa_anggaran += $DPA1->nilai_pagu_dpa;
            }
			
            foreach($row->Dpa As $dpa){
				$dpa_kegiatan ++;
				$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
				$dpa_realisasi += $dpa->realisasi_keuangan;
				$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
				$dpa_bobot+= $bobot;
				
            }
			
            
			
            if($dpa_anggaran==0){
                continue;
            }
			else
			{
				$total_data++;
				$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
				$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;
			
				$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
				$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;
			
			
				$total_anggaran += $dpa_anggaran;
				$total_kegiatan += $dpa_kegiatan;
				$total_bobot += $dpa_bobot;
				$total_realisasi += $dpa_realisasi;
				$total_fisik += $dpa_total_fisik;
				$total_keuangan += $dpa_total_keuangan;
				$total_tertimbang_fisik += $dpa_tertimbang_fisik;
				$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
			}

            $sheet->setCellValue('A' . $cell, $total_data);
            $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
            $sheet->setCellValue('C' . $cell, $dpa_anggaran);
            $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
            $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
            $sheet->setCellValue('F' . $cell, $dpa_realisasi);
            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
            $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
            $sheet->setCellValue('K' . $cell, $row->nama_kepala);
            $sheet->setCellValue('L' . $cell, '-');
            $cell++;
        }

        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell, $total_anggaran);
        $sheet->setCellValue('D' . $cell, $total_kegiatan);
        $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('F' . $cell, $total_realisasi);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
        $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
        $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
		$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
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
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        // $spreadsheet->getActiveSheet()->getStyle('A:L')->getAlignment()->setIndent(9);

        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI APBN.xlsx"');
        }else{
            $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&H'.url()->current());
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

    public function export_apbd_i($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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

        $profile = ProfileDaerah::first();
        // Header Text
        $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', 'SUMBER DANA APBD I DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
        $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->mergeCells('A3:L3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
        $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
        $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
        $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

        $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
        $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
        $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
        $sheet->getStyle('A1:L6')->getFont()->setBold(true);

        $cell = 7;
		$total_data = 0;
		$total_anggaran = 0;
		$total_kegiatan = 0;
        $total_bobot = 0;
		$total_realisasi = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        foreach ($data AS $index => $row) {
			$dpa_anggaran = 0;
			$dpa_kegiatan = 0;
			$dpa_bobot = 0;
			$dpa_realisasi = 0;
			$dpa_fisik = 0;
			$dpa_total_fisik = 0;
			$dpa_total_keuangan = 0;
			$bobot = 0;
			$dpa_tertimbang_fisik = 0;
			$dpa_tertimbang_keuangan = 0;
			
			foreach($row->Dpa As $DPA1){
                $dpa_anggaran += $DPA1->nilai_pagu_dpa;
            }
			
            foreach($row->Dpa As $dpa){
				$dpa_kegiatan ++;
				$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
				$dpa_realisasi += $dpa->realisasi_keuangan;
				$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
				$dpa_bobot+= $bobot;
				
            }
			
            
			
            if($dpa_anggaran==0){
                continue;
            }
			else
			{
				$total_data++;
				$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
				$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;
			
				$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
				$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;
			
			
				$total_anggaran += $dpa_anggaran;
				$total_kegiatan += $dpa_kegiatan;
				$total_bobot += $dpa_bobot;
				$total_realisasi += $dpa_realisasi;
				$total_fisik += $dpa_total_fisik;
				$total_keuangan += $dpa_total_keuangan;
				$total_tertimbang_fisik += $dpa_tertimbang_fisik;
				$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
			}

            $sheet->setCellValue('A' . $cell, $total_data);
            $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
            $sheet->setCellValue('C' . $cell, $dpa_anggaran);
            $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
            $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
            $sheet->setCellValue('F' . $cell, $dpa_realisasi);
            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
            $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
            $sheet->setCellValue('K' . $cell, $row->nama_kepala);
            $sheet->setCellValue('L' . $cell, '-');
            $cell++;
        }

        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell, $total_anggaran);
        $sheet->setCellValue('D' . $cell, $total_kegiatan);
        $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('F' . $cell, $total_realisasi);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
        $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
        $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
		$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
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
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI APBD I.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }

    public function export_apbd_ii($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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

        $profile = ProfileDaerah::first();
        // Header Text
        $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', 'SUMBER DANA APBD II DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
        $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->mergeCells('A3:L3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
        $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
        $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
        $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

        $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
        $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
        $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
        $sheet->getStyle('A1:L6')->getFont()->setBold(true);

        $cell = 7;
		$total_data = 0;
		$total_anggaran = 0;
		$total_kegiatan = 0;
        $total_bobot = 0;
		$total_realisasi = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        foreach ($data AS $index => $row) {
			$dpa_anggaran = 0;
			$dpa_kegiatan = 0;
			$dpa_bobot = 0;
			$dpa_realisasi = 0;
			$dpa_fisik = 0;
			$dpa_total_fisik = 0;
			$dpa_total_keuangan = 0;
			$bobot = 0;
			$dpa_tertimbang_fisik = 0;
			$dpa_tertimbang_keuangan = 0;
			
			foreach($row->Dpa As $DPA1){
                $dpa_anggaran += $DPA1->nilai_pagu_dpa;
            }
			
            foreach($row->Dpa As $dpa){
				$dpa_kegiatan ++;
				$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
				$dpa_realisasi += $dpa->realisasi_keuangan;
				$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
				$dpa_bobot+= $bobot;
				
            }
			
            
			
            if($dpa_anggaran==0){
                continue;
            }
			else
			{
				$total_data++;
				$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
				$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;
			
				$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
				$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;
			
			
				$total_anggaran += $dpa_anggaran;
				$total_kegiatan += $dpa_kegiatan;
				$total_bobot += $dpa_bobot;
				$total_realisasi += $dpa_realisasi;
				$total_fisik += $dpa_total_fisik;
				$total_keuangan += $dpa_total_keuangan;
				$total_tertimbang_fisik += $dpa_tertimbang_fisik;
				$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
			}

            $sheet->setCellValue('A' . $cell, $total_data);
            $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
            $sheet->setCellValue('C' . $cell, $dpa_anggaran);
            $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
            $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
            $sheet->setCellValue('F' . $cell, $dpa_realisasi);
            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
            $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
            $sheet->setCellValue('K' . $cell, $row->nama_kepala);
            $sheet->setCellValue('L' . $cell, '-');
            $cell++;
        }

        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell, $total_anggaran);
        $sheet->setCellValue('D' . $cell, $total_kegiatan);
        $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('F' . $cell, $total_realisasi);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
        $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
        $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
		$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
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
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI APBD II.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }

    public function export_dak_fisik($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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

        $profile = ProfileDaerah::first();
        // Header Text
        $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', 'SUMBER DANA DAK FISIK DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
        $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->mergeCells('A3:L3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
        $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
        $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
        $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

        $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
        $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
        $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
        $sheet->getStyle('A1:L6')->getFont()->setBold(true);

        $cell = 7;
		$total_data = 0;
		$total_anggaran = 0;
		$total_kegiatan = 0;
        $total_bobot = 0;
		$total_realisasi = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        foreach ($data AS $index => $row) {
			$dpa_anggaran = 0;
			$dpa_kegiatan = 0;
			$dpa_bobot = 0;
			$dpa_realisasi = 0;
			$dpa_fisik = 0;
			$dpa_total_fisik = 0;
			$dpa_total_keuangan = 0;
			$bobot = 0;
			$dpa_tertimbang_fisik = 0;
			$dpa_tertimbang_keuangan = 0;
			
			foreach($row->Dpa As $DPA1){
                $dpa_anggaran += $DPA1->nilai_pagu_dpa;
            }
			
            foreach($row->Dpa As $dpa){
				$dpa_kegiatan ++;
				$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
				$dpa_realisasi += $dpa->realisasi_keuangan;
				$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
				$dpa_bobot+= $bobot;
				
            }
			
            
			
            if($dpa_anggaran==0){
                continue;
            }
			else
			{
				$total_data++;
				$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
				$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;
			
				$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
				$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;
			
			
				$total_anggaran += $dpa_anggaran;
				$total_kegiatan += $dpa_kegiatan;
				$total_bobot += $dpa_bobot;
				$total_realisasi += $dpa_realisasi;
				$total_fisik += $dpa_total_fisik;
				$total_keuangan += $dpa_total_keuangan;
				$total_tertimbang_fisik += $dpa_tertimbang_fisik;
				$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
			}

            $sheet->setCellValue('A' . $cell, $total_data);
            $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
            $sheet->setCellValue('C' . $cell, $dpa_anggaran);
            $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
            $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
            $sheet->setCellValue('F' . $cell, $dpa_realisasi);
            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
            $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
            $sheet->setCellValue('K' . $cell, $row->nama_kepala);
            $sheet->setCellValue('L' . $cell, '-');
            $cell++;
        }

        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell, $total_anggaran);
        $sheet->setCellValue('D' . $cell, $total_kegiatan);
        $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('F' . $cell, $total_realisasi);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
        $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
        $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
		$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
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
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI DAK FISIK.xlsx"');
        }else{
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }
        $writer->save('php://output');
    }

    public function export_dak_non_fisik($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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

        $profile = ProfileDaerah::first();
        // Header Text
        $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', 'SUMBER DANA DAK NON FISIK DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
        $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->mergeCells('A3:L3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
        $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
        $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
        $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

        $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
        $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
        $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
        $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
        $sheet->getStyle('A1:L6')->getFont()->setBold(true);

        $cell = 7;
		$total_data = 0;
		$total_anggaran = 0;
		$total_kegiatan = 0;
        $total_bobot = 0;
		$total_realisasi = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        foreach ($data AS $index => $row) {
			$dpa_anggaran = 0;
			$dpa_kegiatan = 0;
			$dpa_bobot = 0;
			$dpa_realisasi = 0;
			$dpa_fisik = 0;
			$dpa_total_fisik = 0;
			$dpa_total_keuangan = 0;
			$bobot = 0;
			$dpa_tertimbang_fisik = 0;
			$dpa_tertimbang_keuangan = 0;
			
			foreach($row->Dpa As $DPA1){
                $dpa_anggaran += $DPA1->nilai_pagu_dpa;
            }
			
            foreach($row->Dpa As $dpa){
				$dpa_kegiatan ++;
				$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
				$dpa_realisasi += $dpa->realisasi_keuangan;
				$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
				$dpa_bobot+= $bobot;
				
            }
			
            
			
            if($dpa_anggaran==0){
                continue;
            }
			else
			{
				$total_data++;
				$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
				$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;
			
				$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
				$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;
			
			
				$total_anggaran += $dpa_anggaran;
				$total_kegiatan += $dpa_kegiatan;
				$total_bobot += $dpa_bobot;
				$total_realisasi += $dpa_realisasi;
				$total_fisik += $dpa_total_fisik;
				$total_keuangan += $dpa_total_keuangan;
				$total_tertimbang_fisik += $dpa_tertimbang_fisik;
				$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
			}

            $sheet->setCellValue('A' . $cell, $total_data);
            $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
            $sheet->setCellValue('C' . $cell, $dpa_anggaran);
            $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
            $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
            $sheet->setCellValue('F' . $cell, $dpa_realisasi);
            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
            $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
            $sheet->setCellValue('K' . $cell, $row->nama_kepala);
            $sheet->setCellValue('L' . $cell, '-');
            $cell++;
        }

        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell, $total_anggaran);
        $sheet->setCellValue('D' . $cell, $total_kegiatan);
        $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('F' . $cell, $total_realisasi);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
        $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
        $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
		$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
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
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI DAK NON FISIK.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }

    //PARAM NO. REPORT 
    public function export_semua_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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
        $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
        $sheet->setCellValue('A3', 'SUMBER DANA APBN, APBD I, APBD II, DAK & PEN');
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('A2:N2');
        $sheet->mergeCells('A3:N3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'KODE')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->setCellValue('C5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(30);
		$sheet->setCellValue('D5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('D5:E5');
        $sheet->setCellValue('F5', 'JUMLAH DANA / DPA')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->setCellValue('G5', 'BOBOT')->mergeCells('G5:G6');
        $sheet->setCellValue('H5', 'REALISASI KEUANGAN (RP)')->mergeCells('H5:H6');
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->setCellValue('I5', 'REALISASI (%)')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'TERTIMBANG %')->mergeCells('K5:L5');
        $sheet->setCellValue('M5', 'PPTK/PELAKSANA')->mergeCells('M5:M6');
        $sheet->getColumnDimension('M')->setWidth(18);
        $sheet->setCellValue('N5', 'KET')->MergeCells('N5:N6');

		$sheet->setCellValue('D6', 'TOLAK UKUR')->getColumnDimension('D')->setWidth(15);
        $sheet->setCellValue('E6', 'SATUAN (UNIT)')->getColumnDimension('E')->setWidth(12);
        $sheet->setCellValue('I6', 'FISIK')->getColumnDimension('I')->setWidth(8);
        $sheet->setCellValue('J6', 'KEUANGAN')->getColumnDimension('J')->setWidth(12);
        $sheet->setCellValue('K6', 'FISIK (%)')->getColumnDimension('K')->setWidth(10);
        $sheet->setCellValue('L6', 'KEUANGAN (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:N')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:N6')->getFont()->setBold(true);

        $cell = 7;
        $total_bobot = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $jumlah_kegiatan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        $i=0;
        $no_program=0;
        foreach ($data AS $index => $row){
            if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
                $i++;

                // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));
                $sheet->setCellValue('A' . $cell, ++$no_program);
                $sheet->setCellValue('B' . $cell, $row->kode_program_baru);
                $sheet->setCellValue('C' . $cell, $row->nama_program);
                $sheet->setCellValue('D' . $cell, '');
                $sheet->setCellValue('E' . $cell, '');
                $sheet->setCellValue('F' . $cell, '');
                $sheet->setCellValue('G' . $cell, '');
                $sheet->setCellValue('H' . $cell, '');
                $sheet->setCellValue('I' . $cell, '');
                $sheet->setCellValue('J' . $cell, '');
                $sheet->setCellValue('K' . $cell, '');
                $sheet->setCellValue('L' . $cell, '');
                $sheet->setCellValue('M' . $cell, '');
                $sheet->setCellValue('N' . $cell, '');
                $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
                $cell++;
                $no_kegiatan=0;
                foreach($row->Kegiatan AS $kegiatan){
                    if ($kegiatan){
                        $sheet->setCellValue('A' . $cell, $no_program.'.'.++$no_kegiatan);
                        $sheet->setCellValue('B' . $cell, $kegiatan->kode_kegiatan_baru);
                        $sheet->setCellValue('C' . $cell, $kegiatan->nama_kegiatan);
                        $sheet->setCellValue('D' . $cell,'');
                        $sheet->setCellValue('E' . $cell, '');
                        $sheet->setCellValue('F' . $cell, '');
                        $sheet->setCellValue('G' . $cell, '');
                        $sheet->setCellValue('H' . $cell, '');
                        $sheet->setCellValue('I' . $cell, '');
                        $sheet->setCellValue('J' . $cell, '');
                        $sheet->setCellValue('K' . $cell, '');
                        $sheet->setCellValue('L' . $cell, '');
                        $sheet->setCellValue('M' . $cell, '');
                        $sheet->setCellValue('N' . $cell, '');
                        $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                        $cell++;
                        $no_sub_kegiatan=0;
                        foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
                            $total_fisik += $dpa->realisasi_fisik;
                            $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
                            $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
                            $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
                            $total_keuangan += $persentase_keuangan;
                            $total_tertimbang_fisik += $tertimbang_fisik;
                            $total_tertimbang_keuangan += $tertimbang_keuangan;
                            $jumlah_kegiatan++;
                            $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $sheet->setCellValue('A' . $cell, $no_program.'.'.$no_kegiatan.'.'.++$no_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('C' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("C$cell:C".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
                            $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
							$sheet->setCellValue('F' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('H' . $cell, $dpa->realisasi_keuangan)->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('M' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('N' . $cell, '')->mergeCells("N$cell:N".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $cell++;
                            for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
                                $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
                                $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
                                $cell++;
                            }
                            foreach($dpa->SumberDanaDpa AS $sumber_dana){
                                $sheet->setCellValue('B' . $cell, '');
                                $sheet->setCellValue('C' . $cell, $sumber_dana->jenis_belanja);
								$sheet->setCellValue('D' . $cell, '');
                                $sheet->setCellValue('E' . $cell, '');
                                $sheet->setCellValue('F' . $cell, $sumber_dana->nilai_pagu);
                                $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
                                $sheet->setCellValue('H' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
                                $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
                                $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
                                $sheet->setCellValue('K' . $cell, '');
                                $sheet->setCellValue('L' . $cell, '');
                                $sheet->setCellValue('M' . $cell, '');
                                $sheet->setCellValue('N' . $cell, '');
                                $cell++;
                            }
                        }
                    }
                }
            }
        }

        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D7:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('H7:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('M7:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('H7:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
		$sheet->setCellValue('D' . $cell, '');
        $sheet->setCellValue('E' . $cell, '');
        $sheet->setCellValue('F' . $cell, $total_pagu_keseluruhan);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('H' . $cell, $total_realisasi_keuangan);
        //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
        //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
        $sheet->setCellValue('M' . $cell, '');
        $sheet->setCellValue('N' . $cell, '');
        $sheet->getStyle('A' . $cell . ':N' . $cell)->getFont()->setBold(true);
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

        $sheet->getStyle('A5:N' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
		if (hasRole('admin')){
        } else if (hasRole('opd')){
            $sheet->setCellValue('L' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$cell = $cell+3;
			$sheet->setCellValue('L' . ++$cell, request('nama',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
        
        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI DINAS '.$dinas.'.xlsx"');
            
        }else{
            
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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

    public function export_apbn_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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
        $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
        $sheet->setCellValue('A3', 'SUMBER DANA APBN');
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('A2:N2');
        $sheet->mergeCells('A3:N3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'KODE')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->setCellValue('C5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(30);
		$sheet->setCellValue('D5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('D5:E5');
        $sheet->setCellValue('F5', 'JUMLAH DANA / DPA')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->setCellValue('G5', 'BOBOT')->mergeCells('G5:G6');
        $sheet->setCellValue('H5', 'REALISASI KEUANGAN (RP)')->mergeCells('H5:H6');
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->setCellValue('I5', 'REALISASI (%)')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'TERTIMBANG %')->mergeCells('K5:L5');
        $sheet->setCellValue('M5', 'PPTK/PELAKSANA')->mergeCells('M5:M6');
        $sheet->getColumnDimension('M')->setWidth(18);
        $sheet->setCellValue('N5', 'KET')->MergeCells('N5:N6');

		$sheet->setCellValue('D6', 'TOLAK UKUR')->getColumnDimension('D')->setWidth(15);
        $sheet->setCellValue('E6', 'SATUAN (UNIT)')->getColumnDimension('E')->setWidth(12);
        $sheet->setCellValue('I6', 'FISIK')->getColumnDimension('I')->setWidth(8);
        $sheet->setCellValue('J6', 'KEUANGAN')->getColumnDimension('J')->setWidth(12);
        $sheet->setCellValue('K6', 'FISIK (%)')->getColumnDimension('K')->setWidth(10);
        $sheet->setCellValue('L6', 'KEUANGAN (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:N')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:N6')->getFont()->setBold(true);

        $cell = 7;
        $total_bobot = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $jumlah_kegiatan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        $i=0;
        $no_program=0;
        foreach ($data AS $index => $row){
            if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
                $i++;

                // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));
                $sheet->setCellValue('A' . $cell, ++$no_program);
                $sheet->setCellValue('B' . $cell, $row->kode_program_baru);
                $sheet->setCellValue('C' . $cell, $row->nama_program);
                $sheet->setCellValue('D' . $cell, '');
                $sheet->setCellValue('E' . $cell, '');
                $sheet->setCellValue('F' . $cell, '');
                $sheet->setCellValue('G' . $cell, '');
                $sheet->setCellValue('H' . $cell, '');
                $sheet->setCellValue('I' . $cell, '');
                $sheet->setCellValue('J' . $cell, '');
                $sheet->setCellValue('K' . $cell, '');
                $sheet->setCellValue('L' . $cell, '');
                $sheet->setCellValue('M' . $cell, '');
                $sheet->setCellValue('N' . $cell, '');
                $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
                $cell++;
                $no_kegiatan=0;
                foreach($row->Kegiatan AS $kegiatan){
                    if ($kegiatan){
                        $sheet->setCellValue('A' . $cell, $no_program.'.'.++$no_kegiatan);
                        $sheet->setCellValue('B' . $cell, $kegiatan->kode_kegiatan_baru);
                        $sheet->setCellValue('C' . $cell, $kegiatan->nama_kegiatan);
                        $sheet->setCellValue('D' . $cell,'');
                        $sheet->setCellValue('E' . $cell, '');
                        $sheet->setCellValue('F' . $cell, '');
                        $sheet->setCellValue('G' . $cell, '');
                        $sheet->setCellValue('H' . $cell, '');
                        $sheet->setCellValue('I' . $cell, '');
                        $sheet->setCellValue('J' . $cell, '');
                        $sheet->setCellValue('K' . $cell, '');
                        $sheet->setCellValue('L' . $cell, '');
                        $sheet->setCellValue('M' . $cell, '');
                        $sheet->setCellValue('N' . $cell, '');
                        $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                        $cell++;
                        $no_sub_kegiatan=0;
                        foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
                            $total_fisik += $dpa->realisasi_fisik;
                            $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
                            $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
                            $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
                            $total_keuangan += $persentase_keuangan;
                            $total_tertimbang_fisik += $tertimbang_fisik;
                            $total_tertimbang_keuangan += $tertimbang_keuangan;
                            $jumlah_kegiatan++;
                            $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $sheet->setCellValue('A' . $cell, $no_program.'.'.$no_kegiatan.'.'.++$no_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('C' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("C$cell:C".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
                            $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
							$sheet->setCellValue('F' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('H' . $cell, $dpa->realisasi_keuangan)->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('M' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('N' . $cell, '')->mergeCells("N$cell:N".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $cell++;
                            for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
                                $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
                                $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
                                $cell++;
                            }
                            foreach($dpa->SumberDanaDpa AS $sumber_dana){
                                $sheet->setCellValue('B' . $cell, '');
                                $sheet->setCellValue('C' . $cell, $sumber_dana->jenis_belanja);
								$sheet->setCellValue('D' . $cell, '');
                                $sheet->setCellValue('E' . $cell, '');
                                $sheet->setCellValue('F' . $cell, $sumber_dana->nilai_pagu);
                                $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
                                $sheet->setCellValue('H' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
                                $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
                                $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
                                $sheet->setCellValue('K' . $cell, '');
                                $sheet->setCellValue('L' . $cell, '');
                                $sheet->setCellValue('M' . $cell, '');
                                $sheet->setCellValue('N' . $cell, '');
                                $cell++;
                            }
                        }
                    }
                }
            }
        }

        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D7:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('H7:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('M7:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('H7:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
		$sheet->setCellValue('D' . $cell, '');
        $sheet->setCellValue('E' . $cell, '');
        $sheet->setCellValue('F' . $cell, $total_pagu_keseluruhan);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('H' . $cell, $total_realisasi_keuangan);
        //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
        //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
        $sheet->setCellValue('M' . $cell, '');
        $sheet->setCellValue('N' . $cell, '');
        $sheet->getStyle('A' . $cell . ':N' . $cell)->getFont()->setBold(true);
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

        $sheet->getStyle('A5:N' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
		if (hasRole('admin')){
        } else if (hasRole('opd')){
            $sheet->setCellValue('L' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$cell = $cell+3;
			$sheet->setCellValue('L' . ++$cell, request('nama',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI APBN DINAS '.$dinas.'.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }

    //NEW PEN
    public function export_pen_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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
        $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
        $sheet->setCellValue('A3', 'SUMBER DANA PEN');
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('A2:N2');
        $sheet->mergeCells('A3:N3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'KODE')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->setCellValue('C5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(30);
		$sheet->setCellValue('D5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('D5:E5');
        $sheet->setCellValue('F5', 'JUMLAH DANA / DPA')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->setCellValue('G5', 'BOBOT')->mergeCells('G5:G6');
        $sheet->setCellValue('H5', 'REALISASI KEUANGAN (RP)')->mergeCells('H5:H6');
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->setCellValue('I5', 'REALISASI (%)')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'TERTIMBANG %')->mergeCells('K5:L5');
        $sheet->setCellValue('M5', 'PPTK/PELAKSANA')->mergeCells('M5:M6');
        $sheet->getColumnDimension('M')->setWidth(18);
        $sheet->setCellValue('N5', 'KET')->MergeCells('N5:N6');

		$sheet->setCellValue('D6', 'TOLAK UKUR')->getColumnDimension('D')->setWidth(15);
        $sheet->setCellValue('E6', 'SATUAN (UNIT)')->getColumnDimension('E')->setWidth(12);
        $sheet->setCellValue('I6', 'FISIK')->getColumnDimension('I')->setWidth(8);
        $sheet->setCellValue('J6', 'KEUANGAN')->getColumnDimension('J')->setWidth(12);
        $sheet->setCellValue('K6', 'FISIK (%)')->getColumnDimension('K')->setWidth(10);
        $sheet->setCellValue('L6', 'KEUANGAN (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:N')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:N6')->getFont()->setBold(true);

        $cell = 7;
        $total_bobot = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $jumlah_kegiatan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        $i=0;
        $no_program=0;
        foreach ($data AS $index => $row){
            if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
                $i++;

                // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));
                $sheet->setCellValue('A' . $cell, ++$no_program);
                $sheet->setCellValue('B' . $cell, $row->kode_program_baru);
                $sheet->setCellValue('C' . $cell, $row->nama_program);
                $sheet->setCellValue('D' . $cell, '');
                $sheet->setCellValue('E' . $cell, '');
                $sheet->setCellValue('F' . $cell, '');
                $sheet->setCellValue('G' . $cell, '');
                $sheet->setCellValue('H' . $cell, '');
                $sheet->setCellValue('I' . $cell, '');
                $sheet->setCellValue('J' . $cell, '');
                $sheet->setCellValue('K' . $cell, '');
                $sheet->setCellValue('L' . $cell, '');
                $sheet->setCellValue('M' . $cell, '');
                $sheet->setCellValue('N' . $cell, '');
                $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
                $cell++;
                $no_kegiatan=0;
                foreach($row->Kegiatan AS $kegiatan){
                    if ($kegiatan){
                        $sheet->setCellValue('A' . $cell, $no_program.'.'.++$no_kegiatan);
                        $sheet->setCellValue('B' . $cell, $kegiatan->kode_kegiatan_baru);
                        $sheet->setCellValue('C' . $cell, $kegiatan->nama_kegiatan);
                        $sheet->setCellValue('D' . $cell,'');
                        $sheet->setCellValue('E' . $cell, '');
                        $sheet->setCellValue('F' . $cell, '');
                        $sheet->setCellValue('G' . $cell, '');
                        $sheet->setCellValue('H' . $cell, '');
                        $sheet->setCellValue('I' . $cell, '');
                        $sheet->setCellValue('J' . $cell, '');
                        $sheet->setCellValue('K' . $cell, '');
                        $sheet->setCellValue('L' . $cell, '');
                        $sheet->setCellValue('M' . $cell, '');
                        $sheet->setCellValue('N' . $cell, '');
                        $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                        $cell++;
                        $no_sub_kegiatan=0;
                        foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
                            $total_fisik += $dpa->realisasi_fisik;
                            $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
                            $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
                            $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
                            $total_keuangan += $persentase_keuangan;
                            $total_tertimbang_fisik += $tertimbang_fisik;
                            $total_tertimbang_keuangan += $tertimbang_keuangan;
                            $jumlah_kegiatan++;
                            $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $sheet->setCellValue('A' . $cell, $no_program.'.'.$no_kegiatan.'.'.++$no_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('C' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("C$cell:C".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
                            $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
							$sheet->setCellValue('F' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('H' . $cell, $dpa->realisasi_keuangan)->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('M' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('N' . $cell, '')->mergeCells("N$cell:N".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $cell++;
                            for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
                                $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
                                $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
                                $cell++;
                            }
                            foreach($dpa->SumberDanaDpa AS $sumber_dana){
                                $sheet->setCellValue('B' . $cell, '');
                                $sheet->setCellValue('C' . $cell, $sumber_dana->jenis_belanja);
								$sheet->setCellValue('D' . $cell, '');
                                $sheet->setCellValue('E' . $cell, '');
                                $sheet->setCellValue('F' . $cell, $sumber_dana->nilai_pagu);
                                $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
                                $sheet->setCellValue('H' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
                                $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
                                $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
                                $sheet->setCellValue('K' . $cell, '');
                                $sheet->setCellValue('L' . $cell, '');
                                $sheet->setCellValue('M' . $cell, '');
                                $sheet->setCellValue('N' . $cell, '');
                                $cell++;
                            }
                        }
                    }
                }
            }
        }

        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D7:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('H7:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('M7:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('H7:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
		$sheet->setCellValue('D' . $cell, '');
        $sheet->setCellValue('E' . $cell, '');
        $sheet->setCellValue('F' . $cell, $total_pagu_keseluruhan);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('H' . $cell, $total_realisasi_keuangan);
        //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
        //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
        $sheet->setCellValue('M' . $cell, '');
        $sheet->setCellValue('N' . $cell, '');
        $sheet->getStyle('A' . $cell . ':N' . $cell)->getFont()->setBold(true);
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

        $sheet->getStyle('A5:N' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
		if (hasRole('admin')){
        } else if (hasRole('opd')){
            $sheet->setCellValue('L' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$cell = $cell+3;
			$sheet->setCellValue('L' . ++$cell, request('nama',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI APBN DINAS '.$dinas.'.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }

    public function export_apbd_i_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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
        $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
        $sheet->setCellValue('A3', 'SUMBER DANA APBD I');
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('A2:N2');
        $sheet->mergeCells('A3:N3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'KODE')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->setCellValue('C5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(30);
		$sheet->setCellValue('D5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('D5:E5');
        $sheet->setCellValue('F5', 'JUMLAH DANA / DPA')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->setCellValue('G5', 'BOBOT')->mergeCells('G5:G6');
        $sheet->setCellValue('H5', 'REALISASI KEUANGAN (RP)')->mergeCells('H5:H6');
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->setCellValue('I5', 'REALISASI (%)')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'TERTIMBANG %')->mergeCells('K5:L5');
        $sheet->setCellValue('M5', 'PPTK/PELAKSANA')->mergeCells('M5:M6');
        $sheet->getColumnDimension('M')->setWidth(18);
        $sheet->setCellValue('N5', 'KET')->MergeCells('N5:N6');

		$sheet->setCellValue('D6', 'TOLAK UKUR')->getColumnDimension('D')->setWidth(15);
        $sheet->setCellValue('E6', 'SATUAN (UNIT)')->getColumnDimension('E')->setWidth(12);
        $sheet->setCellValue('I6', 'FISIK')->getColumnDimension('I')->setWidth(8);
        $sheet->setCellValue('J6', 'KEUANGAN')->getColumnDimension('J')->setWidth(12);
        $sheet->setCellValue('K6', 'FISIK (%)')->getColumnDimension('K')->setWidth(10);
        $sheet->setCellValue('L6', 'KEUANGAN (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:N')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:N6')->getFont()->setBold(true);

        $cell = 7;
        $total_bobot = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $jumlah_kegiatan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        $i=0;
        $no_program=0;
        foreach ($data AS $index => $row){
            if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
                $i++;

                // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));
                $sheet->setCellValue('A' . $cell, ++$no_program);
                $sheet->setCellValue('B' . $cell, $row->kode_program_baru);
                $sheet->setCellValue('C' . $cell, $row->nama_program);
                $sheet->setCellValue('D' . $cell, '');
                $sheet->setCellValue('E' . $cell, '');
                $sheet->setCellValue('F' . $cell, '');
                $sheet->setCellValue('G' . $cell, '');
                $sheet->setCellValue('H' . $cell, '');
                $sheet->setCellValue('I' . $cell, '');
                $sheet->setCellValue('J' . $cell, '');
                $sheet->setCellValue('K' . $cell, '');
                $sheet->setCellValue('L' . $cell, '');
                $sheet->setCellValue('M' . $cell, '');
                $sheet->setCellValue('N' . $cell, '');
                $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
                $cell++;
                $no_kegiatan=0;
                foreach($row->Kegiatan AS $kegiatan){
                    if ($kegiatan){
                        $sheet->setCellValue('A' . $cell, $no_program.'.'.++$no_kegiatan);
                        $sheet->setCellValue('B' . $cell, $kegiatan->kode_kegiatan_baru);
                        $sheet->setCellValue('C' . $cell, $kegiatan->nama_kegiatan);
                        $sheet->setCellValue('D' . $cell,'');
                        $sheet->setCellValue('E' . $cell, '');
                        $sheet->setCellValue('F' . $cell, '');
                        $sheet->setCellValue('G' . $cell, '');
                        $sheet->setCellValue('H' . $cell, '');
                        $sheet->setCellValue('I' . $cell, '');
                        $sheet->setCellValue('J' . $cell, '');
                        $sheet->setCellValue('K' . $cell, '');
                        $sheet->setCellValue('L' . $cell, '');
                        $sheet->setCellValue('M' . $cell, '');
                        $sheet->setCellValue('N' . $cell, '');
                        $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                        $cell++;
                        $no_sub_kegiatan=0;
                        foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
                            $total_fisik += $dpa->realisasi_fisik;
                            $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
                            $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
                            $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
                            $total_keuangan += $persentase_keuangan;
                            $total_tertimbang_fisik += $tertimbang_fisik;
                            $total_tertimbang_keuangan += $tertimbang_keuangan;
                            $jumlah_kegiatan++;
                            $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $sheet->setCellValue('A' . $cell, $no_program.'.'.$no_kegiatan.'.'.++$no_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('C' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("C$cell:C".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
                            $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
							$sheet->setCellValue('F' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('H' . $cell, $dpa->realisasi_keuangan)->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('M' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('N' . $cell, '')->mergeCells("N$cell:N".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $cell++;
                            for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
                                $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
                                $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
                                $cell++;
                            }
                            foreach($dpa->SumberDanaDpa AS $sumber_dana){
                                $sheet->setCellValue('B' . $cell, '');
                                $sheet->setCellValue('C' . $cell, $sumber_dana->jenis_belanja);
								$sheet->setCellValue('D' . $cell, '');
                                $sheet->setCellValue('E' . $cell, '');
                                $sheet->setCellValue('F' . $cell, $sumber_dana->nilai_pagu);
                                $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
                                $sheet->setCellValue('H' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
                                $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
                                $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
                                $sheet->setCellValue('K' . $cell, '');
                                $sheet->setCellValue('L' . $cell, '');
                                $sheet->setCellValue('M' . $cell, '');
                                $sheet->setCellValue('N' . $cell, '');
                                $cell++;
                            }
                        }
                    }
                }
            }
        }

        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D7:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('H7:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('M7:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('H7:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
		$sheet->setCellValue('D' . $cell, '');
        $sheet->setCellValue('E' . $cell, '');
        $sheet->setCellValue('F' . $cell, $total_pagu_keseluruhan);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('H' . $cell, $total_realisasi_keuangan);
        //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
        //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
        $sheet->setCellValue('M' . $cell, '');
        $sheet->setCellValue('N' . $cell, '');
        $sheet->getStyle('A' . $cell . ':N' . $cell)->getFont()->setBold(true);
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

        $sheet->getStyle('A5:N' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
		if (hasRole('admin')){
        } else if (hasRole('opd')){
            $sheet->setCellValue('L' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$cell = $cell+3;
			$sheet->setCellValue('L' . ++$cell, request('nama',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI ABPD I DINAS '.$dinas.'.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }

    public function export_apbd_ii_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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
        $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
        $sheet->setCellValue('A3', 'SUMBER DANA APBD II');
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('A2:N2');
        $sheet->mergeCells('A3:N3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'KODE')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->setCellValue('C5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(30);
		$sheet->setCellValue('D5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('D5:E5');
        $sheet->setCellValue('F5', 'JUMLAH DANA / DPA')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->setCellValue('G5', 'BOBOT')->mergeCells('G5:G6');
        $sheet->setCellValue('H5', 'REALISASI KEUANGAN (RP)')->mergeCells('H5:H6');
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->setCellValue('I5', 'REALISASI (%)')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'TERTIMBANG %')->mergeCells('K5:L5');
        $sheet->setCellValue('M5', 'PPTK/PELAKSANA')->mergeCells('M5:M6');
        $sheet->getColumnDimension('M')->setWidth(18);
        $sheet->setCellValue('N5', 'KET')->MergeCells('N5:N6');

		$sheet->setCellValue('D6', 'TOLAK UKUR')->getColumnDimension('D')->setWidth(15);
        $sheet->setCellValue('E6', 'SATUAN (UNIT)')->getColumnDimension('E')->setWidth(12);
        $sheet->setCellValue('I6', 'FISIK')->getColumnDimension('I')->setWidth(8);
        $sheet->setCellValue('J6', 'KEUANGAN')->getColumnDimension('J')->setWidth(12);
        $sheet->setCellValue('K6', 'FISIK (%)')->getColumnDimension('K')->setWidth(10);
        $sheet->setCellValue('L6', 'KEUANGAN (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:N')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:N6')->getFont()->setBold(true);

        $cell = 7;
        $total_bobot = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $jumlah_kegiatan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        $i=0;
        $no_program=0;
        foreach ($data AS $index => $row){
            if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
                $i++;

                // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));
                $sheet->setCellValue('A' . $cell, ++$no_program);
                $sheet->setCellValue('B' . $cell, $row->kode_program_baru);
                $sheet->setCellValue('C' . $cell, $row->nama_program);
                $sheet->setCellValue('D' . $cell, '');
                $sheet->setCellValue('E' . $cell, '');
                $sheet->setCellValue('F' . $cell, '');
                $sheet->setCellValue('G' . $cell, '');
                $sheet->setCellValue('H' . $cell, '');
                $sheet->setCellValue('I' . $cell, '');
                $sheet->setCellValue('J' . $cell, '');
                $sheet->setCellValue('K' . $cell, '');
                $sheet->setCellValue('L' . $cell, '');
                $sheet->setCellValue('M' . $cell, '');
                $sheet->setCellValue('N' . $cell, '');
                $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
                $cell++;
                $no_kegiatan=0;
                foreach($row->Kegiatan AS $kegiatan){
                    if ($kegiatan){
                        $sheet->setCellValue('A' . $cell, $no_program.'.'.++$no_kegiatan);
                        $sheet->setCellValue('B' . $cell, $kegiatan->kode_kegiatan_baru);
                        $sheet->setCellValue('C' . $cell, $kegiatan->nama_kegiatan);
                        $sheet->setCellValue('D' . $cell,'');
                        $sheet->setCellValue('E' . $cell, '');
                        $sheet->setCellValue('F' . $cell, '');
                        $sheet->setCellValue('G' . $cell, '');
                        $sheet->setCellValue('H' . $cell, '');
                        $sheet->setCellValue('I' . $cell, '');
                        $sheet->setCellValue('J' . $cell, '');
                        $sheet->setCellValue('K' . $cell, '');
                        $sheet->setCellValue('L' . $cell, '');
                        $sheet->setCellValue('M' . $cell, '');
                        $sheet->setCellValue('N' . $cell, '');
                        $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                        $cell++;
                        $no_sub_kegiatan=0;
                        foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
                            $total_fisik += $dpa->realisasi_fisik;
                            $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
                            $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
                            $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
                            $total_keuangan += $persentase_keuangan;
                            $total_tertimbang_fisik += $tertimbang_fisik;
                            $total_tertimbang_keuangan += $tertimbang_keuangan;
                            $jumlah_kegiatan++;
                            $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $sheet->setCellValue('A' . $cell, $no_program.'.'.$no_kegiatan.'.'.++$no_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('C' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("C$cell:C".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
                            $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
							$sheet->setCellValue('F' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('H' . $cell, $dpa->realisasi_keuangan)->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('M' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('N' . $cell, '')->mergeCells("N$cell:N".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $cell++;
                            for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
                                $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
                                $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
                                $cell++;
                            }
                            foreach($dpa->SumberDanaDpa AS $sumber_dana){
                                $sheet->setCellValue('B' . $cell, '');
                                $sheet->setCellValue('C' . $cell, $sumber_dana->jenis_belanja);
								$sheet->setCellValue('D' . $cell, '');
                                $sheet->setCellValue('E' . $cell, '');
                                $sheet->setCellValue('F' . $cell, $sumber_dana->nilai_pagu);
                                $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
                                $sheet->setCellValue('H' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
                                $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
                                $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
                                $sheet->setCellValue('K' . $cell, '');
                                $sheet->setCellValue('L' . $cell, '');
                                $sheet->setCellValue('M' . $cell, '');
                                $sheet->setCellValue('N' . $cell, '');
                                $cell++;
                            }
                        }
                    }
                }
            }
        }

        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D7:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('H7:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('M7:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('H7:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
		$sheet->setCellValue('D' . $cell, '');
        $sheet->setCellValue('E' . $cell, '');
        $sheet->setCellValue('F' . $cell, $total_pagu_keseluruhan);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('H' . $cell, $total_realisasi_keuangan);
        //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
        //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
        $sheet->setCellValue('M' . $cell, '');
        $sheet->setCellValue('N' . $cell, '');
        $sheet->getStyle('A' . $cell . ':N' . $cell)->getFont()->setBold(true);
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

        $sheet->getStyle('A5:N' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
		if (hasRole('admin')){
        } else if (hasRole('opd')){
            $sheet->setCellValue('L' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$cell = $cell+3;
			$sheet->setCellValue('L' . ++$cell, request('nama',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI ABPD II DINAS '.$dinas.'.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }

    public function export_dak_fisik_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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
        $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
        $sheet->setCellValue('A3', 'SUMBER DANA DAK FISIK');
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('A2:N2');
        $sheet->mergeCells('A3:N3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'KODE')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->setCellValue('C5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(30);
		$sheet->setCellValue('D5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('D5:E5');
        $sheet->setCellValue('F5', 'JUMLAH DANA / DPA')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->setCellValue('G5', 'BOBOT')->mergeCells('G5:G6');
        $sheet->setCellValue('H5', 'REALISASI KEUANGAN (RP)')->mergeCells('H5:H6');
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->setCellValue('I5', 'REALISASI (%)')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'TERTIMBANG %')->mergeCells('K5:L5');
        $sheet->setCellValue('M5', 'PPTK/PELAKSANA')->mergeCells('M5:M6');
        $sheet->getColumnDimension('M')->setWidth(18);
        $sheet->setCellValue('N5', 'KET')->MergeCells('N5:N6');

		$sheet->setCellValue('D6', 'TOLAK UKUR')->getColumnDimension('D')->setWidth(15);
        $sheet->setCellValue('E6', 'SATUAN (UNIT)')->getColumnDimension('E')->setWidth(12);
        $sheet->setCellValue('I6', 'FISIK')->getColumnDimension('I')->setWidth(8);
        $sheet->setCellValue('J6', 'KEUANGAN')->getColumnDimension('J')->setWidth(12);
        $sheet->setCellValue('K6', 'FISIK (%)')->getColumnDimension('K')->setWidth(10);
        $sheet->setCellValue('L6', 'KEUANGAN (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:N')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:N6')->getFont()->setBold(true);

        $cell = 7;
        $total_bobot = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $jumlah_kegiatan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        $i=0;
        $no_program=0;
        foreach ($data AS $index => $row){
            if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
                $i++;

                // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));
                $sheet->setCellValue('A' . $cell, ++$no_program);
                $sheet->setCellValue('B' . $cell, $row->kode_program_baru);
                $sheet->setCellValue('C' . $cell, $row->nama_program);
                $sheet->setCellValue('D' . $cell, '');
                $sheet->setCellValue('E' . $cell, '');
                $sheet->setCellValue('F' . $cell, '');
                $sheet->setCellValue('G' . $cell, '');
                $sheet->setCellValue('H' . $cell, '');
                $sheet->setCellValue('I' . $cell, '');
                $sheet->setCellValue('J' . $cell, '');
                $sheet->setCellValue('K' . $cell, '');
                $sheet->setCellValue('L' . $cell, '');
                $sheet->setCellValue('M' . $cell, '');
                $sheet->setCellValue('N' . $cell, '');
                $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
                $cell++;
                $no_kegiatan=0;
                foreach($row->Kegiatan AS $kegiatan){
                    if ($kegiatan){
                        $sheet->setCellValue('A' . $cell, $no_program.'.'.++$no_kegiatan);
                        $sheet->setCellValue('B' . $cell, $kegiatan->kode_kegiatan_baru);
                        $sheet->setCellValue('C' . $cell, $kegiatan->nama_kegiatan);
                        $sheet->setCellValue('D' . $cell,'');
                        $sheet->setCellValue('E' . $cell, '');
                        $sheet->setCellValue('F' . $cell, '');
                        $sheet->setCellValue('G' . $cell, '');
                        $sheet->setCellValue('H' . $cell, '');
                        $sheet->setCellValue('I' . $cell, '');
                        $sheet->setCellValue('J' . $cell, '');
                        $sheet->setCellValue('K' . $cell, '');
                        $sheet->setCellValue('L' . $cell, '');
                        $sheet->setCellValue('M' . $cell, '');
                        $sheet->setCellValue('N' . $cell, '');
                        $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                        $cell++;
                        $no_sub_kegiatan=0;
                        foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
                            $total_fisik += $dpa->realisasi_fisik;
                            $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
                            $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
                            $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
                            $total_keuangan += $persentase_keuangan;
                            $total_tertimbang_fisik += $tertimbang_fisik;
                            $total_tertimbang_keuangan += $tertimbang_keuangan;
                            $jumlah_kegiatan++;
                            $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $sheet->setCellValue('A' . $cell, $no_program.'.'.$no_kegiatan.'.'.++$no_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('C' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("C$cell:C".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
                            $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
							$sheet->setCellValue('F' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('H' . $cell, $dpa->realisasi_keuangan)->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('M' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('N' . $cell, '')->mergeCells("N$cell:N".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $cell++;
                            for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
                                $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
                                $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
                                $cell++;
                            }
                            foreach($dpa->SumberDanaDpa AS $sumber_dana){
                                $sheet->setCellValue('B' . $cell, '');
                                $sheet->setCellValue('C' . $cell, $sumber_dana->jenis_belanja);
								$sheet->setCellValue('D' . $cell, '');
                                $sheet->setCellValue('E' . $cell, '');
                                $sheet->setCellValue('F' . $cell, $sumber_dana->nilai_pagu);
                                $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
                                $sheet->setCellValue('H' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
                                $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
                                $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
                                $sheet->setCellValue('K' . $cell, '');
                                $sheet->setCellValue('L' . $cell, '');
                                $sheet->setCellValue('M' . $cell, '');
                                $sheet->setCellValue('N' . $cell, '');
                                $cell++;
                            }
                        }
                    }
                }
            }
        }

        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D7:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('H7:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('M7:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('H7:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
		$sheet->setCellValue('D' . $cell, '');
        $sheet->setCellValue('E' . $cell, '');
        $sheet->setCellValue('F' . $cell, $total_pagu_keseluruhan);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('H' . $cell, $total_realisasi_keuangan);
        //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
        //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
        $sheet->setCellValue('M' . $cell, '');
        $sheet->setCellValue('N' . $cell, '');
        $sheet->getStyle('A' . $cell . ':N' . $cell)->getFont()->setBold(true);
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

        $sheet->getStyle('A5:N' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
		if (hasRole('admin')){
        } else if (hasRole('opd')){
            $sheet->setCellValue('L' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$cell = $cell+3;
			$sheet->setCellValue('L' . ++$cell, request('nama',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI DAK FISIK DINAS '.$dinas.'.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }

    public function export_dak_non_fisik_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
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
        $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
        $sheet->setCellValue('A3', 'SUMBER DANA DAK NON FISIK');
        $sheet->mergeCells('A1:N1');
        $sheet->mergeCells('A2:N2');
        $sheet->mergeCells('A3:N3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B5', 'KODE')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->setCellValue('C5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('C5:C6');
        $sheet->getColumnDimension('C')->setWidth(30);
		$sheet->setCellValue('D5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('D5:E5');
        $sheet->setCellValue('F5', 'JUMLAH DANA / DPA')->mergeCells('F5:F6');
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->setCellValue('G5', 'BOBOT')->mergeCells('G5:G6');
        $sheet->setCellValue('H5', 'REALISASI KEUANGAN (RP)')->mergeCells('H5:H6');
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->setCellValue('I5', 'REALISASI (%)')->mergeCells('I5:J5');
        $sheet->setCellValue('K5', 'TERTIMBANG %')->mergeCells('K5:L5');
        $sheet->setCellValue('M5', 'PPTK/PELAKSANA')->mergeCells('M5:M6');
        $sheet->getColumnDimension('M')->setWidth(18);
        $sheet->setCellValue('N5', 'KET')->MergeCells('N5:N6');

		$sheet->setCellValue('D6', 'TOLAK UKUR')->getColumnDimension('D')->setWidth(15);
        $sheet->setCellValue('E6', 'SATUAN (UNIT)')->getColumnDimension('E')->setWidth(12);
        $sheet->setCellValue('I6', 'FISIK')->getColumnDimension('I')->setWidth(8);
        $sheet->setCellValue('J6', 'KEUANGAN')->getColumnDimension('J')->setWidth(12);
        $sheet->setCellValue('K6', 'FISIK (%)')->getColumnDimension('K')->setWidth(10);
        $sheet->setCellValue('L6', 'KEUANGAN (%)')->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A:N')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:N6')->getFont()->setBold(true);

        $cell = 7;
        $total_bobot = 0;
        $total_fisik = 0;
        $total_keuangan = 0;
        $jumlah_kegiatan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        $i=0;
        $no_program=0;
        foreach ($data AS $index => $row){
            if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
                $i++;

                // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));
                $sheet->setCellValue('A' . $cell, ++$no_program);
                $sheet->setCellValue('B' . $cell, $row->kode_program_baru);
                $sheet->setCellValue('C' . $cell, $row->nama_program);
                $sheet->setCellValue('D' . $cell, '');
                $sheet->setCellValue('E' . $cell, '');
                $sheet->setCellValue('F' . $cell, '');
                $sheet->setCellValue('G' . $cell, '');
                $sheet->setCellValue('H' . $cell, '');
                $sheet->setCellValue('I' . $cell, '');
                $sheet->setCellValue('J' . $cell, '');
                $sheet->setCellValue('K' . $cell, '');
                $sheet->setCellValue('L' . $cell, '');
                $sheet->setCellValue('M' . $cell, '');
                $sheet->setCellValue('N' . $cell, '');
                $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
                $cell++;
                $no_kegiatan=0;
                foreach($row->Kegiatan AS $kegiatan){
                    if ($kegiatan){
                        $sheet->setCellValue('A' . $cell, $no_program.'.'.++$no_kegiatan);
                        $sheet->setCellValue('B' . $cell, $kegiatan->kode_kegiatan_baru);
                        $sheet->setCellValue('C' . $cell, $kegiatan->nama_kegiatan);
                        $sheet->setCellValue('D' . $cell,'');
                        $sheet->setCellValue('E' . $cell, '');
                        $sheet->setCellValue('F' . $cell, '');
                        $sheet->setCellValue('G' . $cell, '');
                        $sheet->setCellValue('H' . $cell, '');
                        $sheet->setCellValue('I' . $cell, '');
                        $sheet->setCellValue('J' . $cell, '');
                        $sheet->setCellValue('K' . $cell, '');
                        $sheet->setCellValue('L' . $cell, '');
                        $sheet->setCellValue('M' . $cell, '');
                        $sheet->setCellValue('N' . $cell, '');
                        $sheet->getStyle('B' . $cell . ':N' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                        $cell++;
                        $no_sub_kegiatan=0;
                        foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
                            $total_fisik += $dpa->realisasi_fisik;
                            $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
                            $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
                            $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
                            $total_keuangan += $persentase_keuangan;
                            $total_tertimbang_fisik += $tertimbang_fisik;
                            $total_tertimbang_keuangan += $tertimbang_keuangan;
                            $jumlah_kegiatan++;
                            $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
                            $sheet->setCellValue('A' . $cell, $no_program.'.'.$no_kegiatan.'.'.++$no_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('C' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("C$cell:C".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
                            $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
							$sheet->setCellValue('F' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('H' . $cell, $dpa->realisasi_keuangan)->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('M' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('N' . $cell, '')->mergeCells("N$cell:N".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $cell++;
                            for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
                                $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
                                $sheet->setCellValue('E' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
                                $cell++;
                            }
                            foreach($dpa->SumberDanaDpa AS $sumber_dana){
                                $sheet->setCellValue('B' . $cell, '');
                                $sheet->setCellValue('C' . $cell, $sumber_dana->jenis_belanja);
								$sheet->setCellValue('D' . $cell, '');
                                $sheet->setCellValue('E' . $cell, '');
                                $sheet->setCellValue('F' . $cell, $sumber_dana->nilai_pagu);
                                $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
                                $sheet->setCellValue('H' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
                                $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
                                $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
                                $sheet->setCellValue('K' . $cell, '');
                                $sheet->setCellValue('L' . $cell, '');
                                $sheet->setCellValue('M' . $cell, '');
                                $sheet->setCellValue('N' . $cell, '');
                                $cell++;
                            }
                        }
                    }
                }
            }
        }

        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D7:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('H7:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('M7:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('H7:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
		$sheet->setCellValue('D' . $cell, '');
        $sheet->setCellValue('E' . $cell, '');
        $sheet->setCellValue('F' . $cell, $total_pagu_keseluruhan);
        $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('H' . $cell, $total_realisasi_keuangan);
        //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
        //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
        $sheet->setCellValue('M' . $cell, '');
        $sheet->setCellValue('N' . $cell, '');
        $sheet->getStyle('A' . $cell . ':N' . $cell)->getFont()->setBold(true);
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

        $sheet->getStyle('A5:N' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
		if (hasRole('admin')){
        } else if (hasRole('opd')){
            $sheet->setCellValue('L' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$cell = $cell+3;
			$sheet->setCellValue('L' . ++$cell, request('nama',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('L' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('L'.$cell.':N'.$cell);
			$sheet->getStyle('L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI DAK NON FISIK DINAS '.$dinas.'.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }

    public function export_dak_fisik_lama($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
        $sheet->getStyle('A:M')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A:M')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        // Header Text
        $sheet->setCellValue('A1', 'LAPORAN KEMAJUAN PER TRIWULAN');
        $sheet->setCellValue('A2', 'DANA ALOKASI KHUSUS (DAK) FISIK - TAHUN ANGGARAN '.$tahun.' ');
        $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode));
        $sheet->mergeCells('A1:M1');
        $sheet->mergeCells('A2:M2');
        $sheet->mergeCells('A3:M3');
        $sheet->getStyle('A1:A3')->getFont()->setSize(12);
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);

        $profile = ProfileDaerah::first();
        $sheet->setCellValue('A5', 'Provinsi     : Sulawesi Selatan')->mergeCells('A5:B5');
        $sheet->setCellValue('A6', 'Kabupaten   : '.optional($profile)->nama_daerah)->mergeCells('A6:B6');
        $sheet->getStyle('A5:A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);



        $sheet->setCellValue('A7', 'No')->mergeCells('A7:A8');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B7', 'Jenis Kegiatan')->mergeCells('B7:B8');
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->setCellValue('C7', 'Perencanaan Kegiatan')->mergeCells('C7:D7');
        $sheet->setCellValue('E7', 'Bobot')->mergeCells('E7:E8');
        $sheet->setCellValue('F7', 'Pelaksanaan kegiatan')->mergeCells('F7:G7');
        $sheet->setCellValue('H7', 'Realisasi (%)')->mergeCells('H7:J7');
        $sheet->setCellValue('K7', 'Realisasi Tertimbang')->mergeCells('K7:L7');
        $sheet->setCellValue('M7', 'Keterangan')->mergeCells('M7:M8')->getColumnDimension('M')->setWidth(15);

        $sheet->setCellValue('C8', 'DAK (Rp)')->getColumnDimension('C')->setWidth(15);
        $sheet->setCellValue('D8', 'Pendampingan (Rp)')->getColumnDimension('D')->setWidth(15);
        $sheet->setCellValue('F8', 'Swakelola (Rp)')->getColumnDimension('F')->setWidth(15);
        $sheet->setCellValue('G8', 'Kontrak (Rp)')->getColumnDimension('G')->setWidth(15);
        $sheet->setCellValue('H8', 'Keuangan (Rp)')->getColumnDimension('H')->setWidth(15);
        $sheet->setCellValue('I8', 'Fisik (%)');
        $sheet->setCellValue('J8', 'Keuangan (%)');
        $sheet->setCellValue('K8', 'Fisik (%)');
        $sheet->setCellValue('L8', 'Keuangan (%)');

        $sheet->getStyle('A7:M8')->getFont()->setBold(true);
        $sheet->getStyle('A:M')->getAlignment()->setWrapText(true);

        $cell = 9;
        $total_bobot = 0;
        $total_swakelola = 0;
        $total_kontrak = 0;
        $total_realisasi_fisik = 0;
        $total_persentase_kuangan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        $jumlah = 0;
        foreach ($data AS $row) {
            $total_bobot += $row->bobot;
            $total_swakelola += $row->swakelola;
            $total_kontrak += $row->kontrak;
            $total_realisasi_fisik += $row->realisasi_fisik;
            $total_persentase_kuangan += $row->persentase_realisasi_keuangan;
            $total_tertimbang_fisik += $row->tertimbang_fisik;
            $total_tertimbang_keuangan += $row->tertimbang_keuangan;
            $jumlah++;
            $sheet->setCellValue('A' . $cell, $cell - 8);
            $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
            $sheet->setCellValue('C' . $cell, $row->dak);
            $sheet->setCellValue('D' . $cell, '');
            $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($row->bobot,2));
            $sheet->setCellValue('F' . $cell, $row->swakelola);
            $sheet->setCellValue('G' . $cell, $row->kontrak);
            $sheet->setCellValue('H' . $cell, $row->realisasi_keuangan);
            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($row->realisasi_fisik,2));
            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($row->persentase_realisasi_keuangan,2));
            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($row->tertimbang_fisik,2));
            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($row->tertimbang_keuangan,2));
            $sheet->setCellValue('M' . $cell, '');
            $sheet->getRowDimension($cell)->setRowHeight(25);
            $cell++;
        }
        $sheet->getStyle('C9:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('C9:D' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F9:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F9:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('B9:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell, $total_pagu_keseluruhan);
        $sheet->setCellValue('D' . $cell, '');
        $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('F' . $cell, $total_swakelola);
        $sheet->setCellValue('G' . $cell, $total_kontrak);
        $sheet->setCellValue('H' . $cell, $total_realisasi_keuangan);
        $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah ? $total_realisasi_fisik/$jumlah : 0,2));
        $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($jumlah ? $total_persentase_kuangan/$jumlah : 0,2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
        $sheet->getStyle('A' . $cell . ':M' . $cell)->getFont()->setBold(true);
        $sheet->getStyle('B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension($cell)->setRowHeight(30);

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A7:M' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('K' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('K'.$cell.':N'.$cell);
        $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('K' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('K'.$cell.':N'.$cell);
        $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('K' . ++$cell, request('nama',''))->mergeCells('K'.$cell.':N'.$cell);
        $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('K' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('K'.$cell.':N'.$cell);
        $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('K' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('K'.$cell.':N'.$cell);
        $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // $writer = new Xlsx($spreadsheet);
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="REALISASI DAK FISIK.xlsx"');
        // $writer->save('php://output');

        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI DAK FISIK.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }

    public function export_dak_non_fisik_lama($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
        $sheet->getStyle('A:M')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A:M')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        // Header Text
        $sheet->setCellValue('A1', 'LAPORAN KEMAJUAN PER TRIWULAN');
        $sheet->setCellValue('A2', 'DANA ALOKASI KHUSUS (DAK) NON FISIK - TAHUN ANGGARAN '.$tahun);
        $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode));
        $sheet->mergeCells('A1:M1');
        $sheet->mergeCells('A2:M2');
        $sheet->mergeCells('A3:M3');
        $sheet->getStyle('A1:A3')->getFont()->setSize(12);
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $profile = ProfileDaerah::first();
        $sheet->setCellValue('A5', 'Provinsi     : Sulawesi Selatan')->mergeCells('A5:B5');
        $sheet->setCellValue('A6', 'Kabupaten   : '.optional($profile)->nama_daerah)->mergeCells('A6:B6');
        $sheet->getStyle('A5:A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);



        $sheet->setCellValue('A7', 'No')->mergeCells('A7:A8');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B7', 'Jenis Kegiatan')->mergeCells('B7:B8');
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->setCellValue('C7', 'Perencanaan Kegiatan')->mergeCells('C7:D7');
        $sheet->setCellValue('E7', 'Bobot')->mergeCells('E7:E8');
        $sheet->setCellValue('F7', 'Pelaksanaan kegiatan')->mergeCells('F7:G7');
        $sheet->setCellValue('H7', 'Realisasi (%)')->mergeCells('H7:J7');
        $sheet->setCellValue('K7', 'Realisasi Tertimbang')->mergeCells('K7:L7');
        $sheet->setCellValue('M7', 'Keterangan')->mergeCells('M7:M8')->getColumnDimension('M')->setWidth(15);

        $sheet->setCellValue('C8', 'DAK (Rp)')->getColumnDimension('C')->setWidth(15);
        $sheet->setCellValue('D8', 'Pendampingan (Rp)')->getColumnDimension('D')->setWidth(15);
        $sheet->setCellValue('F8', 'Swakelola (Rp)')->getColumnDimension('F')->setWidth(15);
        $sheet->setCellValue('G8', 'Kontrak (Rp)')->getColumnDimension('G')->setWidth(15);
        $sheet->setCellValue('H8', 'Keuangan (Rp)')->getColumnDimension('H')->setWidth(15);
        $sheet->setCellValue('I8', 'Fisik (%)');
        $sheet->setCellValue('J8', 'Keuangan (%)');
        $sheet->setCellValue('K8', 'Fisik (%)');
        $sheet->setCellValue('L8', 'Keuangan (%)');

        $sheet->getStyle('A7:M8')->getFont()->setBold(true);
        $sheet->getStyle('A:M')->getAlignment()->setWrapText(true);

        $cell = 9;
        $total_bobot = 0;
        $total_swakelola = 0;
        $total_kontrak = 0;
        $total_realisasi_fisik = 0;
        $total_persentase_kuangan = 0;
        $total_tertimbang_fisik = 0;
        $total_tertimbang_keuangan = 0;
        $jumlah = 0;
        foreach ($data AS $row) {
            $total_bobot += $row->bobot;
            $total_swakelola += $row->swakelola;
            $total_kontrak += $row->kontrak;
            $total_realisasi_fisik += $row->realisasi_fisik;
            $total_persentase_kuangan += $row->persentase_realisasi_keuangan;
            $total_tertimbang_fisik += $row->tertimbang_fisik;
            $total_tertimbang_keuangan += $row->tertimbang_keuangan;
            $jumlah++;
            $sheet->setCellValue('A' . $cell, $cell - 8);
            $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
            $sheet->setCellValue('C' . $cell, $row->dak);
            $sheet->setCellValue('D' . $cell, '');
            $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($row->bobot,2));
            $sheet->setCellValue('F' . $cell, $row->swakelola);
            $sheet->setCellValue('G' . $cell, $row->kontrak);
            $sheet->setCellValue('H' . $cell, $row->realisasi_keuangan);
            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($row->realisasi_fisik,2));
            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($row->persentase_realisasi_keuangan,2));
            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($row->tertimbang_fisik,2));
            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($row->tertimbang_keuangan,2));
            $sheet->setCellValue('M' . $cell, '');
            $sheet->getRowDimension($cell)->setRowHeight(25);
            $cell++;
        }
        $sheet->getStyle('C9:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('C9:D' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F9:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F9:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('B9:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Total
        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell, $total_pagu_keseluruhan);
        $sheet->setCellValue('D' . $cell, '');
        $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('F' . $cell, $total_swakelola);
        $sheet->setCellValue('G' . $cell, $total_kontrak);
        $sheet->setCellValue('H' . $cell, $total_realisasi_keuangan);
        $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah ? $total_realisasi_fisik/$jumlah : 0,2));
        $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($jumlah ? $total_persentase_kuangan/$jumlah : 0,2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
        $sheet->getStyle('A' . $cell . ':M' . $cell)->getFont()->setBold(true);
        $sheet->getStyle('B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getRowDimension($cell)->setRowHeight(30);

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A7:M' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('K' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('K'.$cell.':N'.$cell);
        $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('K' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('K'.$cell.':N'.$cell);
        $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('K' . ++$cell, request('nama',''))->mergeCells('K'.$cell.':N'.$cell);
        $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('K' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('K'.$cell.':N'.$cell);
        $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('K' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('K'.$cell.':N'.$cell);
        $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI DAK NON FISIK.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }

    public function export_dak_fisik_unit_kerja_lama($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        // $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $sheet->getStyle('A:Q')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A:Q')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $unit_kerja = UnitKerja::with('BidangUrusan.Urusan')->find(request('unit_kerja'));
        $sub_bidang = implode(', ',$unit_kerja->BidangUrusan->pluck('nama_bidang_urusan')->toArray());
        $bidang = $unit_kerja->BidangUrusan->map(function ($value){
            return $value->Urusan->nama_urusan;
        });
        $bidang = array_unique($bidang->toArray());
        $bidang = implode(', ',$bidang);
        $profile = ProfileDaerah::first();
        // Header Text
        $sheet->setCellValue('A1', 'LAPORAN KEMAJUAN PERTRIWULAN')->mergeCells('A1:Q1');
        $sheet->setCellValue('A2', 'DANA ALOKASI KHUSUS (FISIK) - TAHUN ANGGARAN '.$tahun)->mergeCells('A2:Q2');
        $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode))->mergeCells('A3:Q3');
        $sheet->getStyle('A1:A3')->getFont()->setSize(12);
        $sheet->setCellValue('A5','Provinsi       : Sulawesi Selatan')->mergeCells('A5:Q5');
        $sheet->setCellValue('A6','Kabupaten    : '.optional($profile)->nama_daerah)->mergeCells('A6:Q6');
        $sheet->setCellValue('A7','SKPD            : '.$dinas)->mergeCells('A7:Q7');
        $sheet->setCellValue('A8','Bidang          : '.ucwords(strtolower($bidang)))->mergeCells('A8:Q8');
        $sheet->setCellValue('A9','Sub Bidang   : '.ucwords(strtolower($sub_bidang)))->mergeCells('A9:Q9');
        $sheet->getStyle('A5:A9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('A10', 'No')->mergeCells('A10:A12');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B10', 'Jenis Kegiatan')->mergeCells('B10:B12');
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->setCellValue('C10', 'Perencanaan Kegiatan')->mergeCells('C10:H10');
        $sheet->setCellValue('I10', 'Pelaksanaan Kegiatan')->mergeCells('I10:J11');
        $sheet->setCellValue('K10', 'Realisasi')->mergeCells('K10:L11');
        $sheet->setCellValue('M10', 'Kesesuaian Sasaran dan Lokasi Dengan RKPD')->mergeCells('M10:N11');
        $sheet->setCellValue('O10', 'Kesesuaian Antara DPA SKPD Dengan Petunjuk Teknis DAK')->mergeCells('O10:P11');
        $sheet->setCellValue('Q10', 'Kodefikasi Masalah')->mergeCells('Q10:Q12')->getColumnDimension('Q')->setWidth(15);
        $sheet->setCellValue('C11', 'Volume')->mergeCells('C11:C12')->getColumnDimension('C')->setWidth(6);
        $sheet->setCellValue('D11', 'Satuan')->mergeCells('D11:D12')->getColumnDimension('D')->setWidth(10);
        $sheet->setCellValue('E11', 'Jumlah Penerima Manfaat')->mergeCells('E11:E12')->getColumnDimension('E')->setWidth(10);
        $sheet->setCellValue('F11', 'Jumlah')->mergeCells('F11:H11');
        $sheet->setCellValue('F12', 'Jumlah')->getColumnDimension('F')->setWidth(15);
        $sheet->setCellValue('G12', 'Non Pendamping')->getColumnDimension('G')->setWidth(15);
        $sheet->setCellValue('H12', 'Total Biaya')->getColumnDimension('H')->setWidth(15);
        $sheet->setCellValue('I12', 'Swakelola')->getColumnDimension('I')->setWidth(15);
        $sheet->setCellValue('J12', 'Kontrak')->getColumnDimension('J')->setWidth(15);
        $sheet->setCellValue('K12', 'Fisik')->getColumnDimension('K')->setWidth(7);
        $sheet->setCellValue('L12', 'Keuangan')->getColumnDimension('L')->setWidth(15);
        $sheet->setCellValue('M12', 'Ya')->getColumnDimension('M')->setWidth(7);
        $sheet->setCellValue('N12', 'Tidak')->getColumnDimension('N')->setWidth(7);
        $sheet->setCellValue('O12', 'Ya')->getColumnDimension('O')->setWidth(7);
        $sheet->setCellValue('P12', 'Tidak')->getColumnDimension('P')->setWidth(7);
        $sheet->getStyle('A:Q')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:Q12')->getFont()->setBold(true);

        // end Header


        $cell = 13;
        foreach ($data->Dpa AS $dpa) {

            $sheet->setCellValue('A' . $cell, $cell - 12)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
            $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
            $sheet->setCellValue('E' . $cell, '')->mergeCells("E$cell:E".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('F' . $cell, $dpa->nilai_pagu_dpa);
            $sheet->setCellValue('G' . $cell, '');
            $sheet->setCellValue('H' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('I' . $cell, $dpa->swakelola)->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('J' . $cell, $dpa->kontrak)->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($dpa->tertimbang_fisik,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($dpa->tertimbang_keuangan,2))->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('M' . $cell, '')->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('N' . $cell, '')->mergeCells("N$cell:N".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('O' . $cell, '')->mergeCells("O$cell:O".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('P' . $cell, '')->mergeCells("P$cell:P".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('Q' . $cell, '')->mergeCells("Q$cell:Q".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $cell++;
            for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
                $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
                $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
                $cell++;
            }
        }

        $sheet->getStyle('B13:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F13:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F13:J' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('L13:L' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L13:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // // Total
        $sheet->setCellValue('A' . $cell, 'JUMLAH')->mergeCells('A'.$cell.':D'.$cell);
        $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('F' . $cell, $data->total_dak);
        $sheet->setCellValue('H' . $cell, $data->total_dak);
        $sheet->setCellValue('I' . $cell, $data->swakelola);
        $sheet->setCellValue('J' . $cell, $data->kontrak);
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($data->realisasi_fisik,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($data->persentase_realisasi_keuangan,2));
        $sheet->getStyle('A' . $cell . ':L' . $cell)->getFont()->setBold(true);
        $sheet->getRowDimension($cell)->setRowHeight(30);
        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A10:Q' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('N' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('N'.$cell.':Q'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('N' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('N'.$cell.':Q'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('N' . ++$cell, request('nama',''))->mergeCells('N'.$cell.':Q'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('N' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('N'.$cell.':Q'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('N' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('N'.$cell.':Q'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI DAK FISIK '.$dinas.'.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }

    public function export_dak_non_fisik_unit_kerja_lama($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        // $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $sheet->getStyle('A:Q')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A:Q')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $unit_kerja = UnitKerja::with('BidangUrusan.Urusan')->find(request('unit_kerja'));
        $sub_bidang = implode(', ',$unit_kerja->BidangUrusan->pluck('nama_bidang_urusan')->toArray());
        $bidang = $unit_kerja->BidangUrusan->map(function ($value){
            return $value->Urusan->nama_urusan;
        });
        $bidang = array_unique($bidang->toArray());
        $bidang = implode(', ',$bidang);
        $profile = ProfileDaerah::first();
        // Header Text
        $sheet->setCellValue('A1', 'LAPORAN KEMAJUAN PERTRIWULAN')->mergeCells('A1:Q1');
        $sheet->setCellValue('A2', 'DANA ALOKASI KHUSUS (NON FISIK) - TAHUN ANGGARAN '.$tahun)->mergeCells('A2:Q2');
        $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode))->mergeCells('A3:Q3');
        $sheet->getStyle('A1:A3')->getFont()->setSize(12);
        $sheet->setCellValue('A5','Provinsi       : Sulawesi Selatan')->mergeCells('A5:Q5');
        $sheet->setCellValue('A6','Kabupaten    : '.optional($profile)->nama_daerah)->mergeCells('A6:Q6');
        $sheet->setCellValue('A7','SKPD            : '.$dinas)->mergeCells('A7:Q7');
        $sheet->setCellValue('A8','Bidang          : '.ucwords(strtolower($bidang)))->mergeCells('A8:Q8');
        $sheet->setCellValue('A9','Sub Bidang   : '.ucwords(strtolower($sub_bidang)))->mergeCells('A9:Q9');
        $sheet->getStyle('A5:A9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('A10', 'No')->mergeCells('A10:A12');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->setCellValue('B10', 'Jenis Kegiatan')->mergeCells('B10:B12');
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->setCellValue('C10', 'Perencanaan Kegiatan')->mergeCells('C10:H10');
        $sheet->setCellValue('I10', 'Pelaksanaan Kegiatan')->mergeCells('I10:J11');
        $sheet->setCellValue('K10', 'Realisasi')->mergeCells('K10:L11');
        $sheet->setCellValue('M10', 'Kesesuaian Sasaran dan Lokasi Dengan RKPD')->mergeCells('M10:N11');
        $sheet->setCellValue('O10', 'Kesesuaian Antara DPA SKPD Dengan Petunjuk Teknis DAK')->mergeCells('O10:P11');
        $sheet->setCellValue('Q10', 'Kodefikasi Masalah')->mergeCells('Q10:Q12')->getColumnDimension('Q')->setWidth(15);
        $sheet->setCellValue('C11', 'Volume')->mergeCells('C11:C12')->getColumnDimension('C')->setWidth(6);
        $sheet->setCellValue('D11', 'Satuan')->mergeCells('D11:D12')->getColumnDimension('D')->setWidth(10);
        $sheet->setCellValue('E11', 'Jumlah Penerima Manfaat')->mergeCells('E11:E12')->getColumnDimension('E')->setWidth(10);
        $sheet->setCellValue('F11', 'Jumlah')->mergeCells('F11:H11');
        $sheet->setCellValue('F12', 'Jumlah')->getColumnDimension('F')->setWidth(15);
        $sheet->setCellValue('G12', 'Non Pendamping')->getColumnDimension('G')->setWidth(15);
        $sheet->setCellValue('H12', 'Total Biaya')->getColumnDimension('H')->setWidth(15);
        $sheet->setCellValue('I12', 'Swakelola')->getColumnDimension('I')->setWidth(15);
        $sheet->setCellValue('J12', 'Kontrak')->getColumnDimension('J')->setWidth(15);
        $sheet->setCellValue('K12', 'Fisik')->getColumnDimension('K')->setWidth(7);
        $sheet->setCellValue('L12', 'Keuangan')->getColumnDimension('L')->setWidth(15);
        $sheet->setCellValue('M12', 'Ya')->getColumnDimension('M')->setWidth(7);
        $sheet->setCellValue('N12', 'Tidak')->getColumnDimension('N')->setWidth(7);
        $sheet->setCellValue('O12', 'Ya')->getColumnDimension('O')->setWidth(7);
        $sheet->setCellValue('P12', 'Tidak')->getColumnDimension('P')->setWidth(7);
        $sheet->getStyle('A:Q')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:Q12')->getFont()->setBold(true);

        // end Header


        $cell = 13;
        foreach ($data->Dpa AS $dpa) {

            $sheet->setCellValue('A' . $cell, $cell - 12)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
            $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
            $sheet->setCellValue('E' . $cell, '')->mergeCells("E$cell:E".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('F' . $cell, $dpa->nilai_pagu_dpa);
            $sheet->setCellValue('G' . $cell, '');
            $sheet->setCellValue('H' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('I' . $cell, $dpa->swakelola)->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('J' . $cell, $dpa->kontrak)->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($dpa->tertimbang_fisik,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($dpa->tertimbang_keuangan,2))->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('M' . $cell, '')->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('N' . $cell, '')->mergeCells("N$cell:N".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('O' . $cell, '')->mergeCells("O$cell:O".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('P' . $cell, '')->mergeCells("P$cell:P".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $sheet->setCellValue('Q' . $cell, '')->mergeCells("Q$cell:Q".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
            $cell++;
            for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
                $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
                $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
                $cell++;
            }
        }

        $sheet->getStyle('B13:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F13:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F13:J' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('L13:L' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L13:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // // Total
        $sheet->setCellValue('A' . $cell, 'JUMLAH')->mergeCells('A'.$cell.':D'.$cell);
        $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('F' . $cell, $data->total_dak);
        $sheet->setCellValue('H' . $cell, $data->total_dak);
        $sheet->setCellValue('I' . $cell, $data->swakelola);
        $sheet->setCellValue('J' . $cell, $data->kontrak);
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($data->realisasi_fisik,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($data->persentase_realisasi_keuangan,2));
        $sheet->getStyle('A' . $cell . ':L' . $cell)->getFont()->setBold(true);
        $sheet->getRowDimension($cell)->setRowHeight(30);
        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A10:Q' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
        $sheet->setCellValue('N' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('N'.$cell.':Q'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('N' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('N'.$cell.':Q'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('N' . ++$cell, request('nama',''))->mergeCells('N'.$cell.':Q'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('N' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('N'.$cell.':Q'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('N' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('N'.$cell.':Q'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI DAK NON FISIK '.$dinas.'.xlsx"');
        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
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
    }
}