<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Expression;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keluar_masuk_aset', function (Blueprint $table) {
            $gocap = DB::connection('gocap')->getDatabaseName();

            $table->uuid('id_keluar_masuk_aset')->primary();
            $table->date('tanggal_pencatatan');
            $table->foreignUuid('id_pencatat')->nullable();
            $table->foreign('id_pencatat')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('id_supervisor')->nullable();
            $table->foreign('id_supervisor')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('id_kc')->nullable();
            $table->foreign('id_kc')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->enum('status_pencatatan', ['selesai', 'belum'])->default('belum');
            $table->enum('status_spv', ['mengetahui', 'belum'])->default('belum');
            $table->enum('status_kc', ['mengetahui', 'belum'])->default('belum');
            $table->text('catatan_spv')->nullable();
            $table->text('catatan_kc')->nullable();
            $table->date('tgl_mengetahui_spv')->nullable();
            $table->date('tgl_mengetahui_kc')->nullable();
            $table->string('masuk_no_transaksi')->nullable();
            $table->date('masuk_tgl_masuk')->nullable();
            $table->string('masuk_nama_pemasok')->nullable();
            $table->string('masuk_no_faktur')->nullable();
            $table->string('masuk_keterangan')->nullable();
            $table->string('keluar_no_transaksi')->nullable();
            $table->date('keluar_tgl_keluar')->nullable();
            $table->string('keluar_nama_penerima')->nullable();
            $table->string('keluar_no_faktur')->nullable();
            $table->string('keluar_keterangan')->nullable();
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
        Schema::dropIfExists('keluar_masuk_aset');
    }
};
