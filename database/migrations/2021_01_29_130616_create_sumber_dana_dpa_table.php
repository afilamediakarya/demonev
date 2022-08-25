<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSumberDanaDpaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sumber_dana_dpa', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('jenis_belanja');
            $table->string('sumber_dana');
            $table->string('metode_pelaksanaan');
            $table->double('nilai_pagu');
            $table->integer('tahun');
            $table->unsignedBigInteger('id_dpa');
            $table->timestamps();
            $table->unsignedBigInteger('user_insert')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();

            $table->foreign('id_dpa','sumber_dana_dpa_foreign')
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
        Schema::table('sumber_dana_dpa',function (Blueprint $table){
            $table->dropForeign('sumber_dana_dpa_foreign');
        });
        Schema::dropIfExists('sumber_dana_dpa');
    }
}
