<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitScheduleNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_schedule_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_schedule_id')->index();
            $table->unsignedBigInteger('created_by')->index(); // Agent who created this note
            $table->text('note');
            $table->string('visit_status', 50)->nullable(); // Status at time of note (Visited/Cancelled/Rescheduled/etc)
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
        Schema::dropIfExists('visit_schedule_notes');
    }
}
