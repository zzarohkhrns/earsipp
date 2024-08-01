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
        Schema::create('keluar_masuk_barang', function (Blueprint $table) {
            $table->uuid('id_keluar_masuk_barang')->primary();
            $table->foreignUuid('id_barang');
            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->date('tanggal_keluar_masuk');
            $table->string('jumlah_masuk');
            $table->string('jumlah_keluar');
            $table->string('jumlah_sisa');
            $table->string('keterangan');
            $table->string('status_kc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keluar_masuk_barang');
    }
};
