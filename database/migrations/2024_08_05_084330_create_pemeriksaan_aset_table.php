<?php

use Faker\Calculator\Ean;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
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
            $gocap = DB::connection('gocap')->getDatabaseName();

            $table->uuid('id_pemeriksaan_aset')->primary();
            $table->date('tanggal_pemeriksaan');
            $table->foreignUuid('id_pemeriksa')->nullable();
            $table->foreign('id_pemeriksa')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('id_supervisor')->nullable();
            $table->foreign('id_supervisor')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('id_kc')->nullable();
            $table->foreign('id_kc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->enum('status_pemeriksaan', ['selesai', 'belum'])->default('belum');
            $table->enum('status_spv',['mengetahui', 'belum'])->default('belum');
            $table->enum('status_kc',['mengetahui', 'belum'])->default('belum');
            $table->string('catatan_kc')->nullable();
            $table->string('catatan_spv')->nullable();
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
