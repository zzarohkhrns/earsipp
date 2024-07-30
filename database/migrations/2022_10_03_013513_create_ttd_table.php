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
        Schema::create('ttd', function (Blueprint $table) {
            $gocap = DB::connection('gocap')->getDatabaseName();
            $table->uuid('ttd_id')->primary();
            $table->foreignUuid('arsip_digital_id')->nullable();
            $table->foreign('arsip_digital_id')->references('arsip_digital_id')->on('arsip_digital');
            $table->foreignUuid('id_pc_pengurus')->nullable();
            $table->foreign('id_pc_pengurus')->references('id_pc_pengurus')->on(new Expression($gocap . '.pc_pengurus'));
            $table->foreignUuid('id_upzis_pengurus')->nullable();
            $table->foreign('id_upzis_pengurus')->references('id_upzis_pengurus')->on(new Expression($gocap . '.upzis_pengurus'));
            $table->foreignUuid('id_ranting_pengurus')->nullable();
            $table->foreign('id_ranting_pengurus')->references('id_ranting_pengurus')->on(new Expression($gocap . '.ranting_pengurus'));
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
        Schema::dropIfExists('ttd');
    }
};
