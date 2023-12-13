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
        Schema::create('reaction_media', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->foreignUuid('media_id')->references('id')->on('medias');
            $table->foreignUuid('feeling_id')->references('id')->on('feelings');
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
        Schema::dropIfExists('reaction_media');
    }
};
