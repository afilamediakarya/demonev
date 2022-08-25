<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nama_lengkap');
            $table->string('username')->unique();
            $table->string('password');
//            $table->unsignedBigInteger('id_pegawai')->nullable();
            $table->string('nip')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('no_telp')->nullable();
            $table->unsignedBigInteger('id_unit_kerja')->nullable();
            $table->unsignedBigInteger('id_role');
            $table->string('status');
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('user_insert')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
