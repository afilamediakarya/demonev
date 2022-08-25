<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiPenanggungJawabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai_penanggung_jawab', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nip');
            $table->string('nama_lengkap');
            $table->string('jabatan');
            $table->string('no_telp');
            $table->unsignedBigInteger('id_unit_kerja');
            $table->string('status');
            $table->timestamps();
            $table->unsignedBigInteger('user_insert')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();
//            $table->unsignedBigInteger('id_pegawai');
//            $table->foreign('id_pegawai')
//                ->references('id')
//                ->on('pegawai')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawai_penanggung_jawab');
    }
}
