<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKkmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kkms', function (Blueprint $table) {
            $table->id();
            $table->string('sekolah_id', 30)->default('0');
            $table->string('periode_id', 30);
            $table->string('mapel_id', 30);
            $table->string('rombel_id', 30);
            $table->float('nilai')->unsigned()->length(3)->default(65);
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
        Schema::dropIfExists('kkms');
    }
}
