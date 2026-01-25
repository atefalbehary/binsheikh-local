<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrderMasterMapLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_master', function (Blueprint $table) {
            $table->string('map_location', 1500)->default('');
            $table->string('latitude', 50)->default('');
            $table->string('longitude', 50)->default('');
            $table->double("ord_paid_amt")->default(0)->after('ord_gttl');
            $table->double("ord_wal_paid_amt")->default(0)->after('ord_paid_amt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
      
}
