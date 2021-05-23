<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedPublicFieldToSeriesAndEpisodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->boolean('public')->default(0);
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->boolean('public')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->dropColumn('public');
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->dropColumn('public');
        });
    }
}
