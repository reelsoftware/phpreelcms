<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandaloneVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standalone_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->unsignedMediumInteger('length');
            $table->unsignedBigInteger('thumbnail');
            $table->foreign('thumbnail')->references('id')->on('images');
            $table->unsignedBigInteger('video');
            $table->foreign('video')->references('id')->on('videos');
            $table->boolean('public')->default(0);
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
        Schema::dropIfExists('standalone_videos');
    }
}
