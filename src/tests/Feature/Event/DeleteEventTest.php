<?php

namespace Event;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $response = $this->actingAs($user)->delete(
            route('events.destroy', ['event' => $event->external_id])
        );

        $response->assertStatus(200);
        $this->assertTrue($response['status']);
    }
}
