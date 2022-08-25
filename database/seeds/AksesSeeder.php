<?php

use Illuminate\Database\Seeder;

class AksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $akses = [
            [
                'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nama_akses' => 'user',
                'route' => 'users',
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nama_akses' => 'monitoring-dan-evaluasi',
                'route' => 'monitoring-dan-evaluasi',
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nama_akses' => 'master-kegiatan',
                'route' => 'master-kegiatan',
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nama_akses' => 'laporan',
                'route' => 'laporan',
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nama_akses' => 'unit-kerja',
                'route' => 'unit-kerja',
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nama_akses' => 'master',
                'route' => 'master',
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nama_akses' => 'pengaturan',
                'route' => 'pengaturan',
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nama_akses' => 'kegiatan',
                'route' => 'kegiatan',
            ],
        ];

        foreach ($akses AS $item) {
            try {
                \App\Models\Akses::create($item);
            } catch (\Exception $exception){}
        }
    }
}
