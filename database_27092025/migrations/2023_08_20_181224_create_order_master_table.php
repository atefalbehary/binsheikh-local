<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_master', function (Blueprint $table) {
            $table->id();
            $table->datetime("ord_date_time");
            $table->double("ord_item_ttl")->default(0);
            $table->double("ord_dlvry_amt")->default(0);
            $table->double("ord_gttl")->default(0);
            $table->integer('ord_user_id');
            $table->datetime("ord_dlvry_date_time")->nullable();
            $table->string('ord_dlvry_name', 255)->default('');
            $table->string('ord_dlvry_mobile', 50)->default('');
            $table->string('ord_dlvry_pincode', 20)->default('');
            $table->string('ord_dlvry_city', 255)->default('');
            $table->string('ord_dlvry_address_line_1', 500)->default('');
            $table->string('ord_dlvry_address_line_2', 500)->default('');
            $table->tinyinteger("ord_pay_type")->default(0)->comment('0-onlinepayment,1-cod');
            $table->tinyinteger("ord_pay_status")->default(0)->comment('0-pending,1-paid');
            $table->string("ord_pay_hash", 255)->default('');
            //0 pending=>
            $table->tinyinteger("ord_status")->default(0)->comment('0-pending,...');
            $table->datetime("ord_status_updated");
            $table->text("ord_status_remark");
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
        Schema::dropIfExists('order_master');
    }
}
