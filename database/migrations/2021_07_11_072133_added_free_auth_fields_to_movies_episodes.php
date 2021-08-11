<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedFreeAuthFieldsToMoviesEpisodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->boolean('premium')->default('1');
            $table->boolean('auth')->default('1');
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->boolean('premium')->default('1');
            $table->boolean('auth')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('premium');
            $table->dropColumn('auth');
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->dropColumn('premium');
            $table->dropColumn('auth');
        });
    }
}
