<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nama_lengkap' => 'admin',
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'id_role' => \App\Models\Role::where('nama_role','admin')->first()->id,
                'status' => 1,
            ],[
                'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                'nama_lengkap' => 'user',
                'username' => 'user',
                'password' => bcrypt('user'),
                'nip' => '60200112024',
                'id_unit_kerja' => 2,
                'id_role' => \App\Models\Role::where('nama_role','opd')->first()->id,
                'status' => 1,
            ]
        ];

        foreach ($users AS $user){
            try {
                \App\Models\User::create($user);
            }catch (\Exception $exception){
            }
        }


    }
}
