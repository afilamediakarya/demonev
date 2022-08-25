<?php

use Illuminate\Database\Seeder;

class MetodePelaksanaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metode = [
            [
                "nama_metode_pelaksanaan" => "Lelang",
                "kode" => "01",
                "status" => ""
            ],
            [
                "nama_metode_pelaksanaan" => "Pengadaan Langsung",
                "kode" => "02",
                "status" => ""
            ],
            [
                "nama_metode_pelaksanaan" => "Swakelola",
                "kode" => "03",
                "status" => ""
            ]
        ];
        $metode = array_map(function ($value){
            $value['uuid'] = \Illuminate\Support\Str::uuid()->toString();
            return $value;
        },$metode);
        \App\Models\MetodePelaksanaan::insert($metode);
    }
}
