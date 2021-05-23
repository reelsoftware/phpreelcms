<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->longText('description', 500);
            $table->smallInteger('order');
            $table->unsignedBigInteger('series_id');
            $table->foreign('series_id')->references('id')->on('series');
            
            $table->unsignedBigInteger('thumbnail');
            $table->foreign('thumbnail')->references('id')->on('images');

            $table->unsignedBigInteger('trailer');
            $table->foreign('trailer')->references('id')->on('videos');
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
        Schema::dropIfExists('seasons');
    }
}
