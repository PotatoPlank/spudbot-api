<?php

namespace Database\Factories;

use App\Models\Guild;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'guild_id' => Guild::factory(),
            'discord_channel_id' => (string)random_int(100000, 999999),
            'name' => $this->faker->word(),
            'type' => collect(['SESH', 'NATIVE'])->random(),
            'sesh_message_id' => collect([(string)random_int(100000, 999999)])->random(),
            'native_event_id' => collect([(string)random_int(100000, 999999)])->random(),
            'scheduled_at' => Carbon::now()->toIso8601String(),
        ];
    }
}
