<?php

namespace Event;

use App\Models\Guild;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Random\RandomException;
use Tests\TestCase;

class CreateEventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validEventData
     * @param $eventType
     * @param $channelId
     * @param $seshMessageId
     * @param $nativeEventId
     * @return void
     */
    public function test_user_can_create_event($eventType, $channelId, $seshMessageId, $nativeEventId): void
    {
        $user = User::factory()->create();

        $route = route('events.store');
        $payload = [
            'guild' => Guild::factory()->create()->external_id,
            'discord_channel_id' => $channelId,
            'name' => fake()->words(3, true),
            'type' => $eventType,
            'sesh_id' => $seshMessageId,
            'native_id' => $nativeEventId,
            'scheduled_at' => Carbon::now()->toIso8601String(),
        ];
        $response = $this->actingAs($user)->post($route, $payload);

        $response->assertStatus(201);
    }

    /**
     * @dataProvider invalidEventData
     * @param $eventType
     * @param $seshMessageId
     * @param $nativeEventId
     * @return void
     * @throws RandomException
     */
    public function test_user_cannot_create_invalid_event($eventType, $seshMessageId, $nativeEventId): void
    {
        $user = User::factory()->create();

        $route = route('events.store');
        $response = $this->actingAs($user)->post($route, [
            'guild' => Guild::factory()->create()->external_id,
            'discord_channel_id' => random_int(1000000, 9999999),
            'name' => fake()->words(3, true),
            'type' => $eventType,
            'sesh_id' => $seshMessageId,
            'native_id' => $nativeEventId,
            'scheduled_at' => Carbon::now()->toIso8601String(),
        ]);

        $response->assertStatus(302);
    }


    public static function invalidEventData(): array
    {
        return [
            [
                'type' => null,
                'sesh_message_id' => (string)random_int(1000000, 9999999),
                'native_event_id' => null,
            ],
            [
                'type' => 'NATIVE EVENT',
                'sesh_message_id' => null,
                'native_event_id' => (string)random_int(1000000, 9999999),
            ],
        ];
    }

    public static function validEventData(): array
    {
        return [
            [
                'type' => 'SESH',
                'discord_channel_id' => (string)random_int(1000000, 9999999),
                'sesh_message_id' => (string)random_int(1000000, 9999999),
                'native_event_id' => null,
            ],
            [
                'type' => 'NATIVE',
                'discord_channel_id' => (string)random_int(1000000, 9999999),
                'sesh_message_id' => null,
                'native_event_id' => (string)random_int(1000000, 9999999),
            ],
            [
                'type' => 'SESH',
                'discord_channel_id' => null,
                'sesh_message_id' => (string)random_int(1000000, 9999999),
                'native_event_id' => (string)random_int(1000000, 9999999),
            ],
        ];
    }
}
