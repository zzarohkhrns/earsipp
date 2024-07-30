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
        Schema::create('sppd', function (Blueprint $table) {
            $table->uuid('sppd_id')->primary();
            $table->foreignUuid('arsip_digital_id')->nullable();
            $table->foreign('arsip_digital_id')->references('arsip_digital_id')->on('arsip_digital')->cascadeOnDelete();
            $table->foreignUuid('disposisi_id')->nullable();
            $table->foreign('disposisi_id')->references('disposisi_id')->on('disposisi')->cascadeOnDelete();
            $table->string('perihal')->nullable();
            $table->date('tgl_pelaksanaan')->nullable();
            $table->integer('anggaran')->nullable();
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
        Schema::dropIfExists('sppd');
    }
};
