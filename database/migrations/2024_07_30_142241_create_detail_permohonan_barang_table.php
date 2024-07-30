<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_permohonan_barang', function (Blueprint $table) {
            $table->uuid('id_detail_permohonan_barang')->primary();
            $table->foreignUuid('id_barang')->nullable();
            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->foreignUuid('id_permohonan')->nullable();
            $table->foreign('id_permohonan')->references('id_permohonan_barang_jasa')->on('permohonan_barang_jasa');
            $table->string('nama_barang')->nullable();
            $table->integer('kuantiti')->nullable();
            $table->text('uraian')->nullable();
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
        Schema::dropIfExists('detail_permohonan_barang');
    }
};
