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
            $gocap = DB::connection('gocap')->getDatabaseName(); // Menyiapkan nama database gocap

            $table->uuid('aset_id')->primary();
            $table->string('kode_aset')->nullable();
            $table->string('nama_aset')->nullable();
            $table->date('tgl_perolehan')->nullable();
            $table->integer('harga_perolehan')->nullable();

            // Foreign key id_pc
            $table->foreignUuid('id_pc')->nullable();
            $table->foreign('id_pc')->references('id_pc')->on(new Expression($gocap.'.pc')); // Menggunakan sintaks yang benar untuk Expression

            // Foreign key id_upzis
            $table->foreignUuid('id_upzis')->nullable();
            $table->foreign('id_upzis')->references('id_upzis')->on(new Expression($gocap.'.upzis')); // Menggunakan sintaks yang benar untuk Expression

            $table->string('satuan')->nullable();

            // Foreign key id_kategori_aset
            $table->foreignUuid('id_kategori')->nullable();
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori'); // Memastikan tabel dan kolom referensi benar

            $table->string('spesifikasi')->nullable();
            $table->string('lokasi_penyimpanan')->nullable();

            // Foreign key id_pc_pengurus
            $table->foreignUuid('id_pc_pengurus')->nullable();
            $table->foreign('id_pc_pengurus')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus')); // Menggunakan sintaks yang benar untuk Expression

            // Foreign key id_upzis_pengurus
            $table->foreignUuid('id_upzis_pengurus')->nullable();
            $table->foreign('id_upzis_pengurus')->references('id_upzis_pengurus')->on(new Expression($gocap . '.upzis_pengurus')); // Menggunakan sintaks yang benar untuk Expression
            
            $table->string('asal_perolahan')->nullable();

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
