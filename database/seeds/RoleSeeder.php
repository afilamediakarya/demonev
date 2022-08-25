<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nama_role' => 'admin',
            ],
            [
                'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nama_role' => 'opd',
            ],
        ];
        $akses['admin'] = \App\Models\Akses::whereNotIn('nama_akses',['kegiatan','monitoring-dan-evaluasi'])->orderBy('id')->pluck('id')->toArray();
        $akses['opd'] = \App\Models\Akses::whereIn('nama_akses',['kegiatan','monitoring-dan-evaluasi','laporan','unit-kerja'])->pluck('id')->toArray();

        foreach ($roles AS $role){
            try {
                \App\Models\Role::create($role)->Akses()->attach($akses[$role['nama_role']]);
            } catch (\Exception $exception){

            }
        }
    }
}
