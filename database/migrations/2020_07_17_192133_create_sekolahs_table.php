<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSekolahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('npsn', 30);
            $table->string('nama_sekolah', 60);
            $table->string('alamat', 191);
            $table->string('desa', 60);
            $table->string('kec', 60);
            $table->string('kab', 60);
            $table->string('prov', 60);
            $table->string('kode_pos', 6);
            $table->string('telp', 20);
            $table->string('email', 60);
            $table->string('website', 60);
            $table->string('operator_id', 60);
            $table->string('ks_id', 60);
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
        Schema::dropIfExists('sekolahs');
    }
}
