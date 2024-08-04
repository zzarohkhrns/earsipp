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
        Schema::create('pemeriksaan_aset', function (Blueprint $table) {
            $table->uuid('id_pemeriksaan_aset')->primary();
            $table->foreignUuid('aset_id');
            $table->foreign('aset_id')->references('aset_id')->on('aset');
            $table->date('tanggal_pemeriksaan');
            $table->enum('kondisi', ['baik', 'rusak', 'perlu service', 'hilang'])->default('baik');
            $table->enum('status_aset', ['aktif', 'non aktif'])->default('aktif');
            $table->string('keterangan');
            $table->enum('status_kc',['mengetahui', 'belum'])->default('belum');
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
        Schema::dropIfExists('pemeriksaan_aset');
    }
};
