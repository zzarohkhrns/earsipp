<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Expression;
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
        Schema::create('permohonan_aset', function (Blueprint $table) {
            $gocap = DB::connection('gocap')->getDatabaseName();

            $table->uuid('id_permohonan_aset')->primary();
            $table->foreignUuid('id_pc_pengurus')->nullable();
            $table->foreign('id_pc_pengurus')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'))->nullable();
            $table->string('nomor_permohonan')->nullable();
            $table->string('tujuan_permohonan')->nullable();
            $table->date('tgl_permohonan')->nullable();
            $table->enum('status_permohonan', ['diajukan', 'direncanakan'])->default('direncanakan')->nullable();
            $table->enum('respon_spv', ['acc', 'tolak'])->default('tolak')->nullable();
            $table->enum('respon_kc', ['acc', 'tolak'])->default('tolak')->nullable();
            $table->date('tgl_respon_spv')->nullable();
            $table->date('tgl_respon_kc')->nullable();
            $table->text('catatan_kc')->nullable();
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
        Schema::dropIfExists('permohonan_aset');
    }
};
