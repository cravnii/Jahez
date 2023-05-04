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
        Schema::create('logins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('device');
            $table->string('browser');
            $table->string('platform');
            $table->string('ip_address');
            $table->timestamp('login_at')->default(now());
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('logins');
    }

};
