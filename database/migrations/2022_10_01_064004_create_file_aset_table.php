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
        Schema::create('file_aset', function (Blueprint $table) {
            $table->uuid('file_aset_id')->primary();
            $table->foreignUuid('aset_id')->nullable();
            $table->foreign('aset_id')->references('aset_id')->on('aset')->cascadeOnDelete();
            $table->string('nama_file')->nullable();
            $table->string('file_aset')->nullable();
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
        Schema::dropIfExists('file_aset');
    }
};
