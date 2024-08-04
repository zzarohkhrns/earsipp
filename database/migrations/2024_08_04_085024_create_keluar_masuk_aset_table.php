<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keluar_masuk_aset', function (Blueprint $table) {
            $table->uuid('id_keluar_masuk_aset')->primary();
            $table->foreignUuid('aset_id');
            $table->foreign('aset_id')->references('aset_id')->on('aset');
            $table->date('tanggal_keluar_masuk');
            $table->string('jumlah_masuk');
            $table->string('jumlah_keluar');
            $table->string('jumlah_sisa');
            $table->string('keterangan');
            $table->string('status_kc');
            $table->rememberToken();
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
        Schema::dropIfExists('keluar_masuk_aset');
    }
};
