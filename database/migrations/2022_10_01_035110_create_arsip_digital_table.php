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
        Schema::create('arsip_digital', function (Blueprint $table) {

            $siftnu = DB::connection('siftnu')->getDatabaseName();

            $table->uuid('arsip_digital_id')->primary();
            $table->foreignUuid('id_pengguna');
            $table->foreign('id_pengguna')->references('id_pengguna')->on(new Expression($siftnu . '.pengguna'))->nullable();
            $table->enum('akses_internal', ['0', '1'])->nullable();
            $table->enum('akses_upzis', ['0', '1'])->nullable();
            $table->enum('akses_ranting', ['0', '1'])->nullable();
            $table->date('tanggal_arsip')->nullable();
            $table->string('nama_dokumen')->nullable();
            $table->enum('jenis_arsip', ['Dokumen Digital', 'Surat Masuk', 'Surat Keluar'])->nullable();
            $table->enum('jenis_disposisi', ['Golongan', 'Satuan', 'Internal'])->nullable();
            $table->string('nomor_surat')->nullable();
            $table->enum('klasifikasi_surat', ['Biasa', 'Khusus'])->nullable();
            $table->enum('klasifikasi_dokumen', ['Laporan Tahunan', 'Produk Hukum Organisasi NU', 'Produk Hukum Organisasi Banom', 'Hasil Bahtsul Masail'])->nullable();
            $table->string('tujuan_arsip')->nullable();
            $table->string('pengirim_sumber')->nullable();
            $table->string('perihal_isi_deskripsi')->nullable();
            $table->string('isi_surat')->nullable();
            $table->integer('no_urut')->nullable();
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
        Schema::dropIfExists('arsip_digital');
    }
};
