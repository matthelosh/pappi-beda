<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodikSiswaRombelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodik_siswa_rombels', function (Blueprint $table) {
            $table->id();
            $table->string('periode_id', 10);
            $table->string('rombel_id', 60);
            $table->string('siswa_id', 60);
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
        Schema::dropIfExists('periodik_siswa_rombel');
    }
}
