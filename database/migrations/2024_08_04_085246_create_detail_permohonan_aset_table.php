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
        Schema::create('detail_permohonan_aset', function (Blueprint $table) {
            $table->uuid('id_detail_permohonan_aset')->primary();
            $table->foreignUuid('aset_id')->nullable();
            $table->foreign('aset_id')->references('aset_id')->on('aset');
            $table->foreignUuid('id_permohonan_aset')->nullable();
            $table->foreign('id_permohonan_aset')->references('id_permohonan_aset')->on('permohonan_aset');
            $table->string('nama_barang')->nullable();
            $table->integer('kuantiti')->nullable();
            $table->text('uraian')->nullable();
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
        Schema::dropIfExists('detail_permohonan_aset');
    }
};
