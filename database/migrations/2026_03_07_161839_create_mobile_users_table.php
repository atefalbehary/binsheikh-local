<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('user_device_type')->nullable();
            $table->string('user_device_token')->nullable();
            $table->string('social_type')->nullable();
            $table->string('image')->nullable();
            $table->integer('role')->default(2);
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('deleted')->default(0);
            $table->string('otp')->nullable();
            $table->string('otp_token')->nullable();
            $table->dateTime('otp_time')->nullable();
            $table->string('password_otp')->nullable();
            $table->string('password_token')->nullable();
            $table->dateTime('password_time')->nullable();
            $table->integer('verified')->default(0);
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
        Schema::dropIfExists('mobile_users');
    }
}
