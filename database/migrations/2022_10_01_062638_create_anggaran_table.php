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
        Schema::create('anggaran', function (Blueprint $table) {
            $table->uuid('anggaran_id')->primary();
            $table->foreignUuid('sppd_id')->nullable();
            $table->foreign('sppd_id')->references('sppd_id')->on('sppd');
            $table->date('tgl_pengeluaran')->nullable();
            $table->integer('nominal')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('bukti')->nullable();
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
        Schema::dropIfExists('anggaran');
    }
};
