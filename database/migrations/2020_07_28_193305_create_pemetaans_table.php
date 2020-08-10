<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemetaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemetaans', function (Blueprint $table) {
            $table->id();
            $table->string('semester', 10);
            $table->string('mapel_id', 30);
            $table->string('tema_id', 30);
            $table->string('subtema_id', 30);
            $table->string('kd_id', 30);
            $table->string('tingkat', 30);
            $table->string('kata_kunci', 191)->default('0');
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
        Schema::dropIfExists('pemetaans');
    }
}
