<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kds', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kd', 10);
            $table->text('teks_kd');
            $table->string('mapel_id', 10);
            $table->string('tingkat', 10);
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
        Schema::dropIfExists('kds');
    }
}
