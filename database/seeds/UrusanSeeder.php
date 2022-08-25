<?php

use Illuminate\Database\Seeder;

class UrusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urusan = [
            [
                "id" => "1",
                "kode_urusan" => "0",
                "nama_urusan" => "NON URUSAN",
                "tahun" => date('Y')
            ],
            [
                "id" => "3",
                "kode_urusan" => "1",
                "nama_urusan" => "URUSAN PEMERINTAHAN WAJIB YANG BERKAITAN DENGAN PELAYANAN DASAR",
                "tahun" => date('Y')
            ],
            [
                "id" => "4",
                "kode_urusan" => "2",
                "nama_urusan" => "URUSAN PEMERINTAHAN WAJIB YANG TIDAK BERKAITAN DENGAN PELAYANAN DASAR",
                "tahun" => date('Y')
            ],
            [
                "id" => "5",
                "kode_urusan" => "3",
                "nama_urusan" => "URUSAN PEMERINTAHAN PILIHAN",
                "tahun" => date('Y')
            ],
            [
                "id" => "6",
                "kode_urusan" => "4",
                "nama_urusan" => "UNSUR PENDUKUNG URUSAN PEMERINTAHAN",
                "tahun" => date('Y')
            ],
            [
                "id" => "7",
                "kode_urusan" => "5",
                "nama_urusan" => "UNSUR PENUNJANG URUSAN PEMERINTAHAN",
                "tahun" => date('Y')
            ],
            [
                "id" => "8",
                "kode_urusan" => "6",
                "nama_urusan" => "UNSUR PENGAWASAN URUSAN PEMERINTAHAN",
                "tahun" => date('Y')
            ],
            [
                "id" => "9",
                "kode_urusan" => "7",
                "nama_urusan" => "UNSUR KEWILAYAHAN",
                "tahun" => date('Y')
            ],
            [
                "id" => "10",
                "kode_urusan" => "8",
                "nama_urusan" => "UNSUR PEMERINTAHAN UMUM",
                "tahun" => date('Y')
            ],
            [
                "id" => "11",
                "kode_urusan" => "9",
                "nama_urusan" => "UNSUR KEKHUSUSAN",
                "tahun" => date('Y')
            ]
        ];
        foreach ($urusan as $row) {
            $row['uuid'] = \Illuminate\Support\Str::uuid()->toString();
            try {
                \App\Models\Urusan::create($row);
            } catch (\Exception $exception) {
            }
        }
    }
}
