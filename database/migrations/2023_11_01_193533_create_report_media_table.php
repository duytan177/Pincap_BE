<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Album_Media\StateReport;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->enum('state',StateReport::getValues())->default(StateReport::PROCESSING);
            $table->foreignUuid('user_report_id')->references('id')->on('users');
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
        Schema::dropIfExists('report_media');
    }
};
