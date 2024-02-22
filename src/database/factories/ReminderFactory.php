<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Guild;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reminder>
 */
class ReminderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(),
            'mention_role' => fake()->word(),
            'scheduled_at' => Carbon::now()->toIso8601String(),
            'repeats' => fake()->word(),
            'channel_id' => Channel::factory(),
            'guild_id' => Guild::factory(),
        ];
    }
}
