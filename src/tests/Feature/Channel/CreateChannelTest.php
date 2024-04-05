<?php

namespace Tests\Feature\Channel;

use App\Models\Guild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateChannelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validChannelData
     * @param $discordId
     * @return void
     */
    public function test_user_can_create_channel($discordId): void
    {
        $user = User::factory()->create();
        $guild = Guild::factory()->create();

        $route = route('channels.store');
        $payload = [
            'discord_id' => $discordId,
            'guild' => $guild->external_id,
        ];
        $response = $this->actingAs($user)->post($route, $payload);


        $response->assertStatus(201);
    }

    /**
     * @dataProvider invalidChannelData
     * @param $discordId
     * @param $guild
     * @return void
     */
    public function test_user_cannot_create_invalid_channel($discordId, $guild): void
    {
        $user = User::factory()->create();

        $route = route('channels.store');
        $response = $this->actingAs($user)->post($route, [
            'discord_id' => $discordId,
            'guild' => $guild,
        ]);

        $response->assertStatus(302);
    }

    public static function validChannelData(): array
    {
        return [
            [
                'discord_id' => random_int(10000000, 99999999),
            ],
        ];
    }

    public static function invalidChannelData(): array
    {
        return [
            [
                'discord_id' => null,
                'guild' => fake()->uuid,
            ],
            [
                'discord_id' => random_int(10000000, 99999999),
                'guild' => null,
            ],
        ];
    }
}
