<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAltTextToMediaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->string('alt_text')->nullable()->after('image');
            $table->string('alt_text_ar')->nullable()->after('alt_text');
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->string('alt_text')->nullable()->after('link');
            $table->string('alt_text_ar')->nullable()->after('alt_text');
        });
        Schema::table('property_images', function (Blueprint $table) {
            $table->string('alt_text')->nullable()->after('image');
            $table->string('alt_text_ar')->nullable()->after('alt_text');
        });
        Schema::table('project_images', function (Blueprint $table) {
            $table->string('alt_text')->nullable()->after('image');
            $table->string('alt_text_ar')->nullable()->after('alt_text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn(['alt_text', 'alt_text_ar']);
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['alt_text', 'alt_text_ar']);
        });
        Schema::table('property_images', function (Blueprint $table) {
            $table->dropColumn(['alt_text', 'alt_text_ar']);
        });
        Schema::table('project_images', function (Blueprint $table) {
            $table->dropColumn(['alt_text', 'alt_text_ar']);
        });
    }
}
