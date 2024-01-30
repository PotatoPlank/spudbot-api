<?php

namespace Tests\Feature\Guild;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateGuildTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validGuildData
     * @throws \Random\RandomException
     */
    public function test_user_can_create_guild($discordId, $channelAnnounceId, $channelThreadAnnounceId): void
    {
        $user = User::factory()->create();
        $route = route('guilds.store');
        $payload = [
            'discord_id' => $discordId,
            'channel_announce_id' => $channelAnnounceId,
            'channel_thread_announce_id' => $channelThreadAnnounceId,
        ];
        $response = $this->actingAs($user)->post($route, $payload);

        $response->assertStatus(200);
    }

    /**
     * @dataProvider validGuildData
     */
    public function test_guest_cannot_create_guilds($discordId, $channelAnnounceId, $channelThreadAnnounceId): void
    {
        $route = route('guilds.store');
        $payload = [
            'discord_id' => $discordId,
            'channel_announce_id' => $channelAnnounceId,
            'channel_thread_announce_id' => $channelThreadAnnounceId,
        ];
        $response = $this->get($route, $payload);

        $response->assertStatus(302);
    }

    /**
     * @dataProvider invalidGuildData
     */
    public function test_user_cannot_create_invalid_guild(
        $discordId,
        $channelAnnounceId,
        $channelThreadAnnounceId
    ): void {
        $user = User::factory()->create();
        $route = route('guilds.store');
        $payload = [
            'discord_id' => $discordId,
            'channel_announce_id' => $channelAnnounceId,
            'channel_thread_announce_id' => $channelThreadAnnounceId,
        ];
        $response = $this->actingAs($user)->post($route, $payload);

        $response->assertStatus(302);
    }

    public static function validGuildData(): array
    {
        return [
            [
                'discord_id' => random_int(10000000, 99999999),
                'channel_announce_id' => null,
                'channel_thread_announce_id' => null,
            ],
            [
                'discord_id' => random_int(10000000, 99999999),
                'channel_announce_id' => random_int(10000000, 99999999),
                'channel_thread_announce_id' => null,
            ],
            [
                'discord_id' => random_int(10000000, 99999999),
                'channel_announce_id' => random_int(10000000, 99999999),
                'channel_thread_announce_id' => random_int(10000000, 99999999),
            ]
        ];
    }

    public static function invalidGuildData(): array
    {
        return [
            [
                'discord_id' => null,
                'channel_announce_id' => null,
                'channel_thread_announce_id' => null,
            ],
        ];
    }
}
