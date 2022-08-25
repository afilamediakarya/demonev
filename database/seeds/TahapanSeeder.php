<?php

use Illuminate\Database\Seeder;

class TahapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tahapan = [
            [
                'tahapan' => 'Kegiatan'
            ],[
                'tahapan' => 'Target'
            ],[
                'tahapan' => 'Realisasi'
            ],[
                'tahapan' => 'RKPD'
            ],[
                'tahapan' => 'RPJMD'
            ],
        ];

        foreach($tahapan AS $item){
            \App\Models\Tahapan::firstOrNew($item)->save();
        }
    }
}
