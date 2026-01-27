<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Agent fields: qid, authorized_signatory (agent version), license, id_card, id_no
     * Agency fields: trade_license, professional_practice_certificate, cr, id_no
     * Note: authorized_signatory already exists from previous migration
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('users', 'license')) {
                $table->string('license', 500)->nullable()->after('phone');
            }
            
            if (!Schema::hasColumn('users', 'id_card')) {
                $table->string('id_card', 500)->nullable()->after('license');
            }
            
            if (!Schema::hasColumn('users', 'id_no')) {
                $table->string('id_no', 200)->nullable()->after('id_card');
            }
            
            // Agent specific field
            if (!Schema::hasColumn('users', 'qid')) {
                $table->string('qid', 500)->nullable()->comment('QID document for agents')->after('id_no');
            }
            
            // Agency specific fields
            if (!Schema::hasColumn('users', 'trade_license')) {
                $table->string('trade_license', 500)->nullable()->comment('Trade License for agencies')->after('qid');
            }
            
            if (!Schema::hasColumn('users', 'professional_practice_certificate')) {
                $table->string('professional_practice_certificate', 500)->nullable()->comment('Professional Practice Certificate for agencies')->after('trade_license');
            }
            
            if (!Schema::hasColumn('users', 'cr')) {
                $table->string('cr', 500)->nullable()->comment('Commercial Registration for agencies')->after('professional_practice_certificate');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['license', 'id_card', 'id_no', 'qid', 'trade_license', 'professional_practice_certificate', 'cr'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
