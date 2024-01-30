<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Guild;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'discord_id' => random_int(1000000, 9999999),
            'guild_id' => Guild::factory(),
            'channel_id' => Channel::factory(),
            'tag' => $this->faker->words(3, true),
        ];
    }
}
