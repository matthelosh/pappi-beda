<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFisikSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fisik_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('sekolah_id', 20);
            $table->string('periode', 20);
            $table->string('siswa_id', 20);
            $table->string('tingkat', 20);
            $table->string('rombel_id', 5);
            $table->string('tb', 5);
            $table->string('bb', 5);
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
        Schema::dropIfExists('fisik_siswas');
    }
}
