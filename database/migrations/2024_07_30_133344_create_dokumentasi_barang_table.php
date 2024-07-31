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
            $table->integer('id_barang');
            $table->integer('id_kontrol_barang');
            $table->integer('id_keluar_masuk_barang');
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
