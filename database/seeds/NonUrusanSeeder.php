<?php

use Illuminate\Database\Seeder;

class NonUrusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $program = [
            'uuid' => \Illuminate\Support\Str::uuid()->toString(),
            'kode_program' => '01',
            'nama_program' => 'PROGRAM  PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOT',
            'id_bidang_urusan' => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                $q->where('kode_urusan', '0');
            })->where('kode_bidang_urusan', '00')->first())->id,
            'tahun' => date('Y')
        ];
        $program_non_urusan = \App\Models\Program::create($program);
        $kegiatan = [
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.01",
                "nama_kegiatan" => "Perencanaan, Penganggaran, dan Evaluasi Kinerja Perangkat Daerah",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.02",
                "nama_kegiatan" => "Administrasi Keuangan Perangkat Daerah",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.03",
                "nama_kegiatan" => "Administrasi Barang Milik Daerah pada Perangkat Daerah",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.04",
                "nama_kegiatan" => "Administrasi   Pendapatan   Daerah   Kewenangan Perangkat Daerah",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.05",
                "nama_kegiatan" => "Administrasi Kepegawaian Perangkat Daerah",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.06",
                "nama_kegiatan" => "Administrasi Umum Perangkat Daerah",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.07",
                "nama_kegiatan" => "Pengadaan   Barang   Milik   Daerah   Penunjang Urusan Pemerintah Daerah",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.08",
                "nama_kegiatan" => "Penyediaan Jasa Penunjang Urusan Pemerintahan Daerah",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.09",
                "nama_kegiatan" => "Pemeliharaan  Barang  Milik  Daerah  Penunjang\r\nUrusan Pemerintahan Daerah",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.10",
                "nama_kegiatan" => "Peningkatan Pelayanan BLUD",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.11",
                "nama_kegiatan" => "Administrasi  Keuangan  dan  Operasional  Kepala Daerah dan Wakil Kepala Daerah",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.12",
                "nama_kegiatan" => "Fasilitasi Kerumahtanggaan Sekretariat Daerah",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.13",
                "nama_kegiatan" => "Penataan Organisasi",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_kegiatan" => "2.14",
                "nama_kegiatan" => "Pelaksanaan Protokol dan Komunikasi Pimpinan",
                "id_program" => $program_non_urusan->id,
                "hasil_kegiatan" => "-",
                "tahun" => date('Y')
            ]
        ];
        \App\Models\Kegiatan::insert($kegiatan);
        $sub_kegiatan = [
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.01.01",
                "nama_sub_kegiatan" => "Penyusunan  Dokumen  Perencanaan  Perangkat Daerah",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.01')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.01.02",
                "nama_sub_kegiatan" => "Koordinasi dan Penyusunan Dokumen RKA-SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.01')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.01.03",
                "nama_sub_kegiatan" => "Koordinasi dan Penyusunan Dokumen Perubahan RKA-SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.01')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.01.04",
                "nama_sub_kegiatan" => "Koordinasi dan Penyusunan DPA-SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.01')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.01.05",
                "nama_sub_kegiatan" => "Koordinasi   dan   Penyusunan   Perubahan DPA- SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.01')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.01.06",
                "nama_sub_kegiatan" => "Koordinasi  dan  Penyusunan  Laporan  Capaian Kinerja dan Ikhtisar Realisasi Kinerja SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.01')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.01.07",
                "nama_sub_kegiatan" => "Evaluasi Kinerja Perangkat Daerah",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.01')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.02.01",
                "nama_sub_kegiatan" => "Penyediaan Gaji dan Tunjangan ASN",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.02')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.02.02",
                "nama_sub_kegiatan" => "Penyediaan Administrasi Pelaksanaan Tugas ASN",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.02')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.02.03",
                "nama_sub_kegiatan" => "Pelaksanaan Penatausahaan  dan Pengujian/Verifikasi Keuangan SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.02')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.02.04",
                "nama_sub_kegiatan" => "Koordinasi dan Pelaksanaan Akuntansi SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.02')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.02.05",
                "nama_sub_kegiatan" => "Koordinasi  dan  Penyusunan  Laporan  Keuangan Akhir Tahun SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.02')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.02.06",
                "nama_sub_kegiatan" => "Pengelolaan  dan  Penyiapan  Bahan  Tanggapan Pemeriksaan",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.02')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.02.07",
                "nama_sub_kegiatan" => "Koordinasi  dan  Penyusunan  Laporan  Keuangan Bulanan/Triwulanan/Semesteran SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.02')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.02.08",
                "nama_sub_kegiatan" => "Penyusunan  Pelaporan  dan  Analisis  Prognosis Realisasi Anggaran",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.02')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.03.01",
                "nama_sub_kegiatan" => "Penyusunan   Perencanaan   Kebutuhan   Barang Milik Daerah SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.03')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.03.02",
                "nama_sub_kegiatan" => "Pengamanan Barang Milik Daerah SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.03')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.03.03",
                "nama_sub_kegiatan" => "Koordinasi  dan  Penilaian  Barang  Milik  Daerah SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.03')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.03.04",
                "nama_sub_kegiatan" => "Pembinaan, Pengawasan,  dan Pengendalian Barang Milik Daerah pada SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.03')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.03.05",
                "nama_sub_kegiatan" => "Rekonsiliasi  dan  Penyusunan  Laporan  Barang Milik Daerah pada SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.03')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.03.06",
                "nama_sub_kegiatan" => "Penatausahaan Barang Milik Daerah pada SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.03')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.03.07",
                "nama_sub_kegiatan" => "Pemanfaatan Barang Milik Daerah SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.03')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.04.01",
                "nama_sub_kegiatan" => "Perencanaan Pengelolaan Retribusi Daerah",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.04')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.04.02",
                "nama_sub_kegiatan" => "Analisa  dan  Pengembangan  Retribusi  Daerah, serta Penyusunan Kebijakan Retribusi Daerah",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.04')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.04.03",
                "nama_sub_kegiatan" => "Penyuluhan    dan    Penyebarluasan    Kebijakan Retribusi Daerah",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.04')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.04.04",
                "nama_sub_kegiatan" => "Pendataan   dan   Pendaftaran   Objek   Retribusi Daerah",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.04')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.04.05",
                "nama_sub_kegiatan" => "Pengolahan Data Retribusi Daerah",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.04')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.04.06",
                "nama_sub_kegiatan" => "Penetapan Wajib Retribusi Daerah",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.04')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.04.07",
                "nama_sub_kegiatan" => "Pelaporan Pengelolaan Retribusi Daerah",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.04')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.05.01",
                "nama_sub_kegiatan" => "Peningkatan   Sarana   dan   Prasarana   Disiplin Pegawai",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.05')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.05.02",
                "nama_sub_kegiatan" => "Pengadaan    Pakaian    Dinas    Beserta    Atribut Kelengkapannya",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.05')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.05.03",
                "nama_sub_kegiatan" => "Pendataan      dan      Pengolahan      Administrasi Kepegawaian",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.05')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.05.04",
                "nama_sub_kegiatan" => "Koordinasi  dan  Pelaksanaan  Sistem  Informasi Kepegawaian",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.05')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.05.05",
                "nama_sub_kegiatan" => "Monitoring,   Evaluasi,   dan   Penilaian   Kinerja Pegawai",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.05')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.05.06",
                "nama_sub_kegiatan" => "Pemulangan Pegawai yang Pensiun",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.05')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.05.07",
                "nama_sub_kegiatan" => "Pemulangan   Pegawai   yang   Meninggal   dalam Melaksanakan Tugas",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.05')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.05.08",
                "nama_sub_kegiatan" => "Pemindahan Tugas ASN",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.05')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.05.09",
                "nama_sub_kegiatan" => "Pendidikan  dan  Pelatihan  Pegawai  Berdasarkan Tugas dan Fungsi",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.05')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.05.10",
                "nama_sub_kegiatan" => "Sosialisasi Peraturan Perundang-Undangan",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.05')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.05.11",
                "nama_sub_kegiatan" => "Bimbingan     Teknis     Implementasi     Peraturan Perundang-Undangan",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.05')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.06.01",
                "nama_sub_kegiatan" => "Penyediaan Komponen Instalasi\r\nListrik/Penerangan Bangunan Kantor",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.06')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.06.02",
                "nama_sub_kegiatan" => "Penyediaan Peralatan dan Perlengkapan Kantor",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.06')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.06.03",
                "nama_sub_kegiatan" => "Penyediaan Peralatan Rumah Tangga",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.06')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.06.04",
                "nama_sub_kegiatan" => "Penyediaan Bahan Logistik Kantor",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.06')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.06.05",
                "nama_sub_kegiatan" => "Penyediaan Barang Cetakan dan Penggandaan",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.06')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.06.06",
                "nama_sub_kegiatan" => "Penyediaan    Bahan    Bacaan    dan    Peraturan Perundang-undangan",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.06')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.06.07",
                "nama_sub_kegiatan" => "Penyediaan Bahan/Material",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.06')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.06.08",
                "nama_sub_kegiatan" => "Fasilitasi Kunjungan Tamu",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.06')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.06.09",
                "nama_sub_kegiatan" => "Penyelenggaraan Rapat Koordinasi dan Konsultasi SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.06')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.06.10",
                "nama_sub_kegiatan" => "Penatausahaan Arsip Dinamis pada SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.06')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.06.11",
                "nama_sub_kegiatan" => "Dukungan   Pelaksanaan   Sistem   Pemerintahan Berbasis Elektronik pada SKPD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.06')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.07.01",
                "nama_sub_kegiatan" => "Pengadaan  Kendaraan  Perorangan  Dinas  atau Kendaraan Dinas Jabatan",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.07')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.07.02",
                "nama_sub_kegiatan" => "Pengadaan  Kendaraan  Dinas  Operasional  atau Lapangan",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.07')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.07.03",
                "nama_sub_kegiatan" => "Pengadaan Alat Besar",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.07')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.07.04",
                "nama_sub_kegiatan" => "Pengadaan Alat Angkutan Darat Tak Bermotor",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.07')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.07.05",
                "nama_sub_kegiatan" => "Pengadaan Mebel",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.07')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.07.06",
                "nama_sub_kegiatan" => "Pengadaan Peralatan dan Mesin Lainnya",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.07')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.07.07",
                "nama_sub_kegiatan" => "Pengadaan Aset Tetap Lainnya",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.07')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.07.08",
                "nama_sub_kegiatan" => "Pengadaan Aset Tak Berwujud",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.07')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.07.09",
                "nama_sub_kegiatan" => "Pengadaan Gedung Kantor atau Bangunan Lainnya",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.07')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.07.10",
                "nama_sub_kegiatan" => "Pengadaan Sarana dan Prasarana Gedung Kantor atau Bangunan Lainnya",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.07')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.07.11",
                "nama_sub_kegiatan" => "Pengadaan  Sarana  dan  Prasarana  Pendukung Gedung Kantor atau Bangunan Lainnya",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.07')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.08.01",
                "nama_sub_kegiatan" => "Penyediaan Jasa Surat Menyurat",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.08')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.08.02",
                "nama_sub_kegiatan" => "Penyediaan Jasa Komunikasi, Sumber Daya Air dan Listrik",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.08')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.08.03",
                "nama_sub_kegiatan" => "Penyediaan   Jasa   Peralatan   dan   Perlengkapan Kantor",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.08')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.08.04",
                "nama_sub_kegiatan" => "Penyediaan Jasa Pelayanan Umum Kantor",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.08')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.09.01",
                "nama_sub_kegiatan" => "Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan,   dan Pajak Kendaraan Perorangan Dinas atau Kendaraan Dinas Jabatan",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.09')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.09.02",
                "nama_sub_kegiatan" => "Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan, Pajak dan Perizinan Kendaraan Dinas Operasional atau Lapangan",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.09')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.09.03",
                "nama_sub_kegiatan" => "Penyediaan       Jasa       Pemeliharaan,       Biaya Pemeliharaan dan Perizinan Alat Besar",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.09')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.09.04",
                "nama_sub_kegiatan" => "Penyediaan Jasa Pemeliharaan, Biaya Pemeliharaan dan Perizinan Alat Angkutan Darat Tak Bermotor",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.09')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.09.05",
                "nama_sub_kegiatan" => "Pemeliharaan Mebel",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.09')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.09.06",
                "nama_sub_kegiatan" => "Pemeliharaan Peralatan dan Mesin Lainnya",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.09')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.09.07",
                "nama_sub_kegiatan" => "Pemeliharaan Aset Tetap Lainnya",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.09')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.09.08",
                "nama_sub_kegiatan" => "Pemeliharaan Aset Tak Berwujud",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.09')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.09.09",
                "nama_sub_kegiatan" => "Pemeliharaan/Rehabilitasi Gedung Kantor dan Bangunan Lainnya",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.09')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.09.10",
                "nama_sub_kegiatan" => "Pemeliharaan/Rehabilitasi Sarana dan Prasarana Gedung Kantor atau Bangunan Lainnya",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.09')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.09.11",
                "nama_sub_kegiatan" => "Pemeliharaan/Rehabilitasi Sarana dan Prasarana Pendukung Gedung Kantor atau Bangunan Lainnya",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.09')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.09.12",
                "nama_sub_kegiatan" => "Pemeliharaan/Rehabilitasi Tanah",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.09')->first())->id,
                "tahun" => date('Y')
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "kode_sub_kegiatan" => "0.00.01.2.10.01",
                "nama_sub_kegiatan" => "Pelayanan dan Penunjang Pelayanan BLUD",
                "id_kegiatan" => optional(\App\Models\Kegiatan::whereHas('Program', function ($q) {
                    $q->where('kode_program', '01');
                    $q->whereHas('BidangUrusan', function ($q) {
                        $q->where('kode_bidang_urusan', '00');
                        $q->whereHas('Urusan', function ($q) {
                            $q->where('kode_urusan', '0');
                        });
                    });
                })->where('kode_kegiatan', '2.10')->first())->id,
                "tahun" => date('Y')
            ]
        ];
        \App\Models\SubKegiatan::insert($sub_kegiatan);
    }
}
