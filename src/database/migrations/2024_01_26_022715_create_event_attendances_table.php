<?php

use App\Models\Event;
use App\Models\Member;
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
        Schema::create('event_attendances', function (Blueprint $table) {
            $table->id();
            $table->uuid('external_id');
            $table->foreignIdFor(Event::class);
            $table->foreignIdFor(Member::class);
            $table->text('status')->nullable();
            $table->boolean('no_show')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_attendances');
    }
};
