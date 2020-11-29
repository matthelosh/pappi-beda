<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->string('sekolah_id', 30);
            $table->string('periode', 30);
            $table->string('rombel_id', 30);
            $table->string('tingkat', 30);
            $table->string('siswa_id', 30);
            $table->string('alpa', 30);
            $table->string('ijin', 30);
            $table->string('sakit', 30);
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
        Schema::dropIfExists('absensis');
    }
}
