<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDpasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dpa', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->boolean('is_non_urusan');
            $table->unsignedBigInteger('id_program');
            $table->unsignedBigInteger('id_kegiatan');
            $table->unsignedBigInteger('id_sub_kegiatan');
            $table->unsignedBigInteger('id_pegawai_penanggung_jawab');
            $table->double('nilai_pagu_dpa');
            $table->integer('tahun');
            $table->timestamps();
            $table->unsignedBigInteger('user_insert')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();

            $table->foreign('id_sub_kegiatan','dpa_sub_kegiatan_foreign')
                ->references('id')
                ->on('sub_kegiatan')
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
        Schema::table('dpa',function (Blueprint $table){
            $table->dropForeign('dpa_sub_kegiatan_foreign');
        });
        Schema::dropIfExists('dpa');
    }
}
