<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('pincode', 20)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('address_line_1', 500)->nullable();
            $table->string('address_line_2', 500)->nullable();
            $table->integer('is_default')->default(0);
            $table->integer('active')->default(1);
            $table->integer('deleted')->default(0);
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
        Schema::dropIfExists('user_addresses');
    }
}
