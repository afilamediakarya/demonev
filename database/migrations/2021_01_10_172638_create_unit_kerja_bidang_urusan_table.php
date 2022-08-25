<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitKerjaBidangUrusanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_kerja_bidang_urusan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_unit_kerja');
            $table->unsignedBigInteger('id_bidang_urusan');
            $table->timestamps();

            $table->foreign('id_unit_kerja','unit_kerja_foreign')
                ->references('id')
                ->on('unit_kerja')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('id_bidang_urusan','bidang_urusan_foreign')
                ->references('id')
                ->on('bidang_urusan')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_kerja_bidang_urusan',function(Blueprint $table){
            $table->dropForeign('unit_kerja_foreign');
            $table->dropForeign('bidang_urusan_foreign');
        });
        Schema::dropIfExists('unit_kerja_bidang_urusan');
    }
}
