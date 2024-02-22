<?php

namespace Tests\Feature\Reminder;

use App\Models\Channel;
use App\Models\Guild;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateReminderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validReminderData
     * @param $mentionRole
     * @param $repeats
     * @return void
     */
    public function test_user_can_create_reminder($mentionRole, $repeats): void
    {
        $user = User::factory()->create();

        $route = route('reminders.store');
        $payload = [
            'guild' => Guild::factory()->create()->external_id,
            'channel' => Channel::factory()->create()->external_id,
            'description' => fake()->sentence(),
            'mention_role' => $mentionRole,
            'repeats' => $repeats,
            'scheduled_at' => Carbon::now()->toIso8601String(),
        ];
        $response = $this->actingAs($user)->post($route, $payload);

        $response->assertStatus(200);
    }

    /**
     * @dataProvider invalidReminderData
     * @param $eventType
     * @param $seshMessageId
     * @param $nativeEventId
     * @return void
     */
    public function test_user_cannot_create_invalid_reminder($eventType, $seshMessageId, $nativeEventId): void
    {
        $user = User::factory()->create();

        $route = route('reminders.store');
        $response = $this->actingAs($user)->post($route, [
            'guild' => Guild::factory()->create()->external_id,
            'channel' => Channel::factory()->create()->external_id,
            'description' => null,
            'mention_role' => 'Role',
            'repeats' => null,
            'scheduled_at' => null,
        ]);

        $response->assertStatus(302);
    }


    public static function invalidReminderData(): array
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

    public static function validReminderData(): array
    {
        return [
            [
                'mention_role' => 'Test',
                'repeats' => 'Test',
            ],
            [
                'mention_role' => null,
                'repeats' => null,
            ],
            [
                'mention_role' => 'Test',
                'repeats' => null,
            ],
        ];
    }
}
