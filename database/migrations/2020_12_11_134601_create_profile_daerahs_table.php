<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileDaerahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_daerah', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nama_daerah');
            $table->string('pimpinan_daerah');
            $table->text('alamat')->nullable();
            $table->string('email');
            $table->string('no_telp');
            $table->text('visi_daerah')->nullable();
            $table->text('misi_daerah')->nullable();
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
        Schema::dropIfExists('profile_daerah');
    }
}
