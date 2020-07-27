<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilai2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai2s', function (Blueprint $table) {
            $table->id();
            $table->string('sekolah_id', 30)->default('0');
            $table->string('periode_id', 30);
            $table->string('rombel_id', 30);
            $table->string('mapel_id', 30);
            $table->string('butir_sikap', 100);
            $table->string('jenis', 30);
            $table->string('siswa_id', 30);
            $table->decimal('nilai', 5,2)->default(0);
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
        Schema::dropIfExists('nilai2s');
    }
}
