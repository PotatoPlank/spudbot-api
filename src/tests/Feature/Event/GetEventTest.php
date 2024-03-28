<?php

namespace Event;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_events(): void
    {
        $route = route('events.index');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);
    }

    public function test_user_can_see_events(): void
    {
        $route = route('events.index');
        $user = User::factory()->create();
        Event::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);

        $this->assertNotCount(0, $response['data']);
    }

    public function test_user_can_search_event_by_guild(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('events.index', ['guild' => $event->guild->external_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['type'], $event->type);
    }

    public function test_user_can_search_event_by_channel(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('events.index', ['channel' => $event->discord_channel_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['type'], $event->type);
    }

    public function test_user_can_search_event_by_native_id(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('events.index', ['native_id' => $event->native_event_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['type'], $event->type);
    }

    public function test_user_can_search_event_by_sesh_id(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('events.index', ['sesh_id' => $event->sesh_message_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['type'], $event->type);
    }

    public function test_user_can_get_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('events.show', ['event' => $event->external_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data']['type'], $event->type);
    }
}
