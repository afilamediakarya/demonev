<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignPegawaiPenanggungJawabToDpasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dpa', function (Blueprint $table) {
            $table->foreign('id_pegawai_penanggung_jawab','dpa_pj_foreign')
                ->references('id')
                ->on('pegawai_penanggung_jawab')
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
        Schema::table('dpa', function (Blueprint $table) {
            $table->dropForeign('dpa_pj_foreign');
        });
    }
}
