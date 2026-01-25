<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_sub', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->datetime("ordsub_dlvry_date_time")->nullable();
            $table->integer('ordsub_product_id');
            $table->integer('ordsub_qty');
            $table->integer('ordsub_product_price_id');
            $table->string('ordsub_prod_name',1500);
            $table->text('ordsub_cake_msg')->nullable();
            $table->text('ordsub_add_info')->nullable();
            $table->string('ordsub_weight',255);
            $table->double("ordsub_price")->default(0);
            $table->double("ordsub_ttl")->default(0);
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
        Schema::dropIfExists('order_sub');
    }
}
