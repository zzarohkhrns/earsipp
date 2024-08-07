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
        Schema::create('detail_pemeriksaan_aset', function (Blueprint $table) {
            $table->uuid('id_detail_pemeriksaan_aset')->primary();
            
            //foreign key pemeriksaan aset
            $table->foreignUuid('id_pemeriksaan_aset');
            $table->foreign('id_pemeriksaan_aset')->references('id_pemeriksaan_aset')->on('pemeriksaan_aset');
            
            //foreign key aset
            $table->foreignUuid('aset_id');
            $table->foreign('aset_id')->references('aset_id')->on('aset');

            $table->enum('kondisi', ['baik', 'rusak', 'perlu service', 'hilang']);
            $table->enum('status_aset', ['aktif', 'non aktif'])->default('aktif');
            $table->text('masalah_teridentifikasi');
            $table->text('tindakan_diperlukan');
            
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
        Schema::dropIfExists('detail_pemeriksaan_aset');
    }
};
