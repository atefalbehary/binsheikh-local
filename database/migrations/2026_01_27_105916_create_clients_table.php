<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id')->index(); // The agent/agency who registered this client
            $table->string('client_name');
            $table->string('email');
            $table->string('country_code', 10);
            $table->string('phone', 20);
            $table->unsignedBigInteger('project_id')->nullable()->index();
            $table->string('nationality', 10)->nullable();
            $table->string('apartment_no')->nullable();
            $table->string('apartment_type', 20)->nullable(); // studio, 1bhk, 2bhk, 3bhk
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
        Schema::dropIfExists('clients');
    }
}
