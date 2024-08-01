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
        Schema::create('dokumentasi_barang', function (Blueprint $table) {
            $table->uuid('id_dokumentasi_barang')->primary();
            $table->string('judul');
            $table->string('foto');
            $table->foreignUuid('id_barang');
            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->foreignUuid('id_kontrol_barang');
            $table->foreign('id_kontrol_barang')->references('id_kontrol_barang')->on('kontrol_barang');
            $table->foreignUuid('id_keluar_masuk_barang');
            $table->foreign('id_keluar_masuk_barang')->references('id_keluar_masuk_barang')->on('keluar_masuk_barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokumentasi_barang');
    }
};
