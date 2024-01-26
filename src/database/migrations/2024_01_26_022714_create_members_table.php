<?php

use App\Models\Guild;
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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->uuid('external_id');
            $table->string('discord_id');
            $table->foreignIdFor(Guild::class);
            $table->integer('total_comments')->default(0);
            $table->string('username');
            $table->foreignIdFor(Member::class, 'verified_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
