<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrtusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ortus', function (Blueprint $table) {
            $table->id();
            $table->string('siswa_id', 30)->default('0');
            $table->string('nama_ayah', 60);
            $table->string('job_ayah', 60);
            $table->string('nama_ibu', 60);
            $table->string('job_ibu', 60);
            $table->string('nama_wali', 60);
            $table->string('hub_wali', 60);
            $table->string('job_wali', 60);
            $table->string('alamat_wali', 191);
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
        Schema::dropIfExists('ortus');
    }
}
