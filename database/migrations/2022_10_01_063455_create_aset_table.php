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
        Schema::create('aset', function (Blueprint $table) {
            $siftnu = DB::connection('siftnu')->getDatabaseName();

            $table->uuid('aset_id')->primary();
            $table->foreignUuid('id_pengguna')->nullable();
            $table->foreign('id_pengguna')->references('id_pengguna')->on(new Expression($siftnu . '.pengguna'));
            $table->string('kategori')->nullable();
            $table->string('nama')->nullable();
            $table->string('jenis_aset')->nullable();
            $table->string('asal')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('tahun_perolehan')->nullable();
            $table->integer('jumlah_unit')->nullable();
            $table->integer('nominal')->nullable();
            $table->string('kondisi')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('aset');
    }
};
