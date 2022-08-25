<?php

use Illuminate\Database\Seeder;

class SubTahapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kegiatan = \App\Models\Tahapan::where(['tahapan' => 'Kegiatan'])->first();
        $target = \App\Models\Tahapan::where(['tahapan' => 'Target'])->first();
        $realisasi = \App\Models\Tahapan::where(['tahapan' => 'Realisasi'])->first();
        $rkpd = \App\Models\Tahapan::where(['tahapan' => 'RKPD'])->first();
        $rpjmd = \App\Models\Tahapan::where(['tahapan' => 'RPJMD'])->first();
        $sub_tahapan = [
            [
                'id_tahapan' => $kegiatan->id,
                'sub_tahapan' => 'Sub Kegiatan DPA Pokok'
            ],[
                'id_tahapan' => $kegiatan->id,
                'sub_tahapan' => 'Sub Kegiatan DPA Perubahan'
            ],[
                'id_tahapan' => $target->id,
                'sub_tahapan' => 'Target DPA Pokok Triwulan I-IV'
            ],[
                'id_tahapan' => $target->id,
                'sub_tahapan' => 'Target DPA Perubahan Triwulan III-IV'
            ],[
                'id_tahapan' => $realisasi->id,
                'sub_tahapan' => 'Realisasi Triwulan I'
            ],[
                'id_tahapan' => $realisasi->id,
                'sub_tahapan' => 'Realisasi Triwulan II'
            ],[
                'id_tahapan' => $realisasi->id,
                'sub_tahapan' => 'Realisasi Triwulan III'
            ],[
                'id_tahapan' => $realisasi->id,
                'sub_tahapan' => 'Realisasi Triwulan IV'
            ],[
                'id_tahapan' => $realisasi->id,
                'sub_tahapan' => 'Evaluasi Triwulan I'
            ],[
                'id_tahapan' => $realisasi->id,
                'sub_tahapan' => 'Evaluasi Triwulan II'
            ],[
                'id_tahapan' => $realisasi->id,
                'sub_tahapan' => 'Evaluasi Triwulan III'
            ],[
                'id_tahapan' => $realisasi->id,
                'sub_tahapan' => 'Evaluasi Triwulan IV'
            ],[
                'id_tahapan' => $rkpd->id,
                'sub_tahapan' => 'RKPD'
            ],[
                'id_tahapan' => $rpjmd->id,
                'sub_tahapan' => 'RPJMD'
            ],
        ];

        foreach ($sub_tahapan AS $item){
            \App\Models\SubTahapan::firstOrNew($item)->save();
        }
    }
}
