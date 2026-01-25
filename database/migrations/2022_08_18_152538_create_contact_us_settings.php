<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title',300)->nullable();
            $table->string('email',300)->nullable();
            $table->string('mobile',50)->nullable();
            $table->longText('desc')->nullable();
            $table->longText('address')->nullable();
            $table->string('facebook',600)->nullable();
            $table->string('twitter',600)->nullable();
            $table->string('instagram',600)->nullable();
            $table->string('youtube',600)->nullable();
            $table->timestamps();
        });
        DB::table('contact_us_settings')->insert(
          [
            'title' => 'Rexflow'
          ]
       );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_us_settings');
    }
}
