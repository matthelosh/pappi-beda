<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKesehatanSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kesehatan_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('sekolah_id', 30);
            $table->string('periode', 30);
            $table->string('tingkat', 30);
            $table->string('rombel_id', 5);
            $table->string('siswa_id', 30);
            $table->string('pendengaran', 60);
            $table->string('penglihatan', 60);
            $table->string('gigi', 60);
            $table->string('lain', 60);
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
        Schema::dropIfExists('kesehatan_siswas');
    }
}
