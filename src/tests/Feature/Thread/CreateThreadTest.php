<?php

namespace Tests\Feature\Thread;

use App\Models\Channel;
use App\Models\Guild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validThreadData
     * @param $discordId
     * @param $tag
     * @return void
     */
    public function test_user_can_create_thread($discordId, $tag): void
    {
        $user = User::factory()->create();

        $route = route('threads.store');
        $payload = [
            'discord_id' => $discordId,
            'guild' => Guild::factory()->create()->external_id,
            'channel' => Channel::factory()->create()->external_id,
            'tag' => $tag,
        ];
        $response = $this->actingAs($user)->post($route, $payload);

        $response->assertStatus(201);
    }

    /**
     * @dataProvider invalidThreadData
     * @param $discordId
     * @param $createGuild
     * @param $createChannel
     * @param $tag
     * @return void
     */
    public function test_user_cannot_create_invalid_thread($discordId, $createGuild, $createChannel, $tag): void
    {
        $user = User::factory()->create();

        $route = route('threads.store');
        $response = $this->actingAs($user)->post($route, [
            'discord_id' => $discordId,
            'guild' => $createGuild ? Guild::factory()->create()->external_id : null,
            'channel' => $createChannel ? Channel::factory()->create()->external_id : null,
            'tag' => $tag,
        ]);

        $response->assertStatus(302);
    }

    public static function validThreadData(): array
    {
        return [
            [
                'discord_id' => random_int(1000000, 9999999),
                'tag' => fake()->words(3, true),
            ],
            [
                'discord_id' => random_int(1000000, 9999999),
                'tag' => null,
            ],
        ];
    }

    public static function invalidThreadData(): array
    {
        return [
            [
                'discord_id' => null,
                'guild' => true,
                'channel' => true,
                'tag' => fake()->words(3, true),
            ],
            [
                'discord_id' => random_int(1000000, 9999999),
                'guild' => null,
                'channel' => true,
                'tag' => fake()->words(3, true),
            ],
            [
                'discord_id' => random_int(1000000, 9999999),
                'guild' => true,
                'channel' => null,
                'tag' => fake()->words(3, true),
            ],
        ];
    }
}
