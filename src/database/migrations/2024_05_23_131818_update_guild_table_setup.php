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
        Schema::table('guilds', function (Blueprint $table) {
            $table->string('channel_public_log_id')->nullable();
            $table->string('channel_thread_public_log_id')->nullable();
            $table->string('channel_mod_alert_id')->nullable();
            $table->string('channel_thread_mod_alert_id')->nullable();
            $table->string('channel_introduction_id')->nullable();
            $table->string('channel_thread_introduction_id')->nullable();
            $table->string('channel_marketplace_id')->nullable();
            $table->string('channel_thread_marketplace_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guilds', function (Blueprint $table) {
            $table->removeColumn('channel_public_log_id');
            $table->removeColumn('channel_thread_public_log_id');
            $table->removeColumn('channel_mod_alert_id');
            $table->removeColumn('channel_thread_mod_alert_id');
            $table->removeColumn('channel_introduction_id');
            $table->removeColumn('channel_thread_introduction_id');
            $table->removeColumn('channel_marketplace_id');
            $table->removeColumn('channel_thread_marketplace_id');
        });
    }
};
