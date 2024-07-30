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
        Schema::create('disposisi', function (Blueprint $table) {

            $gocap = DB::connection('gocap')->getDatabaseName();

            $table->uuid('disposisi_id')->primary();
            $table->foreignUuid('arsip_digital_id')->nullable();
            $table->foreign('arsip_digital_id')->references('arsip_digital_id')->on('arsip_digital')->cascadeOnDelete();
            $table->foreignUuid('id_pc')->nullable();
            $table->foreign('id_pc')->references('id_pc')->on(new Expression($gocap . '.pc'));
            $table->foreignUuid('id_upzis')->nullable();
            $table->foreign('id_upzis')->references('id_upzis')->on(new Expression($gocap . '.upzis'));
            $table->foreignUuid('id_ranting')->nullable();
            $table->foreign('id_ranting')->references('id_ranting')->on(new Expression($gocap . '.ranting'));
            $table->foreignUuid('id_pengurus_jabatan')->nullable();
            $table->foreign('id_pengurus_jabatan')->references('id_pengurus_jabatan')->on(new Expression($gocap . '.pengurus_jabatan'));
            $table->string('id_pengurus_internal')->nullable();
            $table->enum('status_baca', ['0', '1'])->nullable();
            $table->enum('sifat', ['Segera', 'Sangat Segera', 'Rahasia'])->nullable();
            $table->string('perihal')->nullable();
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
        Schema::dropIfExists('disposisi');
    }
};
