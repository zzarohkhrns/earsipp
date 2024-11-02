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
            $table->uuid('id_keluar_masuk_aset')->primary();
            $table->foreignUuid('aset_id')->nullable();
            $table->foreign('aset_id')->references('aset_id')->on('aset');
            $table->string('masuk_kuantitas');
            $table->string('masuk_kondisi');
            $table->string('masuk_tindak_lanjut');
            $table->string('keluar_kuantitas');
            $table->string('keluar_kondisi');
            $table->string('keluar_tindak_lanjut');
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
