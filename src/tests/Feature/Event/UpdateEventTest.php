<?php

namespace Event;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $payload = [
            'discord_channel_id' => $event->discord_channel_id,
            'name' => $event->name,
            'scheduled_at' => $event->scheduled_at,
        ];

        $route = route('events.update', ['event' => $event->external_id]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(200);
    }

    public function test_user_cannot_update_invalid_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $payload = [
            'discord_channel_id' => $event->discord_channel_id,
            'name' => $event->name,
            'scheduled_at' => $event->scheduled_at,
        ];
        $route = route('events.update', ['event' => fake()->uuid()]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(404);
    }
}
