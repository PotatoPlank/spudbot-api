<?php

namespace Database\Factories;

use App\Models\Guild;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
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
            'guild_id' => $this->faker->randomElement(Guild::pluck('id')),
            'total_comments' => random_int(0, 1000),
            'username' => $this->faker->userName(),
            'verified_by' => null,
        ];
    }

    public function verified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'verified_by' => Member::factory(),
            ];
        });
    }
}
