<?php

use App\Models\Guild;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid('external_id');
            $table->foreignIdFor(Guild::class);
            $table->string('discord_channel_id')->nullable();
            $table->longText('name');
            $table->mediumText('type');
            $table->text('sesh_message_id')->nullable();
            $table->text('native_event_id')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
