<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidangUrusansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidang_urusan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('kode_bidang_urusan');
            $table->string('nama_bidang_urusan');
            $table->unsignedBigInteger('id_urusan');
            $table->integer('tahun');
            $table->timestamps();
            $table->unsignedBigInteger('user_insert')->nullable();
            $table->unsignedBigInteger('user_update')->nullable();

            $table->foreign('id_urusan')
                ->references('id')
                ->on('urusan')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bidang_urusan');
    }
}
