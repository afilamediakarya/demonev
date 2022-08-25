<?php

use Illuminate\Database\Seeder;

class KegiatanSeeder extends Seeder
{

    public function run()
    {
        $kegiatan = [
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Urusan Penyelenggaraan PSU Perumahan"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penataan Sistem Dasar Penanggulangan Bencana"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Inspeksi Peralatan Proteksi Kebakaran"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Investigasi Kejadian Kebakaran"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(10));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(8))->first())->id,
                "nama_kegiatan" => "Penyelesaian Masalah Tanah Kosong"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(10));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(8))->first())->id,
                "nama_kegiatan" => "Inventarisasi  dan Pemanfaatan Tanah Kosong"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(10));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(9))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Membuka Tanah"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan Terminal Penumpang Tipe C"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengujian Berkala Kendaraan Bermotor"
            ],
            [

                "kode_kegiatan" => "2.08",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Audit dan Inspeksi Keselamatan LLAJ di Jalan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penetapan Rencana Induk Perkeretaapian"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(19));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembinaan dan Pengembangan Olahraga Rekreasi"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembangunan Prasarana Pertanian"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengembangan Prasarana Pertanian"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengembangan Lahan Penggembalaan Umum"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(7))->first())->id,
                "nama_kegiatan" => "Pelaksanaan Penyuluhan Pertanian"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan Tanda Daftar Gudang"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(6));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Perencanaan dan Fasilitasi Kerja Sama"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(6));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pelaksanaan Kewilayahan Perbatasan"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(6));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Monitoring dan Evaluasi"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan Pendidikan Sekolah Dasar"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan Pendidikan Anak Usia Dini (PAUD)"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan Pendidikan Nonformal/Kesetaraan"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan Pendidikan Sekolah Menengah Pertama"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penetapan Kurikulum Muatan Lokal Pendidikan Dasar"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penetapan Kurikulum Muatan Lokal Pendidikan\nAnak Usia Dini dan Pendidikan Nonformal"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pemerataan Kuantitas dan Kualitas Pendidik dan\nTenaga Kependidikan   bagi Satuan Pendidikan Dasar, PAUD, dan Pendidikan Nonformal/Kesetaraan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penerbitan     Izin     Pendidikan     Dasar     yang\nDiselenggarakan oleh Masyarakat"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin PAUD dan Pendidikan Nonformal yang Diselenggarakan oleh Masyarakat"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Pembinaan, Pengembangan dan Perlindungan Bahasa dan Sastra yang Penuturannya dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyediaan Fasilitas Pelayanan Kesehatan untuk\nUKM      dan      UKP      Kewenangan      Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyediaan Layanan Kesehatan untuk UKM dan\nUKP Rujukan Tingkat Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan   Sistem   Informasi   Kesehatan\nsecara Terintegrasi"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Rumah Sakit Kelas C dan D serta\nFasilitas  Pelayanan  Kesehatan  Tingkat  Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pemberian   Izin   Praktik   Tenaga   Kesehatan   di\nWilayah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Perencanaan   Kebutuhan   dan   Pendayagunaan\nSumberdaya Manusia Kesehatan untuk UKP dan\nUKM di Wilayah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengembangan       Mutu       dan       Peningkatan\nKompetensi    Teknis    Sumber    Daya    Manusia\nKesehatan Tingkat Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pemberian Izin Apotek, Toko Obat, Toko Alat Kesehatan dan Optikal, Usaha Mikro Obat Tradisional (UMOT)"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pemberian Sertifikat Produksi untuk Sarana Produksi Alat Kesehatan Kelas 1 tertentu dan Perbekalan  Kesehatan  Rumah  Tangga  Kelas  1\nTertentu Perusahaan Rumah Tangga"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penerbitan Sertifikat Produksi Pangan Industri Rumah Tangga dan Nomor P-IRT sebagai Izin Produksi, untuk Produk Makanan Minuman Tertentu yang dapat Diproduksi oleh Industri Rumah Tangga"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penerbitan Sertifikat Laik Higiene Sanitasi Tempat Pengelolaan  Makanan  (TPM)  antara  lain  Jasa Boga, Rumah Makan/Restoran dan Depot Air Minum (DAM)"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penerbitan   Stiker   Pembinaan   pada   Makanan\nJajanan dan Sentra Makanan Jajanan"
            ],
            [

                "kode_kegiatan" => "2.06",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pemeriksaan  dan  Tindak  Lanjut  Hasil Pemeriksaan Post Market pada Produksi dan Produk Makanan Minuman Industri Rumah Tangga"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Advokasi, Pemberdayaan, Kemitraan, Peningkatan Peran serta Masyarakat dan Lintas Sektor Tingkat Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pelaksanaan    Sehat    dalam    rangka    Promotif\nPreventif Tingkat Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pengembangan  dan  Pelaksanaan Upaya Kesehatan Bersumber Daya Masyarakat (UKBM) Tingkat Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(10))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan Jalan Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan SDA dan Bangunan Pengaman Pantai pada Wilayah Sungai (WS) dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengembangan  dan  Pengelolaan  Sistem  Irigasi\nPrimer  dan  Sekunder  pada  Daerah  Irigasi yang\nLuasnya dibawah 1000 Ha dalam 1 (satu) Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengelolaan      dan      Pengembangan      Sistem\nPenyediaan    Air    Minum    (SPAM)    di    Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pengembangan      Sistem      dan      Pengelolaan\nPersampahan di Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pengelolaan    dan    Pengembangan    Sistem   Air\nLimbah Domestik dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Pengelolaan dan Pengembangan Sistem Drainase\nyang Terhubung Langsung dengan Sungai dalam\nDaerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(7))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan Infrastruktur pada Permukiman di Kawasan Strategis Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(8))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan Bangunan Gedung di Wilayah Daerah Kabupaten/Kota, Pemberian Izin Mendirikan  Bangunan  (IMB)  dan  Sertifikat Laik Fungsi Bangunan Gedung"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(9))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan     Penataan     Bangunan     dan\nLingkungannya di Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(11))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan    Pelatihan    Tenaga    Terampil\nKonstruksi"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(11))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan      Sistem      Informasi      Jasa\nKonstruksi Cakupan Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(11))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Usaha Jasa Konstruksi Nasional\n(Non Kecil dan Kecil)"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(11))->first())->id,
                "nama_kegiatan" => "Pengawasan Tertib Usaha, Tertib Penyelenggaraan dan Tertib Pemanfaatan Jasa Konstruksi"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(12))->first())->id,
                "nama_kegiatan" => "Penetapan Rencana Tata Ruang Wilayah (RTRW)\ndan    Rencana    Rinci    Tata    Ruang    (RRTR) Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(12))->first())->id,
                "nama_kegiatan" => "Koordinasi  dan  Sinkronisasi  Perencanaan  Tata\nRuang Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(12))->first())->id,
                "nama_kegiatan" => "Koordinasi dan Sinkronisasi Pemanfaatan Ruang\nDaerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(12))->first())->id,
                "nama_kegiatan" => "Koordinasi     dan     Sinkronisasi     Pengendalian\nPemanfaatan Ruang Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pendataan  Penyediaan  dan  Rehabilitasi  Rumah\nKorban     Bencana     atau     Relokasi     Program\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Sosialisasi    dan    Persiapan    Penyediaan    dan\nRehabilitasi    Rumah    Korban    Bencana    atau\nRelokasi Program Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pembangunan  dan  Rehabilitasi  Rumah  Korban\nBencana atau Relokasi Program Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pendistribusian  dan  Serah  Terima  Rumah  bagi\nKorban     Bencana     atau     Relokasi     Program\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pembinaan  Pengelolaan  Rumah  Susun  Umum\ndan/atau Rumah Khusus"
            ],
            [

                "kode_kegiatan" => "2.06",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Pembangunan dan Pengembangan\nPerumahan"
            ],
            [

                "kode_kegiatan" => "2.07",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan    Sertifikat    Kepemilikan    Bangunan\nGedung (SKGB)"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Pembangunan dan Pengembangan\nKawasan Permukiman"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penataan   dan   Peningkatan   Kualitas   Kawasan\nPermukiman Kumuh dengan Luas di Bawah 10\n(sepuluh) Ha"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Peningkatan    Kualitas    Kawasan    Permukiman\nKumuh dengan Luas di Bawah 10 (sepuluh) Ha"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pencegahan Perumahan dan Kawasan Permukiman  Kumuh  pada Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Sertifikasi dan Registrasi bagi Orang atau Badan Hukum yang Melaksanakan Perancangan dan Perencanaan Rumah serta Perencanaan Prasarana,   Sarana   dan   Utilitas   Umum   PSU Tingkat Kemampuan Kecil"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penanganan Gangguan Ketenteraman dan Ketertiban Umum dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penegakan   Peraturan   Daerah   Kabupaten/Kota\ndan Peraturan Bupati/Wali Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pembinaan Penyidik Pegawai Negeri Sipil (PPNS) Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pelayanan        Informasi        Rawan        Bencana\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pelayanan     Pencegahan     dan     Kesiapsiagaan terhadap Bencana"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pelayanan  Penyelamatan  dan  Evakuasi  Korban\nBencana"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pencegahan,        Pengendalian,        Pemadaman,\nPenyelamatan, dan Penanganan Bahan Berbahaya dan Beracun Kebakaran dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pemberdayaan   Masyarakat   dalam   Pencegahan\nKebakaran"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan Operasi Pencarian dan Pertolongan terhadap Kondisi Membahayakan Manusia"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(6));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Rehabilitasi Sosial Dasar Penyandang Disabilitas Terlantar, Anak Terlantar, Lanjut Usia Terlantar, serta Gelandangan Pengemis di Luar Panti Sosial"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(6));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Rehabilitasi      Sosial      Penyandang      Masalah\nKesejahteraan   Sosial   (PMKS)   Lainnya   Bukan\nKorban HIV/AIDS dan NAPZA di Luar Panti Sosial"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(6));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pemeliharaan Anak-Anak Terlantar"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(6));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pengelolaan Data Fakir Miskin Cakupan Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(6));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Perlindungan  Sosial  Korban  Bencana  Alam  dan Sosial Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(6));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan     Pemberdayaan     Masyarakat terhadap Kesiapsiagaan Bencana Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(6));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',1);
                    });
                })->where('kode_program',$this->convertKode(7))->first())->id,
                "nama_kegiatan" => "Pemeliharaan Taman Makam Pahlawan Nasional Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(11))->first())->id,
                "nama_kegiatan" => "Pengelolaan Sampah"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penyimpanan Sementara Limbah B3"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(12));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pelayanan Pendaftaran Penduduk"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(12));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penataan Pendaftaran Penduduk"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(12));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan Pendaftaran Penduduk"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(12));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pelayanan Pencatatan Sipil"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(12));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan  Pencatatan Sipil"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(12));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penyusunan Profil Kependudukan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(13));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan Penataan Desa"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(13));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Fasilitasi Kerja Sama Antar Desa"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(22));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Pengelolaan Museum Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(24));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan Arsip Statis Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyusunan Rencana Tenaga Kerja (RTK)"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembinaan Lembaga Pelatihan Kerja Swasta"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Konsultansi Produktivitas pada Perusahaan Kecil"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pelaksanaan      Pelatihan      berdasarkan      Unit\nKompetensi"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Perizinan  dan  Pendaftaran  Lembaga  Pelatihan\nKerja"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengukuran     Produktivitas     Tingkat     Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pelayanan Antarkerja di Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pengelolaan Informasi Pasar Kerja"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penerbitan   Izin   Lembaga   Penempatan   Tenaga Kerja  Swasta  (LPTKS)  dalam  1  (satu)  Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pelindungan PMI (Pra dan Purna Penempatan) di\nDaerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penerbitan Perpanjangan IMTA yang Lokasi Kerja dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pengesahan      Peraturan      Perusahaan      dan\nPendaftaran Perjanjian Kerja Bersama untuk Perusahaan yang hanya Beroperasi dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(7));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pencegahan     dan     Penyelesaian     Perselisihan\nHubungan Industrial, Mogok Kerja dan Penutupan\nPerusahaan di Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pelembagaan   Pengarusutamaan   Gender   (PUG) pada      Lembaga      Pemerintah      Kewenangan Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pemberdayaan Perempuan Bidang Politik, Hukum, Sosial,      dan      Ekonomi      pada      Organisasi Kemasyarakatan Kewenangan Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penguatan dan Pengembangan Lembaga Penyedia Layanan Pemberdayaan Perempuan Kewenangan Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pencegahan    Kekerasan    terhadap    Perempuan Lingkup Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penyediaan   Layanan   Rujukan   Lanjutan   bagi\nPerempuan Korban Kekerasan yang Memerlukan\nKoordinasi Kewenangan Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penguatan dan Pengembangan Lembaga Penyedia\nLayanan Perlindungan Perempuan Tingkat Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Peningkatan       Kualitas       Keluarga       dalam\nMewujudkan  Kesetaraan  Gender  (KG)  dan  Hak\nAnak Tingkat Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penguatan dan Pengembangan Lembaga Penyedia Layanan  Peningkatan  Kualitas  Keluarga  dalam Mewujudkan  KG  dan  Hak  Anak  yang  Wilayah Kerjanya dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penyediaan    Layanan    bagi    Keluarga    dalam\nMewujudkan  KG  dan  Hak  Anak  yang  Wilayah\nKerjanya dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pengumpulan, Pengolahan Analisis dan Penyajian\nData Gender dan Anak Dalam Kelembagaan Data di Tingkat Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Pelembagaan  PHA  pada  Lembaga  Pemerintah,\nNonpemerintah,  dan  Dunia  Usaha  Kewenangan\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Penguatan dan Pengembangan Lembaga Penyedia\nLayanan   Peningkatan   Kualitas   Hidup   Anak\nKewenangan Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(7))->first())->id,
                "nama_kegiatan" => "Pencegahan   Kekerasan   terhadap   Anak   yang\nMelibatkan     para     Pihak     Lingkup     Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(7))->first())->id,
                "nama_kegiatan" => "Penyediaan Layanan bagi Anak yang Memerlukan Perlindungan      Khusus      yang      Memerlukan Koordinasi Tingkat Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(8));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(7))->first())->id,
                "nama_kegiatan" => "Penguatan dan Pengembangan Lembaga Penyedia\nLayanan      bagi      Anak      yang      Memerlukan\nPerlindungan     Khusus     Tingkat           Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(9));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyediaan Infrastruktur dan Seluruh Pendukung Kemandirian Pangan sesuai Kewenangan Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(9));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penyediaan dan Penyaluran Pangan Pokok atau Pangan Lainnya sesuai dengan Kebutuhan Daerah Kabupaten/Kota     dalam     rangka     Stabilisasi Pasokan dan Harga Pangan"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(9));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengelolaan dan Keseimbangan Cadangan Pangan\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(9));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penentuan Harga Minimum Daerah untuk Pangan\nLokal  yang  Tidak  Ditetapkan  oleh  Pemerintah\nPusat dan Pemerintah Provinsi"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(9));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pelaksanaan Pencapaian Target Konsumsi Pangan\nPerkapita/Tahun       sesuai       dengan       Angka\nKecukupan Gizi"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(9));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penyusunan   Peta   Kerentanan   dan   Ketahanan\nPangan Kecamatan"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(9));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penanganan   Kerawanan   Pangan   Kewenangan\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(9));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pelaksanaan    Pengawasan    Keamanan    Pangan Segar Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(10));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pemberian  Izin  Lokasi  Dalam  1  (satu)  Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(10));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penyelesaian  Sengketa  Tanah   Garapan  dalam\nDaerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(10));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penyelesaian    Masalah    Ganti    Kerugian    dan\nSantunan   Tanah   untuk   Pembangunan   oleh\nPemerintah Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(10));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Penetapan Subjek dan Objek Redistribusi Tanah serta      Ganti  Kerugian  Tanah  Kelebihan Maksimum   dan Tanah Absentee dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(10));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Penetapan   Ganti   Kerugian   Tanah   Kelebihan\nMaksimum dan Tanah Absentee Lintas Daerah Kabupaten/Kota dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(10));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(7))->first())->id,
                "nama_kegiatan" => "Penetapan  Tanah  Ulayat  yang  Lokasinya  dalam\nDaerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(10));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(10))->first())->id,
                "nama_kegiatan" => "Penggunaan  Tanah  yang  Hamparannya  dalam satu Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Rencana      Perlindungan      dan      Pengelolaan\nLingkungan Hidup (RPPLH) Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan    Kajian    Lingkungan    Hidup\nStrategis (KLHS) Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pencegahan   Pencemaran   dan/atau   Kerusakan\nLingkungan Hidup Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penanggulangan         Pencemaran         dan/atau\nKerusakan Lingkungan Hidup Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pemulihan   Pencemaran   dan/atau   Kerusakan\nLingkungan Hidup Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pengelolaan           Keanekaragaman           Hayati\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pengumpulan Limbah B3 dalam 1 (satu) Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Pembinaan dan Pengawasan terhadap Usaha dan/atau Kegiatan yang Izin Lingkungan dan Izin PPLH diterbitkan oleh Pemerintah Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(7))->first())->id,
                "nama_kegiatan" => "Pengakuan MHA, Kearifan Lokal, Pengetahuan Tradisional, dan Hak MHA yang terkait dengan PPLH"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(7))->first())->id,
                "nama_kegiatan" => "Peningkatan Kapasitas MHA dan Kearifan Lokal, Pengetahuan Tradisional dan Hak MHA yang terkait dengan PPLH"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(8))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan Pendidikan, Pelatihan, dan Penyuluhan Lingkungan Hidup untuk Lembaga Kemasyarakatan Tingkat Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(9))->first())->id,
                "nama_kegiatan" => "Pemberian    Penghargaan    Lingkungan    Hidup\nTingkat Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(10))->first())->id,
                "nama_kegiatan" => "Penyelesaian  Pengaduan  Masyarakat  di  Bidang\nPerlindungan dan Pengelolaan Lingkungan Hidup\n(PPLH) Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(11))->first())->id,
                "nama_kegiatan" => "Penerbitan               Izin               Pendaurulangan\nSampah/Pengelolaan    Sampah,    Pengangkutan\nSampah  dan  Pemrosesan  Akhir  Sampah  yang\nDiselenggarakan oleh Swasta"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(11));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(11))->first())->id,
                "nama_kegiatan" => "Pembinaan dan Pengawasan Pengelolaan Sampah yang Diselenggarakan oleh Pihak Swasta"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(12));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pembinaan   dan   Pengawasan   Penyelenggaraan\nPendaftaran Penduduk"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(12));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembinaan   dan   Pengawasan   Penyelenggaraan\nPencatatan Sipil"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(12));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pengumpulan      Data      Kependudukan      dan\nPemanfaatan       dan       Penyajian       Database\nKependudukan"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(12));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penataan   Pengelolaan   Informasi   Administrasi\nKependudukan"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(12));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan             Pengelolaan      Informasi\nAdministrasi Kependudukan"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(12));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pembinaan      dan      Pengawasan      Pengelolaan\nInformasi Administrasi Kependudukan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(13));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pembinaan   dan   Pengawasan   Penyelenggaraan\nAdministrasi Pemerintahan Desa"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(13));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pemberdayaan Lembaga Kemasyarakatan yang Bergerak di Bidang Pemberdayaan Desa dan Lembaga Adat Tingkat Daerah Kabupaten/Kota serta  Pemberdayaan  Masyarakat  Hukum  Adat yang Masyarakat Pelakunya Hukum Adat yang Sama dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(14));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pemaduan dan Sinkronisasi Kebijakan Pemerintah Daerah   Provinsi   dengan   Pemerintah   Daerah Kabupaten/Kota   dalam   rangka   Pengendalian Kuantitas Penduduk"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(14));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pemetaan    Perkiraan    Pengendalian    Penduduk Cakupan Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(14));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pelaksanaan Advokasi, Komunikasi, Informasi dan\nEdukasi  (KIE)  Pengendalian  Penduduk  dan  KB\nsesuai Kearifan Budaya Lokal"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(14));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pendayagunaan   Tenaga   Penyuluh   KB/Petugas\nLapangan KB (PKB/PLKB)"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(14));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengendalian dan Pendistribusian Kebutuhan Alat dan  Obat  Kontrasepsi  serta  Pelaksanaan Pelayanan KB di Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(14));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pemberdayaan   dan   Peningkatan   Peran   serta\nOrganisasi    Kemasyarakatan    Tingkat    Daerah\nKabupaten/Kota  dalam  Pelaksanaan  Pelayanan dan Pembinaan Kesertaan Ber-KB"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(14));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pelaksanaan   Pembangunan   Keluarga   melalui Pembinaan     Ketahanan     dan     Kesejahteraan Keluarga"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(14));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pelaksanaan dan Peningkatan Peran Serta Organisasi Kemasyarakatan Tingkat Daerah Kabupaten/ Kota dalam Pembangunan Keluarga Melalui Pembinaan Ketahanan dan Kesejahteraan Keluarga"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penetapan    Rencana    Induk    Jaringan    LLAJ Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyediaan    Perlengkapan    Jalan     di    Jalan\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan        Izin        Penyelenggaraan        dan\nPembangunan Fasilitas Parkir"
            ],
            [

                "kode_kegiatan" => "2.06",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pelaksanaan   Manajemen   dan   Rekayasa   Lalu\nLintas untuk Jaringan Jalan Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.07",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Persetujuan  Hasil  Analisis  Dampak  Lalu  Lintas\n(Andalalin) untuk Jalan Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.09",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyediaan    Angkutan    Umum    untuk    Jasa\nAngkutan  Orang  dan/atau  Barang  antar  Kota\ndalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.10",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penetapan Kawasan Perkotaan untuk Pelayanan\nAngkutan Perkotaan yang Melampaui Batas 1 (satu) Daerah Kabupaten/Kota dalam 1 (Satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.11",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penetapan   Rencana   Umum   Jaringan   Trayek\nPerkotaan dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.12",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penetapan   Rencana   Umum   Jaringan   Trayek\nPedesaan  dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.13",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penetapan   Wilayah   Operasi   Angkutan   Orang\ndengan   Menggunakan   Taksi   dalam   Kawasan\nPerkotaan  yang  Wilayah  Operasinya  dalam  1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.14",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Penyelenggaraan Angkutan Orang\ndalam   Trayek   Lintas   Daerah   Kabupaten/Kota\ndalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.15",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Penyelenggaraan Angkutan Taksi yang Wilayah Operasinya  dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.16",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penetapan Tarif Kelas Ekonomi untuk Angkutan Orang yang Melayani Trayek serta   Angkutan Perkotaan  dan Perdesaan dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Usaha Angkutan Laut bagi Badan Usaha yang Berdomisili dalam Daerah Kabupaten/Kota dan Beroperasi pada Lintas Pelabuhan di Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Usaha Angkutan Laut Pelayaran Rakyat bagi Orang Perorangan atau Badan Usaha yang Berdomisili dan yang Beroperasi pada Lintas Pelabuhan dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Usaha Penyelenggaraan Angkutan\nSungai dan Danau sesuai dengan Domisili Orang Perseorangan Warga Negara Indonesia atau Badan Usaha"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembangunan  dan  Penerbitan  Izin  Pelabuhan\nSungai dan Danau yang Melayani Trayek dalam 1\nDaerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Usaha Penyelenggaraan Angkutan\nPenyeberangan  sesuai  dengan  Domisili  Badan\nUsaha"
            ],
            [

                "kode_kegiatan" => "2.06",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penetapan Lintas Penyeberangan dan Persetujuan\nPengoperasian Kapal dalam Daerah Kabupaten/Kota yang Terletak pada Jaringan Jalan Kabupaten/Kota dan/atau Jaringan Jalur Kereta Api Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.07",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penetapan Lintas Penyeberangan dan Persetujuan\nPengoperasian    untuk    Kapal    yang    Melayani\nPenyeberangan dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.08",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan   Izin   Usaha   Jasa   terkait   dengan\nPerawatan dan Perbaikan Kapal"
            ],
            [

                "kode_kegiatan" => "2.09",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penetapan     Tarif     Angkutan     Penyeberangan\nPenumpang   Kelas   Ekonomi      dan   Kendaraan beserta  Muatannya  pada  Lintas  Penyeberangan\ndalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.10",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penetapan  Rencana  Induk  dan  Daerah Lingkungan Kerja (DLKR)/Daerah Lingkungan Kepentingan (DLKP) Pelabuhan Pengumpan Lokal"
            ],
            [

                "kode_kegiatan" => "2.11",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penetapan Rencana Induk dan DLKR/DLKP untuk\nPelabuhan Sungai dan Danau"
            ],
            [

                "kode_kegiatan" => "2.12",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembangunan, Penerbitan Izin Pembangunan dan\nPengoperasian Pelabuhan Pengumpan Lokal"
            ],
            [

                "kode_kegiatan" => "2.13",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembangunan dan Penerbitan Izin Pembangunan dan Pengoperasian Pelabuhan Sungai dan Danau"
            ],
            [

                "kode_kegiatan" => "2.14",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan   Izin   Usaha   untuk   Badan   Usaha\nPelabuhan di Pelabuhan Pengumpan Lokal"
            ],
            [

                "kode_kegiatan" => "2.15",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Pengembangan Pelabuhan untuk\nPelabuhan Pengumpan Lokal"
            ],
            [

                "kode_kegiatan" => "2.16",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Pengoperasian Pelabuhan Selama\n24 Jam untuk Pelabuhan Pengumpan Lokal"
            ],
            [

                "kode_kegiatan" => "2.17",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Pekerjaan Pengerukan di Wilayah\nPerairan Pelabuhan Pengumpan Lokal"
            ],
            [

                "kode_kegiatan" => "2.18",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan  Izin  Reklamasi  di  Wilayah  Perairan\nPelabuhan Pengumpan Lokal"
            ],
            [

                "kode_kegiatan" => "2.19",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan   Izin   Pengelolaan   Terminal   untuk\nKepentingan Sendiri (TUKS) di dalam DLKR/DLKP Pelabuhan Pengumpan Lokal"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penerbitan  Izin  Mendirikan  Bangunan  Tempat\nPendaratan dan Lepas Landas Helikopter"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Usaha, Izin Pembangunan dan Izin\nOperasi  Prasarana  Perkeretaapian  Umum  yang\nJaringan   Jalurnya   dalam   1   (satu)   Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penetapan   Jaringan   Jalur   Kereta   Api   yang\nJaringannya      dalam      1      (satu)      Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penetapan  Kelas  Stasiun  untuk  Stasiun  pada\nJaringan Jalur Kereta Api Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penerbitan  Izin  Operasi  Sarana  Perkeretaapian\nUmum  yang  Jaringan  Jalurnya  Melintasi  Batas\ndalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.06",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penetapan   Jaringan   Pelayanan   Perkeretaapian\npada        Jaringan        Jalur        Perkeretaapian\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.07",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(15));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penerbitan  Izin  Pengadaan  atau  Pembangunan\nPerkeretapian  Khusus,  Izin  Operasi,  dan Penetapan Jalur Kereta Api Khusus yang Jaringannya Dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(16));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan  Informasi  dan  Komunikasi  Publik\nPemerintah Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(16));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengelolaan Nama Domain yang telah Ditetapkan oleh   Pemerintah   Pusat   dan   Sub   Domain   di Lingkup Pemerintah Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(16));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengelolaan e-government Di Lingkup Pemerintah\nDaerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(17));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan  Izin  Usaha  Simpan  Pinjam  untuk Koperasi   dengan   Wilayah   Keanggotaan   dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(17));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan   Izin   Pembukaan   Kantor   Cabang,\nCabang   Pembantu   dan   Kantor   Kas   Koperasi\nSimpan Pinjam untuk Koperasi dengan Wilayah\nKeanggotaan dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(17));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pemeriksaan dan Pengawasan Koperasi, Koperasi Simpan  Pinjam/Unit  Simpan  Pinjam  Koperasi yang   Wilayah   Keanggotaannya   dalam   Daerah Kabupaten/ Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(17));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penilaian       Kesehatan       Koperasi       Simpan\nPinjam/Unit  Simpan  Pinjam  Koperasi yang Wilayah Keanggotaannya dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(17));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pendidikan   dan   Latihan   Perkoperasian   bagi Koperasi    yang    Wilayah    Keanggotaan    dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(17));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Pemberdayaan  dan  Perlindungan  Koperasi  yang Keanggotaannya dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(17));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(7))->first())->id,
                "nama_kegiatan" => "Pemberdayaan   Usaha   Mikro   yang   Dilakukan melalui Pendataan, Kemitraan, Kemudahan Perizinan,  Penguatan  Kelembagaan dan Koordinasi dengan Para Pemangku Kepentingan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(17));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(8))->first())->id,
                "nama_kegiatan" => "Pengembangan  Usaha  Mikro  dengan  Orientasi Peningkatan Skala Usaha menjadi Usaha Kecil"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(18));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penetapan Pemberian Fasilitas/Insentif Dibidang Penanaman Modal yang menjadi Kewenangan Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(18));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pembuatan         Peta         Potensi         Investasi\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(18));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan Promosi Penanaman Modal yang menjadi Kewenangan Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(18));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pelayanan Perizinan dan Non Perizinan secara Terpadu Satu Pintu dibidang Penanaman Modal yang menjadi Kewenangan Daerah Kabupaten/ Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(18));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pengendalian   Pelaksanaan   Penanaman   Modal\nyang         menjadi         Kewenangan         Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(18));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Pengelolaan  Data  dan  Informasi  Perizinan  dan\nNon  Perizinan  yang  Terintegrasi  pada  Tingkat\nDaerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(19));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyadaran,  Pemberdayaan,  dan  Pengembangan Pemuda   dan   Kepemudaan   terhadap   Pemuda Pelopor    Kabupaten/Kota,    Wirausaha    Muda Pemula, dan Pemuda Kader Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(19));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pemberdayaan   dan   Pengembangan   Organisasi Kepemudaan Tingkat Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(19));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembinaan     dan     Pengembangan     Olahraga Pendidikan    pada    Jenjang    Pendidikan    yang menjadi Kewenangan Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(19));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan   Kejuaraan   Olahraga   Tingkat\nDaerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(19));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembinaan dan Pengembangan Olahraga Prestasi\nTingkat Daerah Provinsi"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(19));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembinaan     dan     Pengembangan     Organisasi\nOlahraga"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(19));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pembinaan     dan     Pengembangan     Organisasi Kepramukaan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(21));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan Persandian untuk Pengamanan\nInformasi Pemerintah Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(22));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan     Kebudayaan     yang     Masyarakat\nPelakunya dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(22));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pelestarian Kesenian Tradisional yang Masyarakat\nPelakunya dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(22));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pembinaan   Lembaga   Adat   yang   Penganutnya dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(22));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembinaan Kesenian yang Masyarakat Pelakunya dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(22));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pembinaan Sejarah Lokal dalam 1 (satu) Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(22));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penetapan        Cagar        Budaya        Peringkat\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(22));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pengelolaan        Cagar        Budaya        Peringkat\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(22));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin membawa Cagar Budaya ke Luar\nDaerah  Kabupaten/Kota  dalam  1  (satu)  Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(23));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan     Perpustakaan     Tingkat     Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(23));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pembudayaan  Gemar  Membaca  Tingkat  Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(23));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pelestarian     Naskah     Kuno     Milik     Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(23));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengembangan Koleksi Budaya Etnis  Nusantara yang    ditemukan    oleh    Pemerintah    Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(24));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan Arsip  Dinamis  Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(24));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan Simpul Jaringan Informasi Kearsipan\nNasional Tingkat Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(24));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pemusnahan   Arsip   Dilingkungan   Pemerintah\nDaerah Kabupaten/Kota yang Memiliki Retensi di\nBawah 10 (sepuluh) Tahun"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(24));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Perlindungan   dan   Penyelamatan   Arsip   Akibat\nBencana yang Berskala Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(24));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penyelamatan       Arsip       Perangkat       Daerah\nKabupaten/Kota     yang     Digabung     dan/atau\nDibubarkan, dan Pemekaran Daerah Kecamatan dan Desa/Kelurahan"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(24));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Autentikasi  Arsip  Statis  dan  Arsip  Hasil  Alih\nMedia Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(24));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pencarian   Arsip   Statis   Kabupaten/Kota   yang\nDinyatakan Hilang"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(24));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pelayanan  Izin  Penggunaan  Arsip  yang  Bersifat\nTertutup di Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pemberdayaan Pembudi Daya Ikan Kecil"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pengelolaan Pembudidayaan Ikan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(26));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan Daya Tarik Wisata Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(26));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan Destinasi Pariwisata Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(26));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pengembangan Ekosistem Ekonomi Kreatif"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(26));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pengembangan Kapasitas Pelaku Ekonomi Kreatif"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengawasan Penggunaan Sarana Pertanian"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengawasan Obat Hewan di Tingkat Pengecer"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(32));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pencadangan Tanah untuk Kawasan Transmigrasi"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengelolaan Penangkapan Ikan di Wilayah Sungai,\nDanau, Waduk,  Rawa, dan Genangan Air Lainnya yang dapat Diusahakan dalam 1 (satu) Daerah Kabupaten/ Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pemberdayaan   Nelayan   Kecil   dalam   Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengelolaan     dan     Penyelenggaraan     Tempat Pelelangan Ikan (TPI)"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan    Tanda    Daftar    Kapal    Perikanan Berukuran  sampai  dengan  10  GT  di  Wilayah  Sungai, Danau, Waduk,  Rawa, dan Genangan Air Lainnya yang dapat Diusahakan dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Pengadaan Kapal Penangkap Ikan dan   Kapal   Pengangkut   Ikan   dengan   Ukuran sampai dengan 10 GT di Wilayah Sungai, Danau, Waduk,   Rawa, dan Genangan Air Lainnya yang dapat Diusahakan dalam 1 (satu) Daerah Kabupaten/ Kota"
            ],
            [

                "kode_kegiatan" => "2.06",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pendaftaran Kapal Perikanan Berukuran Sampai Dengan 10 GT yang Beroperasi di Sungai, Danau, Waduk,   Rawa, dan Genangan Air Lainnya yang dapat   Diusahakan   dalam   1   (satu)   Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penerbitan   Izin   Usaha   Perikanan   di   Bidang Pembudidayaan  Ikan  yang  Usahanya  dalam  1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penerbitan Tanda Daftar bagi Pembudi Daya Ikan Kecil (TDPIK) dalam 1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pengawasan Sumber Daya Perikanan di Wilayah Sungai, Danau, Waduk, Rawa, dan Genangan Air Lainnya     yang     dapat     Diusahakan     dalam Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Penerbitan Tanda Daftar Usaha Pengolahan Hasil Perikanan bagi Usaha Skala Mikro dan Kecil"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Pembinaan Mutu dan Keamanan Hasil Perikanan bagi  Usaha  Pengolahan  dan  Pemasaran  Skala Mikro dan Kecil"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(25));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Penyediaan dan Penyaluran Bahan Baku Industri Pengolahan    Ikan    dalam    1    (satu)    Daerah Kabupaten/ Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(26));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan     Kawasan     Strategis     Pariwisata\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(26));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penetapan Tanda Daftar Usaha Pariwisata Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(26));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pemasaran  Pariwisata  Dalam  dan  Luar  Negeri Daya Tarik, Destinasi dan Kawasan Strategis Pariwisata Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(26));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penyediaan Prasarana (Zona Kreatif/Ruang Kreatif/Kota Kreatif) sebagai Ruang Berekspresi, Berpromosi dan Berinteraksi bagi Insan Kreatif di Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(26));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pelaksanaan Peningkatan Kapasitas Sumber Daya Manusia Pariwisata dan Ekonomi Kreatif Tingkat Dasar"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan Sumber Daya Genetik (SDG) Hewan, Tumbuhan, dan Mikro Organisme Kewenangan Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Peningkatan Mutu dan Peredaran Benih/Bibit Ternak dan Tanaman Pakan Ternak serta Pakan dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengendalian dan Pengawasan Penyediaan dan Peredaran Benih/Bibit Ternak, dan Hijauan Pakan Ternak dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.06",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyediaan   Benih/Bibit   Ternak   dan   Hijauan Pakan Ternak yang Sumbernya dalam 1 (satu) Daerah Kabupaten/Kota Lain"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengelolaan Wilayah Sumber Bibit Ternak dan Rumpun/Galur Ternak dalam Daerah Kabupaten/ Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penjaminan Kesehatan Hewan, Penutupan dan Pembukaan Daerah Wabah Penyakit Hewan Menular Dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pengawasan Pemasukan dan Pengeluaran Hewan dan Produk Hewan Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pengelolaan  Pelayanan  Jasa  Laboratorium  dan\nJasa      Medik      Veteriner      dalam      Daerah\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penerapan dan Pengawasaan Persyaratan Teknis\nKesehatan Masyarakat Veteriner"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penerapan  dan  Pengawasan  Persyaratan  Teknis\nKesejahteraan Hewan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Pengendalian    dan    Penanggulangan    Bencana\nPertanian Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Penerbitan  Izin  Usaha  Pertanian  yang  Kegiatan\nUsahanya dalam Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Penerbitan   Izin   Usaha   Produksi   Benih/Bibit\nTernak dan Pakan, Fasilitas Pemeliharaan Hewan,\nRumah Sakit Hewan/Pasar Hewan, Rumah Potong\nHewan"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(27));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Izin Usaha Pengecer (Toko, Retail, Sub Distributor)\nObat Hewan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(28));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pengelolaan    Taman    Hutan    Raya    (TAHURA)\nKabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan Izin Pengelolaan Pasar Rakyat, Pusat\nPerbelanjaan, dan Izin Usaha Toko Swalayan"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan Surat Tanda Pendaftaran Waralaba (STPW) untuk Penerima Waralaba dari Waralaba Dalam Negeri"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan Surat Tanda Pendaftaran Waralaba (STPW) untuk   Penerima Waralaba Lanjutan dari Waralaba Luar Negeri"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan Surat Izin Usaha Perdagangan Minuman Beralkohol Golongan B dan C untuk Pengecer dan Penjual Langsung Minum di Tempat"
            ],
            [

                "kode_kegiatan" => "2.06",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengendalian Fasilitas Penyimpanan Bahan Berbahaya dan Pengawasan Distribusi, Pengemasan dan Pelabelan Bahan Berbahaya di Tingkat Daerah Kabupaten/ Kota"
            ],
            [

                "kode_kegiatan" => "2.07",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penerbitan Surat Keterangan Asal (bagi Daerah Kabupaten/Kota yang Telah Ditetapkan Sebagai Instansi Penerbit Surat Keterangan Asal)"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembangunan dan Pengelolaan Sarana Distribusi\nPerdagangan"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pembinaan terhadap Pengelola Sarana Distribusi\nPerdagangan Masyarakat di Wilayah Kerjanya"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Menjamin Ketersediaan Barang Kebutuhan Pokok dan  Barang  Penting  di  Tingkat  Daerah Kabupaten/ Kota"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pengendalian Harga, dan Stok Barang Kebutuhan Pokok dan Barang Penting di Tingkat Pasar Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pengawasan  Pupuk  dan  Pestisida  Bersubsidi  di\nTingkat Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan     Promosi     Dagang     melalui Pameran Dagang dan Misi Dagang bagi Produk Ekspor  Unggulan  yang  terdapat  pada  1  (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Pelaksanaan  Metrologi  Legal  berupa,  Tera,  Tera\nUlang, dan Pengawasan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(30));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(7))->first())->id,
                "nama_kegiatan" => "Pelaksanaan       Promosi,       Pemasaran       dan Peningkatan Penggunaan Produk Dalam Negeri"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(31));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyusunan,  Penerapan  dan  Evaluasi  Rencana Pembangunan Industri Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(31));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penerbitan  Izin  Usaha  Industri  (IUI),  Izin Perluasan Usaha Industri (IPUI), Izin Usaha Kawasan Industri (IUKI) dan Izin Perluasan Kawasan Industri (IPKI) Kewenangan Kabupaten/Kota Berbasis Sistem Informasi Industri Nasional (SIINAS)"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(31));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Penyediaan Informasi Industri untuk   Informasi Industri untuk IUI,    IPUI, IUKI dan IPKI Kewenangan Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(32));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Penataan Persebaran Penduduk yang Berasal dari\n1 (satu) Daerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(32));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',3);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Pengembangan Satuan Permukiman pada Tahap\nKemandirian"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Administrasi Tata Pemerintahan"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pelaksanaan Kebijakan Kesejahteraan Rakyat"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Fasilitasi dan Koordinasi Hukum"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Fasilitasi Kerjasama Daerah"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pelaksanaan Kebijakan Perekonomian"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pelaksanaan Administrasi Pembangunan"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengelolaan Pengadaan Barang dan Jasa"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pemantauan Kebijakan Sumber Daya Alam"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pembahasan Kebijakan Anggaran"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengawasan Penyelenggaraan Pemerintahan"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Peningkatan Kapasitas DPRD"
            ],
            [

                "kode_kegiatan" => "2.06",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pelaksanaan dan Pengawasan Kode Etik DPRD"
            ],
            [

                "kode_kegiatan" => "2.07",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pembahasan Kerja Sama Daerah"
            ],
            [

                "kode_kegiatan" => "2.08",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Fasilitasi Tugas DPRD"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pembentukan  Peraturan  Daerah  dan  Peraturan\nDPRD"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',4);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyerapan      dan      Penghimpunan      Aspirasi\nMasyarakat"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(20));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',2);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan  Statistik  Sektoral  di  Lingkup\nDaerah Kabupaten/Kota"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyusunan Perencanaan dan Pendanaan"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Analisis Data dan Informasi Pemerintahan Daerah\nBidang Perencanaan Pembangunan Daerah"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengendalian,  Evaluasi  dan  Pelaporan    Bidang\nPerencanaan Pembangunan Daerah"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Koordinasi   Perencanaan   Bidang   Pemerintahan dan Pembangunan Manusia"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Koordinasi   Perencanaan   Bidang   Perekonomian dan SDA (Sumber Daya Alam)"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Koordinasi Perencanaan Bidang Infrastruktur dan\nKewilayahan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Koordinasi  dan  Penyusunan  Rencana  Anggaran Daerah"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Koordinasi    dan    Pengelolaan    Perbendaharaan Daerah"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Koordinasi   dan   Pelaksanaan   Akuntansi   dan Pelaporan Keuangan Daerah"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penunjang    Urusan    Kewenangan    Pengelolaan\nKeuangan Daerah"
            ],
            [

                "kode_kegiatan" => "2.05",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengelolaan   Data   dan   Implementasi   Sistem Informasi Pemerintah Daerah Lingkup Keuangan Daerah"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pengelolaan Barang Milik Daerah"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(2));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Kegiatan Pengelolaan pendapatan Daerah"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Mutasi dan Promosi ASN"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengembangan Kompetensi ASN"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penilaian dan Evaluasi Kinerja Aparatur"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(3));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengadaan,     Pemberhentian     dan     Informasi Kepegawaian ASN"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengembangan Kompetensi Teknis"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(4));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Sertifikasi, Kelembagaan, Pengembangan Kompetensi Manajerial dan Fungsional"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pengembangan Inovasi dan Teknologi"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penelitian       dan       Pengembangan       Bidang Penyelenggaraan  Pemerintahan  dan  Pengkajian Peraturan"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penelitian dan Pengembangan Bidang Sosial dan Kependudukan"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(5));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',5);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penelitian  dan  Pengembangan  Bidang  Ekonomi dan Pembangunan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',6);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan Pengawasan Internal"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',6);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan   Pengawasan   dengan   Tujuan\nTertentu"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',6);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pendampingan dan Asistensi"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',6);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Perumusan     Kebijakan     Teknis     di     Bidang Pengawasan dan Fasilitasi Pengawasan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',7);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Koordinasi           Penyelenggaraan           Kegiatan\nPemerintahan di Tingkat Kecamatan"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',7);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan Urusan Pemerintahan yang tidak\nDilaksanakan oleh Unit Kerja Perangkat Daerah yang Ada di Kecamatan"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',7);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Koordinasi  Pemeliharaan  Prasarana  dan  Sarana\nPelayanan Umum"
            ],
            [

                "kode_kegiatan" => "2.04",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',7);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Pelaksanaan      Urusan      Pemerintahan      yang\nDilimpahkan kepada Camat"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',7);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Koordinasi Kegiatan Pemberdayaan Desa"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',7);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Kegiatan Pemberdayaan Kelurahan"
            ],
            [

                "kode_kegiatan" => "2.03",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',7);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Pemberdayaan Lembaga Kemasyarakatan Tingkat\nKecamatan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',7);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Koordinasi Upaya Penyelenggaraan Ketenteraman dan Ketertiban Umum"
            ],
            [

                "kode_kegiatan" => "2.02",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',7);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Koordinasi Penerapan dan Penegakan Peraturan\nDaerah dan Peraturan Kepala Daerah"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',7);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Penyelenggaraan   Urusan   Pemerintahan  Umum sesuai Penugasan Kepala Daerah"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',7);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Fasilitasi,      Rekomendasi      dan      Koordinasi\nPembinaan dan Pengawasan Pemerintahan Desa"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',8);
                    });
                })->where('kode_program',$this->convertKode(2))->first())->id,
                "nama_kegiatan" => "Perumusan Kebijakan Teknis dan Pemantapan Pelaksanaan Bidang Ideologi Pancasila dan Karakter Kebangsaan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',8);
                    });
                })->where('kode_program',$this->convertKode(3))->first())->id,
                "nama_kegiatan" => "Perumusan Kebijakan Teknis dan Pemantapan Pelaksanaan Bidang Pendidikan Politik, Etika Budaya Politik, Peningkatan Demokrasi, Fasilitasi Kelembagaan  Pemerintahan,  Perwakilan  dan Partai Politik, Pemilihan Umum/Pemilihan Umum Kepala Daerah, serta Pemantauan Situasi Politik"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',8);
                    });
                })->where('kode_program',$this->convertKode(4))->first())->id,
                "nama_kegiatan" => "Perumusan Kebijakan Teknis dan Pemantapan Pelaksanaan Bidang Pemberdayaan dan Pengawasan Organisasi Kemasyarakatan"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',8);
                    });
                })->where('kode_program',$this->convertKode(5))->first())->id,
                "nama_kegiatan" => "Perumusan Kebijakan Teknis dan Pemantapan Pelaksanaan Bidang Ketahanan Ekonomi, Sosial dan Budaya"
            ],
            [

                "kode_kegiatan" => "2.01",
                "id_program" => optional(\App\Models\Program::whereHas('BidangUrusan',function($q){
                    $q->where('kode_bidang_urusan',$this->convertKode(1));
                    $q->whereHas('Urusan',function ($q){
                        $q->where('kode_urusan',8);
                    });
                })->where('kode_program',$this->convertKode(6))->first())->id,
                "nama_kegiatan" => "Perumusan Kebijakan Teknis dan Pelaksanaan Pemantapan Kewaspadaan Nasional dan Penanganan Konflik Sosial"
            ]
        ];
        foreach ($kegiatan AS $index => $value){
            $kegiatan[$index]['uuid'] = \Illuminate\Support\Str::uuid()->toString();
            $kegiatan[$index]['tahun'] = date('Y');
        }
        \App\Models\Kegiatan::insert($kegiatan);
    }

    public function convertKode($kode){
        return $kode < 10 ? "0". $kode : $kode;
    }
}
