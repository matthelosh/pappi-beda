<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateLogInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_infos', function (Blueprint $table) {
            $table->id();
            $table->string('log_id', 191)->unique();
            $table->string('sekolah_id', 30);
            $table->string('user_id', 40);
            $table->string('client_ip', 100);
            $table->string('client_os', 100);
            $table->dateTime('logout_time')->nullable();
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
        Schema::dropIfExists('log_infos');
    }
}
