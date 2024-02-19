<?php

namespace Tests\Feature\Guild;

use App\Models\Guild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateGuildTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validGuildFields
     */
    public function test_user_can_update_guild($channelId, $threadId): void
    {
        $user = User::factory()->create();
        $guild = Guild::factory()->create();

        $payload = [
            'channel_announce_id' => $channelId,
            'channel_thread_announce_id' => $threadId,
        ];
        $route = route('guilds.update', ['guild' => $guild->external_id]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(200);
    }

    /**
     * @dataProvider validGuildFields
     */
    public function test_user_cannot_update_invalid_guild($channelId, $threadId): void
    {
        $user = User::factory()->create();

        $payload = [
            'channel_announce_id' => $channelId,
            'channel_thread_announce_id' => $threadId,
        ];
        $route = route('guilds.update', ['guild' => fake()->uuid()]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(404);
    }

    public static function validGuildFields(): array
    {
        return [
            [
                'channel_announce_id' => random_int(10000000, 99999999),
                'channel_thread_announce_id' => random_int(10000000, 99999999),
            ]
        ];
    }
}
