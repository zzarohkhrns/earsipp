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
        Schema::create('kontrol_barang', function (Blueprint $table) {
            $table->uuid('id_kontrol_barang')->primary();
            $table->integer('id_barang');
            $table->date('tanggal_kontrol');
            $table->enum('berfungsi', ['ya', 'tidak'])->default('ya');
            $table->enum('kondisi', ['baik', 'tidak'])->default('baik');
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
        Schema::dropIfExists('kontrol_barang');
    }
};
