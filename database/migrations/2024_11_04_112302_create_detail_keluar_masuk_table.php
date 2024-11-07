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
        Schema::create('detail_keluar_masuk_aset', function (Blueprint $table) {
            $table->uuid('id_detail_keluar_masuk_aset')->primary();
            $table->foreignUuid('id_keluar_masuk_aset')->nullable();
            $table->foreign('id_keluar_masuk_aset')->references('id_keluar_masuk_aset')->on('keluar_masuk_aset')->onDelete('cascade');
            $table->foreignUuid('aset_id')->nullable();
            $table->foreign('aset_id')->references('aset_id')->on('aset')->onDelete('cascade');
            $table->integer('masuk_kuantitas')->nullable();
            $table->string('masuk_kondisi')->nullable();
            $table->string('masuk_tindak_lanjut')->nullable();
            $table->string('masuk_dokumentasi')->nullable();
            $table->integer('keluar_kuantitas')->nullable();
            $table->string('keluar_kondisi')->nullable();
            $table->string('keluar_tindak_lanjut')->nullable();
            $table->string('keluar_dokumentasi')->nullable();
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
        Schema::dropIfExists('detail_keluar_masuk_aset');
    }
};
