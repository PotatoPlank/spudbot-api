<?php

use App\Models\Channel;
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
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->uuid('external_id');
            $table->longText('description');
            $table->string('mention_role')->nullable();
            $table->dateTime('scheduled_at');
            $table->string('repeats')->nullable();
            $table->foreignIdFor(Channel::class);
            $table->foreignIdFor(Guild::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
