<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealisasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realisasi', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('periode')->comment('dalam triwulan');
            $table->double('realisasi_keuangan')->nullable();
            $table->double('realisasi_fisik')->nullable();
            $table->integer('tahun');
            $table->unsignedBigInteger('id_dpa');
            $table->text('permasalahan')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_insert')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();

            $table->foreign('id_dpa','realisasi_dpa_foreign')
                ->references('id')
                ->on('dpa')
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
        Schema::table('realisasi',function (Blueprint $table){
            $table->dropForeign('realisasi_dpa_foreign');
        });
        Schema::dropIfExists('realisasi');
    }
}
