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
        Schema::table('users', function (Blueprint $table) {
            $table->string('commission_number')->nullable()->after('email');
            $table->string('discount_number')->nullable()->after('commission_number');
            $table->text('apartment_sell')->nullable()->after('discount_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('commission_number');
            $table->dropColumn('discount_number');
            $table->dropColumn('apartment_sell');
        });
    }
}; 