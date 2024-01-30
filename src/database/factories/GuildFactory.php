<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guild>
 */
class GuildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'discord_id' => random_int(10000000, 99999999),
            'channel_announce_id' => random_int(10000000, 99999999),
            'channel_thread_announce_id' => random_int(0, 1) ? random_int(10000000, 99999999) : null,
        ];
    }
}
