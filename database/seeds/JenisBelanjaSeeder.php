<?php

use Illuminate\Database\Seeder;

class JenisBelanjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis_belanja = [
            [
                "nama_jenis_belanja" => "Belanja Operasi",
                "kode" => "01",
                "status" => ""
            ],
            [
                "nama_jenis_belanja" => "Belanja Modal",
                "kode" => "02",
                "status" => ""
            ],
            [
                "nama_jenis_belanja" => "Belanja TIdak Terduga",
                "kode" => "03",
                "status" => ""
            ],
            [
                "nama_jenis_belanja" => "Belanja Transfer",
                "kode" => "04",
                "status" => ""
            ]
        ];
        $jenis_belanja = array_map(function ($value){
            $value['uuid'] = \Illuminate\Support\Str::uuid()->toString();
            return $value;
        },$jenis_belanja);
        \App\Models\JenisBelanja::insert($jenis_belanja);
    }
}
