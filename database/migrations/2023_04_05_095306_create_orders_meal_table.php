<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersMealTable extends Migration
{
    public function up()
    {
        Schema::create('order_meal', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('meal_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_meal');
    }
}
