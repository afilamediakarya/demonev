<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToBackupSumberDanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('backup_report_sumber_dana_dpa', function (Blueprint $table) {
            $table->unsignedBigInteger('id_dpa_backup')->nullable();
        });
        Schema::table('backup_report_tolak_ukur', function (Blueprint $table) {
            $table->unsignedBigInteger('id_dpa_backup')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
