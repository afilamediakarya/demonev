<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRkpdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rkpd', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->double('target_rpjmd_keuangan');
            $table->double('target_rpjmd_kinerja');
            $table->double('realisasi_rkpd_lalu_keuangan');
            $table->double('realisasi_rkpd_lalu_kinerja');
            $table->double('target_rkpd_sekarang_keuangan');
            $table->double('target_rkpd_sekarang_kinerja');
            $table->integer('semester');
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
        Schema::dropIfExists('rkpd');
    }
}
