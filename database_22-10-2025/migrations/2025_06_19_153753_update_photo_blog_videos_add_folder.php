<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePhotoBlogVideosAddFolder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->integer('folder_id')->after('active')->nullable();
        });
        Schema::table('blogs', function (Blueprint $table) {
            $table->integer('folder_id')->after('active')->nullable();
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->integer('folder_id')->after('active')->nullable();
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
            $table->dropColumn('folder_id');
        });
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('folder_id');
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('folder_id');
        });
    }
}
