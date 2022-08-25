<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTolakUkurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tolak_ukur', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->unsignedBigInteger('id_dpa');
            $table->string('tolak_ukur');
            $table->double('volume');
            $table->string('satuan');
            $table->integer('tahun');
            $table->timestamps();
            $table->unsignedBigInteger('user_insert')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();

            $table->foreign('id_dpa','tolak_ukur_dpa_foreign')
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
        Schema::table('tolak_ukur',function (Blueprint $table){
            $table->dropForeign('tolak_ukur_dpa_foreign');
        });
        Schema::dropIfExists('tolak_ukur');
    }
}
