<?php

namespace Tests\Feature\Channel;

use App\Models\Channel;
use App\Models\Guild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateChannelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validChannelFields
     */
    public function test_user_can_update_channel($discordId, $guild): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create();
        $payload = [
            'discord_id' => $discordId,
        ];
        if ($guild !== null) {
            $payload['guild'] = Guild::factory()->create()->external_id;
        }

        $route = route('channels.update', ['channel' => $channel->external_id]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(200);
    }

    public function test_user_cannot_update_invalid_channel(): void
    {
        $user = User::factory()->create();

        $payload = [
            'discord_id' => random_int(100000, 9999999)
        ];
        $route = route('channels.update', ['channel' => fake()->uuid()]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(404);
    }

    public static function validChannelFields(): array
    {
        return [
            [
                'discord_id' => random_int(100000, 9999999),
                'guild' => null,
            ],
            [
                'discord_id' => random_int(100000, 9999999),
                'guild' => true,
            ],
        ];
    }
}
