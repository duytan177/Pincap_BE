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
        Schema::create('album_media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('album_id')->references('id')->on('albums');
            $table->foreignUuid('media_id')->references('id')->on('medias');
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
        Schema::dropIfExists('album_media');
    }
};
