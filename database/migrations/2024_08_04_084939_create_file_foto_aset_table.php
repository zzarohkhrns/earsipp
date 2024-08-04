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
        Schema::create('file_foto_aset', function (Blueprint $table) {
            $table->uuid('id_file_aset');
            $table->foreignUuid('aset_id');
            $table->foreign('aset_id')->references('aset_id')->on('aset');
            $table->string('judul_file');
            $table->string('file');
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
        Schema::dropIfExists('file_foto_aset');
    }
};
