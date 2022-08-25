<?php

use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        $program = [
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(10))->first())->id,
                "kode_program" => 10,
                "nama_program" => "PROGRAM PENATAGUNAAN TANAH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(10))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGELOLAAN IZIN LOKASI",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(10))->first())->id,
                "kode_program" => 7,
                "nama_program" => "PROGRAM PENETAPAN TANAH ULAYAT",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(10))->first())->id,
                "kode_program" => 8,
                "nama_program" => "PROGRAM PENGELOLAAN TANAH KOSONG",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(11))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PERENCANAAN LINGKUNGAN HIDUP",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(12))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENDAFTARAN PENDUDUK",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(12))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENCATATAN SIPIL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(13))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENATAAN DESA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(13))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENINGKATAN KERJASAMA DESA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(13))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM ADMINISTRASI PEMERINTAHAN DESA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(15))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENYELENGGARAAN LALU LINTAS DAN ANGKUTAN JALAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(15))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENGELOLAAN PELAYARAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(15))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENGELOLAAN PENERBANGAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(15))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENGELOLAAN PERKERETAAPIAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(17))->first())->id,
                "kode_program" => 8,
                "nama_program" => "PROGRAM PENGEMBANGAN UMKM",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(18))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PROMOSI PENANAMAN MODAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(18))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PELAYANAN PENANAMAN MODAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(22))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGEMBANGAN KEBUDAYAAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(22))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PEMBINAAN SEJARAH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(22))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PENGELOLAAN PERMUSEUMAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(23))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PEMBINAAN PERPUSTAKAAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(24))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGELOLAAN ARSIP",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(24))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PERIZINAN PENGGUNAAN ARSIP",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(25))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENGELOLAAN PERIKANAN TANGKAP",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(26))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PEMASARAN PARIWISATA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(27))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PERIZINAN USAHA PERTANIAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(27))->first())->id,
                "kode_program" => 7,
                "nama_program" => "PROGRAM PENYULUHAN PERTANIAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(30))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENGEMBANGAN EKSPOR",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGELOLAAN PENDIDIKAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENGEMBANGAN KURIKULUM",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENDIDIK DAN TENAGA KEPENDIDIKAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENGENDALIAN PERIZINAN PENDIDIKAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PENGEMBANGAN BAHASA DAN SASTRA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 4);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 1,
                "nama_program" => "PROGRAM ADMINISTRASI UMUM",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 4);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PEMERINTAHAN DAN KESEJAHTERAAN RAKYAT",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 4);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PEREKONOMIAN DAN PEMBANGUNAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 5);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PERENCANAAN, PENGENDALIAN DAN EVALUASI PEMBANGUNAN DAERAH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 5);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM KOORDINASI DAN SINKRONISASI PERENCANAAN PEMBANGUNAN DAERAH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 6);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENYELENGGARAAN PENGAWASAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 6);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PERUMUSAN KEBIJAKAN, PENDAMPINGAN DAN ASISTENSI",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 7);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENYELENGGARAAN PEMERINTAHAN DAN PELAYANAN PUBLIK",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 7);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PEMBERDAYAAN MASYARAKAT DESA DAN KELURAHAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 7);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM KOORDINASI KETENTRAMAN DAN KETERTIBAN UMUM",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 7);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENYELENGGARAAN URUSAN PEMERINTAHAN UMUM",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 7);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PEMBINAAN DAN PENGAWASAN PEMERINTAHAN DESA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 8);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGUATAN IDEOLOGI PANCASILA DAN KARAKTER KEBANGSAAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 8);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENINGKATAN PERAN PARTAI POLITIK DAN LEMBAGA PENDIDIKAN MELALUI PENDIDIKAN POLITIK DAN PENGEMBANGAN ETIKA SERTA BUDAYA POLITIK",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 8);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PEMBERDAYAAN DAN PENGAWASAN ORGANISASI KEMASYARAKATAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 8);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PEMBINAAN DAN PENGEMBANGAN KETAHANAN EKONOMI, SOSIAL, DAN BUDAYA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 8);
                })->where('kode_bidang_urusan', $this->convertKode(1))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PENINGKATAN KEWASPADAAN NASIONAL DAN PENINGKATAN KUALITAS DAN FASILITASI PENANGANAN KONFLIK SOSIAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(2))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PEMENUHAN UPAYA KESEHATAN PERORANGAN DAN UPAYA KESEHATAN MASYARAKAT",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(2))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENINGKATAN KAPASITAS SUMBER DAYA MANUSIA KESEHATAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(2))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM SEDIAAN FARMASI, ALAT KESEHATAN DAN MAKANAN MINUMAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(2))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PEMBERDAYAAN MASYARAKAT BIDANG KESEHATAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 4);
                })->where('kode_bidang_urusan', $this->convertKode(2))->first())->id,
                "kode_program" => 1,
                "nama_program" => "PROGRAM ADMINISTRASI UMUM SEKRETARIAT DPRD KABUPATEN/KOTA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 4);
                })->where('kode_bidang_urusan', $this->convertKode(2))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM DUKUNGAN PELAKSANAAN TUGAS DAN FUNGSI DPRD",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 5);
                })->where('kode_bidang_urusan', $this->convertKode(2))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGELOLAAN KEUANGAN DAERAH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 5);
                })->where('kode_bidang_urusan', $this->convertKode(2))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENGELOLAAN BARANG MILIK DAERAH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 5);
                })->where('kode_bidang_urusan', $this->convertKode(2))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENGELOLAAN PENDAPATAN DAERAH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(3))->first())->id,
                "kode_program" => 10,
                "nama_program" => "PROGRAM PENYELENGGARAAN JALAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(3))->first())->id,
                "kode_program" => 11,
                "nama_program" => "PROGRAM PENGEMBANGAN JASA KONSTRUKSI",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(3))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGELOLAAN SUMBER DAYA AIR (SDA)",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(3))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENGELOLAAN DAN PENGEMBANGAN SISTEM PENYEDIAAN AIR MINUM",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(3))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENGEMBANGAN SISTEM DAN PENGELOLAAN PERSAMPAHAN REGIONAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(3))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENGELOLAAN DAN PENGEMBANGAN SISTEM AIR LIMBAH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(3))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PENGELOLAAN DAN PENGEMBANGAN SISTEM DRAINASE",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(3))->first())->id,
                "kode_program" => 7,
                "nama_program" => "PROGRAM PENGEMBANGAN PERMUKIMAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(3))->first())->id,
                "kode_program" => 8,
                "nama_program" => "PROGRAM PENATAAN BANGUNAN GEDUNG",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(3))->first())->id,
                "kode_program" => 9,
                "nama_program" => "PROGRAM PENATAAN BANGUNAN DAN LINGKUNGANNYA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(3))->first())->id,
                "kode_program" => 12,
                "nama_program" => "PROGRAM PENYELENGGARAAN PENATAAN RUANG",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 5);
                })->where('kode_bidang_urusan', $this->convertKode(3))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM KEPEGAWAIAN DAERAH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(4))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGEMBANGAN PERUMAHAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(4))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM KAWASAN PERMUKIMAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(4))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PERUMAHAN DAN KAWASAN PERMUKIMAN KUMUH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(4))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENINGKATAN PRASARANA, SARANA DAN UTILITAS UMUM (PSU)",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(4))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PENINGKATAN PELAYANAN SERTIFIKASI, KUALIFIKASI, KLASIFIKASI, DAN REGISTRASI BIDANG PERUMAHAN DAN KAWASAN PERMUKIMAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 5);
                })->where('kode_bidang_urusan', $this->convertKode(4))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGEMBANGAN SUMBER DAYA MANUSIA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(5))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENANGGULANGAN BENCANA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(5))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENINGKATAN KETENTERAMAN DAN KETERTIBAN UMUM",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(5))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENCEGAHAN, PENANGGULANGAN, PENYELAMATAN KEBAKARAN DAN PENYELAMATAN NON KEBAKARAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 5);
                })->where('kode_bidang_urusan', $this->convertKode(5))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENELITIAN DAN PENGEMBANGAN DAERAH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 5);
                })->where('kode_bidang_urusan', $this->convertKode(6))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGELOLAAN PERBATASAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(6))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM REHABILITASI SOSIAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(6))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PERLINDUNGAN DAN JAMINAN SOSIAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(6))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PENANGANAN BENCANA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 1);
                })->where('kode_bidang_urusan', $this->convertKode(6))->first())->id,
                "kode_program" => 7,
                "nama_program" => "PROGRAM PENGELOLAAN TAMAN MAKAM PAHLAWAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(7))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PERENCANAAN TENAGA KERJA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(7))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PELATIHAN KERJA DAN PRODUKTIVITAS TENAGA KERJA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(7))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENEMPATAN TENAGA KERJA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(7))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM HUBUNGAN INDUSTRIAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(7))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PENGAWASAN KETENAGAKERJAAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(8))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PERLINDUNGAN PEREMPUAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(8))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENINGKATAN KUALITAS KELUARGA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(8))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PEMENUHAN HAK ANAK (PHA)",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(8))->first())->id,
                "kode_program" => 7,
                "nama_program" => "PROGRAM PERLINDUNGAN KHUSUS ANAK",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(8))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGARUS UTAMAAN GENDER DAN PEMBERDAYAAN PEREMPUAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(8))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENGELOLAAN SISTEM DATA GENDER DAN ANAK",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(9))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGELOLAAN SUMBER DAYA EKONOMI UNTUK KEDAULATAN DAN KEMANDIRIAN PANGAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(9))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENINGKATAN DIVERSIFIKASI DAN KETAHANAN PANGAN MASYARAKAT",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(9))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENANGANAN KERAWANAN PANGAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(9))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENGAWASAN KEAMANAN PANGAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(10))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENGADAAN TANAH UNTUK KEPENTINGAN UMUM",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(10))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENYELESAIAN SENGKETA TANAH GARAPAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(10))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENYELESAIAN GANTI KERUGIAN DAN SANTUNAN TANAH UNTUK PEMBANGUNAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(10))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM REDISTRIBUSI TANAH, DAN GANTI KERUGIAN PROGRAM TANAH KELEBIHAN MAKSIMUM DAN TANAH ABSENTEE",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(10))->first())->id,
                "kode_program" => 9,
                "nama_program" => "PROGRAM PENGELOLAAN IZIN MEMBUKA TANAH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(11))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENGENDALIAN PENCEMARAN DAN/ATAU KERUSAKAN LINGKUNGAN HIDUP",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(11))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENGELOLAAN KEANEKARAGAMAN HAYATI (KEHATI)",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(11))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENGENDALIAN BAHAN BERBAHAYA DAN BERACUN (B3) DAN LIMBAH BAHAN BERBAHAYA DAN BERACUN (LIMBAH B3)",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(11))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PEMBINAAN DAN PENGAWASAN TERHADAP IZIN LINGKUNGAN DAN IZIN PERLINDUNGAN DAN PENGELOLAAN LINGKUNGAN HIDUP (PPLH)",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(11))->first())->id,
                "kode_program" => 7,
                "nama_program" => "PROGRAM PENGAKUAN KEBERADAAN MASYARAKAT HUKUM ADAT (MHA), KEARIFAN LOKAL DAN HAK MHA YANG TERKAIT DENGAN PPLH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(11))->first())->id,
                "kode_program" => 8,
                "nama_program" => "PROGRAM PENINGKATAN PENDIDIKAN, PELATIHAN DAN PENYULUHAN LINGKUNGAN HIDUP UNTUK MASYARAKAT",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(11))->first())->id,
                "kode_program" => 9,
                "nama_program" => "PROGRAM PENGHARGAAN LINGKUNGAN HIDUP UNTUK MASYARAKAT",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(11))->first())->id,
                "kode_program" => 10,
                "nama_program" => "PROGRAM PENANGANAN PENGADUAN LINGKUNGAN HIDUP",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(11))->first())->id,
                "kode_program" => 11,
                "nama_program" => "PROGRAM PENGELOLAAN SAMPAH",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(12))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENGELOLAAN INFORMASI ADMINISTRASI KEPENDUDUKAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(12))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENGELOLAAN PROFIL KEPENDUDUKAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(13))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PEMBERDAYAAN LEMBAGA KEMASYARAKATAN, LEMBAGA ADAT DAN MASYARAKAT HUKUM ADAT",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(14))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGENDALIAN PENDUDUK",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(14))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PEMBINAAN KELUARGA BERENCANA (KB)",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(14))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PEMBERDAYAAN DAN PENINGKATAN KELUARGA SEJAHTERA (KS)",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(16))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGELOLAAN INFORMASI DAN KOMUNIKASI PUBLIK",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(16))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENGELOLAAN APLIKASI INFORMATIKA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(17))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PELAYANAN IZIN USAHA SIMPAN PINJAM",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(17))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENGAWASAN DAN PEMERIKSAAN KOPERASI",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(17))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENILAIAN KESEHATAN KSP/USP KOPERASI",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(17))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENDIDIKAN DAN LATIHAN PERKOPERASIAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(17))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PEMBERDAYAAN DAN PERLINDUNGAN KOPERASI",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(17))->first())->id,
                "kode_program" => 7,
                "nama_program" => "PROGRAM PEMBERDAYAAN USAHA MENENGAH, USAHA KECIL, DAN USAHA MIKRO (UMKM)",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(18))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGEMBANGAN IKLIM PENANAMAN MODAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(18))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENGENDALIAN PELAKSANAAN PENANAMAN MODAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(18))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PENGELOLAAN DATA DAN SISTEM INFORMASI PENANAMAN MODAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(19))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGEMBANGAN KAPASITAS DAYA SAING KEPEMUDAAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(19))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENGEMBANGAN KAPASITAS DAYA SAING KEOLAHRAGAAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(19))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENGEMBANGAN KAPASITAS KEPRAMUKAAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(20))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENYELENGGARAAN STATISTIK SEKTORAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(21))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENYELENGGARAAN PERSANDIAN UNTUK PENGAMANAN INFORMASI",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(22))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENGEMBANGAN KESENIAN TRADISIONAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(22))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PELESTARIAN DAN PENGELOLAAN CAGAR BUDAYA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(23))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PELESTARIAN KOLEKSI NASIONAL DAN NASKAH KUNO",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 2);
                })->where('kode_bidang_urusan', $this->convertKode(24))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PERLINDUNGAN DAN PENYELAMATAN ARSIP",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(25))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENGELOLAAN KELAUTAN, PESISIR DAN PULAU-PULAU KECIL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(25))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENGELOLAAN PERIKANAN BUDIDAYA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(25))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENGAWASAN SUMBER DAYA KELAUTAN DAN PERIKANAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(25))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM PENGOLAHAN DAN PEMASARAN HASIL PERIKANAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(26))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENINGKATAN DAYA TARIK DESTINASI PARIWISATA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(26))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENGEMBANGAN EKONOMI KREATIF MELALUI PEMANFAATAN DAN PERLINDUNGAN HAK KEKAYAAN INTELEKTUAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(26))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENGEMBANGAN SUMBER DAYA PARIWISATA DAN EKONOMI KREATIF",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(27))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PENYEDIAAN  DAN  PENGEMBANGAN SARANA PERTANIAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(27))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENYEDIAAN  DAN  PENGEMBANGAN PRASARANA PERTANIAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(27))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENGENDALIAN KESEHATAN HEWAN DAN KESEHATAN MASYARAKAT VETERINER",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(27))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENGENDALIAN DAN PENANGGULANGAN BENCANA PERTANIAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(28))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM KONSERVASI SUMBER DAYA ALAM HAYATI DAN EKOSISTEMNYA",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(28))->first())->id,
                "kode_program" => 5,
                "nama_program" => "PROGRAM PENDIDIKAN DAN PELATIHAN, PENYULUHAN DAN PEMBERDAYAAN MASYARAKAT DI BIDANG KEHUTANAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(30))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PERIZINAN DAN PENDAFTARAN PERUSAHAAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(30))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENINGKATAN SARANA DISTRIBUSI PERDAGANGAN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(30))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM STABILISASI HARGA BARANG KEBUTUHAN POKOK DAN BARANG PENTING",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(30))->first())->id,
                "kode_program" => 6,
                "nama_program" => "PROGRAM STANDARDISASI DAN PERLINDUNGAN KONSUMEN",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(30))->first())->id,
                "kode_program" => 7,
                "nama_program" => "PROGRAM PENGGUNAAN DAN PEMASARAN PRODUK DALAM NEGERI",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(31))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PERENCANAAN DAN PEMBANGUNAN INDUSTRI",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(31))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PENGENDALIAN IZIN USAHA INDUSTRI",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(31))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENGELOLAAN SISTEM INFORMASI INDUSTRI NASIONAL",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(32))->first())->id,
                "kode_program" => 2,
                "nama_program" => "PROGRAM PERENCANAAN KAWASAN TRANSMIGRASI",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(32))->first())->id,
                "kode_program" => 3,
                "nama_program" => "PROGRAM PEMBANGUNAN KAWASAN TRANSMIGRASI",
            ],
            [
                "uuid" => \Illuminate\Support\Str::uuid()->toString(),
                "id_bidang_urusan" => optional(\App\Models\BidangUrusan::whereHas('Urusan', function ($q) {
                    $q->where('kode_urusan', 3);
                })->where('kode_bidang_urusan', $this->convertKode(32))->first())->id,
                "kode_program" => 4,
                "nama_program" => "PROGRAM PENGEMBANGAN KAWASAN TRANSMIGRASI",
            ],
        ];
        foreach ($program as $index => $value) {
            $program[$index]['tahun'] = date('Y');
            $program[$index]['kode_program'] = $this->convertKode($value['kode_program']);
        }
        \App\Models\Program::insert($program);
    }

    public function convertKode($kode)
    {
        return $kode < 10 ? "0" . $kode : $kode;
    }

}
