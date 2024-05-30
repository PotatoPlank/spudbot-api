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
        Schema::table('marketplace', function (Blueprint $table) {
            $table->string('discord_id', 256)->after('external_id');
            $table->string('name', 256)->after('discord_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marketplace', function (Blueprint $table) {
            $table->removeColumn('name');
            $table->removeColumn('discord_id');
        });
    }
};
