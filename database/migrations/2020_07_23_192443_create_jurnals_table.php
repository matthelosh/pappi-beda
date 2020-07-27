<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal', 10);
            $table->string('periode_id', 10);
            $table->string('rombel_id', 10);
            $table->string('butir_sikap', 100);
            $table->string('aspek', 3);
            $table->string('siswa_id', 30);
            $table->text('catatan');
            $table->decimal('nilai', 8,2)->default(80);
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
        Schema::dropIfExists('jurnals');
    }
}
