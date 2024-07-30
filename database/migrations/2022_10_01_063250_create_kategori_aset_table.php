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
        Schema::create('kategori_aset', function (Blueprint $table) {
            $siftnu = DB::connection('siftnu')->getDatabaseName();

            $table->uuid('kategori_aset_id')->primary();
            $table->foreignUuid('id_pengguna');
            $table->foreign('id_pengguna')->references('id_pengguna')->on(new Expression($siftnu . '.pengguna'))->nullable();
            $table->string('nama_kategori')->nullable();
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
        Schema::dropIfExists('kategori_aset');
    }
};
