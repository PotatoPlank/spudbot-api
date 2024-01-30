<?php

namespace Database\Factories;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Directory>
 */
class DirectoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'directory_channel_id' => Channel::factory(),
            'forum_channel_id' => Channel::factory(),
            'embed_id' => random_int(100000, 999999),
        ];
    }
}
