<?php

use Illuminate\Database\Seeder;

class SumberDanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sumber_dana = [
            [
                "nama_sumber_dana" => "APBN",
                "kode" => "01",
                "status" => ""
            ],
            [
                "nama_sumber_dana" => "DAK FISIK",
                "kode" => "02",
                "status" => ""
            ],
            [
                "nama_sumber_dana" => "DAK NON-FISIK",
                "kode" => "03",
                "status" => ""
            ],
            [
                "nama_sumber_dana" => "APBD I",
                "kode" => "04",
                "status" => ""
            ],
            [
                "nama_sumber_dana" => "APBD II",
                "kode" => "05",
                "status" => ""
            ]
        ];
        $sumber_dana = array_map(function ($value){
            $value['uuid'] = \Illuminate\Support\Str::uuid()->toString();
            return $value;
        },$sumber_dana);
        \App\Models\SumberDana::insert($sumber_dana);
    }
}
