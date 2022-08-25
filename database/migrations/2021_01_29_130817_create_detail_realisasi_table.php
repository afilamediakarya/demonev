<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailRealisasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_realisasi', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('id_realisasi');
            $table->integer('tahun');
            $table->unsignedBigInteger('id_dpa');
            $table->unsignedBigInteger('id_sumber_dana_dpa');
            $table->double('realisasi_keuangan')->nullable();
            $table->double('realisasi_fisik')->nullable();
            $table->integer('periode')->comment('dalam triwulan');
            $table->timestamps();
            $table->unsignedBigInteger('user_insert')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();

            $table->foreign('id_dpa','detail_realisasi_dpa_foreign')
                ->references('id')
                ->on('dpa')
                ->onUpdate('cascade')
                ->onDelete('restrict');

//            $table->foreign('id_realisasi','detail_realisasi_realisasi_foreign')
//                ->references('id')
//                ->on('realisasi')
//                ->onUpdate('cascade')
//                ->onDelete('restrict');
//
//            $table->foreign('id_sumber_dana_dpa','detail_realisasi_sumber_dana_foreign')
//                ->references('id')
//                ->on('sumber_dana_dpa')
//                ->onUpdate('cascade')
//                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_realisasi',function (Blueprint $table){
            $table->dropForeign('detail_realisasi_dpa_foreign');
//            $table->dropForeign('detail_realisasi_realisasi_foreign');
//            $table->dropForeign('detail_realisasi_sumber_dana_foreign');
        });
        Schema::dropIfExists('detail_realisasi');
    }
}
