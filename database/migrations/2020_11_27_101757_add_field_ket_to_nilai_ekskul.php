<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldKetToNilaiEkskul extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nilai_ekskuls', function (Blueprint $table) {
            $table->dropColumn('nilai');
            $table->string('keterangan', 191);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nilai_ekskuls', function (Blueprint $table) {
            //
        });
    }
}
