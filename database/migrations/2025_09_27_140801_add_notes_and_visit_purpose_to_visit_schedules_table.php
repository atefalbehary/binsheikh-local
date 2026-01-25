<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotesAndVisitPurposeToVisitSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visit_schedules', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('client_id');
            $table->enum('visit_purpose', ['buy', 'rent'])->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visit_schedules', function (Blueprint $table) {
            $table->dropColumn(['notes', 'visit_purpose']);
        });
    }
}
