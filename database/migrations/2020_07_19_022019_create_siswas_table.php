<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 10)->nullable();
            $table->string('nisn', 30);
            $table->string('nama_siswa', 50);
            $table->string('jk', 6);
            $table->string('alamat', 191)->default('0');
            $table->string('desa', 60)->default('0');
            $table->string('kec', 60)->default('0');
            $table->string('kab', 60)->default('0');
            $table->string('prov', 60)->default('0');
            $table->string('hp', 20)->default('0');
            $table->string('sekolah_id', 40)->default('0');
            $table->string('rombel_id', 40)->default('0');
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
        Schema::dropIfExists('siswas');
    }
}
