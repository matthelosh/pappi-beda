<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiEkskulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_ekskuls', function (Blueprint $table) {
            $table->id();
            $table->string('sekolah_id', 30)->default('20518848');
            $table->string('periode', 8);
            $table->string('siswa_id', 20);
            $table->string('ekskul_id', 20);
            $table->decimal('nilai', 4,2);
            $table->string('tingkat', 20);
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
        Schema::dropIfExists('nilai_ekskuls');
    }
}
