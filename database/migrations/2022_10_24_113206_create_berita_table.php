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
        Schema::create('berita', function (Blueprint $table) {
            $siftnu = DB::connection('siftnu')->getDatabaseName();

            $table->uuid('id_berita_umum')->primary();
            $table->string('id_penyaluran_ziswaf')->nullable();
            $table->foreignUuid('id_pengguna')->nullable();
            $table->foreign('id_pengguna')->references('id_pengguna')->on(new Expression($siftnu . '.pengguna'));
            $table->string('kategori_berita')->nullable();
            $table->string('hastag_berita')->nullable();
            $table->string('judul_berita')->nullable();
            $table->text('narasi_berita')->nullable();
            $table->string('foto_background_berita')->nullable();
            $table->string('foto_dokumentasi_berita')->nullable();
            $table->date('tanggal_terbit')->nullable();
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
        Schema::dropIfExists('berita');
    }
};
