<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer("wal_ordr_id");
            $table->double("wal_in_amt")->default(0);
            $table->double("wal_out_amt")->default(0);
            $table->tinyinteger("wal_status")->default(0)->comment('0-in to wallet,1-out from wallet');
            $table->text("wal_remark");
            $table->datetime("wal_created");
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
        Schema::dropIfExists('wallet');
    }
}
