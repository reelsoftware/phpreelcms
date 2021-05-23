<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25);
            $table->string('description', 255)->nullable();
            $table->string('stripe_price_id', 40);
            $table->string('benefits', 500)->nullable();
            $table->unsignedBigInteger('subscription_type_id');
            $table->foreign('subscription_type_id')->references('id')->on('subscription_types');
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
        Schema::dropIfExists('subscription_plans');
    }
}
