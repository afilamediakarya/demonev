<?php

use Illuminate\Database\Seeder;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::table('oauth_clients')->insert([
                'id' => 1,
                'user_id' => null,
                'name' => 'Client',
                'secret' => 'secret',
                'provider' => 'users',
                'redirect' => url(''),
                'personal_access_client' => 1,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => \Carbon\Carbon::now()
            ]);
        } catch (\Exception $exception){}
    }
}
