<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('notifiable', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->unsignedBigInteger('notifiable_id');
            $table->string('notifiable_type');
            $table->text('data')->nullable();
            $table->text('login_data')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};

