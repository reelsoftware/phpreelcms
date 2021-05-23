<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedPublicFieldToSubscriptionTypePlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_types', function (Blueprint $table) {
            $table->boolean('public')->default(0);
        });

        Schema::table('subscription_plans', function (Blueprint $table) {
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
        Schema::table('subscription_types', function (Blueprint $table) {
            $table->dropColumn('public');
        });

        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn('public');
        });
    }
}
