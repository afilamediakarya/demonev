<?php

use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $satuan = [
            [
                "nama_satuan" => "Dokumen",
                "kode" => "01",
                "status" => ""
            ],
            [
                "nama_satuan" => "Paket",
                "kode" => "02",
                "status" => ""
            ]
        ];
        $satuan = array_map(function ($value){
            $value['uuid'] = \Illuminate\Support\Str::uuid()->toString();
            return $value;
        },$satuan);
        \App\Models\Satuan::insert($satuan);
    }
}
