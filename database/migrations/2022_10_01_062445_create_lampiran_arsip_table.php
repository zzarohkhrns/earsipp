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
        Schema::create('lampiran_arsip', function (Blueprint $table) {
            $table->uuid('lampiran_arsip_id')->primary();
            $table->foreignUuid('arsip_digital_id')->nullable();
            $table->foreign('arsip_digital_id')->references('arsip_digital_id')->on('arsip_digital')->cascadeOnDelete();
            $table->string('file')->nullable();
            $table->string('nama')->nullable();
            $table->string('jenis')->nullable();
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
        Schema::dropIfExists('lampiran_arsip');
    }
};
