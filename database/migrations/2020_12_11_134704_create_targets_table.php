<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('target', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->integer('periode')->comment('dalam triwulan');
            $table->double('target_keuangan')->nullable();
            $table->double('target_fisik')->nullable();
            $table->double('persentase')->nullable();
            $table->unsignedBigInteger('id_dpa');
            $table->integer('tahun');
            $table->timestamps();
            $table->unsignedBigInteger('user_insert')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();

            $table->foreign('id_dpa','target_dpa_foreign')
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
        Schema::table('target',function (Blueprint $table){
            $table->dropForeign('target_dpa_foreign');
        });
        Schema::dropIfExists('target');
    }
}
