<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanggalBiodataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanggal_biodata', function (Blueprint $table) {
            $table->id();
            $table->string('sekolah_id', 20);
            $table->string('periode_id', 10);
            $table->string('rombel_id', 10);
            $table->string('tanggal', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tanggal_biodata');
    }
}
