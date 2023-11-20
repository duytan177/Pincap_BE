<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Album_Media\Privacy;
use App\Enums\Album_Media\MediaType;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('mediaName');
            $table->longText('mediaURL');
            $table->longText('description');
            $table->enum('type',MediaType::getValues());
            $table->enum('privacy',Privacy::getValues())->default(Privacy::PUBLIC);
            $table->boolean('isCreated')->default(false);
            $table->boolean('isDeleted')->default(false);
            $table->foreignUuid('mediaOwner_id')->references('id')->on('users');
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
        Schema::dropIfExists('medias');
    }
};
