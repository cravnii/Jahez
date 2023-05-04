<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMealsTable extends Migration
{
    public function up()
    {
        Schema::create('order_meals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('meal_id');
            $table->decimal('price');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('meal_id')->references('id')->on('meals');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_meals');
    }
}

