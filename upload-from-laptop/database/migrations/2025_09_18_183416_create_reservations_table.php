<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('reservations');

        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('agent_id');
            $table->enum('status', ['waitingApproval', 'Reserved', 'PreparingDocument', 'ClosedDeal'])->default('waitingApproval');
            $table->decimal('commission', 10, 2)->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['property_id', 'agent_id']);
            $table->index('status');
        });

        // Add foreign key constraints separately
        // Schema::table('reservations', function (Blueprint $table) {
        //     $table->foreign('property_id')->references('id')->on('properties');
        //     $table->foreign('agent_id')->references('id')->on('users');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
