<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketDak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_dak', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nama_paket');
            $table->double('volume');
            $table->string('satuan');
            $table->double('penerima_manfaat');
            $table->double('anggaran_dak');
            $table->double('pendampingan');
            $table->double('swakelola');
            $table->double('kontrak');
            $table->integer('tahun');
            $table->unsignedBigInteger('id_sumber_dana_dpa');
            $table->timestamps();
            $table->unsignedBigInteger('user_insert')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();

            $table->foreign('id_sumber_dana_dpa','paket_dak_foreign')
                ->references('id')
                ->on('sumber_dana_dpa')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_dak');
    }
}
