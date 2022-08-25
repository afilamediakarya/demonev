<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OauthClientSeeder::class);
        $this->call(AksesSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(TahapanSeeder::class);
        $this->call(SubTahapanSeeder::class);
        $this->call(UrusanSeeder::class);
        $this->call(BidangUrusanSeeder::class);
        $this->call(ProgramSeeder::class);
        $this->call(KegiatanSeeder::class);
        $this->call(SubKegiatanSeeder::class);
        $this->call(JenisBelanjaSeeder::class);
        $this->call(MetodePelaksanaanSeeder::class);
        $this->call(SatuanSeeder::class);
        $this->call(SumberDanaSeeder::class);
        $this->call(UnitKerjaSeeder::class);
        $this->call(NonUrusanSeeder::class);
        $this->call(UserSeeder::class);
    }
}
