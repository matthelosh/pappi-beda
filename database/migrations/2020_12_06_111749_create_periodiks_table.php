<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodiks', function (Blueprint $table) {
            $table->id();
            $table->string('sekolah_id', 30);
            $table->string('periode_id', 10);
            $table->string('rombel_id', 60);
            $table->string('siswa_id', 60);
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
        Schema::dropIfExists('periodiks');
    }
}
