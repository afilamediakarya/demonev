<?php

namespace App\Http\Controllers;

use App\Models\BidangUrusan;
use App\Models\JenisBelanja;
use App\Models\MetodePelaksanaan;
use App\Models\ProfileDaerah;
use App\Models\SumberDana;
use App\Models\BackupReport;
use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class LaporanControllerBackup extends Controller
{

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

    public function evaluasi_renja()
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
            $sumber_dana_view = $sumber_dana_selected == '' ? 'index' :'index';
            $tabel = view('Laporan.tabel_evaluasi_renja.' . Str::slug($sumber_dana_view . ($unit_kerja_selected ? ' dinas' : '_dinas'), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected','periode_selected'))->render();
        }

        return view('Laporan/laporan_evaluasi_renja', compact('sumber_dana', 'unit_kerja', 'periode_selected', 'sumber_dana_selected', 'unit_kerja_selected', 'tabel', 'metode_pelaksanaan', 'jenis_belanja', 'metode_pelaksanaan_selected', 'jenis_belanja_selected'));
    }

    public function evaluasi_renstra()
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
            $sumber_dana_view = $sumber_dana_selected == '' ? 'index' :'index';
            $tabel = view('Laporan.tabel_evaluasi_renstra.' . Str::slug($sumber_dana_view . ($unit_kerja_selected ? ' dinas' : '_dinas'), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected','periode_selected'))->render();
        }

        return view('Laporan/laporan_evaluasi_renstra', compact('sumber_dana', 'unit_kerja', 'periode_selected', 'sumber_dana_selected', 'unit_kerja_selected', 'tabel', 'metode_pelaksanaan', 'jenis_belanja', 'metode_pelaksanaan_selected', 'jenis_belanja_selected'));
    }

    public function evaluasi_rkpd()
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
            $sumber_dana_view = $sumber_dana_selected == '' ? 'index' :'index';
            $tabel = view('Laporan.tabel_evaluasi_rkpd.' . Str::slug($sumber_dana_view . ($unit_kerja_selected ? ' dinas' : '_dinas'), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected','periode_selected'))->render();
        }

        return view('Laporan/laporan_evaluasi_rkpd', compact('sumber_dana', 'unit_kerja', 'periode_selected', 'sumber_dana_selected', 'unit_kerja_selected', 'tabel', 'metode_pelaksanaan', 'jenis_belanja', 'metode_pelaksanaan_selected', 'jenis_belanja_selected'));
    }

    public function evaluasi_rpjmd()
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
            $sumber_dana_view = $sumber_dana_selected == '' ? 'index' :'index';
            $tabel = view('Laporan.tabel_evaluasi_rpjmd.' . Str::slug($sumber_dana_view . ($unit_kerja_selected ? ' dinas' : '_dinas'), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected','periode_selected'))->render();
        }

        return view('Laporan/laporan_evaluasi_rpjmd', compact('sumber_dana', 'unit_kerja', 'periode_selected', 'sumber_dana_selected', 'unit_kerja_selected', 'tabel', 'metode_pelaksanaan', 'jenis_belanja', 'metode_pelaksanaan_selected', 'jenis_belanja_selected'));
    }

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

        $cek=BackupReport::whereRaw("tahun='$tahun' AND triwulan='$periode_selected'")->count();
        if($cek>0){

            //GET DATA BACKUP

            //START TRIWULANPARAMBACKUP

        if ($periode_selected) {
            if (
//            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
//            &&
            !$unit_kerja_selected) {
                $data = UnitKerja::with(['BackupReportDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                    $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("triwulan='$periode_selected'");
                        if ($sumber_dana_selected) {
                            $q->whereRaw("triwulan='$periode_selected' AND sumber_dana='$sumber_dana_selected'");
                        }
                        if ($jenis_belanja_selected)
                            $q->where('jenis_belanja', $jenis_belanja_selected);
                        if ($metode_pelaksanaan_selected)
                            $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                            if ($periode_selected)
                                $q->whereRaw("triwulan='$periode_selected' AND periode<='$periode_selected'");
                        }]);
                    }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                    $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$periode_selected) {
                        if ($sumber_dana_selected) {
                            //SAMPAI DISINI kasi where triwulan
                            $q->whereRaw("triwulan='$periode_selected' AND sumber_dana='$sumber_dana_selected'");
                        }
                    });
                }])->get();
                $data = $data->map(function ($value) {
                    $value->Dpa = $value->BackupReportDpa->map(function ($value) {
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
                    $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                        return $total + $value->nilai_pagu_dpa;
                    });
                    $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                        return $total + $value->realisasi_keuangan;
                    });
                    $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                        return $total + $value->jumlah_tolak_ukur;
                    });
                    try {
                        $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                return $total + $value->realisasi_fisik;
                            }) / $value->BackupReportDpa->count();
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
                $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.BackupReportDpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                    $q->where('id_unit_kerja', $unit_kerja_selected);
                    $q->where('tahun', $tahun);
                    $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        if ($sumber_dana_selected) {
                            $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }
                        if ($jenis_belanja_selected)
                            $q->where('jenis_belanja', $jenis_belanja_selected);
                        if ($metode_pelaksanaan_selected)
                            $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                        $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                            if ($periode_selected)
                            $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('periode', '<=', $periode_selected);
                        }]);
                    }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                    $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$periode_selected,$tahun) {
                        if ($sumber_dana_selected) {
                            $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }
                    });
                }])->where('id', $unit_kerja_selected)
                    ->whereHas('BidangUrusan.Program.Kegiatan.BackupReportDpa', function ($q) use ($tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('tahun', $tahun);
                        $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                        });
                    })
                    ->first();
                $non_urusan = BidangUrusan::with(['Program.Kegiatan.BackupReportDpa' => function ($q) use ($unit_kerja_selected, $sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
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
                    $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                        if ($sumber_dana_selected) {
                            $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                            $q->where('sumber_dana', $sumber_dana_selected);
                        }
                    });
                }])
                    ->where('kode_bidang_urusan', '00')
                    ->whereHas('Program.Kegiatan.BackupReportDpa', function ($q) use ($unit_kerja_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
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
                                if ($value->BackupReportDpa->count()) {
                                    $kode_kegiatan_baru = $kode_program . '.' . $value->kode_kegiatan;
                                    $value->jumlah_sub_kegiatan = $value->Subkegiatan->count();
                                    $value->kode_kegiatan_baru = $kode_kegiatan_baru;

                                    $value->Dpa = $value->BackupReportDpa->map(function ($value) use ($kode_program, $non_urusan) {

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
                                    $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                                        return $total + $value->nilai_pagu_dpa;
                                    });
                                    $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                                        return $total + $value->realisasi_keuangan;
                                    });
                                    $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                                        return $total + $value->jumlah_tolak_ukur;
                                    });
                                    $value->jumlah_sumber_dana = $value->BackupReportDpa->reduce(function ($total, $value) {
                                        return $total + $value->jumlah_sumber_dana;
                                    });
                                    try {
                                        $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                                return $total + $value->realisasi_fisik;
                                            }) / $value->BackupReportDpa->count();
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
                $data = UnitKerja::with(['BackupReportDpa' => function ($q) use ($periode_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                    $q->with(['SumberDanaDpa' => function ($q) use ($periode_selected, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                            if ($periode_selected)
                            $q->whereRaw("periode<='$periode_selected'");
                        }]);
                        if ($sumber_dana_selected) {
                            $q->whereRaw("triwulan='$periode_selected' AND sumber_dana='$sumber_dana_selected'");
                        }
                        if ($jenis_belanja_selected)
                            $q->where('jenis_belanja', $jenis_belanja_selected);
                        if ($metode_pelaksanaan_selected)
                            $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                    }]);
                    $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$periode_selected) {
                        if ($sumber_dana_selected) {
                            $q->whereRaw("triwulan='$periode_selected' AND sumber_dana='$sumber_dana_selected'");
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
                $data = UnitKerja::with(['BackupReportDpa' => function ($q) use ($periode_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                    $q->where('id_unit_kerja', $unit_kerja_selected);
                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                    $q->with(['SumberDanaDpa' => function ($q) use ($periode_selected, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->with(['DetailRealisasi' => function ($q) use ($periode_selected) {
                            if ($periode_selected)
                            $q->whereRaw("triwulan='$periode_selected' AND periode<='$periode_selected'");
                        }]);
                        if ($sumber_dana_selected) {
                            $q->whereRaw("triwulan='$periode_selected' AND sumber_dana='$sumber_dana_selected'");
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
            // $sumber_dana_selected = $sumber_dana_selected == '' ? 'index' : $sumber_dana_selected;
            // $tabel = view('Laporan.tabel_realisasi.' . Str::slug($sumber_dana_selected . ($unit_kerja_selected ? ' dinas' : ''), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected'))->render();
            $sumber_dana_view = $sumber_dana_selected == '' ? 'index' :'index';
            $tabel = view('Laporan.tabel_realisasi.' . Str::slug($sumber_dana_view . ($unit_kerja_selected ? ' dinas' : ''), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected','periode_selected'))->render();
        }
        //END TRIWULANPARAMBACKUP

        }else{

            //GET DATA CURRENT

            //START TRIWULANPARAM

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
                                        // echo $value->SumberDanaDpa->count();
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
            // $sumber_dana_selected = $sumber_dana_selected == '' ? 'index' : $sumber_dana_selected;
            // $tabel = view('Laporan.tabel_realisasi.' . Str::slug($sumber_dana_selected . ($unit_kerja_selected ? ' dinas' : ''), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected'))->render();
            $sumber_dana_view = $sumber_dana_selected == '' ? 'index' :'index';
            $tabel = view('Laporan.tabel_realisasi.' . Str::slug($sumber_dana_view . ($unit_kerja_selected ? ' dinas' : ''), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected','periode_selected'))->render();
        }
        //END TRIWULANPARAM


        }





        return view('Laporan/laporan_realisasi', compact('sumber_dana', 'unit_kerja', 'periode_selected', 'sumber_dana_selected', 'unit_kerja_selected', 'tabel', 'metode_pelaksanaan', 'jenis_belanja', 'metode_pelaksanaan_selected', 'jenis_belanja_selected'));
    }


    public function export($tipe)
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

        $cek=BackupReport::whereRaw("tahun='$tahun' AND triwulan='$periode_selected'")->count();
        if($cek>0){
            //GET DATA BACKUP

            if ($periode_selected) {
                if (
    //            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
    //            &&
                !$unit_kerja_selected) {
                    $data = UnitKerja::with(['BackupReportDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->where('tahun', $tahun);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                        });
                    }])->get();
                    $data = $data->map(function ($value) {
                        $value->Dpa = $value->BackupReportDpa->map(function ($value) {
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
                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->nilai_pagu_dpa;
                        });
                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->realisasi_keuangan;
                        });
                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->jumlah_tolak_ukur;
                        });
                        try {
                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                }) / $value->BackupReportDpa->count();
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
                    $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.BackupReportDpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                        });
                    }])->where('id', $unit_kerja_selected)
                        ->whereHas('BidangUrusan.Program.Kegiatan.BackupReportDpa', function ($q) use ($tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$tahun,$periode_selected) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }
                                if ($jenis_belanja_selected)
                                    $q->where('jenis_belanja', $jenis_belanja_selected);
                                if ($metode_pelaksanaan_selected)
                                    $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            });
                        })
                        ->first();
                    $non_urusan = BidangUrusan::with(['Program.Kegiatan.BackupReportDpa' => function ($q) use ($unit_kerja_selected, $sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }
                        });
                    }])
                        ->where('kode_bidang_urusan', '00')
                        ->whereHas('Program.Kegiatan.BackupReportDpa', function ($q) use ($unit_kerja_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                            $q->where('id_unit_kerja', $unit_kerja_selected);
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$tahun,$periode_selected) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
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
                                    if ($value->BackupReportDpa->count()) {
                                        $kode_kegiatan_baru = $kode_program . '.' . $value->kode_kegiatan;
                                        $value->jumlah_sub_kegiatan = $value->Subkegiatan->count();
                                        $value->kode_kegiatan_baru = $kode_kegiatan_baru;
                                        $value->Dpa = $value->BackupReportDpa->map(function ($value) use ($kode_program, $non_urusan) {
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
                                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->nilai_pagu_dpa;
                                        });
                                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->realisasi_keuangan;
                                        });
                                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_tolak_ukur;
                                        });
                                        $value->jumlah_sumber_dana = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_sumber_dana;
                                        });
                                        try {
                                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                                    return $total + $value->realisasi_fisik;
                                                }) / $value->BackupReportDpa->count();
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

        }else{
            //GET DATA CURRENT

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

        }

        // $fungsi = Str::slug($sumber_dana_selected . ($unit_kerja_selected ? ' unit kerja' : ''), '_');
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
            $fungsi = "export_$fungsi";
        }
        return $this->{$fungsi}($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$sumber_dana_selected);
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

        $cek=BackupReport::whereRaw("tahun='$tahun' AND triwulan='$periode_selected'")->count();
        if($cek>0){
            //GET DATA BACKUP

            if ($periode_selected) {
                if (
    //            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
    //            &&
                !$unit_kerja_selected) {
                    $data = UnitKerja::with(['BackupReportDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->where('tahun', $tahun);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])->get();
                    $data = $data->map(function ($value) {
                        $value->Dpa = $value->BackupReportDpa->map(function ($value) {
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


                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->nilai_pagu_dpa;
                        });
                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->realisasi_keuangan;
                        });
                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->jumlah_tolak_ukur;
                        });
                        try {
                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                }) / $value->BackupReportDpa->count();
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
                    $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.BackupReportDpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);

                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])->where('id', $unit_kerja_selected)
                        ->whereHas('BidangUrusan.Program.Kegiatan.BackupReportDpa', function ($q) use ($tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$tahun,$periode_selected) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }else{
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->whereRaw("sumber_dana LIKE '%DAK%'");
                                }
                                if ($jenis_belanja_selected)
                                    $q->where('jenis_belanja', $jenis_belanja_selected);
                                if ($metode_pelaksanaan_selected)
                                    $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            });
                        })
                        ->first();
                    $non_urusan = BidangUrusan::with(['Program.Kegiatan.BackupReportDpa' => function ($q) use ($unit_kerja_selected, $sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])
                        ->where('kode_bidang_urusan', '00')
                        ->whereHas('Program.Kegiatan.BackupReportDpa', function ($q) use ($unit_kerja_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                            $q->where('id_unit_kerja', $unit_kerja_selected);
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected,$tahun) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }else{
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
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
                                    if ($value->BackupReportDpa->count()) {
                                        $kode_kegiatan_baru = $kode_program . '.' . $value->kode_kegiatan;
                                        $value->jumlah_sub_kegiatan = $value->Subkegiatan->count();
                                        $value->kode_kegiatan_baru = $kode_kegiatan_baru;
                                        $value->Dpa = $value->BackupReportDpa->map(function ($value) use ($kode_program, $non_urusan) {
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

                                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->nilai_pagu_dpa;
                                        });
                                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->realisasi_keuangan;
                                        });
                                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_tolak_ukur;
                                        });
                                        $value->jumlah_sumber_dana = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_sumber_dana;
                                        });
                                        try {
                                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                                    return $total + $value->realisasi_fisik;
                                                }) / $value->BackupReportDpa->count();
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

        }else{
            //GET DATA CURRENT

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
        }
        return view('Laporan/laporan_kemajuan_dak', compact('sumber_dana', 'unit_kerja', 'periode_selected', 'sumber_dana_selected', 'unit_kerja_selected', 'tabel', 'metode_pelaksanaan', 'jenis_belanja', 'metode_pelaksanaan_selected', 'jenis_belanja_selected'));
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

        $cek=BackupReport::whereRaw("tahun='$tahun' AND triwulan='$periode_selected'")->count();
        if($cek>0){
            //GET DATA BACKUP

            if ($periode_selected) {
                if (
    //            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
    //            &&
                !$unit_kerja_selected) {
                    $data = UnitKerja::with(['BackupReportDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {

                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{

                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->where('tahun', $tahun);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])->get();
                    $data = $data->map(function ($value) {
                        $value->Dpa = $value->BackupReportDpa->map(function ($value) {
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
                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->nilai_pagu_dpa;
                        });
                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->realisasi_keuangan;
                        });
                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->jumlah_tolak_ukur;
                        });
                        try {
                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                }) / $value->BackupReportDpa->count();
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
                    $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.BackupReportDpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])->where('id', $unit_kerja_selected)
                        ->whereHas('BidangUrusan.Program.Kegiatan.BackupReportDpa', function ($q) use ($tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected,$tahun) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }else{
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->whereRaw("sumber_dana LIKE '%DAK%'");
                                }
                                if ($jenis_belanja_selected)
                                    $q->where('jenis_belanja', $jenis_belanja_selected);
                                if ($metode_pelaksanaan_selected)
                                    $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            });
                        })
                        ->first();
                    $non_urusan = BidangUrusan::with(['Program.Kegiatan.BackupReportDpa' => function ($q) use ($unit_kerja_selected, $sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])
                        ->where('kode_bidang_urusan', '00')
                        ->whereHas('Program.Kegiatan.BackupReportDpa', function ($q) use ($unit_kerja_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                            $q->where('id_unit_kerja', $unit_kerja_selected);
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$tahun,$periode_selected) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }else{
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
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
                                    if ($value->BackupReportDpa->count()) {
                                        $kode_kegiatan_baru = $kode_program . '.' . $value->kode_kegiatan;
                                        $value->jumlah_sub_kegiatan = $value->Subkegiatan->count();
                                        $value->kode_kegiatan_baru = $kode_kegiatan_baru;
                                        $value->Dpa = $value->BackupReportDpa->map(function ($value) use ($kode_program, $non_urusan) {
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
                                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->nilai_pagu_dpa;
                                        });
                                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->realisasi_keuangan;
                                        });
                                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_tolak_ukur;
                                        });
                                        $value->jumlah_sumber_dana = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_sumber_dana;
                                        });
                                        try {
                                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                                    return $total + $value->realisasi_fisik;
                                                }) / $value->BackupReportDpa->count();
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

        }else{
            //GET DATA CURRENT

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
        return $this->{$fungsi}($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected,$sumber_dana_selected);
    }


    public function export_kemajuan_dak_semua_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected,$sumber_dana_selected)
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
        if($sumber_dana_selected=='semua'){
            $sumber_dana_selected='DAK FISIK & NON FISIK';
        }else{
            $sumber_dana_selected=strtoupper($sumber_dana_selected);
        }
        // Header Text
        $sheet->setCellValue('A1', 'LAPORAN KEMAJUAN PER TRIWULAN');
        $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
        $sheet->setCellValue('A3', 'SUMBER DANA '.$sumber_dana_selected);
        $sheet->mergeCells('A1:Q1');
        $sheet->mergeCells('A2:Q2');
        $sheet->mergeCells('A3:Q3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'KODE')->mergeCells('A5:A7');
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->setCellValue('B5', 'JENIS KEGIATAN')->mergeCells('B5:B7');
        $sheet->getColumnDimension('B')->setWidth(32);
//        $sheet->setCellValue('C5', 'PERENCANAAN KEGIATAN')->mergeCells('C5:H5');
        $sheet->setCellValue('C5', 'PERENCANAAN KEGIATAN')->mergeCells('C5:F5');
        $sheet->setCellValue('I5', 'PELAKSANA KEGIATAN')->mergeCells('I5:J6');
        $sheet->setCellValue('K5', 'REALISASI')->mergeCells('K5:L6');;
        $sheet->setCellValue('M5', 'Kesesuaian Sasaran dan Lokasi dgn RKPD')->mergeCells('M5:N6');
        $sheet->setCellValue('O5', 'Kesesuaian Antara DPA SKPD dgn Petunjuk Teknis DAK')->mergeCells('O5:P6');
        $sheet->setCellValue('Q5', 'Modifikasi Masalah')->mergeCells('Q5:Q7');
        $sheet->getColumnDimension('Q')->setWidth(10);

        $sheet->setCellValue('C6', 'Volume')->mergeCells('C6:C7')->getColumnDimension('C')->setWidth(8);
        $sheet->setCellValue('D6', 'Satuan')->mergeCells('D6:D7')->getColumnDimension('D')->setWidth(10);
        $sheet->setCellValue('E6', 'Jml Penerima Manfaat')->mergeCells('E6:E7')->getColumnDimension('E')->setWidth(10);
//        $sheet->setCellValue('F6', 'Jumlah')->mergeCells('F6:H6');
        $sheet->setCellValue('F6', 'Jumlah')->mergeCells('F6:F7')->getColumnDimension('F')->setWidth(10);;


//        $sheet->setCellValue('F7', 'Jumlah')->mergeCells('F7:F7')->getColumnDimension('F')->setWidth(18);
//        $sheet->setCellValue('G7', 'Non Pendamping')->mergeCells('G7:G7')->getColumnDimension('G')->setWidth(18);
//        $sheet->setCellValue('H7', 'Total Biaya')->mergeCells('H7:H7')->getColumnDimension('H')->setWidth(18);

        $sheet->setCellValue('I7', 'Swakelola')->mergeCells('I7:I7')->getColumnDimension('I')->setWidth(18);
        $sheet->setCellValue('J7', 'Kontrak')->mergeCells('J7:J7')->getColumnDimension('J')->setWidth(18);

        $sheet->setCellValue('K7', 'Fisik(%)')->mergeCells('K7:K7')->getColumnDimension('K')->setWidth(10);
        $sheet->setCellValue('L7', 'Keuangan(Rp)')->mergeCells('L7:L7')->getColumnDimension('L')->setWidth(18);

        $sheet->setCellValue('M7', 'Ya')->mergeCells('M7:M7')->getColumnDimension('M')->setWidth(8);
        $sheet->setCellValue('N7', 'Tidak')->mergeCells('N7:N7')->getColumnDimension('N')->setWidth(8);
        $sheet->setCellValue('O7', 'Ya')->mergeCells('O7:O7')->getColumnDimension('O')->setWidth(8);
        $sheet->setCellValue('P7', 'Tidak')->mergeCells('P7:P7')->getColumnDimension('P')->setWidth(8);


        $sheet->getStyle('A:Q')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:Q7')->getFont()->setBold(true);

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
		$jumlah_paket=0;
        foreach ($data AS $index => $row){
            if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
                $i++;

                // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));

                $sheet->setCellValue('A' . $cell, $row->kode_program_baru);
                $sheet->setCellValue('B' . $cell, $row->nama_program);
                $sheet->setCellValue('C' . $cell, '');
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
                $sheet->getStyle('A' . $cell . ':Q' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
                $cell++;
                $no_kegiatan=0;
                foreach($row->Kegiatan AS $kegiatan){
                    if ($kegiatan){
                        $sheet->setCellValue('A' . $cell, $kegiatan->kode_kegiatan_baru);
                        $sheet->setCellValue('B' . $cell, $kegiatan->nama_kegiatan);
                        $sheet->setCellValue('C' . $cell,'');
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
                        $sheet->setCellValue('O' . $cell, '');
                        $sheet->setCellValue('P' . $cell, '');
                        $sheet->setCellValue('Q' . $cell, '');
                        $sheet->getStyle('A' . $cell . ':Q' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                        $cell++;
                        $no_sub_kegiatan=0;
                        foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){

                            $kp=1;
                            $sheet->setCellValue('A' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan);
                            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan);
                            $sheet->setCellValue('C' . $cell,'');
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
                            $sheet->setCellValue('O' . $cell, '');
                            $sheet->setCellValue('P' . $cell, '');
                            $sheet->setCellValue('Q' . $cell, '');
//                            $sheet->getStyle('B' . $cell . ':Q' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                            $sheet->getStyle('B' . $cell . ':Q' . $cell)->getFont()->setBold(true);
                            $cell++;

                            foreach($dpa->SumberDanaDpa AS $sumber_dana){
                                foreach($sumber_dana->PaketDak AS $paket_dak){
                                    $jumlah_paket++;
                                    $tot_swakelola+=$paket_dak->swakelola;
                                    $tot_kontrak+=$paket_dak->kontrak;
                                    $tot_penerima_manfaat+=$paket_dak->penerima_manfaat;

                                    $anggaran_dak=$paket_dak->anggaran_dak;
                                    $pendampingan=$paket_dak->pendampingan;
                                    //$total_biaya=$paket_dak->total_biaya;

                                    $total_biaya=$anggaran_dak+$pendampingan;
                                    $total_total_biaya+=$total_biaya;
                                    $total_anggaran_dak+=$anggaran_dak;
                                    $total_pendampingan+=$pendampingan;


                                    $sheet->setCellValue('A' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan.'.'.sprintf("%02d", $kp++));
                                    $sheet->setCellValue('B' . $cell, $paket_dak->nama_paket);
                                    $sheet->setCellValue('C' . $cell,$paket_dak->volume);
                                    $sheet->setCellValue('D' . $cell,$paket_dak->satuan);
                                    $sheet->setCellValue('E' . $cell, $paket_dak->penerima_manfaat);
                                    $sheet->setCellValue('F' . $cell, $anggaran_dak);
                                    $sheet->setCellValue('G' . $cell, $pendampingan);
                                    $sheet->setCellValue('H' . $cell, $total_biaya);
                                    $sheet->setCellValue('I' . $cell, ($paket_dak->swakelola));
                                    $sheet->setCellValue('J' . $cell, ($paket_dak->kontrak));

                                    $realisasi=$paket_dak->RealisasiDak->where('periode','<=',$periode_selected);
                                    $fisik=$realisasi->sum('realisasi_fisik');
                                    $keuangan=$realisasi->sum('realisasi_keuangan');

                                    $tot_fisik+=$fisik;
                                    $tot_keuangan+=$keuangan;

                                    $real_data=$paket_dak->RealisasiDak->where('periode',$periode_selected);
                                    $kes_rkpd=$paket_dak->kesesuaian_rkpd;
                                    $kes_skpd=$paket_dak->kesesuaian_dpa_skpd;
                                    $permasalahan=$real_data->first()->permasalahan;


                                    $sheet->setCellValue('K' . $cell, ($fisik));
                                    $sheet->setCellValue('L' . $cell, ($keuangan));


                                    if($kes_rkpd=='Y'){
                                        $sheet->setCellValue('M' . $cell, 'V');
                                        $sheet->setCellValue('N' . $cell, '');
                                    }else{
                                        $sheet->setCellValue('M' . $cell, '');
                                        $sheet->setCellValue('N' . $cell, 'V');
                                    }
                                    if($kes_skpd=='Y'){
                                        $sheet->setCellValue('O' . $cell, 'V');
                                        $sheet->setCellValue('P' . $cell, '');
                                    }else{
                                        $sheet->setCellValue('O' . $cell, '');
                                        $sheet->setCellValue('P' . $cell, 'V');
                                    }

                                    $sheet->setCellValue('Q' . $cell, $permasalahan);
                                    $cell++;

                                }

                            }
                        }
                    }
                }
            }
        }
        /*foreach ($data AS $index => $row){
            if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
                $i++;

                foreach($row->Kegiatan AS $kegiatan){
                    if ($kegiatan){

                        $kp=1;
                        foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){

                            $kp=1;
                            $sheet->setCellValue('A' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan);
                            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan);
                            $sheet->setCellValue('C' . $cell,'');
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
                            $sheet->setCellValue('O' . $cell, '');
                            $sheet->setCellValue('P' . $cell, '');
                            $sheet->setCellValue('Q' . $cell, '');
                            $sheet->getStyle('B' . $cell . ':Q' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
                            $sheet->getStyle('B' . $cell . ':Q' . $cell)->getFont()->setBold(true);
                            $cell++;

                            foreach($dpa->SumberDanaDpa AS $sumber_dana){
                                foreach($sumber_dana->PaketDak AS $paket_dak){
                                    $jumlah_paket++;
									$tot_swakelola+=$paket_dak->swakelola;
                                    $tot_kontrak+=$paket_dak->kontrak;
                                    $tot_penerima_manfaat+=$paket_dak->penerima_manfaat;

                                    $anggaran_dak=$paket_dak->anggaran_dak;
                                    $pendampingan=$paket_dak->pendampingan;
									//$total_biaya=$paket_dak->total_biaya;

									$total_biaya=$anggaran_dak+$pendampingan;
									$total_total_biaya+=$total_biaya;
                                    $total_anggaran_dak+=$anggaran_dak;
                                    $total_pendampingan+=$pendampingan;


                                    $sheet->setCellValue('A' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan.'.'.sprintf("%02d", $kp++));
                                    $sheet->setCellValue('B' . $cell, $paket_dak->nama_paket);
                                    $sheet->setCellValue('C' . $cell,$paket_dak->volume);
                                    $sheet->setCellValue('D' . $cell,$paket_dak->satuan);
                                    $sheet->setCellValue('E' . $cell, $paket_dak->penerima_manfaat);
                                    $sheet->setCellValue('F' . $cell, $anggaran_dak);
                                    $sheet->setCellValue('G' . $cell, $pendampingan);
                                    $sheet->setCellValue('H' . $cell, $total_biaya);
                                    $sheet->setCellValue('I' . $cell, ($paket_dak->swakelola));
                                    $sheet->setCellValue('J' . $cell, ($paket_dak->kontrak));

                                    $realisasi=$paket_dak->RealisasiDak->where('periode','<=',$periode_selected);
                                    $fisik=$realisasi->sum('realisasi_fisik');
                                    $keuangan=$realisasi->sum('realisasi_keuangan');

                                    $tot_fisik+=$fisik;
                                    $tot_keuangan+=$keuangan;

                                    $real_data=$paket_dak->RealisasiDak->where('periode',$periode_selected);
                                    $kes_rkpd=$paket_dak->kesesuaian_rkpd;
                                    $kes_skpd=$paket_dak->kesesuaian_dpa_skpd;
                                    $permasalahan=$real_data->first()->permasalahan;


                                    $sheet->setCellValue('K' . $cell, ($fisik));
                                    $sheet->setCellValue('L' . $cell, ($keuangan));


                                    if($kes_rkpd=='Y'){
                                        $sheet->setCellValue('M' . $cell, 'V');
                                        $sheet->setCellValue('N' . $cell, '');
                                    }else{
                                        $sheet->setCellValue('M' . $cell, '');
                                        $sheet->setCellValue('N' . $cell, 'V');
                                    }
                                    if($kes_skpd=='Y'){
                                        $sheet->setCellValue('O' . $cell, 'V');
                                        $sheet->setCellValue('P' . $cell, '');
                                    }else{
                                        $sheet->setCellValue('O' . $cell, '');
                                        $sheet->setCellValue('P' . $cell, 'V');
                                    }

                                    $sheet->setCellValue('Q' . $cell, $permasalahan);
                                    $cell++;

                                }

                            }
                        }
                    }
                }
            }
        }*/

        $sheet->getStyle('A1:Q' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:Q' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A8:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		$sheet->getStyle('B8:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		$sheet->getStyle('F8:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('G8:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('H8:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('I8:I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('J8:J' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('L8:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('C8:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('D8:D' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('E8:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('F8:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('G8:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H8:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('I8:I' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J8:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L8:L' . $cell)->getNumberFormat()->setFormatCode('#,##0');


        // Total
        $tot_fisik_keseluruhan=round(($tot_fisik/($jumlah_paket)),2);

        $sheet->setCellValue('A' . $cell, 'JUMLAH');
        $sheet->setCellValue('B' . $cell,'');
        $sheet->setCellValue('C' . $cell,'');
        $sheet->setCellValue('D' . $cell, '');
        $sheet->setCellValue('E' . $cell, $tot_penerima_manfaat);
        $sheet->setCellValue('F' . $cell, $total_anggaran_dak);
        $sheet->setCellValue('G' . $cell, $total_pendampingan);
        $sheet->setCellValue('H' . $cell, $total_total_biaya);
        $sheet->setCellValue('I' . $cell, ($tot_swakelola));
        $sheet->setCellValue('J' . $cell, ($tot_kontrak));
        $sheet->setCellValue('K' . $cell, ($tot_fisik_keseluruhan));
        $sheet->setCellValue('L' . $cell, ($tot_keuangan));
        $sheet->setCellValue('M' . $cell, '');
        $sheet->setCellValue('N' . $cell, '');
        $sheet->setCellValue('O' . $cell, '');
        $sheet->setCellValue('P' . $cell, '');
        $sheet->setCellValue('Q' . $cell, '');
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
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
		if (hasRole('admin')){
        } else if (hasRole('opd')){
        $sheet->setCellValue('N' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('N'.$cell.':P'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('N' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('N'.$cell.':P'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('N' . ++$cell, request('nama',''))->mergeCells('N'.$cell.':P'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('N' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('N'.$cell.':P'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('N' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('N'.$cell.':P'.$cell);
        $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
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

    public function export_kemajuan_dak_semua($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected,$sumber_dana_selected)
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
        $spreadsheet->getDefaultStyle()->getFont()->setSize(24);

        //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.6);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

        $profile = ProfileDaerah::first();
        // Header Text
        if($sumber_dana_selected=='semua'){
            $sumber_dana_selected='DAK FISIK & NON FISIK';
        }else{
            $sumber_dana_selected=strtoupper($sumber_dana_selected);
        }
        $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', 'SUMBER DANA '.$sumber_dana_selected.' DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
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
        $sheet->setCellValue('E5', 'BOBOT (%)')->mergeCells('E5:E6');
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->setCellValue('F5', 'PELAKSANAAN KEGIATAN')->mergeCells('F5:G5');
        $sheet->setCellValue('H5', 'REALISASI')->mergeCells('H5:J5');
        $sheet->setCellValue('K5', 'REALISASI TERTIMBANG')->mergeCells('K5:L5');
        $sheet->setCellValue('M5', 'KET')->mergeCells('M5:M6');
        $sheet->getColumnDimension('M')->setWidth(10);

        $sheet->setCellValue('C6', 'DAK(Rp)')->getColumnDimension('C')->setWidth(20);
        $sheet->setCellValue('D6', 'Pendampingan(Rp)')->getColumnDimension('D')->setWidth(20);

        $sheet->setCellValue('F6', 'Swakelola(Rp)')->getColumnDimension('F')->setWidth(20);
        $sheet->setCellValue('G6', 'Kontrak(Rp)')->getColumnDimension('G')->setWidth(20);

        $sheet->setCellValue('H6', 'Keuangan(Rp)')->getColumnDimension('H')->setWidth(20);
        $sheet->setCellValue('I6', 'Fisik (%)')->getColumnDimension('I')->setWidth(10);
        $sheet->setCellValue('J6', 'Keu(%)')->getColumnDimension('J')->setWidth(10);

        $sheet->setCellValue('K6', 'Fisik (%)')->getColumnDimension('K')->setWidth(10);
        $sheet->setCellValue('L6', 'Keu(%)')->getColumnDimension('L')->setWidth(10);

        $sheet->getStyle('A:M')->getAlignment()->setIndent(1)->setWrapText(true);
        $sheet->getStyle('A1:M6')->getFont()->setBold(true);

        $cell = 7;
        $jumlah_bobot = 0;
		$jumlah_data= 0;

		$jumlah_dak=0;
        $jumlah_pendampingan=0;
		$jumlah_biaya=0;
		$jumlah_swakelola=0;
        $jumlah_kontrak=0;
		$jumlah_keuangan=0;
		$jumlah_persentase_fisik=0;
		$jumlah_persentase_keuangan=0;
		$jumlah_tertimbang_fisik=0;
		$jumlah_tertimbang_keuangan=0;




        foreach ($data AS $index => $row) {
			$bobot[$index]=0;
			$total_dak[$index]=0;
            $total_pendampingan[$index]=0;
			$total_biaya[$index]=0;
			$total_swakelola[$index]=0;
            $total_kontrak[$index]=0;
            $total_fisik[$index]=0;
            $total_keuangan[$index]=0;

			$persentase_fisik[$index]=0;
			$persentase_keuangan[$index]=0;

			$tertimbang_fisik[$index]=0;
			$tertimbang_keuangan[$index]=0;

			$jumlah_paket[$index]=0;


            foreach($row->Dpa As $dpa){
                foreach($dpa->SumberDanaDpa AS $sumber_dana){
                    foreach($sumber_dana->PaketDak AS $paket_dak){
						$jumlah_paket[$index]++;

                        $total_dak[$index]+=$paket_dak->anggaran_dak;
						$total_pendampingan[$index]+=$paket_dak->pendampingan;
						$total_biaya[$index]+=$paket_dak->pendampingan+$paket_dak->anggaran_dak;

						$bobot[$index]=$total_biaya[$index]/$total_pagu_keseluruhan*100;

                        $total_swakelola[$index]+=$paket_dak->swakelola;
                        $total_kontrak[$index]+=$paket_dak->kontrak;

                        $realisasi=$paket_dak->RealisasiDak->where('periode','<=',$periode_selected);;

						$fisik=$realisasi->sum('realisasi_fisik');
                        $keuangan=$realisasi->sum('realisasi_keuangan');

                        $total_fisik[$index]+=$fisik;
                        $total_keuangan[$index]+=$keuangan;

						$persentase_fisik[$index]=$total_fisik[$index]/$jumlah_paket[$index];
						$persentase_keuangan[$index]=$total_keuangan[$index]/$total_biaya[$index];

						$tertimbang_fisik[$index]=($persentase_fisik[$index]*$bobot[$index])/100;
						$tertimbang_keuangan[$index]=($persentase_keuangan[$index]*$bobot[$index])/100;
                    }

                }

            }
        }


        foreach ($data AS $index => $row){

			if($total_dak[$index]==0 && $total_pendampingan[$index]==0){
                continue;
            }
			else{
			$jumlah_data++;
            $sheet->setCellValue('A' . $cell, $cell - 6);
            $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
            $sheet->setCellValue('C' . $cell, ($total_dak[$index]));
            $sheet->setCellValue('D' . $cell, ($total_pendampingan[$index]));
            $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($bobot[$index],2));
            $sheet->setCellValue('F' . $cell, ($total_swakelola[$index]));
            $sheet->setCellValue('G' . $cell, ($total_kontrak[$index]));
            $sheet->setCellValue('H' . $cell, ($total_keuangan[$index]));
            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($persentase_fisik[$index],2));
			$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($persentase_keuangan[$index],2));

            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_fisik[$index],2));
            $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($tertimbang_keuangan[$index],2));
            $sheet->setCellValue('M' . $cell, '-');
            $cell++;
			}

			$jumlah_bobot+=$bobot[$index];
			$jumlah_dak+=$total_dak[$index];
			$jumlah_pendampingan+=$total_pendampingan[$index];
			$jumlah_biaya+=$total_biaya[$index];
			$jumlah_swakelola+=$total_swakelola[$index];
			$jumlah_kontrak+=$total_kontrak[$index];
			$jumlah_keuangan+=$total_keuangan[$index];
			$jumlah_persentase_fisik+=$persentase_fisik[$index];
			$jumlah_persentase_keuangan+=$persentase_keuangan[$index];
			$jumlah_tertimbang_fisik+=$tertimbang_fisik[$index];
			$jumlah_tertimbang_keuangan+=$tertimbang_keuangan[$index];

        }



        $sheet->getStyle('A1:M' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('D7:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('G7:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('H7:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('D7:D' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('G7:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        $sheet->getStyle('H7:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total



        $sheet->setCellValue('B' . $cell, 'JUMLAH');
        $sheet->setCellValue('C' . $cell, ($jumlah_dak));
        $sheet->setCellValue('D' . $cell, ($jumlah_pendampingan));
        $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($jumlah_bobot,2));
        $sheet->setCellValue('F' . $cell, ($jumlah_swakelola));
        $sheet->setCellValue('G' . $cell, ($jumlah_kontrak));
        $sheet->setCellValue('H' . $cell, ($jumlah_keuangan));
        $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_persentase_fisik/$jumlah_data,2));
        $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($jumlah_persentase_keuangan/$jumlah_data,2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($jumlah_tertimbang_fisik,2));
        $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($jumlah_tertimbang_keuangan,2));
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
        $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':M'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('I'.$cell.':M'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+3;
        $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':M'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':M'.$cell);
        $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':M'.$cell);
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




    //EVALUASI RENJA

    public function export_evaluasi_renja($tipe){
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

        $cek=BackupReport::whereRaw("tahun='$tahun' AND triwulan='$periode_selected'")->count();
        if($cek>0){
            //GET DATA BACKUP

            if ($periode_selected) {
                if (
    //            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
    //            &&
                !$unit_kerja_selected) {
                    $data = UnitKerja::with(['BackupReportDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {

                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{

                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->where('tahun', $tahun);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])->get();
                    $data = $data->map(function ($value) {
                        $value->Dpa = $value->BackupReportDpa->map(function ($value) {
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
                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->nilai_pagu_dpa;
                        });
                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->realisasi_keuangan;
                        });
                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->jumlah_tolak_ukur;
                        });
                        try {
                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                }) / $value->BackupReportDpa->count();
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
                    $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.BackupReportDpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])->where('id', $unit_kerja_selected)
                        ->whereHas('BidangUrusan.Program.Kegiatan.BackupReportDpa', function ($q) use ($tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected,$tahun) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }else{
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->whereRaw("sumber_dana LIKE '%DAK%'");
                                }
                                if ($jenis_belanja_selected)
                                    $q->where('jenis_belanja', $jenis_belanja_selected);
                                if ($metode_pelaksanaan_selected)
                                    $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            });
                        })
                        ->first();
                    $non_urusan = BidangUrusan::with(['Program.Kegiatan.BackupReportDpa' => function ($q) use ($unit_kerja_selected, $sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])
                        ->where('kode_bidang_urusan', '00')
                        ->whereHas('Program.Kegiatan.BackupReportDpa', function ($q) use ($unit_kerja_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                            $q->where('id_unit_kerja', $unit_kerja_selected);
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$tahun,$periode_selected) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }else{
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
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
                                    if ($value->BackupReportDpa->count()) {
                                        $kode_kegiatan_baru = $kode_program . '.' . $value->kode_kegiatan;
                                        $value->jumlah_sub_kegiatan = $value->Subkegiatan->count();
                                        $value->kode_kegiatan_baru = $kode_kegiatan_baru;
                                        $value->Dpa = $value->BackupReportDpa->map(function ($value) use ($kode_program, $non_urusan) {
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
                                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->nilai_pagu_dpa;
                                        });
                                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->realisasi_keuangan;
                                        });
                                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_tolak_ukur;
                                        });
                                        $value->jumlah_sumber_dana = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_sumber_dana;
                                        });
                                        try {
                                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                                    return $total + $value->realisasi_fisik;
                                                }) / $value->BackupReportDpa->count();
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

        }else{
            //GET DATA CURRENT

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
            // $fungsi = "export_evaluasi_renja_$fungsi";
            $fungsi = "export_evaluasi_renja_semua_unit_kerja";
        }
        return $this->{$fungsi}($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected,$sumber_dana_selected);
    }


    public function export_evaluasi_renja_semua_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected,$sumber_dana_selected)
    {
			$spreadsheet = new Spreadsheet();

			$spreadsheet->getProperties()->setCreator('AFILA')
			->setLastModifiedBy('AFILA')
			->setTitle('EVALUASI RKPD '.$dinas.'')
			->setSubject('EVALUASI RKPD '.$dinas.'')
			->setDescription('EVALUASI RKPD '.$dinas.'')
			->setKeywords('pdf php')
			->setCategory('EVALUASI RKPD');
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
			if($sumber_dana_selected=='semua'){
					$sumber_dana_selected='DAK FISIK & NON FISIK';
			}else{
					$sumber_dana_selected=strtoupper($sumber_dana_selected);
			}
			// Header Text
			$sheet->setCellValue('A1', 'EVALUASI TERHADAP HASIL RKPD PERANGKAT DAERAH KABUPATEN ENREKANG');
			$sheet->setCellValue('A2', 'RKPD '.strtoupper($dinas).' KABUPATEN ENREKANG ');
			$sheet->setCellValue('A3', 'SEMESTER I (TRIWULAN I DAN II) TA. '.$tahun);
			$sheet->mergeCells('A1:Z1');
			$sheet->mergeCells('A2:Z2');
			$sheet->mergeCells('A3:Z3');
			$sheet->getStyle('A1')->getFont()->setSize(12);

			$sheet->setCellValue('A5', 'No')->mergeCells('A5:A7');
			$sheet->getColumnDimension('A')->setWidth(20);
			$sheet->setCellValue('B5', 'Sasaran')->mergeCells('B5:B7');
			$sheet->getColumnDimension('B')->setWidth(20);
			$sheet->setCellValue('C5', 'Urusan/Bidang Urusan Pemerintah Daerah dan Program/Kegiatan')->mergeCells('C5:C7');
			$sheet->getColumnDimension('C')->setWidth(20);
			$sheet->setCellValue('D5', 'Indikator Kinerja Program (outcome) / Kegiatan (output)')->mergeCells('D5:D7');
			$sheet->getColumnDimension('D')->setWidth(20);
			$sheet->setCellValue('E5', 'Target Renstra OPD pada Tahun 2018 s/d 2023 (akhir periode Renstra OPD)')->mergeCells('E5:F6');
			$sheet->getColumnDimension('E')->setWidth(20);
			$sheet->setCellValue('G5', 'Realisasi Capaian Kinerja Renstra OPD s/d Renja OPD Tahun lalu (2020)')->mergeCells('G5:H6');
			$sheet->getColumnDimension('G')->setWidth(20);
			$sheet->setCellValue('I5', 'Target Kinerja dan Anggaran Renja OPD Tahun berjalan yang dievaluasi (2021)')->mergeCells('I5:J6');
			$sheet->getColumnDimension('I')->setWidth(20);
			$sheet->setCellValue('K5', 'Realisasi Kinerja Pada Triwulan')->mergeCells('K5:R5');
			$sheet->getColumnDimension('K')->setWidth(40);
			$sheet->setCellValue('S5', 'Realisasi Capaian Kinerja dan Anggaran Renja OPD  yang Dievaluasi')->mergeCells('S5:T6');
			$sheet->getColumnDimension('S')->setWidth(20);
			$sheet->setCellValue('U5', 'Realisasi kinerja dan Anggaran Renstra OPD s/d tahun 2020 (Ahkir Tahun pelaksanaan Renja OPD)')->mergeCells('U5:V6');
			$sheet->getColumnDimension('U')->setWidth(20);
			$sheet->setCellValue('W5', 'Tingkat Capaian Kinerja dan Realisasi Anggaran Renstra OPD s/d tahun 2020 (%)')->mergeCells('W5:X6');
			$sheet->getColumnDimension('W')->setWidth(20);
			$sheet->setCellValue('Y5', 'Unit OPD penanggung jawab')->mergeCells('Y5:Y7');
			$sheet->getColumnDimension('Y')->setWidth(20);
			$sheet->setCellValue('Z5', 'Ket')->mergeCells('Z5:Z7');

			$sheet->setCellValue('K6', 'I')->mergeCells('K6:L6');
			$sheet->getColumnDimension('K')->setWidth(10);
			$sheet->setCellValue('M6', 'II')->mergeCells('M6:N6');
			$sheet->getColumnDimension('M')->setWidth(10);
			$sheet->setCellValue('O6', 'III')->mergeCells('O6:P6');
			$sheet->getColumnDimension('O')->setWidth(10);
			$sheet->setCellValue('Q6', 'IV')->mergeCells('Q6:R6');
			$sheet->getColumnDimension('Q')->setWidth(10);


			$sheet->setCellValue('E7', 'K')->mergeCells('E7:E7')->getColumnDimension('E')->setWidth(10);
			$sheet->setCellValue('F7', 'Rp')->mergeCells('F7:F7')->getColumnDimension('F')->setWidth(10);
			$sheet->setCellValue('G7', 'K')->mergeCells('G7:G7')->getColumnDimension('G')->setWidth(10);
			$sheet->setCellValue('H7', 'Rp')->mergeCells('H7:H7')->getColumnDimension('H')->setWidth(10);
			$sheet->setCellValue('I7', 'K')->mergeCells('I7:I7')->getColumnDimension('I')->setWidth(10);
			$sheet->setCellValue('J7', 'Rp')->mergeCells('J7:J7')->getColumnDimension('J')->setWidth(10);
			$sheet->setCellValue('K7', 'K')->mergeCells('K7:K7')->getColumnDimension('K')->setWidth(10);
			$sheet->setCellValue('L7', 'Rp')->mergeCells('L7:L7')->getColumnDimension('L')->setWidth(10);
			$sheet->setCellValue('M7', 'K')->mergeCells('M7:M7')->getColumnDimension('M')->setWidth(10);
			$sheet->setCellValue('N7', 'Rp')->mergeCells('N7:N7')->getColumnDimension('N')->setWidth(10);
			$sheet->setCellValue('O7', 'K')->mergeCells('O7:O7')->getColumnDimension('O')->setWidth(10);
			$sheet->setCellValue('P7', 'Rp')->mergeCells('P7:P7')->getColumnDimension('P')->setWidth(10);
			$sheet->setCellValue('Q7', 'K')->mergeCells('Q7:Q7')->getColumnDimension('Q')->setWidth(10);
			$sheet->setCellValue('R7', 'Rp')->mergeCells('R7:R7')->getColumnDimension('R')->setWidth(10);
			$sheet->setCellValue('S7', 'K')->mergeCells('S7:S7')->getColumnDimension('S')->setWidth(10);
			$sheet->setCellValue('T7', 'Rp')->mergeCells('T7:T7')->getColumnDimension('T')->setWidth(10);
			$sheet->setCellValue('U7', 'K')->mergeCells('U7:U7')->getColumnDimension('U')->setWidth(10);
			$sheet->setCellValue('V7', 'Rp')->mergeCells('V7:V7')->getColumnDimension('V')->setWidth(10);
			$sheet->setCellValue('W7', 'K')->mergeCells('W7:W7')->getColumnDimension('W')->setWidth(10);
			$sheet->setCellValue('X7', 'Rp')->mergeCells('X7:X7')->getColumnDimension('X')->setWidth(10);
			$sheet->setCellValue('Y7', 'K')->mergeCells('Y7:Y7')->getColumnDimension('Y')->setWidth(10);
			$sheet->setCellValue('Z7', 'Rp')->mergeCells('Z7:Z7')->getColumnDimension('Z')->setWidth(10);

			$sheet->getStyle('A:Z')->getAlignment()->setWrapText(true);
			$sheet->getStyle('A1:Z7')->getFont()->setBold(true);

			$cell = 8;
			$sheet->setCellValue('A' . $cell, '1');
			$sheet->setCellValue('B' . $cell, '2');
			$sheet->setCellValue('C' . $cell,	'3');
			$sheet->setCellValue('D' . $cell, '4');
			$sheet->setCellValue('E' . $cell, '5')->mergeCells('E8:F8');
			$sheet->setCellValue('G' . $cell, '6')->mergeCells('G8:H8');
			$sheet->setCellValue('I' . $cell, '7')->mergeCells('I8:J8');
			$sheet->setCellValue('K' . $cell, '8')->mergeCells('K8:L8');
			$sheet->setCellValue('M' . $cell, '9')->mergeCells('M8:N8');
			$sheet->setCellValue('O' . $cell, '10')->mergeCells('O8:P8');
			$sheet->setCellValue('Q' . $cell, '11')->mergeCells('Q8:R8');
			$sheet->setCellValue('S' . $cell, '12=8+9+10+11')->mergeCells('S8:T8');
			$sheet->setCellValue('U' . $cell, '13=6+12')->mergeCells('U8:V8');
			$sheet->setCellValue('W' . $cell, '14=13/5x100')->mergeCells('W8:X8');
			$sheet->setCellValue('Y' . $cell, '15');
			$sheet->setCellValue('Z' . $cell, '16');


			$cell = 9;
			$sheet->setCellValue('C' . $cell,'Urusan Wajib Non Pelayanan Dasar');

			$cell = 10;
			$sheet->setCellValue('C' . $cell,'Bidang Urusan Pemberdayaan Perempuan dan Perlindungan Anak');

			for ($cell=11; $cell <20 ; $cell++) {
				// code...\

					$sheet->setCellValue('A' . $cell, '1');
					$sheet->setCellValue('B' . $cell, 'Meningkatnya kualitas dan pencapaian kinerja penyelenggaraan urusan perangkat daerah');
					$sheet->setCellValue('C' . $cell, 'Program Penunjang Urusan Pemerintah Daerah Kabupaten/ Kota');
					$sheet->setCellValue('D' . $cell, 'Persentase penunjang urusan perangkat daerah berjalan sesuai standar');
					$sheet->setCellValue('E' . $cell, '100%');
					$sheet->setCellValue('F' . $cell, '10.650.857.000');
					$sheet->setCellValue('G' . $cell, '');
					$sheet->setCellValue('H' . $cell, '');
					$sheet->setCellValue('I' . $cell, '100%');
					$sheet->setCellValue('J' . $cell, '3.074.452.650');
					$sheet->setCellValue('K' . $cell, '25%');
					$sheet->setCellValue('L' . $cell, '  492.775.283 ');
					$sheet->setCellValue('M' . $cell, '25%');
					$sheet->setCellValue('N' . $cell, '695.355.16');
					$sheet->setCellValue('O' . $cell, '');
					$sheet->setCellValue('P' . $cell, '');
					$sheet->setCellValue('Q' . $cell, '');
					$sheet->setCellValue('R' . $cell, '');
					$sheet->setCellValue('S' . $cell, '50%');
					$sheet->setCellValue('T' . $cell, '1.188.130.452');
					$sheet->setCellValue('U' . $cell, '50%');
					$sheet->setCellValue('V' . $cell, '1.188.130.452');
					$sheet->setCellValue('W' . $cell, '50%');
					$sheet->setCellValue('X' . $cell, '11,16');
					$sheet->setCellValue('Y' . $cell, 'DPP-PA');
					$sheet->setCellValue('Z' . $cell, '');
			}




			$sheet->getStyle('A1:AB' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$sheet->getStyle('A1:AB' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('A9:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B9:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('F9:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('G9:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle('H9:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle('I9:I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle('J9:J' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle('L9:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('C9:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('D9:D' . $cell)->getNumberFormat()->setFormatCode('#,##0');
	$sheet->getStyle('E9:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
	$sheet->getStyle('F9:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
	$sheet->getStyle('G9:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('H9:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('I9:I' . $cell)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('J9:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('L9:L' . $cell)->getNumberFormat()->setFormatCode('#,##0');


		 $sheet->getStyle('A' . $cell . ':Z' . $cell)->getFont()->setBold(true);
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

			$sheet->getStyle('A5:Z' . $cell)->applyFromArray($border);
			$cell++;
			$profile = ProfileDaerah::first();
			$tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
	if (hasRole('admin')){
			} else if (hasRole('opd')){
			$sheet->setCellValue('X' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('X'.$cell.':Z'.$cell);
			$sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('X' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('X'.$cell.':Z'.$cell);
			$sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$cell = $cell+6;
			$sheet->setCellValue('X' . ++$cell, request('nama',''))->mergeCells('X'.$cell.':Z'.$cell);
			$sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('X' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('X'.$cell.':Z'.$cell);
			$sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('X' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('X'.$cell.':Z'.$cell);
			$sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			}
	if($tipe == 'excel'){
					$writer = new Xlsx($spreadsheet);
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="EVALUASI RKPD '.$dinas.'.xlsx"');

			}else{
					$sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
					$spreadsheet->getActiveSheet()->getHeaderFooter()
							->setOddHeader('&C&H'.url()->current());
					$spreadsheet->getActiveSheet()->getHeaderFooter()
							->setOddFooter('&L&B &RPage &P of &N');
					$class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
					\PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
					header('Content-Type: application/pdf');
					// header('Content-Disposition: attachment;filename="EVALUASI RKPD '.$dinas.'.pdf"');
					header('Cache-Control: max-age=0');
					$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
			}
			$writer->save('php://output');
			exit;
    }


    //END EVALUASI RENJA





    //EVALUASI RENSTRA

    public function export_evaluasi_renstra($tipe){
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

        $cek=BackupReport::whereRaw("tahun='$tahun' AND triwulan='$periode_selected'")->count();
        if($cek>0){
            //GET DATA BACKUP

            if ($periode_selected) {
                if (
    //            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
    //            &&
                !$unit_kerja_selected) {
                    $data = UnitKerja::with(['BackupReportDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {

                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{

                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->where('tahun', $tahun);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])->get();
                    $data = $data->map(function ($value) {
                        $value->Dpa = $value->BackupReportDpa->map(function ($value) {
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
                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->nilai_pagu_dpa;
                        });
                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->realisasi_keuangan;
                        });
                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->jumlah_tolak_ukur;
                        });
                        try {
                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                }) / $value->BackupReportDpa->count();
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
                    $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.BackupReportDpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])->where('id', $unit_kerja_selected)
                        ->whereHas('BidangUrusan.Program.Kegiatan.BackupReportDpa', function ($q) use ($tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected,$tahun) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }else{
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->whereRaw("sumber_dana LIKE '%DAK%'");
                                }
                                if ($jenis_belanja_selected)
                                    $q->where('jenis_belanja', $jenis_belanja_selected);
                                if ($metode_pelaksanaan_selected)
                                    $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            });
                        })
                        ->first();
                    $non_urusan = BidangUrusan::with(['Program.Kegiatan.BackupReportDpa' => function ($q) use ($unit_kerja_selected, $sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])
                        ->where('kode_bidang_urusan', '00')
                        ->whereHas('Program.Kegiatan.BackupReportDpa', function ($q) use ($unit_kerja_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                            $q->where('id_unit_kerja', $unit_kerja_selected);
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$tahun,$periode_selected) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }else{
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
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
                                    if ($value->BackupReportDpa->count()) {
                                        $kode_kegiatan_baru = $kode_program . '.' . $value->kode_kegiatan;
                                        $value->jumlah_sub_kegiatan = $value->Subkegiatan->count();
                                        $value->kode_kegiatan_baru = $kode_kegiatan_baru;
                                        $value->Dpa = $value->BackupReportDpa->map(function ($value) use ($kode_program, $non_urusan) {
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
                                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->nilai_pagu_dpa;
                                        });
                                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->realisasi_keuangan;
                                        });
                                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_tolak_ukur;
                                        });
                                        $value->jumlah_sumber_dana = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_sumber_dana;
                                        });
                                        try {
                                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                                    return $total + $value->realisasi_fisik;
                                                }) / $value->BackupReportDpa->count();
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

        }else{
            //GET DATA CURRENT

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
            // $fungsi = "export_evaluasi_renstra_$fungsi";
            $fungsi = "export_evaluasi_renstra_semua_unit_kerja";
        }
        return $this->{$fungsi}($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected,$sumber_dana_selected);
    }


    public function export_evaluasi_renstra_semua_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected,$sumber_dana_selected)
    {
			$spreadsheet = new Spreadsheet();

			$spreadsheet->getProperties()->setCreator('AFILA')
			->setLastModifiedBy('AFILA')
			->setTitle('EVALUASI RPJMD '.$dinas.'')
			->setSubject('EVALUASI RPJMD '.$dinas.'')
			->setDescription('EVALUASI RPJMD '.$dinas.'')
			->setKeywords('pdf php')
			->setCategory('EVALUASI RPJMD');
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
			if($sumber_dana_selected=='semua'){
					$sumber_dana_selected='DAK FISIK & NON FISIK';
			}else{
					$sumber_dana_selected=strtoupper($sumber_dana_selected);
			}
			// Header Text
			$sheet->setCellValue('A1', 'EVALUASI TERHADAP PELAKSANAAN RPJMD PERIODE (2019-2023)');
			$sheet->setCellValue('A2', 'RPJMD '.strtoupper($dinas).'PEMERINTAH KABUPATEN ENEKANG');
			$sheet->setCellValue('A3', 'TAHUN PELAKSANAAN '.$tahun);
			$sheet->mergeCells('A1:X1');
			$sheet->mergeCells('A2:X2');
			$sheet->mergeCells('A3:X3');
			$sheet->getStyle('A1')->getFont()->setSize(12);

			$sheet->setCellValue('A5', 'No')->mergeCells('A5:A7');
			$sheet->getColumnDimension('A')->setWidth(20);
			$sheet->setCellValue('B5', 'Program Prioritas')->mergeCells('B5:B7');
			$sheet->getColumnDimension('B')->setWidth(40);
			$sheet->setCellValue('C5', 'Indikator Kinerja')->mergeCells('C5:D7');
			$sheet->getColumnDimension('C')->setWidth(10);
			$sheet->getColumnDimension('D')->setWidth(40);
			$sheet->setCellValue('E5', 'Kondisi Kinerja Awal RPJMD')->mergeCells('E5:E7');
			$sheet->getColumnDimension('E')->setWidth(20);
			$sheet->setCellValue('F5', 'Target Pada Akhir Tahun Perencanaan')->mergeCells('F5:F7');
			$sheet->getColumnDimension('F')->setWidth(20);
			$sheet->setCellValue('G5', 'Target RPJMD Kabupaten/Kota Pada RKPD Kabuapten/Kota Tahun Ke-')->mergeCells('G5:K6');
			$sheet->getColumnDimension('G')->setWidth(20);
			$sheet->setCellValue('L5', 'Capaian Target RPJMD Kabupaten/Kota Melalui Pelaksanaan RKPD Tahun Ke-')->mergeCells('L5:P6');
			$sheet->getColumnDimension('L')->setWidth(20);
			$sheet->setCellValue('Q5', 'Tingkat Capaian Target RPJMD Kabupaten/Kota Hasil Pelaksanaan RKPD Kabupaten/Kota Tahun Ke- (%)')->mergeCells('Q5:U6');
			$sheet->getColumnDimension('Q')->setWidth(40);
			$sheet->setCellValue('V5', 'Capaian Pada Akhir Tahun Perencanaan')->mergeCells('V5:V7');
			$sheet->getColumnDimension('V')->setWidth(20);
			$sheet->setCellValue('W5', 'Rasio Capaian Akhir (%)')->mergeCells('W5:W7');
			$sheet->getColumnDimension('W')->setWidth(20);
			$sheet->setCellValue('X5', 'Penanggung Jawab')->mergeCells('X5:X7');
			$sheet->getColumnDimension('X')->setWidth(20);



			$sheet->setCellValue('G7', '2019');
			$sheet->getColumnDimension('G')->setWidth(10);
			$sheet->setCellValue('H7', '2020');
			$sheet->getColumnDimension('H')->setWidth(10);
			$sheet->setCellValue('I7', '2021');
			$sheet->getColumnDimension('I')->setWidth(10);
			$sheet->setCellValue('J7', '2022');
			$sheet->getColumnDimension('G')->setWidth(10);
			$sheet->setCellValue('K7', '2023');
			$sheet->getColumnDimension('K')->setWidth(10);
			$sheet->setCellValue('L7', '2019');
			$sheet->getColumnDimension('L')->setWidth(10);
			$sheet->setCellValue('M7', '2020');
			$sheet->getColumnDimension('M')->setWidth(10);
			$sheet->setCellValue('N7', '2021');
			$sheet->getColumnDimension('N')->setWidth(10);
			$sheet->setCellValue('O7', '2022');
			$sheet->getColumnDimension('O')->setWidth(10);
			$sheet->setCellValue('P7', '2023');
			$sheet->getColumnDimension('P')->setWidth(10);
			$sheet->setCellValue('Q7', '2019');
			$sheet->getColumnDimension('Q')->setWidth(10);
			$sheet->setCellValue('R7', '2020');
			$sheet->getColumnDimension('R')->setWidth(10);
			$sheet->setCellValue('S7', '2021');
			$sheet->getColumnDimension('S')->setWidth(10);
			$sheet->setCellValue('T7', '2022');
			$sheet->getColumnDimension('T')->setWidth(10);
			$sheet->setCellValue('U7', '2023');
			$sheet->getColumnDimension('U')->setWidth(10);


			$sheet->getStyle('A:AB')->getAlignment()->setWrapText(true);
			$sheet->getStyle('A1:AB7')->getFont()->setBold(true);

			for ($cell=8; $cell <30 ; $cell++) {
				// code...


			$sheet->setCellValue('A' . $cell, '1');
			$sheet->setCellValue('B' . $cell, 'Program pembangunan jalan dan jembatan');
			$sheet->setCellValue('C' . $cell,'%');
			$sheet->setCellValue('D' . $cell, 'Persentase panjang jalan dalam kondisi baik ');
			$sheet->setCellValue('E' . $cell, '61,09');
			$sheet->setCellValue('F' . $cell, '72,00');
			$sheet->setCellValue('G' . $cell, '63,00');
			$sheet->setCellValue('H' . $cell, '65,00');
			$sheet->setCellValue('I' . $cell, '67,00');
			$sheet->setCellValue('J' . $cell, '69,00');
			$sheet->setCellValue('K' . $cell, '72,00');
			$sheet->setCellValue('L' . $cell, '62,00');
			$sheet->setCellValue('M' . $cell, '');
			$sheet->setCellValue('N' . $cell, '');
			$sheet->setCellValue('O' . $cell, '');
			$sheet->setCellValue('P' . $cell, '');
			$sheet->setCellValue('Q' . $cell, '98,41');
			$sheet->setCellValue('R' . $cell, '');
			$sheet->setCellValue('S' . $cell, '');
			$sheet->setCellValue('T' . $cell, '');
			$sheet->setCellValue('U' . $cell, '');
			$sheet->setCellValue('V' . $cell, '62,00');
			$sheet->setCellValue('W' . $cell, '86,11');
			$sheet->setCellValue('X' . $cell, 'PU');
			}

			$sheet->getStyle('A1:X' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$sheet->getStyle('A1:X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('A8:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('B8:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	$sheet->getStyle('F8:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('G8:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle('H8:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle('I8:I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle('J8:J' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle('L8:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
			$sheet->getStyle('C8:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('D8:D' . $cell)->getNumberFormat()->setFormatCode('#,##0');
	$sheet->getStyle('E8:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
	$sheet->getStyle('F8:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
	$sheet->getStyle('G8:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('H8:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('I8:I' . $cell)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('J8:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
			$sheet->getStyle('L8:L' . $cell)->getNumberFormat()->setFormatCode('#,##0');


		 $sheet->getStyle('A' . $cell . ':X' . $cell)->getFont()->setBold(true);
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

			$sheet->getStyle('A5:X' . $cell)->applyFromArray($border);
			$cell++;
			$profile = ProfileDaerah::first();
			$tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
	if (hasRole('admin')){
			} else if (hasRole('opd')){
			$sheet->setCellValue('X' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('X'.$cell.':Z'.$cell);
			$sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('X' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('X'.$cell.':Z'.$cell);
			$sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$cell = $cell+6;
			$sheet->setCellValue('X' . ++$cell, request('nama',''))->mergeCells('X'.$cell.':Z'.$cell);
			$sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('X' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('X'.$cell.':Z'.$cell);
			$sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('X' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('X'.$cell.':Z'.$cell);
			$sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			}
	if($tipe == 'excel'){
					$writer = new Xlsx($spreadsheet);
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
					header('Content-Disposition: attachment;filename="EVALUASI RPJMD '.$dinas.'.xlsx"');

			}else{
					$sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
					$spreadsheet->getActiveSheet()->getHeaderFooter()
							->setOddHeader('&C&H'.url()->current());
					$spreadsheet->getActiveSheet()->getHeaderFooter()
							->setOddFooter('&L&B &RPage &P of &N');
					$class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
					\PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
					header('Content-Type: application/pdf');
					// header('Content-Disposition: attachment;filename="EVALUASI RPJMD '.$dinas.'.pdf"');
					header('Cache-Control: max-age=0');
					$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
			}
			$writer->save('php://output');
			exit;
    }


    //END EVALUASI RENJA




    //EVALUASI RPJMD

    public function export_evaluasi_rpjmd($tipe){
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

        $cek=BackupReport::whereRaw("tahun='$tahun' AND triwulan='$periode_selected'")->count();
        if($cek>0){
            //GET DATA BACKUP

            if ($periode_selected) {
                if (
    //            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
    //            &&
                !$unit_kerja_selected) {
                    $data = UnitKerja::with(['BackupReportDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {

                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{

                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->where('tahun', $tahun);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])->get();
                    $data = $data->map(function ($value) {
                        $value->Dpa = $value->BackupReportDpa->map(function ($value) {
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
                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->nilai_pagu_dpa;
                        });
                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->realisasi_keuangan;
                        });
                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->jumlah_tolak_ukur;
                        });
                        try {
                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                }) / $value->BackupReportDpa->count();
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
                    $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.BackupReportDpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])->where('id', $unit_kerja_selected)
                        ->whereHas('BidangUrusan.Program.Kegiatan.BackupReportDpa', function ($q) use ($tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected,$tahun) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }else{
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->whereRaw("sumber_dana LIKE '%DAK%'");
                                }
                                if ($jenis_belanja_selected)
                                    $q->where('jenis_belanja', $jenis_belanja_selected);
                                if ($metode_pelaksanaan_selected)
                                    $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            });
                        })
                        ->first();
                    $non_urusan = BidangUrusan::with(['Program.Kegiatan.BackupReportDpa' => function ($q) use ($unit_kerja_selected, $sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])
                        ->where('kode_bidang_urusan', '00')
                        ->whereHas('Program.Kegiatan.BackupReportDpa', function ($q) use ($unit_kerja_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                            $q->where('id_unit_kerja', $unit_kerja_selected);
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$tahun,$periode_selected) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }else{
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
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
                                    if ($value->BackupReportDpa->count()) {
                                        $kode_kegiatan_baru = $kode_program . '.' . $value->kode_kegiatan;
                                        $value->jumlah_sub_kegiatan = $value->Subkegiatan->count();
                                        $value->kode_kegiatan_baru = $kode_kegiatan_baru;
                                        $value->Dpa = $value->BackupReportDpa->map(function ($value) use ($kode_program, $non_urusan) {
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
                                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->nilai_pagu_dpa;
                                        });
                                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->realisasi_keuangan;
                                        });
                                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_tolak_ukur;
                                        });
                                        $value->jumlah_sumber_dana = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_sumber_dana;
                                        });
                                        try {
                                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                                    return $total + $value->realisasi_fisik;
                                                }) / $value->BackupReportDpa->count();
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

        }else{
            //GET DATA CURRENT

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
            // $fungsi = "export_evaluasi_rpjmd_$fungsi";
            $fungsi = "export_evaluasi_rpjmd_semua_unit_kerja";
        }
        return $this->{$fungsi}($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected,$sumber_dana_selected);
    }


    public function export_evaluasi_rpjmd_semua_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected,$sumber_dana_selected)
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('AFILA')
        ->setLastModifiedBy('AFILA')
        ->setTitle('EVALUASI RPJMD '.$dinas.'')
        ->setSubject('EVALUASI RPJMD '.$dinas.'')
        ->setDescription('EVALUASI RPJMD '.$dinas.'')
        ->setKeywords('pdf php')
        ->setCategory('EVALUASI RPJMD');
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
        if($sumber_dana_selected=='semua'){
            $sumber_dana_selected='DAK FISIK & NON FISIK';
        }else{
            $sumber_dana_selected=strtoupper($sumber_dana_selected);
        }
        // Header Text
        $sheet->setCellValue('A1', 'EVALUASI TERHADAP PELAKSANAAN RPJMD PERIODE (2019-2023)');
        $sheet->setCellValue('A2', 'RPJMD '.strtoupper($dinas).'PEMERINTAH KABUPATEN ENEKANG');
        $sheet->setCellValue('A3', 'TAHUN PELAKSANAAN '.$tahun);
        $sheet->mergeCells('A1:X1');
        $sheet->mergeCells('A2:X2');
        $sheet->mergeCells('A3:X3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'No')->mergeCells('A5:A7');
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->setCellValue('B5', 'Program Prioritas')->mergeCells('B5:B7');
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->setCellValue('C5', 'Indikator Kinerja')->mergeCells('C5:D7');
        $sheet->getColumnDimension('C')->setWidth(10);
				$sheet->getColumnDimension('D')->setWidth(40);
        $sheet->setCellValue('E5', 'Kondisi Kinerja Awal RPJMD')->mergeCells('E5:E7');
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->setCellValue('F5', 'Target Pada Akhir Tahun Perencanaan')->mergeCells('F5:F7');
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->setCellValue('G5', 'Target RPJMD Kabupaten/Kota Pada RKPD Kabuapten/Kota Tahun Ke-')->mergeCells('G5:K6');
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->setCellValue('L5', 'Capaian Target RPJMD Kabupaten/Kota Melalui Pelaksanaan RKPD Tahun Ke-')->mergeCells('L5:P6');
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->setCellValue('Q5', 'Tingkat Capaian Target RPJMD Kabupaten/Kota Hasil Pelaksanaan RKPD Kabupaten/Kota Tahun Ke- (%)')->mergeCells('Q5:U6');
        $sheet->getColumnDimension('Q')->setWidth(40);
        $sheet->setCellValue('V5', 'Capaian Pada Akhir Tahun Perencanaan')->mergeCells('V5:V7');
        $sheet->getColumnDimension('V')->setWidth(20);
        $sheet->setCellValue('W5', 'Rasio Capaian Akhir (%)')->mergeCells('W5:W7');
        $sheet->getColumnDimension('W')->setWidth(20);
        $sheet->setCellValue('X5', 'Penanggung Jawab')->mergeCells('X5:X7');
        $sheet->getColumnDimension('X')->setWidth(20);



        $sheet->setCellValue('G7', '2019');
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->setCellValue('H7', '2020');
        $sheet->getColumnDimension('H')->setWidth(10);
        $sheet->setCellValue('I7', '2021');
        $sheet->getColumnDimension('I')->setWidth(10);
        $sheet->setCellValue('J7', '2022');
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->setCellValue('K7', '2023');
        $sheet->getColumnDimension('K')->setWidth(10);
				$sheet->setCellValue('L7', '2019');
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->setCellValue('M7', '2020');
        $sheet->getColumnDimension('M')->setWidth(10);
        $sheet->setCellValue('N7', '2021');
        $sheet->getColumnDimension('N')->setWidth(10);
        $sheet->setCellValue('O7', '2022');
        $sheet->getColumnDimension('O')->setWidth(10);
        $sheet->setCellValue('P7', '2023');
        $sheet->getColumnDimension('P')->setWidth(10);
				$sheet->setCellValue('Q7', '2019');
        $sheet->getColumnDimension('Q')->setWidth(10);
        $sheet->setCellValue('R7', '2020');
        $sheet->getColumnDimension('R')->setWidth(10);
        $sheet->setCellValue('S7', '2021');
        $sheet->getColumnDimension('S')->setWidth(10);
        $sheet->setCellValue('T7', '2022');
        $sheet->getColumnDimension('T')->setWidth(10);
        $sheet->setCellValue('U7', '2023');
        $sheet->getColumnDimension('U')->setWidth(10);


        $sheet->getStyle('A:AB')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:AB7')->getFont()->setBold(true);

				for ($cell=8; $cell <30 ; $cell++) {
					// code...


        $sheet->setCellValue('A' . $cell, '1');
        $sheet->setCellValue('B' . $cell, 'Program pembangunan jalan dan jembatan');
        $sheet->setCellValue('C' . $cell,'%');
        $sheet->setCellValue('D' . $cell, 'Persentase panjang jalan dalam kondisi baik ');
        $sheet->setCellValue('E' . $cell, '61,09');
        $sheet->setCellValue('F' . $cell, '72,00');
        $sheet->setCellValue('G' . $cell, '63,00');
        $sheet->setCellValue('H' . $cell, '65,00');
        $sheet->setCellValue('I' . $cell, '67,00');
        $sheet->setCellValue('J' . $cell, '69,00');
        $sheet->setCellValue('K' . $cell, '72,00');
        $sheet->setCellValue('L' . $cell, '62,00');
        $sheet->setCellValue('M' . $cell, '');
        $sheet->setCellValue('N' . $cell, '');
        $sheet->setCellValue('O' . $cell, '');
        $sheet->setCellValue('P' . $cell, '');
        $sheet->setCellValue('Q' . $cell, '98,41');
        $sheet->setCellValue('R' . $cell, '');
        $sheet->setCellValue('S' . $cell, '');
        $sheet->setCellValue('T' . $cell, '');
        $sheet->setCellValue('U' . $cell, '');
        $sheet->setCellValue('V' . $cell, '62,00');
        $sheet->setCellValue('W' . $cell, '86,11');
        $sheet->setCellValue('X' . $cell, 'PU');
				}

        $sheet->getStyle('A1:X' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A8:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		$sheet->getStyle('B8:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		$sheet->getStyle('F8:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('G8:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('H8:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('I8:I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('J8:J' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('L8:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('C8:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('D8:D' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('E8:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('F8:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('G8:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H8:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('I8:I' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J8:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L8:L' . $cell)->getNumberFormat()->setFormatCode('#,##0');


       $sheet->getStyle('A' . $cell . ':X' . $cell)->getFont()->setBold(true);
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

        $sheet->getStyle('A5:X' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
		if (hasRole('admin')){
        } else if (hasRole('opd')){
        $sheet->setCellValue('X' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('X'.$cell.':Z'.$cell);
        $sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('X' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('X'.$cell.':Z'.$cell);
        $sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+6;
        $sheet->setCellValue('X' . ++$cell, request('nama',''))->mergeCells('X'.$cell.':Z'.$cell);
        $sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('X' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('X'.$cell.':Z'.$cell);
        $sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('X' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('X'.$cell.':Z'.$cell);
        $sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
		if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="EVALUASI RPJMD '.$dinas.'.xlsx"');

        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            // header('Content-Disposition: attachment;filename="EVALUASI RPJMD '.$dinas.'.pdf"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }
        $writer->save('php://output');
        exit;
    }


    //END EVALUASI RPJMD


    //EVALUASI RKPD

    public function export_evaluasi_rkpd($tipe){
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

        $cek=BackupReport::whereRaw("tahun='$tahun' AND triwulan='$periode_selected'")->count();
        if($cek>0){
            //GET DATA BACKUP

            if ($periode_selected) {
                if (
    //            (($sumber_dana_selected == 'APBN' || $sumber_dana_selected == 'APBD I' || $sumber_dana_selected == 'APBD II') || ($sumber_dana_selected == 'DAK FISIK' || $sumber_dana_selected == 'DAK NON-FISIK'))
    //            &&
                !$unit_kerja_selected) {
                    $data = UnitKerja::with(['BackupReportDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {

                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{

                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->where('tahun', $tahun);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])->get();
                    $data = $data->map(function ($value) {
                        $value->Dpa = $value->BackupReportDpa->map(function ($value) {
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
                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->nilai_pagu_dpa;
                        });
                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->realisasi_keuangan;
                        });
                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                            return $total + $value->jumlah_tolak_ukur;
                        });
                        try {
                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                    return $total + $value->realisasi_fisik;
                                }) / $value->BackupReportDpa->count();
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
                    $data = UnitKerja::with(['BidangUrusan.Program.Kegiatan.BackupReportDpa' => function ($q) use ($sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected,$unit_kerja_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])->where('id', $unit_kerja_selected)
                        ->whereHas('BidangUrusan.Program.Kegiatan.BackupReportDpa', function ($q) use ($tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected,$tahun) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }else{
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->whereRaw("sumber_dana LIKE '%DAK%'");
                                }
                                if ($jenis_belanja_selected)
                                    $q->where('jenis_belanja', $jenis_belanja_selected);
                                if ($metode_pelaksanaan_selected)
                                    $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            });
                        })
                        ->first();
                    $non_urusan = BidangUrusan::with(['Program.Kegiatan.BackupReportDpa' => function ($q) use ($unit_kerja_selected, $sumber_dana_selected, $periode_selected, $tahun, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                        $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                        $q->where('id_unit_kerja', $unit_kerja_selected);
                        $q->where('tahun', $tahun);
                        $q->with(['SumberDanaDpa' => function ($q) use ($sumber_dana_selected, $tahun, $periode_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                            if ($jenis_belanja_selected)
                                $q->where('jenis_belanja', $jenis_belanja_selected);
                            if ($metode_pelaksanaan_selected)
                                $q->where('metode_pelaksanaan', $metode_pelaksanaan_selected);
                            $q->with(['DetailRealisasi' => function ($q) use ($periode_selected,$tahun) {
                                if ($periode_selected)
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('periode', '<=', $periode_selected);
                            }]);
                        }, 'TolakUkur', 'PegawaiPenanggungJawab']);
                        $q->whereHas('SumberDanaDpa', function ($q) use ($sumber_dana_selected,$tahun,$periode_selected) {
                            if ($sumber_dana_selected) {
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->where('sumber_dana', $sumber_dana_selected);
                            }else{
                                $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                $q->whereRaw("sumber_dana LIKE '%DAK%'");
                            }
                        });
                    }])
                        ->where('kode_bidang_urusan', '00')
                        ->whereHas('Program.Kegiatan.BackupReportDpa', function ($q) use ($unit_kerja_selected, $tahun, $sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$periode_selected) {
                            $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                            $q->where('id_unit_kerja', $unit_kerja_selected);
                            $q->where('tahun', $tahun);
                            $q->wherehas('SumberDanaDpa', function ($q) use ($sumber_dana_selected, $jenis_belanja_selected, $metode_pelaksanaan_selected,$tahun,$periode_selected) {
                                if ($sumber_dana_selected) {
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
                                    $q->where('sumber_dana', $sumber_dana_selected);
                                }else{
                                    $q->whereRaw("tahun='$tahun' AND triwulan='$periode_selected'");
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
                                    if ($value->BackupReportDpa->count()) {
                                        $kode_kegiatan_baru = $kode_program . '.' . $value->kode_kegiatan;
                                        $value->jumlah_sub_kegiatan = $value->Subkegiatan->count();
                                        $value->kode_kegiatan_baru = $kode_kegiatan_baru;
                                        $value->Dpa = $value->BackupReportDpa->map(function ($value) use ($kode_program, $non_urusan) {
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
                                        $value->total_pagu = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->nilai_pagu_dpa;
                                        });
                                        $value->realisasi_keuangan = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->realisasi_keuangan;
                                        });
                                        $value->jumlah_tolak_ukur = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_tolak_ukur;
                                        });
                                        $value->jumlah_sumber_dana = $value->BackupReportDpa->reduce(function ($total, $value) {
                                            return $total + $value->jumlah_sumber_dana;
                                        });
                                        try {
                                            $value->realisasi_fisik = $value->BackupReportDpa->reduce(function ($total, $value) {
                                                    return $total + $value->realisasi_fisik;
                                                }) / $value->BackupReportDpa->count();
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

        }else{
            //GET DATA CURRENT

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
            // $fungsi = "export_evaluasi_rkpd_$fungsi";
            $fungsi = "export_evaluasi_rkpd_semua_unit_kerja";
        }
        return $this->{$fungsi}($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected,$sumber_dana_selected);
    }


    public function export_evaluasi_rkpd_semua_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$periode_selected,$sumber_dana_selected)
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('AFILA')
        ->setLastModifiedBy('AFILA')
        ->setTitle('EVALUASI RKPD '.$dinas.'')
        ->setSubject('EVALUASI RKPD '.$dinas.'')
        ->setDescription('EVALUASI RKPD '.$dinas.'')
        ->setKeywords('pdf php')
        ->setCategory('EVALUASI RKPD');
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
        if($sumber_dana_selected=='semua'){
            $sumber_dana_selected='DAK FISIK & NON FISIK';
        }else{
            $sumber_dana_selected=strtoupper($sumber_dana_selected);
        }
        // Header Text
        $sheet->setCellValue('A1', 'EVALUASI TERHADAP HASIL RKPD PERANGKAT DAERAH KABUPATEN ENREKANG');
        $sheet->setCellValue('A2', 'RKPD '.strtoupper($dinas).' KABUPATEN ENREKANG ');
        $sheet->setCellValue('A3', 'SEMESTER I (TRIWULAN I DAN II) TA. '.$tahun);
        $sheet->mergeCells('A1:Z1');
        $sheet->mergeCells('A2:Z2');
        $sheet->mergeCells('A3:Z3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'No')->mergeCells('A5:A7');
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->setCellValue('B5', 'Sasaran')->mergeCells('B5:B7');
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->setCellValue('C5', 'Urusan/Bidang Urusan Pemerintah Daerah dan Program/Kegiatan')->mergeCells('C5:C7');
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->setCellValue('D5', 'Indikator Kinerja Program (outcome) / Kegiatan (output)')->mergeCells('D5:D7');
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->setCellValue('E5', 'Target Renstra OPD pada Tahun 2018 s/d 2023 (akhir periode Renstra OPD)')->mergeCells('E5:F6');
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->setCellValue('G5', 'Realisasi Capaian Kinerja Renstra OPD s/d Renja OPD Tahun lalu (2020)')->mergeCells('G5:H6');
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->setCellValue('I5', 'Target Kinerja dan Anggaran Renja OPD Tahun berjalan yang dievaluasi (2021)')->mergeCells('I5:J6');
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->setCellValue('K5', 'Realisasi Kinerja Pada Triwulan')->mergeCells('K5:R5');
        $sheet->getColumnDimension('K')->setWidth(40);
        $sheet->setCellValue('S5', 'Realisasi Capaian Kinerja dan Anggaran Renja OPD  yang Dievaluasi')->mergeCells('S5:T6');
        $sheet->getColumnDimension('S')->setWidth(20);
        $sheet->setCellValue('U5', 'Realisasi kinerja dan Anggaran Renstra OPD s/d tahun 2020 (Ahkir Tahun pelaksanaan Renja OPD)')->mergeCells('U5:V6');
        $sheet->getColumnDimension('U')->setWidth(20);
        $sheet->setCellValue('W5', 'Tingkat Capaian Kinerja dan Realisasi Anggaran Renstra OPD s/d tahun 2020 (%)')->mergeCells('W5:X6');
        $sheet->getColumnDimension('W')->setWidth(20);
        $sheet->setCellValue('Y5', 'Unit OPD penanggung jawab')->mergeCells('Y5:Y7');
        $sheet->getColumnDimension('Y')->setWidth(20);
        $sheet->setCellValue('Z5', 'Ket')->mergeCells('Z5:Z7');

        $sheet->setCellValue('K6', 'I')->mergeCells('K6:L6');
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->setCellValue('M6', 'II')->mergeCells('M6:N6');
        $sheet->getColumnDimension('M')->setWidth(10);
        $sheet->setCellValue('O6', 'III')->mergeCells('O6:P6');
        $sheet->getColumnDimension('O')->setWidth(10);
        $sheet->setCellValue('Q6', 'IV')->mergeCells('Q6:R6');
        $sheet->getColumnDimension('Q')->setWidth(10);


        $sheet->setCellValue('E7', 'K')->mergeCells('E7:E7')->getColumnDimension('E')->setWidth(10);
        $sheet->setCellValue('F7', 'Rp')->mergeCells('F7:F7')->getColumnDimension('F')->setWidth(10);
        $sheet->setCellValue('G7', 'K')->mergeCells('G7:G7')->getColumnDimension('G')->setWidth(10);
        $sheet->setCellValue('H7', 'Rp')->mergeCells('H7:H7')->getColumnDimension('H')->setWidth(10);
        $sheet->setCellValue('I7', 'K')->mergeCells('I7:I7')->getColumnDimension('I')->setWidth(10);
        $sheet->setCellValue('J7', 'Rp')->mergeCells('J7:J7')->getColumnDimension('J')->setWidth(10);
        $sheet->setCellValue('K7', 'K')->mergeCells('K7:K7')->getColumnDimension('K')->setWidth(10);
        $sheet->setCellValue('L7', 'Rp')->mergeCells('L7:L7')->getColumnDimension('L')->setWidth(10);
        $sheet->setCellValue('M7', 'K')->mergeCells('M7:M7')->getColumnDimension('M')->setWidth(10);
        $sheet->setCellValue('N7', 'Rp')->mergeCells('N7:N7')->getColumnDimension('N')->setWidth(10);
        $sheet->setCellValue('O7', 'K')->mergeCells('O7:O7')->getColumnDimension('O')->setWidth(10);
        $sheet->setCellValue('P7', 'Rp')->mergeCells('P7:P7')->getColumnDimension('P')->setWidth(10);
        $sheet->setCellValue('Q7', 'K')->mergeCells('Q7:Q7')->getColumnDimension('Q')->setWidth(10);
        $sheet->setCellValue('R7', 'Rp')->mergeCells('R7:R7')->getColumnDimension('R')->setWidth(10);
        $sheet->setCellValue('S7', 'K')->mergeCells('S7:S7')->getColumnDimension('S')->setWidth(10);
        $sheet->setCellValue('T7', 'Rp')->mergeCells('T7:T7')->getColumnDimension('T')->setWidth(10);
        $sheet->setCellValue('U7', 'K')->mergeCells('U7:U7')->getColumnDimension('U')->setWidth(10);
        $sheet->setCellValue('V7', 'Rp')->mergeCells('V7:V7')->getColumnDimension('V')->setWidth(10);
        $sheet->setCellValue('W7', 'K')->mergeCells('W7:W7')->getColumnDimension('W')->setWidth(10);
        $sheet->setCellValue('X7', 'Rp')->mergeCells('X7:X7')->getColumnDimension('X')->setWidth(10);
        $sheet->setCellValue('Y7', 'K')->mergeCells('Y7:Y7')->getColumnDimension('Y')->setWidth(10);
        $sheet->setCellValue('Z7', 'Rp')->mergeCells('Z7:Z7')->getColumnDimension('Z')->setWidth(10);

        $sheet->getStyle('A:Z')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:Z7')->getFont()->setBold(true);

        $cell = 8;
        $sheet->setCellValue('A' . $cell, '1');
        $sheet->setCellValue('B' . $cell, '2');
        $sheet->setCellValue('C' . $cell,	'3');
        $sheet->setCellValue('D' . $cell, '4');
        $sheet->setCellValue('E' . $cell, '5')->mergeCells('E8:F8');
        $sheet->setCellValue('G' . $cell, '6')->mergeCells('G8:H8');
        $sheet->setCellValue('I' . $cell, '7')->mergeCells('I8:J8');
        $sheet->setCellValue('K' . $cell, '8')->mergeCells('K8:L8');
        $sheet->setCellValue('M' . $cell, '9')->mergeCells('M8:N8');
        $sheet->setCellValue('O' . $cell, '10')->mergeCells('O8:P8');
        $sheet->setCellValue('Q' . $cell, '11')->mergeCells('Q8:R8');
        $sheet->setCellValue('S' . $cell, '12=8+9+10+11')->mergeCells('S8:T8');
        $sheet->setCellValue('U' . $cell, '13=6+12')->mergeCells('U8:V8');
        $sheet->setCellValue('W' . $cell, '14=13/5x100')->mergeCells('W8:X8');
        $sheet->setCellValue('Y' . $cell, '15');
        $sheet->setCellValue('Z' . $cell, '16');


        $cell = 9;
        $sheet->setCellValue('C' . $cell,'Urusan Wajib Non Pelayanan Dasar');

				$cell = 10;
				$sheet->setCellValue('C' . $cell,'Bidang Urusan Pemberdayaan Perempuan dan Perlindungan Anak');

				for ($cell=11; $cell <20 ; $cell++) {
					// code...\

		        $sheet->setCellValue('A' . $cell, '1');
		        $sheet->setCellValue('B' . $cell, 'Meningkatnya kualitas dan pencapaian kinerja penyelenggaraan urusan perangkat daerah');
		        $sheet->setCellValue('C' . $cell, 'Program Penunjang Urusan Pemerintah Daerah Kabupaten/ Kota');
		        $sheet->setCellValue('D' . $cell, 'Persentase penunjang urusan perangkat daerah berjalan sesuai standar');
		        $sheet->setCellValue('E' . $cell, '100%');
		        $sheet->setCellValue('F' . $cell, '10.650.857.000');
		        $sheet->setCellValue('G' . $cell, '');
		        $sheet->setCellValue('H' . $cell, '');
		        $sheet->setCellValue('I' . $cell, '100%');
		        $sheet->setCellValue('J' . $cell, '3.074.452.650');
		        $sheet->setCellValue('K' . $cell, '25%');
		        $sheet->setCellValue('L' . $cell, '  492.775.283 ');
		        $sheet->setCellValue('M' . $cell, '25%');
		        $sheet->setCellValue('N' . $cell, '695.355.16');
		        $sheet->setCellValue('O' . $cell, '');
		        $sheet->setCellValue('P' . $cell, '');
		        $sheet->setCellValue('Q' . $cell, '');
		        $sheet->setCellValue('R' . $cell, '');
		        $sheet->setCellValue('S' . $cell, '50%');
		        $sheet->setCellValue('T' . $cell, '1.188.130.452');
		        $sheet->setCellValue('U' . $cell, '50%');
		        $sheet->setCellValue('V' . $cell, '1.188.130.452');
		        $sheet->setCellValue('W' . $cell, '50%');
		        $sheet->setCellValue('X' . $cell, '11,16');
		        $sheet->setCellValue('Y' . $cell, 'DPP-PA');
		        $sheet->setCellValue('Z' . $cell, '');
				}




        $sheet->getStyle('A1:AB' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:AB' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A9:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		$sheet->getStyle('B9:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		$sheet->getStyle('F9:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('G9:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('H9:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('I9:I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('J9:J' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
		$sheet->getStyle('L9:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('C9:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('D9:D' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('E9:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('F9:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('G9:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H9:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('I9:I' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('J9:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('L9:L' . $cell)->getNumberFormat()->setFormatCode('#,##0');


       $sheet->getStyle('A' . $cell . ':Z' . $cell)->getFont()->setBold(true);
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

        $sheet->getStyle('A5:Z' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
		if (hasRole('admin')){
        } else if (hasRole('opd')){
        $sheet->setCellValue('X' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('X'.$cell.':Z'.$cell);
        $sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('X' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('X'.$cell.':Z'.$cell);
        $sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $cell = $cell+6;
        $sheet->setCellValue('X' . ++$cell, request('nama',''))->mergeCells('X'.$cell.':Z'.$cell);
        $sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('X' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('X'.$cell.':Z'.$cell);
        $sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('X' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('X'.$cell.':Z'.$cell);
        $sheet->getStyle('X' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
		if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="EVALUASI RKPD '.$dinas.'.xlsx"');

        }else{
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H'.url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            // header('Content-Disposition: attachment;filename="EVALUASI RKPD '.$dinas.'.pdf"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }
        $writer->save('php://output');
        exit;
    }


    //END EVALUASI RKPD




    public function export_semua($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$sumber_dana_selected)
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

		if($sumber_dana_selected=='semua'){
            $sumber_dana_selected='APBN, APBD I, APBD II, DAK & PEN';
        }else{
            $sumber_dana_selected=strtoupper($sumber_dana_selected);
        }
        // Header Text
        $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', 'SUMBER DANA '.$sumber_dana_selected.' KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
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


    //PARAM NO. REPORT
    public function export_semua_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun,$sumber_dana_selected)
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

        if($sumber_dana_selected=='semua'){
            $sumber_dana_selected='APBN, APBD I, APBD II, DAK & PEN';
        }else{
            $sumber_dana_selected=strtoupper($sumber_dana_selected);
        }

        // Header Text
        $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
        $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
        $sheet->setCellValue('A3', 'SUMBER DANA '.$sumber_dana_selected);
        $sheet->mergeCells('A1:M1');
        $sheet->mergeCells('A2:M2');
        $sheet->mergeCells('A3:M3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        $sheet->setCellValue('A5', 'KODE')->mergeCells('A5:A6');
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->setCellValue('B5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('B5:B6');
        $sheet->getColumnDimension('B')->setWidth(30);
		$sheet->setCellValue('C5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('C5:D5');
        $sheet->setCellValue('E5', 'JUMLAH DANA / DPA')->mergeCells('E5:E6');
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->setCellValue('F5', 'BOBOT')->mergeCells('F5:F6');
        $sheet->setCellValue('G5', 'REALISASI KEUANGAN (RP)')->mergeCells('G5:G6');
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->setCellValue('H5', 'REALISASI (%)')->mergeCells('H5:I5');
        $sheet->setCellValue('J5', 'TERTIMBANG %')->mergeCells('J5:K5');
        $sheet->setCellValue('L5', 'PPTK/PELAKSANA')->mergeCells('L5:L6');
        $sheet->getColumnDimension('L')->setWidth(18);
        $sheet->setCellValue('M5', 'KET')->MergeCells('M5:M6');

		$sheet->setCellValue('C6', 'TOLAK UKUR')->getColumnDimension('C')->setWidth(15);
        $sheet->setCellValue('D6', 'SATUAN (UNIT)')->getColumnDimension('D')->setWidth(12);
        $sheet->setCellValue('H6', 'FISIK')->getColumnDimension('H')->setWidth(8);
        $sheet->setCellValue('I6', 'KEUANGAN')->getColumnDimension('I')->setWidth(12);
        $sheet->setCellValue('J6', 'FISIK (%)')->getColumnDimension('J')->setWidth(10);
        $sheet->setCellValue('K6', 'KEUANGAN (%)')->getColumnDimension('K')->setWidth(15);

        $sheet->getStyle('A:M')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:M6')->getFont()->setBold(true);

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

                $sheet->setCellValue('A' . $cell, $row->kode_program_baru);
                $sheet->setCellValue('B' . $cell, $row->nama_program);
                $sheet->setCellValue('C' . $cell, '');
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
                $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
                $cell++;
                $no_kegiatan=0;
                foreach($row->Kegiatan AS $kegiatan){
                    if ($kegiatan){
                        $sheet->setCellValue('A' . $cell, $kegiatan->kode_kegiatan_baru);
                        $sheet->setCellValue('B' . $cell, $kegiatan->nama_kegiatan);
                        $sheet->setCellValue('C' . $cell,'');
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
                        $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
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
                            $sheet->setCellValue('A' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
                            $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
							$sheet->setCellValue('E' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("E$cell:E".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('G' . $cell, $dpa->realisasi_keuangan)->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('L' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $sheet->setCellValue('M' . $cell, '')->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
                            $cell++;
                            for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
                                $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
                                $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
                                $cell++;
                            }
                            foreach($dpa->SumberDanaDpa AS $sumber_dana){
                                $sheet->setCellValue('A' . $cell, '');
                                $sheet->setCellValue('B' . $cell, $sumber_dana->jenis_belanja);
								$sheet->setCellValue('C' . $cell, '');
                                $sheet->setCellValue('D' . $cell, '');
                                $sheet->setCellValue('E' . $cell, $sumber_dana->nilai_pagu);
                                $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
                                $sheet->setCellValue('G' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
                                $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
                                $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
                                $sheet->setCellValue('J' . $cell, '');
                                $sheet->setCellValue('K' . $cell, '');
                                $sheet->setCellValue('L' . $cell, '');
                                $sheet->setCellValue('M' . $cell, '');
                                $cell++;
                            }
                        }
                    }
                }
            }
        }

        $sheet->getStyle('A1:M' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A7:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('E7:E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('G7:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('L7:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle('E7:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
		$sheet->getStyle('G7:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');

        // Total
        $sheet->setCellValue('A' . $cell, 'JUMLAH');
		$sheet->setCellValue('C' . $cell, '');
        $sheet->setCellValue('D' . $cell, '');
        $sheet->setCellValue('E' . $cell, $total_pagu_keseluruhan);
        $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_bobot,2));
        $sheet->setCellValue('G' . $cell, $total_realisasi_keuangan);
        //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
        //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
        $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
        $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
        $sheet->setCellValue('L' . $cell, '');
        $sheet->setCellValue('M' . $cell, '');
        $sheet->getStyle('A' . $cell . ':M' . $cell)->getFont()->setBold(true);
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

        $sheet->getStyle('A5:M' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
		if (hasRole('admin')){
        } else if (hasRole('opd')){
            $sheet->setCellValue('K' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('K'.$cell.':M'.$cell);
			$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('K' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('K'.$cell.':M'.$cell);
			$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$cell = $cell+3;
			$sheet->setCellValue('K' . ++$cell, request('nama',''))->mergeCells('K'.$cell.':M'.$cell);
			$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('K' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('K'.$cell.':M'.$cell);
			$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
			$sheet->setCellValue('K' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('K'.$cell.':M'.$cell);
			$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }

        if($tipe == 'excel'){
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="REALISASI '.$sumber_dana_selected.' DINAS '.$dinas.'.xlsx"');

        }else{

            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':K'.$cell);
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




    // public function export_apbn($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(5)->setRowHeight(25);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     $profile = ProfileDaerah::first();
    //     // Header Text
    //     $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
    //     $sheet->setCellValue('A2', 'SUMBER DANA APBN DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
    //     $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
    //     $sheet->mergeCells('A1:L1');
    //     $sheet->mergeCells('A2:L2');
    //     $sheet->mergeCells('A3:L3');
    //     $sheet->getStyle('A1')->getFont()->setSize(12);

    //     $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
    //     $sheet->getColumnDimension('A')->setWidth(5);
    //     $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
    //     $sheet->getColumnDimension('B')->setWidth(40);
    //     $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
    //     $sheet->getColumnDimension('C')->setWidth(18);
    //     $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
    //     $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
    //     $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
    //     $sheet->getColumnDimension('F')->setWidth(18);
    //     $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
    //     $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
    //     $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
    //     $sheet->getColumnDimension('K')->setWidth(30);
    //     $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

    //     $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
    //     $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
    //     $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
    //     $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

    //     $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
    //     $sheet->getStyle('A1:L6')->getFont()->setBold(true);

    //     $cell = 7;
	// 	$total_data = 0;
	// 	$total_anggaran = 0;
	// 	$total_kegiatan = 0;
    //     $total_bobot = 0;
	// 	$total_realisasi = 0;
    //     $total_fisik = 0;
    //     $total_keuangan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     foreach ($data AS $index => $row) {
	// 		$dpa_anggaran = 0;
	// 		$dpa_kegiatan = 0;
	// 		$dpa_bobot = 0;
	// 		$dpa_realisasi = 0;
	// 		$dpa_fisik = 0;
	// 		$dpa_total_fisik = 0;
	// 		$dpa_total_keuangan = 0;
	// 		$bobot = 0;
	// 		$dpa_tertimbang_fisik = 0;
	// 		$dpa_tertimbang_keuangan = 0;

	// 		foreach($row->Dpa As $DPA1){
    //             $dpa_anggaran += $DPA1->nilai_pagu_dpa;
    //         }

    //         foreach($row->Dpa As $dpa){
	// 			$dpa_kegiatan ++;
	// 			$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
	// 			$dpa_realisasi += $dpa->realisasi_keuangan;
	// 			$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
	// 			$dpa_bobot+= $bobot;

    //         }



    //         if($dpa_anggaran==0){
    //             continue;
    //         }
	// 		else
	// 		{
	// 			$total_data++;
	// 			$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
	// 			$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;

	// 			$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
	// 			$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;


	// 			$total_anggaran += $dpa_anggaran;
	// 			$total_kegiatan += $dpa_kegiatan;
	// 			$total_bobot += $dpa_bobot;
	// 			$total_realisasi += $dpa_realisasi;
	// 			$total_fisik += $dpa_total_fisik;
	// 			$total_keuangan += $dpa_total_keuangan;
	// 			$total_tertimbang_fisik += $dpa_tertimbang_fisik;
	// 			$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
	// 		}

    //         $sheet->setCellValue('A' . $cell, $total_data);
    //         $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
    //         $sheet->setCellValue('C' . $cell, $dpa_anggaran);
    //         $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
    //         $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
    //         $sheet->setCellValue('F' . $cell, $dpa_realisasi);
    //         $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
    //         $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
    //         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
    //         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
    //         $sheet->setCellValue('K' . $cell, $row->nama_kepala);
    //         $sheet->setCellValue('L' . $cell, '-');
    //         $cell++;
    //     }

    //     $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

    //     // Total
    //     $sheet->setCellValue('B' . $cell, 'JUMLAH');
    //     $sheet->setCellValue('C' . $cell, $total_anggaran);
    //     $sheet->setCellValue('D' . $cell, $total_kegiatan);
    //     $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('F' . $cell, $total_realisasi);
    //     $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
    //     $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
    //     $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
	// 	$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->getStyle('A' . $cell . ':L' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $sheet->getStyle('B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A5:L' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
    //     $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $cell = $cell+3;
    //     $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     // $spreadsheet->getActiveSheet()->getStyle('A:L')->getAlignment()->setIndent(9);

    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI APBN.xlsx"');
    //     }else{
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B &RPage &P of &N');
    //         $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //         \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //         header('Content-Type: application/pdf');
    //         // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //         header('Cache-Control: max-age=0');
    //         $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_pen($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(5)->setRowHeight(25);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     $profile = ProfileDaerah::first();
    //     // Header Text
    //     $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
    //     $sheet->setCellValue('A2', 'SUMBER DANA PEN DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
    //     $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
    //     $sheet->mergeCells('A1:L1');
    //     $sheet->mergeCells('A2:L2');
    //     $sheet->mergeCells('A3:L3');
    //     $sheet->getStyle('A1')->getFont()->setSize(12);

    //     $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
    //     $sheet->getColumnDimension('A')->setWidth(5);
    //     $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
    //     $sheet->getColumnDimension('B')->setWidth(40);
    //     $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
    //     $sheet->getColumnDimension('C')->setWidth(18);
    //     $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
    //     $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
    //     $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
    //     $sheet->getColumnDimension('F')->setWidth(18);
    //     $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
    //     $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
    //     $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
    //     $sheet->getColumnDimension('K')->setWidth(30);
    //     $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

    //     $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
    //     $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
    //     $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
    //     $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

    //     $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
    //     $sheet->getStyle('A1:L6')->getFont()->setBold(true);

    //     $cell = 7;
	// 	$total_data = 0;
	// 	$total_anggaran = 0;
	// 	$total_kegiatan = 0;
    //     $total_bobot = 0;
	// 	$total_realisasi = 0;
    //     $total_fisik = 0;
    //     $total_keuangan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     foreach ($data AS $index => $row) {
	// 		$dpa_anggaran = 0;
	// 		$dpa_kegiatan = 0;
	// 		$dpa_bobot = 0;
	// 		$dpa_realisasi = 0;
	// 		$dpa_fisik = 0;
	// 		$dpa_total_fisik = 0;
	// 		$dpa_total_keuangan = 0;
	// 		$bobot = 0;
	// 		$dpa_tertimbang_fisik = 0;
	// 		$dpa_tertimbang_keuangan = 0;

	// 		foreach($row->Dpa As $DPA1){
    //             $dpa_anggaran += $DPA1->nilai_pagu_dpa;
    //         }

    //         foreach($row->Dpa As $dpa){
	// 			$dpa_kegiatan ++;
	// 			$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
	// 			$dpa_realisasi += $dpa->realisasi_keuangan;
	// 			$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
	// 			$dpa_bobot+= $bobot;

    //         }



    //         if($dpa_anggaran==0){
    //             continue;
    //         }
	// 		else
	// 		{
	// 			$total_data++;
	// 			$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
	// 			$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;

	// 			$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
	// 			$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;


	// 			$total_anggaran += $dpa_anggaran;
	// 			$total_kegiatan += $dpa_kegiatan;
	// 			$total_bobot += $dpa_bobot;
	// 			$total_realisasi += $dpa_realisasi;
	// 			$total_fisik += $dpa_total_fisik;
	// 			$total_keuangan += $dpa_total_keuangan;
	// 			$total_tertimbang_fisik += $dpa_tertimbang_fisik;
	// 			$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
	// 		}

    //         $sheet->setCellValue('A' . $cell, $total_data);
    //         $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
    //         $sheet->setCellValue('C' . $cell, $dpa_anggaran);
    //         $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
    //         $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
    //         $sheet->setCellValue('F' . $cell, $dpa_realisasi);
    //         $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
    //         $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
    //         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
    //         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
    //         $sheet->setCellValue('K' . $cell, $row->nama_kepala);
    //         $sheet->setCellValue('L' . $cell, '-');
    //         $cell++;
    //     }

    //     $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

    //     // Total
    //     $sheet->setCellValue('B' . $cell, 'JUMLAH');
    //     $sheet->setCellValue('C' . $cell, $total_anggaran);
    //     $sheet->setCellValue('D' . $cell, $total_kegiatan);
    //     $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('F' . $cell, $total_realisasi);
    //     $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
    //     $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
    //     $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
	// 	$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->getStyle('A' . $cell . ':L' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $sheet->getStyle('B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A5:L' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
    //     $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $cell = $cell+3;
    //     $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     // $spreadsheet->getActiveSheet()->getStyle('A:L')->getAlignment()->setIndent(9);

    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI APBN.xlsx"');
    //     }else{
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B &RPage &P of &N');
    //         $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //         \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //         header('Content-Type: application/pdf');
    //         // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //         header('Cache-Control: max-age=0');
    //         $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_apbd_i($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(5)->setRowHeight(25);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     $profile = ProfileDaerah::first();
    //     // Header Text
    //     $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
    //     $sheet->setCellValue('A2', 'SUMBER DANA APBD I DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
    //     $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
    //     $sheet->mergeCells('A1:L1');
    //     $sheet->mergeCells('A2:L2');
    //     $sheet->mergeCells('A3:L3');
    //     $sheet->getStyle('A1')->getFont()->setSize(12);

    //     $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
    //     $sheet->getColumnDimension('A')->setWidth(5);
    //     $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
    //     $sheet->getColumnDimension('B')->setWidth(40);
    //     $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
    //     $sheet->getColumnDimension('C')->setWidth(18);
    //     $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
    //     $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
    //     $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
    //     $sheet->getColumnDimension('F')->setWidth(18);
    //     $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
    //     $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
    //     $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
    //     $sheet->getColumnDimension('K')->setWidth(30);
    //     $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

    //     $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
    //     $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
    //     $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
    //     $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

    //     $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
    //     $sheet->getStyle('A1:L6')->getFont()->setBold(true);

    //     $cell = 7;
	// 	$total_data = 0;
	// 	$total_anggaran = 0;
	// 	$total_kegiatan = 0;
    //     $total_bobot = 0;
	// 	$total_realisasi = 0;
    //     $total_fisik = 0;
    //     $total_keuangan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     foreach ($data AS $index => $row) {
	// 		$dpa_anggaran = 0;
	// 		$dpa_kegiatan = 0;
	// 		$dpa_bobot = 0;
	// 		$dpa_realisasi = 0;
	// 		$dpa_fisik = 0;
	// 		$dpa_total_fisik = 0;
	// 		$dpa_total_keuangan = 0;
	// 		$bobot = 0;
	// 		$dpa_tertimbang_fisik = 0;
	// 		$dpa_tertimbang_keuangan = 0;

	// 		foreach($row->Dpa As $DPA1){
    //             $dpa_anggaran += $DPA1->nilai_pagu_dpa;
    //         }

    //         foreach($row->Dpa As $dpa){
	// 			$dpa_kegiatan ++;
	// 			$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
	// 			$dpa_realisasi += $dpa->realisasi_keuangan;
	// 			$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
	// 			$dpa_bobot+= $bobot;

    //         }



    //         if($dpa_anggaran==0){
    //             continue;
    //         }
	// 		else
	// 		{
	// 			$total_data++;
	// 			$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
	// 			$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;

	// 			$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
	// 			$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;


	// 			$total_anggaran += $dpa_anggaran;
	// 			$total_kegiatan += $dpa_kegiatan;
	// 			$total_bobot += $dpa_bobot;
	// 			$total_realisasi += $dpa_realisasi;
	// 			$total_fisik += $dpa_total_fisik;
	// 			$total_keuangan += $dpa_total_keuangan;
	// 			$total_tertimbang_fisik += $dpa_tertimbang_fisik;
	// 			$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
	// 		}

    //         $sheet->setCellValue('A' . $cell, $total_data);
    //         $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
    //         $sheet->setCellValue('C' . $cell, $dpa_anggaran);
    //         $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
    //         $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
    //         $sheet->setCellValue('F' . $cell, $dpa_realisasi);
    //         $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
    //         $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
    //         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
    //         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
    //         $sheet->setCellValue('K' . $cell, $row->nama_kepala);
    //         $sheet->setCellValue('L' . $cell, '-');
    //         $cell++;
    //     }

    //     $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

    //     // Total
    //     $sheet->setCellValue('B' . $cell, 'JUMLAH');
    //     $sheet->setCellValue('C' . $cell, $total_anggaran);
    //     $sheet->setCellValue('D' . $cell, $total_kegiatan);
    //     $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('F' . $cell, $total_realisasi);
    //     $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
    //     $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
    //     $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
	// 	$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->getStyle('A' . $cell . ':L' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $sheet->getStyle('B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A5:L' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
    //     $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $cell = $cell+3;
    //     $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI APBD I.xlsx"');
    //     }else{
    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_apbd_ii($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(5)->setRowHeight(25);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     $profile = ProfileDaerah::first();
    //     // Header Text
    //     $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
    //     $sheet->setCellValue('A2', 'SUMBER DANA APBD II DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
    //     $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
    //     $sheet->mergeCells('A1:L1');
    //     $sheet->mergeCells('A2:L2');
    //     $sheet->mergeCells('A3:L3');
    //     $sheet->getStyle('A1')->getFont()->setSize(12);

    //     $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
    //     $sheet->getColumnDimension('A')->setWidth(5);
    //     $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
    //     $sheet->getColumnDimension('B')->setWidth(40);
    //     $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
    //     $sheet->getColumnDimension('C')->setWidth(18);
    //     $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
    //     $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
    //     $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
    //     $sheet->getColumnDimension('F')->setWidth(18);
    //     $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
    //     $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
    //     $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
    //     $sheet->getColumnDimension('K')->setWidth(30);
    //     $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

    //     $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
    //     $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
    //     $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
    //     $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

    //     $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
    //     $sheet->getStyle('A1:L6')->getFont()->setBold(true);

    //     $cell = 7;
	// 	$total_data = 0;
	// 	$total_anggaran = 0;
	// 	$total_kegiatan = 0;
    //     $total_bobot = 0;
	// 	$total_realisasi = 0;
    //     $total_fisik = 0;
    //     $total_keuangan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     foreach ($data AS $index => $row) {
	// 		$dpa_anggaran = 0;
	// 		$dpa_kegiatan = 0;
	// 		$dpa_bobot = 0;
	// 		$dpa_realisasi = 0;
	// 		$dpa_fisik = 0;
	// 		$dpa_total_fisik = 0;
	// 		$dpa_total_keuangan = 0;
	// 		$bobot = 0;
	// 		$dpa_tertimbang_fisik = 0;
	// 		$dpa_tertimbang_keuangan = 0;

	// 		foreach($row->Dpa As $DPA1){
    //             $dpa_anggaran += $DPA1->nilai_pagu_dpa;
    //         }

    //         foreach($row->Dpa As $dpa){
	// 			$dpa_kegiatan ++;
	// 			$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
	// 			$dpa_realisasi += $dpa->realisasi_keuangan;
	// 			$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
	// 			$dpa_bobot+= $bobot;

    //         }



    //         if($dpa_anggaran==0){
    //             continue;
    //         }
	// 		else
	// 		{
	// 			$total_data++;
	// 			$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
	// 			$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;

	// 			$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
	// 			$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;


	// 			$total_anggaran += $dpa_anggaran;
	// 			$total_kegiatan += $dpa_kegiatan;
	// 			$total_bobot += $dpa_bobot;
	// 			$total_realisasi += $dpa_realisasi;
	// 			$total_fisik += $dpa_total_fisik;
	// 			$total_keuangan += $dpa_total_keuangan;
	// 			$total_tertimbang_fisik += $dpa_tertimbang_fisik;
	// 			$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
	// 		}

    //         $sheet->setCellValue('A' . $cell, $total_data);
    //         $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
    //         $sheet->setCellValue('C' . $cell, $dpa_anggaran);
    //         $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
    //         $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
    //         $sheet->setCellValue('F' . $cell, $dpa_realisasi);
    //         $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
    //         $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
    //         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
    //         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
    //         $sheet->setCellValue('K' . $cell, $row->nama_kepala);
    //         $sheet->setCellValue('L' . $cell, '-');
    //         $cell++;
    //     }

    //     $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

    //     // Total
    //     $sheet->setCellValue('B' . $cell, 'JUMLAH');
    //     $sheet->setCellValue('C' . $cell, $total_anggaran);
    //     $sheet->setCellValue('D' . $cell, $total_kegiatan);
    //     $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('F' . $cell, $total_realisasi);
    //     $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
    //     $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
    //     $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
	// 	$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->getStyle('A' . $cell . ':L' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $sheet->getStyle('B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A5:L' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
    //     $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $cell = $cell+3;
    //     $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI APBD II.xlsx"');
    //     }else{
    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_dak_fisik($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(5)->setRowHeight(25);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     $profile = ProfileDaerah::first();
    //     // Header Text
    //     $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
    //     $sheet->setCellValue('A2', 'SUMBER DANA DAK FISIK DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
    //     $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
    //     $sheet->mergeCells('A1:L1');
    //     $sheet->mergeCells('A2:L2');
    //     $sheet->mergeCells('A3:L3');
    //     $sheet->getStyle('A1')->getFont()->setSize(12);

    //     $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
    //     $sheet->getColumnDimension('A')->setWidth(5);
    //     $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
    //     $sheet->getColumnDimension('B')->setWidth(40);
    //     $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
    //     $sheet->getColumnDimension('C')->setWidth(18);
    //     $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
    //     $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
    //     $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
    //     $sheet->getColumnDimension('F')->setWidth(18);
    //     $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
    //     $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
    //     $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
    //     $sheet->getColumnDimension('K')->setWidth(30);
    //     $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

    //     $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
    //     $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
    //     $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
    //     $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

    //     $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
    //     $sheet->getStyle('A1:L6')->getFont()->setBold(true);

    //     $cell = 7;
	// 	$total_data = 0;
	// 	$total_anggaran = 0;
	// 	$total_kegiatan = 0;
    //     $total_bobot = 0;
	// 	$total_realisasi = 0;
    //     $total_fisik = 0;
    //     $total_keuangan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     foreach ($data AS $index => $row) {
	// 		$dpa_anggaran = 0;
	// 		$dpa_kegiatan = 0;
	// 		$dpa_bobot = 0;
	// 		$dpa_realisasi = 0;
	// 		$dpa_fisik = 0;
	// 		$dpa_total_fisik = 0;
	// 		$dpa_total_keuangan = 0;
	// 		$bobot = 0;
	// 		$dpa_tertimbang_fisik = 0;
	// 		$dpa_tertimbang_keuangan = 0;

	// 		foreach($row->Dpa As $DPA1){
    //             $dpa_anggaran += $DPA1->nilai_pagu_dpa;
    //         }

    //         foreach($row->Dpa As $dpa){
	// 			$dpa_kegiatan ++;
	// 			$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
	// 			$dpa_realisasi += $dpa->realisasi_keuangan;
	// 			$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
	// 			$dpa_bobot+= $bobot;

    //         }



    //         if($dpa_anggaran==0){
    //             continue;
    //         }
	// 		else
	// 		{
	// 			$total_data++;
	// 			$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
	// 			$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;

	// 			$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
	// 			$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;


	// 			$total_anggaran += $dpa_anggaran;
	// 			$total_kegiatan += $dpa_kegiatan;
	// 			$total_bobot += $dpa_bobot;
	// 			$total_realisasi += $dpa_realisasi;
	// 			$total_fisik += $dpa_total_fisik;
	// 			$total_keuangan += $dpa_total_keuangan;
	// 			$total_tertimbang_fisik += $dpa_tertimbang_fisik;
	// 			$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
	// 		}

    //         $sheet->setCellValue('A' . $cell, $total_data);
    //         $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
    //         $sheet->setCellValue('C' . $cell, $dpa_anggaran);
    //         $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
    //         $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
    //         $sheet->setCellValue('F' . $cell, $dpa_realisasi);
    //         $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
    //         $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
    //         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
    //         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
    //         $sheet->setCellValue('K' . $cell, $row->nama_kepala);
    //         $sheet->setCellValue('L' . $cell, '-');
    //         $cell++;
    //     }

    //     $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

    //     // Total
    //     $sheet->setCellValue('B' . $cell, 'JUMLAH');
    //     $sheet->setCellValue('C' . $cell, $total_anggaran);
    //     $sheet->setCellValue('D' . $cell, $total_kegiatan);
    //     $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('F' . $cell, $total_realisasi);
    //     $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
    //     $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
    //     $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
	// 	$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->getStyle('A' . $cell . ':L' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $sheet->getStyle('B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A5:L' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
    //     $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $cell = $cell+3;
    //     $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI DAK FISIK.xlsx"');
    //     }else{
    //         $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //         \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //         header('Content-Type: application/pdf');
    //         // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //         header('Cache-Control: max-age=0');
    //         $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_dak_non_fisik($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(5)->setRowHeight(25);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     $profile = ProfileDaerah::first();
    //     // Header Text
    //     $sheet->setCellValue('A1', 'REKAPITULASI LAPORAN PERKEMBANGAN KEMAJUAN FISIK DAN KEUANGAN');
    //     $sheet->setCellValue('A2', 'SUMBER DANA DAK NON FISIK DI KABUPATEN '.strtoupper(optional($profile)->nama_daerah));
    //     $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode).' TAHUN '.$tahun);
    //     $sheet->mergeCells('A1:L1');
    //     $sheet->mergeCells('A2:L2');
    //     $sheet->mergeCells('A3:L3');
    //     $sheet->getStyle('A1')->getFont()->setSize(12);

    //     $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
    //     $sheet->getColumnDimension('A')->setWidth(5);
    //     $sheet->setCellValue('B5', 'UNIT KERJA (SKPD)')->mergeCells('B5:B6');
    //     $sheet->getColumnDimension('B')->setWidth(40);
    //     $sheet->setCellValue('C5', 'ANGGARAN')->mergeCells('C5:C6');
    //     $sheet->getColumnDimension('C')->setWidth(18);
    //     $sheet->setCellValue('D5', 'JUMLAH KEGIATAN')->mergeCells('D5:D6');
    //     $sheet->setCellValue('E5', 'BOBOT')->mergeCells('E5:E6');
    //     $sheet->setCellValue('F5', 'REALISASI KEUANGAN (RP)')->mergeCells('F5:F6');
    //     $sheet->getColumnDimension('F')->setWidth(18);
    //     $sheet->setCellValue('G5', 'REALISASI (%)')->mergeCells('G5:H5');
    //     $sheet->setCellValue('I5', 'PRESENTASE TERTIMBANG')->mergeCells('I5:J5');
    //     $sheet->setCellValue('K5', 'KEPALA SKPD')->mergeCells('K5:K6');
    //     $sheet->getColumnDimension('K')->setWidth(30);
    //     $sheet->setCellValue('L5', 'KET')->MergeCells('L5:L6');

    //     $sheet->setCellValue('G6', 'Fisik')->getColumnDimension('G')->setWidth(10);
    //     $sheet->setCellValue('H6', 'Keu')->getColumnDimension('H')->setWidth(10);
    //     $sheet->setCellValue('I6', 'Fisik(%)')->getColumnDimension('K')->setWidth(30);
    //     $sheet->setCellValue('J6', 'Keu (%)')->getColumnDimension('L')->setWidth(15);

    //     $sheet->getStyle('A:L')->getAlignment()->setIndent(1)->setWrapText(true);
    //     $sheet->getStyle('A1:L6')->getFont()->setBold(true);

    //     $cell = 7;
	// 	$total_data = 0;
	// 	$total_anggaran = 0;
	// 	$total_kegiatan = 0;
    //     $total_bobot = 0;
	// 	$total_realisasi = 0;
    //     $total_fisik = 0;
    //     $total_keuangan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     foreach ($data AS $index => $row) {
	// 		$dpa_anggaran = 0;
	// 		$dpa_kegiatan = 0;
	// 		$dpa_bobot = 0;
	// 		$dpa_realisasi = 0;
	// 		$dpa_fisik = 0;
	// 		$dpa_total_fisik = 0;
	// 		$dpa_total_keuangan = 0;
	// 		$bobot = 0;
	// 		$dpa_tertimbang_fisik = 0;
	// 		$dpa_tertimbang_keuangan = 0;

	// 		foreach($row->Dpa As $DPA1){
    //             $dpa_anggaran += $DPA1->nilai_pagu_dpa;
    //         }

    //         foreach($row->Dpa As $dpa){
	// 			$dpa_kegiatan ++;
	// 			$bobot = $dpa_anggaran ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
	// 			$dpa_realisasi += $dpa->realisasi_keuangan;
	// 			$dpa_fisik += $dpa->realisasi_fisik*($dpa->nilai_pagu_dpa/$dpa_anggaran*100)/100;
	// 			$dpa_bobot+= $bobot;

    //         }



    //         if($dpa_anggaran==0){
    //             continue;
    //         }
	// 		else
	// 		{
	// 			$total_data++;
	// 			$dpa_total_fisik = $dpa_anggaran ? $dpa_fisik : 2;
	// 			$dpa_total_keuangan = $dpa_anggaran ? $dpa_realisasi/$dpa_anggaran*100 : 2;

	// 			$dpa_tertimbang_fisik = $dpa_bobot ? $dpa_total_fisik*$dpa_bobot/100 : 2;
	// 			$dpa_tertimbang_keuangan = $dpa_bobot ? $dpa_total_keuangan*$dpa_bobot/100 : 2;


	// 			$total_anggaran += $dpa_anggaran;
	// 			$total_kegiatan += $dpa_kegiatan;
	// 			$total_bobot += $dpa_bobot;
	// 			$total_realisasi += $dpa_realisasi;
	// 			$total_fisik += $dpa_total_fisik;
	// 			$total_keuangan += $dpa_total_keuangan;
	// 			$total_tertimbang_fisik += $dpa_tertimbang_fisik;
	// 			$total_tertimbang_keuangan += $dpa_tertimbang_keuangan;
	// 		}

    //         $sheet->setCellValue('A' . $cell, $total_data);
    //         $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
    //         $sheet->setCellValue('C' . $cell, $dpa_anggaran);
    //         $sheet->setCellValue('D' . $cell, $dpa_kegiatan);
    //         $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($dpa_bobot,2));
    //         $sheet->setCellValue('F' . $cell, $dpa_realisasi);
    //         $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($dpa_total_fisik,2));
    //         $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa_total_keuangan,2));
    //         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($dpa_tertimbang_fisik,2));
    //         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($dpa_tertimbang_keuangan,2));
    //         $sheet->setCellValue('K' . $cell, $row->nama_kepala);
    //         $sheet->setCellValue('L' . $cell, '-');
    //         $cell++;
    //     }

    //     $sheet->getStyle('A1:L' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A1:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('F7:F' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('K7:K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('F7:F' . $cell)->getNumberFormat()->setFormatCode('#,##0');

    //     // Total
    //     $sheet->setCellValue('B' . $cell, 'JUMLAH');
    //     $sheet->setCellValue('C' . $cell, $total_anggaran);
    //     $sheet->setCellValue('D' . $cell, $total_kegiatan);
    //     $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('F' . $cell, $total_realisasi);
    //     $sheet->setCellValue('G' . $cell, pembulatanDuaDecimal($total_data ? $total_fisik/$total_data : 0,2));
    //     $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($total_data ? $total_keuangan/$total_data : 0,2));
    //     $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
	// 	$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->getStyle('A' . $cell . ':L' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $sheet->getStyle('B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A5:L' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
    //     $sheet->setCellValue('I' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'Kepala Bappeda Litbang')->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $cell = $cell+3;
    //     $sheet->setCellValue('I' . ++$cell, request('nama',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('I' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('I'.$cell.':L'.$cell);
    //     $sheet->getStyle('I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI DAK NON FISIK.xlsx"');
    //     }else{
    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }


    // public function export_apbn_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(5)->setRowHeight(25);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     // Header Text
    //     $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
    //     $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
    //     $sheet->setCellValue('A3', 'SUMBER DANA APBN');
    //     $sheet->mergeCells('A1:M1');
    //     $sheet->mergeCells('A2:M2');
    //     $sheet->mergeCells('A3:M3');
    //     $sheet->getStyle('A1')->getFont()->setSize(12);

    //     $sheet->setCellValue('A5', 'KODE')->mergeCells('A5:A6');
    //     $sheet->getColumnDimension('A')->setWidth(20);
    //     $sheet->setCellValue('B5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('B5:B6');
    //     $sheet->getColumnDimension('B')->setWidth(30);
	// 	$sheet->setCellValue('C5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('C5:D5');
    //     $sheet->setCellValue('E5', 'JUMLAH DANA / DPA')->mergeCells('E5:E6');
    //     $sheet->getColumnDimension('E')->setWidth(15);
    //     $sheet->setCellValue('F5', 'BOBOT')->mergeCells('F5:F6');
    //     $sheet->setCellValue('G5', 'REALISASI KEUANGAN (RP)')->mergeCells('G5:G6');
    //     $sheet->getColumnDimension('G')->setWidth(18);
    //     $sheet->setCellValue('H5', 'REALISASI (%)')->mergeCells('H5:I5');
    //     $sheet->setCellValue('J5', 'TERTIMBANG %')->mergeCells('J5:K5');
    //     $sheet->setCellValue('L5', 'PPTK/PELAKSANA')->mergeCells('L5:L6');
    //     $sheet->getColumnDimension('L')->setWidth(18);
    //     $sheet->setCellValue('M5', 'KET')->MergeCells('M5:M6');

	// 	$sheet->setCellValue('C6', 'TOLAK UKUR')->getColumnDimension('C')->setWidth(15);
    //     $sheet->setCellValue('D6', 'SATUAN (UNIT)')->getColumnDimension('D')->setWidth(12);
    //     $sheet->setCellValue('H6', 'FISIK')->getColumnDimension('H')->setWidth(8);
    //     $sheet->setCellValue('I6', 'KEUANGAN')->getColumnDimension('I')->setWidth(12);
    //     $sheet->setCellValue('J6', 'FISIK (%)')->getColumnDimension('J')->setWidth(10);
    //     $sheet->setCellValue('K6', 'KEUANGAN (%)')->getColumnDimension('K')->setWidth(15);

    //     $sheet->getStyle('A:M')->getAlignment()->setWrapText(true);
    //     $sheet->getStyle('A1:M6')->getFont()->setBold(true);

    //     $cell = 7;
    //     $total_bobot = 0;
    //     $total_fisik = 0;
    //     $total_keuangan = 0;
    //     $jumlah_kegiatan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     $i=0;
    //     $no_program=0;
    //     foreach ($data AS $index => $row){
    //         if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
    //             $i++;

    //             // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));

    //             $sheet->setCellValue('A' . $cell, $row->kode_program_baru);
    //             $sheet->setCellValue('B' . $cell, $row->nama_program);
    //             $sheet->setCellValue('C' . $cell, '');
    //             $sheet->setCellValue('D' . $cell, '');
    //             $sheet->setCellValue('E' . $cell, '');
    //             $sheet->setCellValue('F' . $cell, '');
    //             $sheet->setCellValue('G' . $cell, '');
    //             $sheet->setCellValue('H' . $cell, '');
    //             $sheet->setCellValue('I' . $cell, '');
    //             $sheet->setCellValue('J' . $cell, '');
    //             $sheet->setCellValue('K' . $cell, '');
    //             $sheet->setCellValue('L' . $cell, '');
    //             $sheet->setCellValue('M' . $cell, '');
    //             $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
    //             $cell++;
    //             $no_kegiatan=0;
    //             foreach($row->Kegiatan AS $kegiatan){
    //                 if ($kegiatan){
    //                     $sheet->setCellValue('A' . $cell, $kegiatan->kode_kegiatan_baru);
    //                     $sheet->setCellValue('B' . $cell, $kegiatan->nama_kegiatan);
    //                     $sheet->setCellValue('C' . $cell,'');
    //                     $sheet->setCellValue('D' . $cell, '');
    //                     $sheet->setCellValue('E' . $cell, '');
    //                     $sheet->setCellValue('F' . $cell, '');
    //                     $sheet->setCellValue('G' . $cell, '');
    //                     $sheet->setCellValue('H' . $cell, '');
    //                     $sheet->setCellValue('I' . $cell, '');
    //                     $sheet->setCellValue('J' . $cell, '');
    //                     $sheet->setCellValue('K' . $cell, '');
    //                     $sheet->setCellValue('L' . $cell, '');
    //                     $sheet->setCellValue('M' . $cell, '');
    //                     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
    //                     $cell++;
    //                     $no_sub_kegiatan=0;
    //                     foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
    //                         $total_fisik += $dpa->realisasi_fisik;
    //                         $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
    //                         $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
    //                         $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
    //                         $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
    //                         $total_keuangan += $persentase_keuangan;
    //                         $total_tertimbang_fisik += $tertimbang_fisik;
    //                         $total_tertimbang_keuangan += $tertimbang_keuangan;
    //                         $jumlah_kegiatan++;
    //                         $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
    //                         $sheet->setCellValue('A' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
    //                         $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
	// 						$sheet->setCellValue('E' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("E$cell:E".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('G' . $cell, $dpa->realisasi_keuangan)->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('L' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('M' . $cell, '')->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $cell++;
    //                         for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
    //                             $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
    //                             $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
    //                             $cell++;
    //                         }
    //                         foreach($dpa->SumberDanaDpa AS $sumber_dana){
    //                             $sheet->setCellValue('A' . $cell, '');
    //                             $sheet->setCellValue('B' . $cell, $sumber_dana->jenis_belanja);
	// 							$sheet->setCellValue('C' . $cell, '');
    //                             $sheet->setCellValue('D' . $cell, '');
    //                             $sheet->setCellValue('E' . $cell, $sumber_dana->nilai_pagu);
    //                             $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
    //                             $sheet->setCellValue('G' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
    //                             $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
    //                             $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
    //                             $sheet->setCellValue('J' . $cell, '');
    //                             $sheet->setCellValue('K' . $cell, '');
    //                             $sheet->setCellValue('L' . $cell, '');
    //                             $sheet->setCellValue('M' . $cell, '');
    //                             $cell++;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     $sheet->getStyle('A1:M' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A1:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	// 	$sheet->getStyle('A7:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('E7:E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('G7:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('L7:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     $sheet->getStyle('E7:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
	// 	$sheet->getStyle('G7:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');

    //     // Total
    //     $sheet->setCellValue('A' . $cell, 'JUMLAH');
	// 	$sheet->setCellValue('C' . $cell, '');
    //     $sheet->setCellValue('D' . $cell, '');
    //     $sheet->setCellValue('E' . $cell, $total_pagu_keseluruhan);
    //     $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('G' . $cell, $total_realisasi_keuangan);
    //     //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
    //     //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
    //     $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
    //     $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->setCellValue('L' . $cell, '');
    //     $sheet->setCellValue('M' . $cell, '');
    //     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A5:M' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
	// 	if (hasRole('admin')){
    //     } else if (hasRole('opd')){
    //         $sheet->setCellValue('K' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$cell = $cell+3;
	// 		$sheet->setCellValue('K' . ++$cell, request('nama',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     }

    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI APBN DINAS '.$dinas.'.xlsx"');

    //     }else{

    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':K'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // //NEW PEN
    // public function export_pen_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(5)->setRowHeight(25);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     // Header Text
    //     $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
    //     $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
    //     $sheet->setCellValue('A3', 'SUMBER DANA PEN');
    //     $sheet->mergeCells('A1:M1');
    //     $sheet->mergeCells('A2:M2');
    //     $sheet->mergeCells('A3:M3');
    //     $sheet->getStyle('A1')->getFont()->setSize(12);

    //     $sheet->setCellValue('A5', 'KODE')->mergeCells('A5:A6');
    //     $sheet->getColumnDimension('A')->setWidth(20);
    //     $sheet->setCellValue('B5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('B5:B6');
    //     $sheet->getColumnDimension('B')->setWidth(30);
	// 	$sheet->setCellValue('C5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('C5:D5');
    //     $sheet->setCellValue('E5', 'JUMLAH DANA / DPA')->mergeCells('E5:E6');
    //     $sheet->getColumnDimension('E')->setWidth(15);
    //     $sheet->setCellValue('F5', 'BOBOT')->mergeCells('F5:F6');
    //     $sheet->setCellValue('G5', 'REALISASI KEUANGAN (RP)')->mergeCells('G5:G6');
    //     $sheet->getColumnDimension('G')->setWidth(18);
    //     $sheet->setCellValue('H5', 'REALISASI (%)')->mergeCells('H5:I5');
    //     $sheet->setCellValue('J5', 'TERTIMBANG %')->mergeCells('J5:K5');
    //     $sheet->setCellValue('L5', 'PPTK/PELAKSANA')->mergeCells('L5:L6');
    //     $sheet->getColumnDimension('L')->setWidth(18);
    //     $sheet->setCellValue('M5', 'KET')->MergeCells('M5:M6');

	// 	$sheet->setCellValue('C6', 'TOLAK UKUR')->getColumnDimension('C')->setWidth(15);
    //     $sheet->setCellValue('D6', 'SATUAN (UNIT)')->getColumnDimension('D')->setWidth(12);
    //     $sheet->setCellValue('H6', 'FISIK')->getColumnDimension('H')->setWidth(8);
    //     $sheet->setCellValue('I6', 'KEUANGAN')->getColumnDimension('I')->setWidth(12);
    //     $sheet->setCellValue('J6', 'FISIK (%)')->getColumnDimension('J')->setWidth(10);
    //     $sheet->setCellValue('K6', 'KEUANGAN (%)')->getColumnDimension('K')->setWidth(15);

    //     $sheet->getStyle('A:M')->getAlignment()->setWrapText(true);
    //     $sheet->getStyle('A1:M6')->getFont()->setBold(true);

    //     $cell = 7;
    //     $total_bobot = 0;
    //     $total_fisik = 0;
    //     $total_keuangan = 0;
    //     $jumlah_kegiatan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     $i=0;
    //     $no_program=0;
    //     foreach ($data AS $index => $row){
    //         if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
    //             $i++;

    //             // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));

    //             $sheet->setCellValue('A' . $cell, $row->kode_program_baru);
    //             $sheet->setCellValue('B' . $cell, $row->nama_program);
    //             $sheet->setCellValue('C' . $cell, '');
    //             $sheet->setCellValue('D' . $cell, '');
    //             $sheet->setCellValue('E' . $cell, '');
    //             $sheet->setCellValue('F' . $cell, '');
    //             $sheet->setCellValue('G' . $cell, '');
    //             $sheet->setCellValue('H' . $cell, '');
    //             $sheet->setCellValue('I' . $cell, '');
    //             $sheet->setCellValue('J' . $cell, '');
    //             $sheet->setCellValue('K' . $cell, '');
    //             $sheet->setCellValue('L' . $cell, '');
    //             $sheet->setCellValue('M' . $cell, '');
    //             $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
    //             $cell++;
    //             $no_kegiatan=0;
    //             foreach($row->Kegiatan AS $kegiatan){
    //                 if ($kegiatan){
    //                     $sheet->setCellValue('A' . $cell, $kegiatan->kode_kegiatan_baru);
    //                     $sheet->setCellValue('B' . $cell, $kegiatan->nama_kegiatan);
    //                     $sheet->setCellValue('C' . $cell,'');
    //                     $sheet->setCellValue('D' . $cell, '');
    //                     $sheet->setCellValue('E' . $cell, '');
    //                     $sheet->setCellValue('F' . $cell, '');
    //                     $sheet->setCellValue('G' . $cell, '');
    //                     $sheet->setCellValue('H' . $cell, '');
    //                     $sheet->setCellValue('I' . $cell, '');
    //                     $sheet->setCellValue('J' . $cell, '');
    //                     $sheet->setCellValue('K' . $cell, '');
    //                     $sheet->setCellValue('L' . $cell, '');
    //                     $sheet->setCellValue('M' . $cell, '');
    //                     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
    //                     $cell++;
    //                     $no_sub_kegiatan=0;
    //                     foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
    //                         $total_fisik += $dpa->realisasi_fisik;
    //                         $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
    //                         $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
    //                         $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
    //                         $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
    //                         $total_keuangan += $persentase_keuangan;
    //                         $total_tertimbang_fisik += $tertimbang_fisik;
    //                         $total_tertimbang_keuangan += $tertimbang_keuangan;
    //                         $jumlah_kegiatan++;
    //                         $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
    //                         $sheet->setCellValue('A' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
    //                         $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
	// 						$sheet->setCellValue('E' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("E$cell:E".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('G' . $cell, $dpa->realisasi_keuangan)->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('L' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('M' . $cell, '')->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $cell++;
    //                         for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
    //                             $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
    //                             $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
    //                             $cell++;
    //                         }
    //                         foreach($dpa->SumberDanaDpa AS $sumber_dana){
    //                             $sheet->setCellValue('A' . $cell, '');
    //                             $sheet->setCellValue('B' . $cell, $sumber_dana->jenis_belanja);
	// 							$sheet->setCellValue('C' . $cell, '');
    //                             $sheet->setCellValue('D' . $cell, '');
    //                             $sheet->setCellValue('E' . $cell, $sumber_dana->nilai_pagu);
    //                             $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
    //                             $sheet->setCellValue('G' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
    //                             $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
    //                             $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
    //                             $sheet->setCellValue('J' . $cell, '');
    //                             $sheet->setCellValue('K' . $cell, '');
    //                             $sheet->setCellValue('L' . $cell, '');
    //                             $sheet->setCellValue('M' . $cell, '');
    //                             $cell++;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     $sheet->getStyle('A1:M' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A1:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	// 	$sheet->getStyle('A7:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('E7:E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('G7:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('L7:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     $sheet->getStyle('E7:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
	// 	$sheet->getStyle('G7:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');

    //     // Total
    //     $sheet->setCellValue('A' . $cell, 'JUMLAH');
	// 	$sheet->setCellValue('C' . $cell, '');
    //     $sheet->setCellValue('D' . $cell, '');
    //     $sheet->setCellValue('E' . $cell, $total_pagu_keseluruhan);
    //     $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('G' . $cell, $total_realisasi_keuangan);
    //     //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
    //     //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
    //     $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
    //     $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->setCellValue('L' . $cell, '');
    //     $sheet->setCellValue('M' . $cell, '');
    //     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A5:M' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
	// 	if (hasRole('admin')){
    //     } else if (hasRole('opd')){
    //         $sheet->setCellValue('K' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$cell = $cell+3;
	// 		$sheet->setCellValue('K' . ++$cell, request('nama',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     }

    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI PEN '.$dinas.'.xlsx"');

    //     }else{

    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':K'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_apbd_i_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(5)->setRowHeight(25);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     // Header Text
    //     $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
    //     $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
    //     $sheet->setCellValue('A3', 'SUMBER DANA APBD I');
    //     $sheet->mergeCells('A1:M1');
    //     $sheet->mergeCells('A2:M2');
    //     $sheet->mergeCells('A3:M3');
    //     $sheet->getStyle('A1')->getFont()->setSize(12);

    //     $sheet->setCellValue('A5', 'KODE')->mergeCells('A5:A6');
    //     $sheet->getColumnDimension('A')->setWidth(20);
    //     $sheet->setCellValue('B5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('B5:B6');
    //     $sheet->getColumnDimension('B')->setWidth(30);
	// 	$sheet->setCellValue('C5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('C5:D5');
    //     $sheet->setCellValue('E5', 'JUMLAH DANA / DPA')->mergeCells('E5:E6');
    //     $sheet->getColumnDimension('E')->setWidth(15);
    //     $sheet->setCellValue('F5', 'BOBOT')->mergeCells('F5:F6');
    //     $sheet->setCellValue('G5', 'REALISASI KEUANGAN (RP)')->mergeCells('G5:G6');
    //     $sheet->getColumnDimension('G')->setWidth(18);
    //     $sheet->setCellValue('H5', 'REALISASI (%)')->mergeCells('H5:I5');
    //     $sheet->setCellValue('J5', 'TERTIMBANG %')->mergeCells('J5:K5');
    //     $sheet->setCellValue('L5', 'PPTK/PELAKSANA')->mergeCells('L5:L6');
    //     $sheet->getColumnDimension('L')->setWidth(18);
    //     $sheet->setCellValue('M5', 'KET')->MergeCells('M5:M6');

	// 	$sheet->setCellValue('C6', 'TOLAK UKUR')->getColumnDimension('C')->setWidth(15);
    //     $sheet->setCellValue('D6', 'SATUAN (UNIT)')->getColumnDimension('D')->setWidth(12);
    //     $sheet->setCellValue('H6', 'FISIK')->getColumnDimension('H')->setWidth(8);
    //     $sheet->setCellValue('I6', 'KEUANGAN')->getColumnDimension('I')->setWidth(12);
    //     $sheet->setCellValue('J6', 'FISIK (%)')->getColumnDimension('J')->setWidth(10);
    //     $sheet->setCellValue('K6', 'KEUANGAN (%)')->getColumnDimension('K')->setWidth(15);

    //     $sheet->getStyle('A:M')->getAlignment()->setWrapText(true);
    //     $sheet->getStyle('A1:M6')->getFont()->setBold(true);

    //     $cell = 7;
    //     $total_bobot = 0;
    //     $total_fisik = 0;
    //     $total_keuangan = 0;
    //     $jumlah_kegiatan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     $i=0;
    //     $no_program=0;
    //     foreach ($data AS $index => $row){
    //         if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
    //             $i++;

    //             // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));

    //             $sheet->setCellValue('A' . $cell, $row->kode_program_baru);
    //             $sheet->setCellValue('B' . $cell, $row->nama_program);
    //             $sheet->setCellValue('C' . $cell, '');
    //             $sheet->setCellValue('D' . $cell, '');
    //             $sheet->setCellValue('E' . $cell, '');
    //             $sheet->setCellValue('F' . $cell, '');
    //             $sheet->setCellValue('G' . $cell, '');
    //             $sheet->setCellValue('H' . $cell, '');
    //             $sheet->setCellValue('I' . $cell, '');
    //             $sheet->setCellValue('J' . $cell, '');
    //             $sheet->setCellValue('K' . $cell, '');
    //             $sheet->setCellValue('L' . $cell, '');
    //             $sheet->setCellValue('M' . $cell, '');
    //             $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
    //             $cell++;
    //             $no_kegiatan=0;
    //             foreach($row->Kegiatan AS $kegiatan){
    //                 if ($kegiatan){
    //                     $sheet->setCellValue('A' . $cell, $kegiatan->kode_kegiatan_baru);
    //                     $sheet->setCellValue('B' . $cell, $kegiatan->nama_kegiatan);
    //                     $sheet->setCellValue('C' . $cell,'');
    //                     $sheet->setCellValue('D' . $cell, '');
    //                     $sheet->setCellValue('E' . $cell, '');
    //                     $sheet->setCellValue('F' . $cell, '');
    //                     $sheet->setCellValue('G' . $cell, '');
    //                     $sheet->setCellValue('H' . $cell, '');
    //                     $sheet->setCellValue('I' . $cell, '');
    //                     $sheet->setCellValue('J' . $cell, '');
    //                     $sheet->setCellValue('K' . $cell, '');
    //                     $sheet->setCellValue('L' . $cell, '');
    //                     $sheet->setCellValue('M' . $cell, '');
    //                     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
    //                     $cell++;
    //                     $no_sub_kegiatan=0;
    //                     foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
    //                         $total_fisik += $dpa->realisasi_fisik;
    //                         $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
    //                         $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
    //                         $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
    //                         $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
    //                         $total_keuangan += $persentase_keuangan;
    //                         $total_tertimbang_fisik += $tertimbang_fisik;
    //                         $total_tertimbang_keuangan += $tertimbang_keuangan;
    //                         $jumlah_kegiatan++;
    //                         $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
    //                         $sheet->setCellValue('A' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
    //                         $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
	// 						$sheet->setCellValue('E' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("E$cell:E".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('G' . $cell, $dpa->realisasi_keuangan)->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('L' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('M' . $cell, '')->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $cell++;
    //                         for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
    //                             $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
    //                             $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
    //                             $cell++;
    //                         }
    //                         foreach($dpa->SumberDanaDpa AS $sumber_dana){
    //                             $sheet->setCellValue('A' . $cell, '');
    //                             $sheet->setCellValue('B' . $cell, $sumber_dana->jenis_belanja);
	// 							$sheet->setCellValue('C' . $cell, '');
    //                             $sheet->setCellValue('D' . $cell, '');
    //                             $sheet->setCellValue('E' . $cell, $sumber_dana->nilai_pagu);
    //                             $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
    //                             $sheet->setCellValue('G' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
    //                             $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
    //                             $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
    //                             $sheet->setCellValue('J' . $cell, '');
    //                             $sheet->setCellValue('K' . $cell, '');
    //                             $sheet->setCellValue('L' . $cell, '');
    //                             $sheet->setCellValue('M' . $cell, '');
    //                             $cell++;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     $sheet->getStyle('A1:M' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A1:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	// 	$sheet->getStyle('A7:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('E7:E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('G7:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('L7:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     $sheet->getStyle('E7:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
	// 	$sheet->getStyle('G7:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');

    //     // Total
    //     $sheet->setCellValue('A' . $cell, 'JUMLAH');
	// 	$sheet->setCellValue('C' . $cell, '');
    //     $sheet->setCellValue('D' . $cell, '');
    //     $sheet->setCellValue('E' . $cell, $total_pagu_keseluruhan);
    //     $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('G' . $cell, $total_realisasi_keuangan);
    //     //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
    //     //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
    //     $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
    //     $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->setCellValue('L' . $cell, '');
    //     $sheet->setCellValue('M' . $cell, '');
    //     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A5:M' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
	// 	if (hasRole('admin')){
    //     } else if (hasRole('opd')){
    //         $sheet->setCellValue('K' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$cell = $cell+3;
	// 		$sheet->setCellValue('K' . ++$cell, request('nama',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     }

    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI APBD I DINAS '.$dinas.'.xlsx"');

    //     }else{

    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':K'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_apbd_ii_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(5)->setRowHeight(25);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     // Header Text
    //     $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
    //     $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
    //     $sheet->setCellValue('A3', 'SUMBER DANA APBD II');
    //     $sheet->mergeCells('A1:M1');
    //     $sheet->mergeCells('A2:M2');
    //     $sheet->mergeCells('A3:M3');
    //     $sheet->getStyle('A1')->getFont()->setSize(12);

    //     $sheet->setCellValue('A5', 'KODE')->mergeCells('A5:A6');
    //     $sheet->getColumnDimension('A')->setWidth(20);
    //     $sheet->setCellValue('B5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('B5:B6');
    //     $sheet->getColumnDimension('B')->setWidth(30);
	// 	$sheet->setCellValue('C5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('C5:D5');
    //     $sheet->setCellValue('E5', 'JUMLAH DANA / DPA')->mergeCells('E5:E6');
    //     $sheet->getColumnDimension('E')->setWidth(15);
    //     $sheet->setCellValue('F5', 'BOBOT')->mergeCells('F5:F6');
    //     $sheet->setCellValue('G5', 'REALISASI KEUANGAN (RP)')->mergeCells('G5:G6');
    //     $sheet->getColumnDimension('G')->setWidth(18);
    //     $sheet->setCellValue('H5', 'REALISASI (%)')->mergeCells('H5:I5');
    //     $sheet->setCellValue('J5', 'TERTIMBANG %')->mergeCells('J5:K5');
    //     $sheet->setCellValue('L5', 'PPTK/PELAKSANA')->mergeCells('L5:L6');
    //     $sheet->getColumnDimension('L')->setWidth(18);
    //     $sheet->setCellValue('M5', 'KET')->MergeCells('M5:M6');

	// 	$sheet->setCellValue('C6', 'TOLAK UKUR')->getColumnDimension('C')->setWidth(15);
    //     $sheet->setCellValue('D6', 'SATUAN (UNIT)')->getColumnDimension('D')->setWidth(12);
    //     $sheet->setCellValue('H6', 'FISIK')->getColumnDimension('H')->setWidth(8);
    //     $sheet->setCellValue('I6', 'KEUANGAN')->getColumnDimension('I')->setWidth(12);
    //     $sheet->setCellValue('J6', 'FISIK (%)')->getColumnDimension('J')->setWidth(10);
    //     $sheet->setCellValue('K6', 'KEUANGAN (%)')->getColumnDimension('K')->setWidth(15);

    //     $sheet->getStyle('A:M')->getAlignment()->setWrapText(true);
    //     $sheet->getStyle('A1:M6')->getFont()->setBold(true);

    //     $cell = 7;
    //     $total_bobot = 0;
    //     $total_fisik = 0;
    //     $total_keuangan = 0;
    //     $jumlah_kegiatan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     $i=0;
    //     $no_program=0;
    //     foreach ($data AS $index => $row){
    //         if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
    //             $i++;

    //             // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));

    //             $sheet->setCellValue('A' . $cell, $row->kode_program_baru);
    //             $sheet->setCellValue('B' . $cell, $row->nama_program);
    //             $sheet->setCellValue('C' . $cell, '');
    //             $sheet->setCellValue('D' . $cell, '');
    //             $sheet->setCellValue('E' . $cell, '');
    //             $sheet->setCellValue('F' . $cell, '');
    //             $sheet->setCellValue('G' . $cell, '');
    //             $sheet->setCellValue('H' . $cell, '');
    //             $sheet->setCellValue('I' . $cell, '');
    //             $sheet->setCellValue('J' . $cell, '');
    //             $sheet->setCellValue('K' . $cell, '');
    //             $sheet->setCellValue('L' . $cell, '');
    //             $sheet->setCellValue('M' . $cell, '');
    //             $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
    //             $cell++;
    //             $no_kegiatan=0;
    //             foreach($row->Kegiatan AS $kegiatan){
    //                 if ($kegiatan){
    //                     $sheet->setCellValue('A' . $cell, $kegiatan->kode_kegiatan_baru);
    //                     $sheet->setCellValue('B' . $cell, $kegiatan->nama_kegiatan);
    //                     $sheet->setCellValue('C' . $cell,'');
    //                     $sheet->setCellValue('D' . $cell, '');
    //                     $sheet->setCellValue('E' . $cell, '');
    //                     $sheet->setCellValue('F' . $cell, '');
    //                     $sheet->setCellValue('G' . $cell, '');
    //                     $sheet->setCellValue('H' . $cell, '');
    //                     $sheet->setCellValue('I' . $cell, '');
    //                     $sheet->setCellValue('J' . $cell, '');
    //                     $sheet->setCellValue('K' . $cell, '');
    //                     $sheet->setCellValue('L' . $cell, '');
    //                     $sheet->setCellValue('M' . $cell, '');
    //                     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
    //                     $cell++;
    //                     $no_sub_kegiatan=0;
    //                     foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
    //                         $total_fisik += $dpa->realisasi_fisik;
    //                         $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
    //                         $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
    //                         $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
    //                         $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
    //                         $total_keuangan += $persentase_keuangan;
    //                         $total_tertimbang_fisik += $tertimbang_fisik;
    //                         $total_tertimbang_keuangan += $tertimbang_keuangan;
    //                         $jumlah_kegiatan++;
    //                         $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
    //                         $sheet->setCellValue('A' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
    //                         $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
	// 						$sheet->setCellValue('E' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("E$cell:E".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('G' . $cell, $dpa->realisasi_keuangan)->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('L' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('M' . $cell, '')->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $cell++;
    //                         for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
    //                             $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
    //                             $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
    //                             $cell++;
    //                         }
    //                         foreach($dpa->SumberDanaDpa AS $sumber_dana){
    //                             $sheet->setCellValue('A' . $cell, '');
    //                             $sheet->setCellValue('B' . $cell, $sumber_dana->jenis_belanja);
	// 							$sheet->setCellValue('C' . $cell, '');
    //                             $sheet->setCellValue('D' . $cell, '');
    //                             $sheet->setCellValue('E' . $cell, $sumber_dana->nilai_pagu);
    //                             $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
    //                             $sheet->setCellValue('G' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
    //                             $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
    //                             $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
    //                             $sheet->setCellValue('J' . $cell, '');
    //                             $sheet->setCellValue('K' . $cell, '');
    //                             $sheet->setCellValue('L' . $cell, '');
    //                             $sheet->setCellValue('M' . $cell, '');
    //                             $cell++;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     $sheet->getStyle('A1:M' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A1:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	// 	$sheet->getStyle('A7:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('E7:E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('G7:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('L7:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     $sheet->getStyle('E7:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
	// 	$sheet->getStyle('G7:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');

    //     // Total
    //     $sheet->setCellValue('A' . $cell, 'JUMLAH');
	// 	$sheet->setCellValue('C' . $cell, '');
    //     $sheet->setCellValue('D' . $cell, '');
    //     $sheet->setCellValue('E' . $cell, $total_pagu_keseluruhan);
    //     $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('G' . $cell, $total_realisasi_keuangan);
    //     //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
    //     //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
    //     $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
    //     $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->setCellValue('L' . $cell, '');
    //     $sheet->setCellValue('M' . $cell, '');
    //     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A5:M' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
	// 	if (hasRole('admin')){
    //     } else if (hasRole('opd')){
    //         $sheet->setCellValue('K' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$cell = $cell+3;
	// 		$sheet->setCellValue('K' . ++$cell, request('nama',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     }

    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI APBD II DINAS '.$dinas.'.xlsx"');

    //     }else{

    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':K'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_dak_fisik_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(5)->setRowHeight(25);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     // Header Text
    //     $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
    //     $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
    //     $sheet->setCellValue('A3', 'SUMBER DANA DAK FISIK');
    //     $sheet->mergeCells('A1:M1');
    //     $sheet->mergeCells('A2:M2');
    //     $sheet->mergeCells('A3:M3');
    //     $sheet->getStyle('A1')->getFont()->setSize(12);

    //     $sheet->setCellValue('A5', 'KODE')->mergeCells('A5:A6');
    //     $sheet->getColumnDimension('A')->setWidth(20);
    //     $sheet->setCellValue('B5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('B5:B6');
    //     $sheet->getColumnDimension('B')->setWidth(30);
	// 	$sheet->setCellValue('C5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('C5:D5');
    //     $sheet->setCellValue('E5', 'JUMLAH DANA / DPA')->mergeCells('E5:E6');
    //     $sheet->getColumnDimension('E')->setWidth(15);
    //     $sheet->setCellValue('F5', 'BOBOT')->mergeCells('F5:F6');
    //     $sheet->setCellValue('G5', 'REALISASI KEUANGAN (RP)')->mergeCells('G5:G6');
    //     $sheet->getColumnDimension('G')->setWidth(18);
    //     $sheet->setCellValue('H5', 'REALISASI (%)')->mergeCells('H5:I5');
    //     $sheet->setCellValue('J5', 'TERTIMBANG %')->mergeCells('J5:K5');
    //     $sheet->setCellValue('L5', 'PPTK/PELAKSANA')->mergeCells('L5:L6');
    //     $sheet->getColumnDimension('L')->setWidth(18);
    //     $sheet->setCellValue('M5', 'KET')->MergeCells('M5:M6');

	// 	$sheet->setCellValue('C6', 'TOLAK UKUR')->getColumnDimension('C')->setWidth(15);
    //     $sheet->setCellValue('D6', 'SATUAN (UNIT)')->getColumnDimension('D')->setWidth(12);
    //     $sheet->setCellValue('H6', 'FISIK')->getColumnDimension('H')->setWidth(8);
    //     $sheet->setCellValue('I6', 'KEUANGAN')->getColumnDimension('I')->setWidth(12);
    //     $sheet->setCellValue('J6', 'FISIK (%)')->getColumnDimension('J')->setWidth(10);
    //     $sheet->setCellValue('K6', 'KEUANGAN (%)')->getColumnDimension('K')->setWidth(15);

    //     $sheet->getStyle('A:M')->getAlignment()->setWrapText(true);
    //     $sheet->getStyle('A1:M6')->getFont()->setBold(true);

    //     $cell = 7;
    //     $total_bobot = 0;
    //     $total_fisik = 0;
    //     $total_keuangan = 0;
    //     $jumlah_kegiatan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     $i=0;
    //     $no_program=0;
    //     foreach ($data AS $index => $row){
    //         if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
    //             $i++;

    //             // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));

    //             $sheet->setCellValue('A' . $cell, $row->kode_program_baru);
    //             $sheet->setCellValue('B' . $cell, $row->nama_program);
    //             $sheet->setCellValue('C' . $cell, '');
    //             $sheet->setCellValue('D' . $cell, '');
    //             $sheet->setCellValue('E' . $cell, '');
    //             $sheet->setCellValue('F' . $cell, '');
    //             $sheet->setCellValue('G' . $cell, '');
    //             $sheet->setCellValue('H' . $cell, '');
    //             $sheet->setCellValue('I' . $cell, '');
    //             $sheet->setCellValue('J' . $cell, '');
    //             $sheet->setCellValue('K' . $cell, '');
    //             $sheet->setCellValue('L' . $cell, '');
    //             $sheet->setCellValue('M' . $cell, '');
    //             $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
    //             $cell++;
    //             $no_kegiatan=0;
    //             foreach($row->Kegiatan AS $kegiatan){
    //                 if ($kegiatan){
    //                     $sheet->setCellValue('A' . $cell, $kegiatan->kode_kegiatan_baru);
    //                     $sheet->setCellValue('B' . $cell, $kegiatan->nama_kegiatan);
    //                     $sheet->setCellValue('C' . $cell,'');
    //                     $sheet->setCellValue('D' . $cell, '');
    //                     $sheet->setCellValue('E' . $cell, '');
    //                     $sheet->setCellValue('F' . $cell, '');
    //                     $sheet->setCellValue('G' . $cell, '');
    //                     $sheet->setCellValue('H' . $cell, '');
    //                     $sheet->setCellValue('I' . $cell, '');
    //                     $sheet->setCellValue('J' . $cell, '');
    //                     $sheet->setCellValue('K' . $cell, '');
    //                     $sheet->setCellValue('L' . $cell, '');
    //                     $sheet->setCellValue('M' . $cell, '');
    //                     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
    //                     $cell++;
    //                     $no_sub_kegiatan=0;
    //                     foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
    //                         $total_fisik += $dpa->realisasi_fisik;
    //                         $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
    //                         $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
    //                         $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
    //                         $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
    //                         $total_keuangan += $persentase_keuangan;
    //                         $total_tertimbang_fisik += $tertimbang_fisik;
    //                         $total_tertimbang_keuangan += $tertimbang_keuangan;
    //                         $jumlah_kegiatan++;
    //                         $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
    //                         $sheet->setCellValue('A' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
    //                         $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
	// 						$sheet->setCellValue('E' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("E$cell:E".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('G' . $cell, $dpa->realisasi_keuangan)->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('L' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('M' . $cell, '')->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $cell++;
    //                         for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
    //                             $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
    //                             $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
    //                             $cell++;
    //                         }
    //                         foreach($dpa->SumberDanaDpa AS $sumber_dana){
    //                             $sheet->setCellValue('A' . $cell, '');
    //                             $sheet->setCellValue('B' . $cell, $sumber_dana->jenis_belanja);
	// 							$sheet->setCellValue('C' . $cell, '');
    //                             $sheet->setCellValue('D' . $cell, '');
    //                             $sheet->setCellValue('E' . $cell, $sumber_dana->nilai_pagu);
    //                             $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
    //                             $sheet->setCellValue('G' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
    //                             $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
    //                             $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
    //                             $sheet->setCellValue('J' . $cell, '');
    //                             $sheet->setCellValue('K' . $cell, '');
    //                             $sheet->setCellValue('L' . $cell, '');
    //                             $sheet->setCellValue('M' . $cell, '');
    //                             $cell++;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     $sheet->getStyle('A1:M' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A1:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	// 	$sheet->getStyle('A7:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('E7:E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('G7:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('L7:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     $sheet->getStyle('E7:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
	// 	$sheet->getStyle('G7:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');

    //     // Total
    //     $sheet->setCellValue('A' . $cell, 'JUMLAH');
	// 	$sheet->setCellValue('C' . $cell, '');
    //     $sheet->setCellValue('D' . $cell, '');
    //     $sheet->setCellValue('E' . $cell, $total_pagu_keseluruhan);
    //     $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('G' . $cell, $total_realisasi_keuangan);
    //     //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
    //     //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
    //     $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
    //     $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->setCellValue('L' . $cell, '');
    //     $sheet->setCellValue('M' . $cell, '');
    //     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A5:M' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
	// 	if (hasRole('admin')){
    //     } else if (hasRole('opd')){
    //         $sheet->setCellValue('K' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$cell = $cell+3;
	// 		$sheet->setCellValue('K' . ++$cell, request('nama',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     }

    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI DAK FISIK DINAS '.$dinas.'.xlsx"');

    //     }else{

    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':K'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_dak_non_fisik_unit_kerja($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(5)->setRowHeight(25);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     // Header Text
    //     $sheet->setCellValue('A1', 'LAPORAN REALISASI KEGIATAN PEMBANGUNAN FISIK DAN KEUANGAN');
    //     $sheet->setCellValue('A2', strtoupper($dinas).' TAHUN ANGGARAN '.$tahun.' KEADAAN BULAN '.strtoupper($periode));
    //     $sheet->setCellValue('A3', 'SUMBER DANA DAK NON FISIK');
    //     $sheet->mergeCells('A1:M1');
    //     $sheet->mergeCells('A2:M2');
    //     $sheet->mergeCells('A3:M3');
    //     $sheet->getStyle('A1')->getFont()->setSize(12);

    //     $sheet->setCellValue('A5', 'KODE')->mergeCells('A5:A6');
    //     $sheet->getColumnDimension('A')->setWidth(20);
    //     $sheet->setCellValue('B5', 'PROGRAM, KEGIATAN DAN SUB KEGIATAN')->mergeCells('B5:B6');
    //     $sheet->getColumnDimension('B')->setWidth(30);
	// 	$sheet->setCellValue('C5', 'INDIKATOR KERJA KELUARAN (OUTPUT)')->mergeCells('C5:D5');
    //     $sheet->setCellValue('E5', 'JUMLAH DANA / DPA')->mergeCells('E5:E6');
    //     $sheet->getColumnDimension('E')->setWidth(15);
    //     $sheet->setCellValue('F5', 'BOBOT')->mergeCells('F5:F6');
    //     $sheet->setCellValue('G5', 'REALISASI KEUANGAN (RP)')->mergeCells('G5:G6');
    //     $sheet->getColumnDimension('G')->setWidth(18);
    //     $sheet->setCellValue('H5', 'REALISASI (%)')->mergeCells('H5:I5');
    //     $sheet->setCellValue('J5', 'TERTIMBANG %')->mergeCells('J5:K5');
    //     $sheet->setCellValue('L5', 'PPTK/PELAKSANA')->mergeCells('L5:L6');
    //     $sheet->getColumnDimension('L')->setWidth(18);
    //     $sheet->setCellValue('M5', 'KET')->MergeCells('M5:M6');

	// 	$sheet->setCellValue('C6', 'TOLAK UKUR')->getColumnDimension('C')->setWidth(15);
    //     $sheet->setCellValue('D6', 'SATUAN (UNIT)')->getColumnDimension('D')->setWidth(12);
    //     $sheet->setCellValue('H6', 'FISIK')->getColumnDimension('H')->setWidth(8);
    //     $sheet->setCellValue('I6', 'KEUANGAN')->getColumnDimension('I')->setWidth(12);
    //     $sheet->setCellValue('J6', 'FISIK (%)')->getColumnDimension('J')->setWidth(10);
    //     $sheet->setCellValue('K6', 'KEUANGAN (%)')->getColumnDimension('K')->setWidth(15);

    //     $sheet->getStyle('A:M')->getAlignment()->setWrapText(true);
    //     $sheet->getStyle('A1:M6')->getFont()->setBold(true);

    //     $cell = 7;
    //     $total_bobot = 0;
    //     $total_fisik = 0;
    //     $total_keuangan = 0;
    //     $jumlah_kegiatan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     $i=0;
    //     $no_program=0;
    //     foreach ($data AS $index => $row){
    //         if ($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0){
    //             $i++;

    //             // $sheet->setCellValue('A' . $cell, $i)->mergeCells("A$cell:A".($row->jumlah_tolak_ukur+$row->jumlah_sumber_dana > 0 ? $row->jumlah_tolak_ukur+$row->jumlah_sumber_dana+$row->jumlah_kegiatan-1+$cell : $cell));

    //             $sheet->setCellValue('A' . $cell, $row->kode_program_baru);
    //             $sheet->setCellValue('B' . $cell, $row->nama_program);
    //             $sheet->setCellValue('C' . $cell, '');
    //             $sheet->setCellValue('D' . $cell, '');
    //             $sheet->setCellValue('E' . $cell, '');
    //             $sheet->setCellValue('F' . $cell, '');
    //             $sheet->setCellValue('G' . $cell, '');
    //             $sheet->setCellValue('H' . $cell, '');
    //             $sheet->setCellValue('I' . $cell, '');
    //             $sheet->setCellValue('J' . $cell, '');
    //             $sheet->setCellValue('K' . $cell, '');
    //             $sheet->setCellValue('L' . $cell, '');
    //             $sheet->setCellValue('M' . $cell, '');
    //             $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('6D9EEB');
    //             $cell++;
    //             $no_kegiatan=0;
    //             foreach($row->Kegiatan AS $kegiatan){
    //                 if ($kegiatan){
    //                     $sheet->setCellValue('A' . $cell, $kegiatan->kode_kegiatan_baru);
    //                     $sheet->setCellValue('B' . $cell, $kegiatan->nama_kegiatan);
    //                     $sheet->setCellValue('C' . $cell,'');
    //                     $sheet->setCellValue('D' . $cell, '');
    //                     $sheet->setCellValue('E' . $cell, '');
    //                     $sheet->setCellValue('F' . $cell, '');
    //                     $sheet->setCellValue('G' . $cell, '');
    //                     $sheet->setCellValue('H' . $cell, '');
    //                     $sheet->setCellValue('I' . $cell, '');
    //                     $sheet->setCellValue('J' . $cell, '');
    //                     $sheet->setCellValue('K' . $cell, '');
    //                     $sheet->setCellValue('L' . $cell, '');
    //                     $sheet->setCellValue('M' . $cell, '');
    //                     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9');
    //                     $cell++;
    //                     $no_sub_kegiatan=0;
    //                     foreach($kegiatan->Dpa->sortBy('kode_sub_kegiatan') AS $dpa){
    //                         $total_fisik += $dpa->realisasi_fisik;
    //                         $bobot = $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
    //                         $persentase_keuangan = $dpa->nilai_pagu_dpa ? $dpa->realisasi_keuangan/$dpa->nilai_pagu_dpa*100 : 0;
    //                         $tertimbang_fisik = $total_pagu_keseluruhan ? $dpa->realisasi_fisik * $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan : 0;
    //                         $tertimbang_keuangan = $total_pagu_keseluruhan ? $dpa->realisasi_keuangan/$total_pagu_keseluruhan*100 : 0;
    //                         $total_keuangan += $persentase_keuangan;
    //                         $total_tertimbang_fisik += $tertimbang_fisik;
    //                         $total_tertimbang_keuangan += $tertimbang_keuangan;
    //                         $jumlah_kegiatan++;
    //                         $total_bobot += $total_pagu_keseluruhan ? $dpa->nilai_pagu_dpa/$total_pagu_keseluruhan*100 : 0;
    //                         $sheet->setCellValue('A' . $cell, $dpa->SubKegiatan->kode_sub_kegiatan)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
    //                         $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
	// 						$sheet->setCellValue('E' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("E$cell:E".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($bobot,2))->mergeCells("F$cell:F".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('G' . $cell, $dpa->realisasi_keuangan)->mergeCells("G$cell:G".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($dpa->realisasi_fisik,2))->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($persentase_keuangan,2))->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($tertimbang_fisik,2))->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($tertimbang_keuangan,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('L' . $cell, $dpa->PegawaiPenanggungJawab->nama_lengkap)->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $sheet->setCellValue('M' . $cell, '')->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur-1+$cell : $cell));
    //                         $cell++;
    //                         for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
    //                             $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
    //                             $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
    //                             $cell++;
    //                         }
    //                         foreach($dpa->SumberDanaDpa AS $sumber_dana){
    //                             $sheet->setCellValue('A' . $cell, '');
    //                             $sheet->setCellValue('B' . $cell, $sumber_dana->jenis_belanja);
	// 							$sheet->setCellValue('C' . $cell, '');
    //                             $sheet->setCellValue('D' . $cell, '');
    //                             $sheet->setCellValue('E' . $cell, $sumber_dana->nilai_pagu);
    //                             $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_pagu_keseluruhan ? $sumber_dana->nilai_pagu/$total_pagu_keseluruhan * 100 : 0,2));
    //                             $sheet->setCellValue('G' . $cell, $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}));
    //                             $sheet->setCellValue('H' . $cell, pembulatanDuaDecimal($sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_fisik;}),2));
    //                             $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($sumber_dana->nilai_pagu ? $sumber_dana->DetailRealisasi->reduce(function ($total,$value){return $total+$value->realisasi_keuangan;}) / $sumber_dana->nilai_pagu * 100 : 0,2));
    //                             $sheet->setCellValue('J' . $cell, '');
    //                             $sheet->setCellValue('K' . $cell, '');
    //                             $sheet->setCellValue('L' . $cell, '');
    //                             $sheet->setCellValue('M' . $cell, '');
    //                             $cell++;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     $sheet->getStyle('A1:M' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A1:M' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	// 	$sheet->getStyle('A7:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('E7:E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('G7:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('L7:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     $sheet->getStyle('E7:E' . $cell)->getNumberFormat()->setFormatCode('#,##0');
	// 	$sheet->getStyle('G7:G' . $cell)->getNumberFormat()->setFormatCode('#,##0');

    //     // Total
    //     $sheet->setCellValue('A' . $cell, 'JUMLAH');
	// 	$sheet->setCellValue('C' . $cell, '');
    //     $sheet->setCellValue('D' . $cell, '');
    //     $sheet->setCellValue('E' . $cell, $total_pagu_keseluruhan);
    //     $sheet->setCellValue('F' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('G' . $cell, $total_realisasi_keuangan);
    //     //$sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah_kegiatan ? $total_fisik/$jumlah_kegiatan : 0,2));
    //     //$sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_realisasi_keuangan/$total_pagu_keseluruhan*100 ,2));
    //     $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
    //     $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->setCellValue('L' . $cell, '');
    //     $sheet->setCellValue('M' . $cell, '');
    //     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A5:M' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
	// 	if (hasRole('admin')){
    //     } else if (hasRole('opd')){
    //         $sheet->setCellValue('K' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$cell = $cell+3;
	// 		$sheet->setCellValue('K' . ++$cell, request('nama',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	// 		$sheet->setCellValue('K' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('K'.$cell.':M'.$cell);
	// 		$sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     }

    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI DAK NON FISIK DINAS '.$dinas.'.xlsx"');

    //     }else{

    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':K'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_dak_fisik_lama($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
    //     $sheet->getStyle('A:M')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A:M')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     // Header Text
    //     $sheet->setCellValue('A1', 'LAPORAN KEMAJUAN PER TRIWULAN');
    //     $sheet->setCellValue('A2', 'DANA ALOKASI KHUSUS (DAK) FISIK - TAHUN ANGGARAN '.$tahun.' ');
    //     $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode));
    //     $sheet->mergeCells('A1:M1');
    //     $sheet->mergeCells('A2:M2');
    //     $sheet->mergeCells('A3:M3');
    //     $sheet->getStyle('A1:A3')->getFont()->setSize(12);
    //     $sheet->getStyle('A1:A3')->getFont()->setBold(true);

    //     $profile = ProfileDaerah::first();
    //     $sheet->setCellValue('A5', 'Provinsi     : Sulawesi Selatan')->mergeCells('A5:B5');
    //     $sheet->setCellValue('A6', 'Kabupaten   : '.optional($profile)->nama_daerah)->mergeCells('A6:B6');
    //     $sheet->getStyle('A5:A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);



    //     $sheet->setCellValue('A7', 'No')->mergeCells('A7:A8');
    //     $sheet->getColumnDimension('A')->setWidth(5);
    //     $sheet->setCellValue('B7', 'Jenis Kegiatan')->mergeCells('B7:B8');
    //     $sheet->getColumnDimension('B')->setWidth(50);
    //     $sheet->setCellValue('C7', 'Perencanaan Kegiatan')->mergeCells('C7:D7');
    //     $sheet->setCellValue('E7', 'Bobot')->mergeCells('E7:E8');
    //     $sheet->setCellValue('F7', 'Pelaksanaan kegiatan')->mergeCells('F7:G7');
    //     $sheet->setCellValue('H7', 'Realisasi (%)')->mergeCells('H7:J7');
    //     $sheet->setCellValue('K7', 'Realisasi Tertimbang')->mergeCells('K7:L7');
    //     $sheet->setCellValue('M7', 'Keterangan')->mergeCells('M7:M8')->getColumnDimension('M')->setWidth(15);

    //     $sheet->setCellValue('C8', 'DAK (Rp)')->getColumnDimension('C')->setWidth(15);
    //     $sheet->setCellValue('D8', 'Pendampingan (Rp)')->getColumnDimension('D')->setWidth(15);
    //     $sheet->setCellValue('F8', 'Swakelola (Rp)')->getColumnDimension('F')->setWidth(15);
    //     $sheet->setCellValue('G8', 'Kontrak (Rp)')->getColumnDimension('G')->setWidth(15);
    //     $sheet->setCellValue('H8', 'Keuangan (Rp)')->getColumnDimension('H')->setWidth(15);
    //     $sheet->setCellValue('I8', 'Fisik (%)');
    //     $sheet->setCellValue('J8', 'Keuangan (%)');
    //     $sheet->setCellValue('K8', 'Fisik (%)');
    //     $sheet->setCellValue('L8', 'Keuangan (%)');

    //     $sheet->getStyle('A7:M8')->getFont()->setBold(true);
    //     $sheet->getStyle('A:M')->getAlignment()->setWrapText(true);

    //     $cell = 9;
    //     $total_bobot = 0;
    //     $total_swakelola = 0;
    //     $total_kontrak = 0;
    //     $total_realisasi_fisik = 0;
    //     $total_persentase_kuangan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     $jumlah = 0;
    //     foreach ($data AS $row) {
    //         $total_bobot += $row->bobot;
    //         $total_swakelola += $row->swakelola;
    //         $total_kontrak += $row->kontrak;
    //         $total_realisasi_fisik += $row->realisasi_fisik;
    //         $total_persentase_kuangan += $row->persentase_realisasi_keuangan;
    //         $total_tertimbang_fisik += $row->tertimbang_fisik;
    //         $total_tertimbang_keuangan += $row->tertimbang_keuangan;
    //         $jumlah++;
    //         $sheet->setCellValue('A' . $cell, $cell - 8);
    //         $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
    //         $sheet->setCellValue('C' . $cell, $row->dak);
    //         $sheet->setCellValue('D' . $cell, '');
    //         $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($row->bobot,2));
    //         $sheet->setCellValue('F' . $cell, $row->swakelola);
    //         $sheet->setCellValue('G' . $cell, $row->kontrak);
    //         $sheet->setCellValue('H' . $cell, $row->realisasi_keuangan);
    //         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($row->realisasi_fisik,2));
    //         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($row->persentase_realisasi_keuangan,2));
    //         $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($row->tertimbang_fisik,2));
    //         $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($row->tertimbang_keuangan,2));
    //         $sheet->setCellValue('M' . $cell, '');
    //         $sheet->getRowDimension($cell)->setRowHeight(25);
    //         $cell++;
    //     }
    //     $sheet->getStyle('C9:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('C9:D' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('F9:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('F9:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('B9:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     // Total
    //     $sheet->setCellValue('B' . $cell, 'JUMLAH');
    //     $sheet->setCellValue('C' . $cell, $total_pagu_keseluruhan);
    //     $sheet->setCellValue('D' . $cell, '');
    //     $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('F' . $cell, $total_swakelola);
    //     $sheet->setCellValue('G' . $cell, $total_kontrak);
    //     $sheet->setCellValue('H' . $cell, $total_realisasi_keuangan);
    //     $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah ? $total_realisasi_fisik/$jumlah : 0,2));
    //     $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($jumlah ? $total_persentase_kuangan/$jumlah : 0,2));
    //     $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
    //     $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFont()->setBold(true);
    //     $sheet->getStyle('B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);

    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A7:M' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
    //     $sheet->setCellValue('K' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('K'.$cell.':N'.$cell);
    //     $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('K' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('K'.$cell.':N'.$cell);
    //     $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $cell = $cell+3;
    //     $sheet->setCellValue('K' . ++$cell, request('nama',''))->mergeCells('K'.$cell.':N'.$cell);
    //     $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('K' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('K'.$cell.':N'.$cell);
    //     $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('K' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('K'.$cell.':N'.$cell);
    //     $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     // $writer = new Xlsx($spreadsheet);
    //     // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     // header('Content-Disposition: attachment;filename="REALISASI DAK FISIK.xlsx"');
    //     // $writer->save('php://output');

    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI DAK FISIK.xlsx"');
    //     }else{
    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_dak_non_fisik_lama($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
    //     $sheet->getStyle('A:M')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A:M')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     // Header Text
    //     $sheet->setCellValue('A1', 'LAPORAN KEMAJUAN PER TRIWULAN');
    //     $sheet->setCellValue('A2', 'DANA ALOKASI KHUSUS (DAK) NON FISIK - TAHUN ANGGARAN '.$tahun);
    //     $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode));
    //     $sheet->mergeCells('A1:M1');
    //     $sheet->mergeCells('A2:M2');
    //     $sheet->mergeCells('A3:M3');
    //     $sheet->getStyle('A1:A3')->getFont()->setSize(12);
    //     $sheet->getStyle('A1:A3')->getFont()->setBold(true);
    //     $profile = ProfileDaerah::first();
    //     $sheet->setCellValue('A5', 'Provinsi     : Sulawesi Selatan')->mergeCells('A5:B5');
    //     $sheet->setCellValue('A6', 'Kabupaten   : '.optional($profile)->nama_daerah)->mergeCells('A6:B6');
    //     $sheet->getStyle('A5:A6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);



    //     $sheet->setCellValue('A7', 'No')->mergeCells('A7:A8');
    //     $sheet->getColumnDimension('A')->setWidth(5);
    //     $sheet->setCellValue('B7', 'Jenis Kegiatan')->mergeCells('B7:B8');
    //     $sheet->getColumnDimension('B')->setWidth(50);
    //     $sheet->setCellValue('C7', 'Perencanaan Kegiatan')->mergeCells('C7:D7');
    //     $sheet->setCellValue('E7', 'Bobot')->mergeCells('E7:E8');
    //     $sheet->setCellValue('F7', 'Pelaksanaan kegiatan')->mergeCells('F7:G7');
    //     $sheet->setCellValue('H7', 'Realisasi (%)')->mergeCells('H7:J7');
    //     $sheet->setCellValue('K7', 'Realisasi Tertimbang')->mergeCells('K7:L7');
    //     $sheet->setCellValue('M7', 'Keterangan')->mergeCells('M7:M8')->getColumnDimension('M')->setWidth(15);

    //     $sheet->setCellValue('C8', 'DAK (Rp)')->getColumnDimension('C')->setWidth(15);
    //     $sheet->setCellValue('D8', 'Pendampingan (Rp)')->getColumnDimension('D')->setWidth(15);
    //     $sheet->setCellValue('F8', 'Swakelola (Rp)')->getColumnDimension('F')->setWidth(15);
    //     $sheet->setCellValue('G8', 'Kontrak (Rp)')->getColumnDimension('G')->setWidth(15);
    //     $sheet->setCellValue('H8', 'Keuangan (Rp)')->getColumnDimension('H')->setWidth(15);
    //     $sheet->setCellValue('I8', 'Fisik (%)');
    //     $sheet->setCellValue('J8', 'Keuangan (%)');
    //     $sheet->setCellValue('K8', 'Fisik (%)');
    //     $sheet->setCellValue('L8', 'Keuangan (%)');

    //     $sheet->getStyle('A7:M8')->getFont()->setBold(true);
    //     $sheet->getStyle('A:M')->getAlignment()->setWrapText(true);

    //     $cell = 9;
    //     $total_bobot = 0;
    //     $total_swakelola = 0;
    //     $total_kontrak = 0;
    //     $total_realisasi_fisik = 0;
    //     $total_persentase_kuangan = 0;
    //     $total_tertimbang_fisik = 0;
    //     $total_tertimbang_keuangan = 0;
    //     $jumlah = 0;
    //     foreach ($data AS $row) {
    //         $total_bobot += $row->bobot;
    //         $total_swakelola += $row->swakelola;
    //         $total_kontrak += $row->kontrak;
    //         $total_realisasi_fisik += $row->realisasi_fisik;
    //         $total_persentase_kuangan += $row->persentase_realisasi_keuangan;
    //         $total_tertimbang_fisik += $row->tertimbang_fisik;
    //         $total_tertimbang_keuangan += $row->tertimbang_keuangan;
    //         $jumlah++;
    //         $sheet->setCellValue('A' . $cell, $cell - 8);
    //         $sheet->setCellValue('B' . $cell, $row->nama_unit_kerja);
    //         $sheet->setCellValue('C' . $cell, $row->dak);
    //         $sheet->setCellValue('D' . $cell, '');
    //         $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($row->bobot,2));
    //         $sheet->setCellValue('F' . $cell, $row->swakelola);
    //         $sheet->setCellValue('G' . $cell, $row->kontrak);
    //         $sheet->setCellValue('H' . $cell, $row->realisasi_keuangan);
    //         $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($row->realisasi_fisik,2));
    //         $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($row->persentase_realisasi_keuangan,2));
    //         $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($row->tertimbang_fisik,2));
    //         $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($row->tertimbang_keuangan,2));
    //         $sheet->setCellValue('M' . $cell, '');
    //         $sheet->getRowDimension($cell)->setRowHeight(25);
    //         $cell++;
    //     }
    //     $sheet->getStyle('C9:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('C9:D' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('F9:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('F9:H' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('B9:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     // Total
    //     $sheet->setCellValue('B' . $cell, 'JUMLAH');
    //     $sheet->setCellValue('C' . $cell, $total_pagu_keseluruhan);
    //     $sheet->setCellValue('D' . $cell, '');
    //     $sheet->setCellValue('E' . $cell, pembulatanDuaDecimal($total_bobot,2));
    //     $sheet->setCellValue('F' . $cell, $total_swakelola);
    //     $sheet->setCellValue('G' . $cell, $total_kontrak);
    //     $sheet->setCellValue('H' . $cell, $total_realisasi_keuangan);
    //     $sheet->setCellValue('I' . $cell, pembulatanDuaDecimal($jumlah ? $total_realisasi_fisik/$jumlah : 0,2));
    //     $sheet->setCellValue('J' . $cell, pembulatanDuaDecimal($jumlah ? $total_persentase_kuangan/$jumlah : 0,2));
    //     $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($total_tertimbang_fisik,2));
    //     $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($total_tertimbang_keuangan,2));
    //     $sheet->getStyle('A' . $cell . ':M' . $cell)->getFont()->setBold(true);
    //     $sheet->getStyle('B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);

    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A7:M' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
    //     $sheet->setCellValue('K' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('K'.$cell.':N'.$cell);
    //     $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('K' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('K'.$cell.':N'.$cell);
    //     $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $cell = $cell+3;
    //     $sheet->setCellValue('K' . ++$cell, request('nama',''))->mergeCells('K'.$cell.':N'.$cell);
    //     $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('K' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('K'.$cell.':N'.$cell);
    //     $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('K' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('K'.$cell.':N'.$cell);
    //     $sheet->getStyle('K' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI DAK NON FISIK.xlsx"');
    //     }else{
    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_dak_fisik_unit_kerja_lama($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     // $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     $sheet->getStyle('A:AB')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A:Q')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $unit_kerja = UnitKerja::with('BidangUrusan.Urusan')->find(request('unit_kerja'));
    //     $sub_bidang = implode(', ',$unit_kerja->BidangUrusan->pluck('nama_bidang_urusan')->toArray());
    //     $bidang = $unit_kerja->BidangUrusan->map(function ($value){
    //         return $value->Urusan->nama_urusan;
    //     });
    //     $bidang = array_unique($bidang->toArray());
    //     $bidang = implode(', ',$bidang);
    //     $profile = ProfileDaerah::first();
    //     // Header Text
    //     $sheet->setCellValue('A1', 'LAPORAN KEMAJUAN PERTRIWULAN')->mergeCells('A1:Q1');
    //     $sheet->setCellValue('A2', 'DANA ALOKASI KHUSUS (FISIK) - TAHUN ANGGARAN '.$tahun)->mergeCells('A2:Q2');
    //     $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode))->mergeCells('A3:Q3');
    //     $sheet->getStyle('A1:A3')->getFont()->setSize(12);
    //     $sheet->setCellValue('A5','Provinsi       : Sulawesi Selatan')->mergeCells('A5:Q5');
    //     $sheet->setCellValue('A6','Kabupaten    : '.optional($profile)->nama_daerah)->mergeCells('A6:Q6');
    //     $sheet->setCellValue('A7','SKPD            : '.$dinas)->mergeCells('A7:Q7');
    //     $sheet->setCellValue('A8','Bidang          : '.ucwords(strtolower($bidang)))->mergeCells('A8:Q8');
    //     $sheet->setCellValue('A9','Sub Bidang   : '.ucwords(strtolower($sub_bidang)))->mergeCells('A9:Q9');
    //     $sheet->getStyle('A5:A9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('A10', 'No')->mergeCells('A10:A12');
    //     $sheet->getColumnDimension('A')->setWidth(5);
    //     $sheet->setCellValue('B10', 'Jenis Kegiatan')->mergeCells('B10:B12');
    //     $sheet->getColumnDimension('B')->setWidth(25);
    //     $sheet->setCellValue('C10', 'Perencanaan Kegiatan')->mergeCells('C10:H10');
    //     $sheet->setCellValue('I10', 'Pelaksanaan Kegiatan')->mergeCells('I10:J11');
    //     $sheet->setCellValue('K10', 'Realisasi')->mergeCells('K10:L11');
    //     $sheet->setCellValue('M10', 'Kesesuaian Sasaran dan Lokasi Dengan RKPD')->mergeCells('M10:N11');
    //     $sheet->setCellValue('O10', 'Kesesuaian Antara DPA SKPD Dengan Petunjuk Teknis DAK')->mergeCells('O10:P11');
    //     $sheet->setCellValue('Q10', 'Kodefikasi Masalah')->mergeCells('Q10:Q12')->getColumnDimension('Q')->setWidth(15);
    //     $sheet->setCellValue('C11', 'Volume')->mergeCells('C11:C12')->getColumnDimension('C')->setWidth(6);
    //     $sheet->setCellValue('D11', 'Satuan')->mergeCells('D11:D12')->getColumnDimension('D')->setWidth(10);
    //     $sheet->setCellValue('E11', 'Jumlah Penerima Manfaat')->mergeCells('E11:E12')->getColumnDimension('E')->setWidth(10);
    //     $sheet->setCellValue('F11', 'Jumlah')->mergeCells('F11:H11');
    //     $sheet->setCellValue('F12', 'Jumlah')->getColumnDimension('F')->setWidth(15);
    //     $sheet->setCellValue('G12', 'Non Pendamping')->getColumnDimension('G')->setWidth(15);
    //     $sheet->setCellValue('H12', 'Total Biaya')->getColumnDimension('H')->setWidth(15);
    //     $sheet->setCellValue('I12', 'Swakelola')->getColumnDimension('I')->setWidth(15);
    //     $sheet->setCellValue('J12', 'Kontrak')->getColumnDimension('J')->setWidth(15);
    //     $sheet->setCellValue('K12', 'Fisik')->getColumnDimension('K')->setWidth(7);
    //     $sheet->setCellValue('L12', 'Keuangan')->getColumnDimension('L')->setWidth(15);
    //     $sheet->setCellValue('M12', 'Ya')->getColumnDimension('M')->setWidth(7);
    //     $sheet->setCellValue('N12', 'Tidak')->getColumnDimension('N')->setWidth(7);
    //     $sheet->setCellValue('O12', 'Ya')->getColumnDimension('O')->setWidth(7);
    //     $sheet->setCellValue('P12', 'Tidak')->getColumnDimension('P')->setWidth(7);
    //     $sheet->getStyle('A:Q')->getAlignment()->setWrapText(true);
    //     $sheet->getStyle('A1:Q12')->getFont()->setBold(true);

    //     // end Header


    //     $cell = 13;
    //     foreach ($data->Dpa AS $dpa) {

    //         $sheet->setCellValue('A' . $cell, $cell - 12)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
    //         $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
    //         $sheet->setCellValue('E' . $cell, '')->mergeCells("E$cell:E".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('F' . $cell, $dpa->nilai_pagu_dpa);
    //         $sheet->setCellValue('G' . $cell, '');
    //         $sheet->setCellValue('H' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('I' . $cell, $dpa->swakelola)->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('J' . $cell, $dpa->kontrak)->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($dpa->tertimbang_fisik,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($dpa->tertimbang_keuangan,2))->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('M' . $cell, '')->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('N' . $cell, '')->mergeCells("N$cell:N".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('O' . $cell, '')->mergeCells("O$cell:O".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('P' . $cell, '')->mergeCells("P$cell:P".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('Q' . $cell, '')->mergeCells("Q$cell:Q".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $cell++;
    //         for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
    //             $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
    //             $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
    //             $cell++;
    //         }
    //     }

    //     $sheet->getStyle('B13:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('F13:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('F13:J' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('L13:L' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('L13:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

    //     // // Total
    //     $sheet->setCellValue('A' . $cell, 'JUMLAH')->mergeCells('A'.$cell.':D'.$cell);
    //     $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->setCellValue('F' . $cell, $data->total_dak);
    //     $sheet->setCellValue('H' . $cell, $data->total_dak);
    //     $sheet->setCellValue('I' . $cell, $data->swakelola);
    //     $sheet->setCellValue('J' . $cell, $data->kontrak);
    //     $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($data->realisasi_fisik,2));
    //     $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($data->persentase_realisasi_keuangan,2));
    //     $sheet->getStyle('A' . $cell . ':L' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A10:Q' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
    //     $sheet->setCellValue('N' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('N'.$cell.':Q'.$cell);
    //     $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('N' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('N'.$cell.':Q'.$cell);
    //     $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $cell = $cell+3;
    //     $sheet->setCellValue('N' . ++$cell, request('nama',''))->mergeCells('N'.$cell.':Q'.$cell);
    //     $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('N' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('N'.$cell.':Q'.$cell);
    //     $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('N' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('N'.$cell.':Q'.$cell);
    //     $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI DAK FISIK '.$dinas.'.xlsx"');
    //     }else{
    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }

    // public function export_dak_non_fisik_unit_kerja_lama($tipe,$data,$total_pagu_keseluruhan,$total_realisasi_keuangan,$periode,$dinas,$tahun)
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
    //     $sheet->getRowDimension(1)->setRowHeight(17);
    //     $sheet->getRowDimension(2)->setRowHeight(17);
    //     $sheet->getRowDimension(3)->setRowHeight(17);
    //     $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
    //     $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    //     $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
    //     // $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

    //     //Margin PDF
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
    //     $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);

    //     $sheet->getStyle('A:Q')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    //     $sheet->getStyle('A:Q')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $unit_kerja = UnitKerja::with('BidangUrusan.Urusan')->find(request('unit_kerja'));
    //     $sub_bidang = implode(', ',$unit_kerja->BidangUrusan->pluck('nama_bidang_urusan')->toArray());
    //     $bidang = $unit_kerja->BidangUrusan->map(function ($value){
    //         return $value->Urusan->nama_urusan;
    //     });
    //     $bidang = array_unique($bidang->toArray());
    //     $bidang = implode(', ',$bidang);
    //     $profile = ProfileDaerah::first();
    //     // Header Text
    //     $sheet->setCellValue('A1', 'LAPORAN KEMAJUAN PERTRIWULAN')->mergeCells('A1:Q1');
    //     $sheet->setCellValue('A2', 'DANA ALOKASI KHUSUS (NON FISIK) - TAHUN ANGGARAN '.$tahun)->mergeCells('A2:Q2');
    //     $sheet->setCellValue('A3', 'TRIWULAN '.strtoupper($periode))->mergeCells('A3:Q3');
    //     $sheet->getStyle('A1:A3')->getFont()->setSize(12);
    //     $sheet->setCellValue('A5','Provinsi       : Sulawesi Selatan')->mergeCells('A5:Q5');
    //     $sheet->setCellValue('A6','Kabupaten    : '.optional($profile)->nama_daerah)->mergeCells('A6:Q6');
    //     $sheet->setCellValue('A7','SKPD            : '.$dinas)->mergeCells('A7:Q7');
    //     $sheet->setCellValue('A8','Bidang          : '.ucwords(strtolower($bidang)))->mergeCells('A8:Q8');
    //     $sheet->setCellValue('A9','Sub Bidang   : '.ucwords(strtolower($sub_bidang)))->mergeCells('A9:Q9');
    //     $sheet->getStyle('A5:A9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('A10', 'No')->mergeCells('A10:A12');
    //     $sheet->getColumnDimension('A')->setWidth(5);
    //     $sheet->setCellValue('B10', 'Jenis Kegiatan')->mergeCells('B10:B12');
    //     $sheet->getColumnDimension('B')->setWidth(25);
    //     $sheet->setCellValue('C10', 'Perencanaan Kegiatan')->mergeCells('C10:H10');
    //     $sheet->setCellValue('I10', 'Pelaksanaan Kegiatan')->mergeCells('I10:J11');
    //     $sheet->setCellValue('K10', 'Realisasi')->mergeCells('K10:L11');
    //     $sheet->setCellValue('M10', 'Kesesuaian Sasaran dan Lokasi Dengan RKPD')->mergeCells('M10:N11');
    //     $sheet->setCellValue('O10', 'Kesesuaian Antara DPA SKPD Dengan Petunjuk Teknis DAK')->mergeCells('O10:P11');
    //     $sheet->setCellValue('Q10', 'Kodefikasi Masalah')->mergeCells('Q10:Q12')->getColumnDimension('Q')->setWidth(15);
    //     $sheet->setCellValue('C11', 'Volume')->mergeCells('C11:C12')->getColumnDimension('C')->setWidth(6);
    //     $sheet->setCellValue('D11', 'Satuan')->mergeCells('D11:D12')->getColumnDimension('D')->setWidth(10);
    //     $sheet->setCellValue('E11', 'Jumlah Penerima Manfaat')->mergeCells('E11:E12')->getColumnDimension('E')->setWidth(10);
    //     $sheet->setCellValue('F11', 'Jumlah')->mergeCells('F11:H11');
    //     $sheet->setCellValue('F12', 'Jumlah')->getColumnDimension('F')->setWidth(15);
    //     $sheet->setCellValue('G12', 'Non Pendamping')->getColumnDimension('G')->setWidth(15);
    //     $sheet->setCellValue('H12', 'Total Biaya')->getColumnDimension('H')->setWidth(15);
    //     $sheet->setCellValue('I12', 'Swakelola')->getColumnDimension('I')->setWidth(15);
    //     $sheet->setCellValue('J12', 'Kontrak')->getColumnDimension('J')->setWidth(15);
    //     $sheet->setCellValue('K12', 'Fisik')->getColumnDimension('K')->setWidth(7);
    //     $sheet->setCellValue('L12', 'Keuangan')->getColumnDimension('L')->setWidth(15);
    //     $sheet->setCellValue('M12', 'Ya')->getColumnDimension('M')->setWidth(7);
    //     $sheet->setCellValue('N12', 'Tidak')->getColumnDimension('N')->setWidth(7);
    //     $sheet->setCellValue('O12', 'Ya')->getColumnDimension('O')->setWidth(7);
    //     $sheet->setCellValue('P12', 'Tidak')->getColumnDimension('P')->setWidth(7);
    //     $sheet->getStyle('A:Q')->getAlignment()->setWrapText(true);
    //     $sheet->getStyle('A1:Q12')->getFont()->setBold(true);

    //     // end Header


    //     $cell = 13;
    //     foreach ($data->Dpa AS $dpa) {

    //         $sheet->setCellValue('A' . $cell, $cell - 12)->mergeCells("A$cell:A".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('B' . $cell, $dpa->SubKegiatan->nama_sub_kegiatan)->mergeCells("B$cell:B".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[0]->tolak_ukur);
    //         $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[0]->volume.' '.$dpa->TolakUkur[0]->satuan);
    //         $sheet->setCellValue('E' . $cell, '')->mergeCells("E$cell:E".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('F' . $cell, $dpa->nilai_pagu_dpa);
    //         $sheet->setCellValue('G' . $cell, '');
    //         $sheet->setCellValue('H' . $cell, $dpa->nilai_pagu_dpa)->mergeCells("H$cell:H".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('I' . $cell, $dpa->swakelola)->mergeCells("I$cell:I".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('J' . $cell, $dpa->kontrak)->mergeCells("J$cell:J".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($dpa->tertimbang_fisik,2))->mergeCells("K$cell:K".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($dpa->tertimbang_keuangan,2))->mergeCells("L$cell:L".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('M' . $cell, '')->mergeCells("M$cell:M".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('N' . $cell, '')->mergeCells("N$cell:N".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('O' . $cell, '')->mergeCells("O$cell:O".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('P' . $cell, '')->mergeCells("P$cell:P".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $sheet->setCellValue('Q' . $cell, '')->mergeCells("Q$cell:Q".($dpa->jumlah_tolak_ukur ? $dpa->jumlah_tolak_ukur -1 + $cell : $cell));
    //         $cell++;
    //         for($i = 1; $i < $dpa->jumlah_tolak_ukur; $i++){
    //             $sheet->setCellValue('C' . $cell, $dpa->TolakUkur[$i]->tolak_ukur);
    //             $sheet->setCellValue('D' . $cell, $dpa->TolakUkur[$i]->volume.' '.$dpa->TolakUkur[$i]->satuan);
    //             $cell++;
    //         }
    //     }

    //     $sheet->getStyle('B13:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->getStyle('F13:J' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('F13:J' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
    //     $sheet->getStyle('L13:L' . $cell)->getNumberFormat()->setFormatCode('#,##0');
    //     $sheet->getStyle('L13:L' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

    //     // // Total
    //     $sheet->setCellValue('A' . $cell, 'JUMLAH')->mergeCells('A'.$cell.':D'.$cell);
    //     $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    //     $sheet->setCellValue('F' . $cell, $data->total_dak);
    //     $sheet->setCellValue('H' . $cell, $data->total_dak);
    //     $sheet->setCellValue('I' . $cell, $data->swakelola);
    //     $sheet->setCellValue('J' . $cell, $data->kontrak);
    //     $sheet->setCellValue('K' . $cell, pembulatanDuaDecimal($data->realisasi_fisik,2));
    //     $sheet->setCellValue('L' . $cell, pembulatanDuaDecimal($data->persentase_realisasi_keuangan,2));
    //     $sheet->getStyle('A' . $cell . ':L' . $cell)->getFont()->setBold(true);
    //     $sheet->getRowDimension($cell)->setRowHeight(30);
    //     $border = [
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                 'color' => ['argb' => '0000000'],
    //             ],
    //         ],
    //     ];

    //     $sheet->getStyle('A10:Q' . $cell)->applyFromArray($border);
    //     $cell++;
    //     $profile = ProfileDaerah::first();
    //     $tgl_cetak = tglIndo(request('tgl_cetak',date('d/m/Y')));
    //     $sheet->setCellValue('N' . ++$cell, optional($profile)->nama_daerah.', '.$tgl_cetak)->mergeCells('N'.$cell.':Q'.$cell);
    //     $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('N' . ++$cell, request('nama_jabatan_kepala',''))->mergeCells('N'.$cell.':Q'.$cell);
    //     $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $cell = $cell+3;
    //     $sheet->setCellValue('N' . ++$cell, request('nama',''))->mergeCells('N'.$cell.':Q'.$cell);
    //     $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('N' . ++$cell, 'Pangkat/Golongan : '.request('jabatan',''))->mergeCells('N'.$cell.':Q'.$cell);
    //     $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
    //     $sheet->setCellValue('N' . ++$cell, 'NIP : '.request('nip',''))->mergeCells('N'.$cell.':Q'.$cell);
    //     $sheet->getStyle('N' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

    //     if($tipe == 'excel'){
    //         $writer = new Xlsx($spreadsheet);
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment;filename="REALISASI DAK NON FISIK '.$dinas.'.xlsx"');
    //     }else{
    //         $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui '.url()->current())->mergeCells('A'.$cell.':L'.$cell);
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddHeader('&C&H'.url()->current());
    //         $spreadsheet->getActiveSheet()->getHeaderFooter()
    //             ->setOddFooter('&L&B &RPage &P of &N');
    //             $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
    //             \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
    //             header('Content-Type: application/pdf');
    //             // header('Content-Disposition: attachment;filename="KEMAJUAN DINAS '.$dinas.'.pdf"');
    //             header('Cache-Control: max-age=0');
    //             $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
    //     }
    //     $writer->save('php://output');
    // }
}
