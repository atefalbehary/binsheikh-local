<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('mobile_admin_user_notifications')) {
            return;
        }

        Schema::create('mobile_admin_user_notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('campaign_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('title');
            $table->string('title_ar')->nullable();
            $table->text('body')->nullable();
            $table->text('body_ar')->nullable();
            $table->string('channel', 40)->default('push');
            $table->string('target', 80)->default('all');
            $table->string('deep_link', 1500)->nullable();
            $table->boolean('is_read')->default(false)->index();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobile_admin_user_notifications');
    }
};
