<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVisitSchedulesTableRemovePropertyAddProjectAndUnitType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visit_schedules', function (Blueprint $table) {
            // Remove the property_id column
            $table->dropColumn('property_id');
            
            // Add project_id column to reference projects table
            $table->bigInteger('project_id')->after('client_id');
            
            // Add unit_type string column
            $table->string('unit_type')->nullable()->after('project_id');
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
            // Remove the new columns
            $table->dropColumn(['project_id', 'unit_type']);
            
            // Add back the property_id column
            $table->bigInteger('property_id')->after('client_id');
        });
    }
}
