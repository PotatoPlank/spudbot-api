<?php

namespace Tests\Feature\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetReminderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_reminders(): void
    {
        $route = route('reminders.index');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);
    }

    public function test_user_can_see_reminders(): void
    {
        $route = route('reminders.index');
        $user = User::factory()->create();
        Reminder::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);

        $this->assertTrue($response['status']);
        $this->assertNotCount(0, $response['data']);
    }

    public function test_user_can_search_reminder_by_guild(): void
    {
        $user = User::factory()->create();
        $reminder = Reminder::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('reminders.index', ['guild' => $reminder->guild->external_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['description'], $reminder->description);
    }

    public function test_user_can_search_reminder_by_channel(): void
    {
        $user = User::factory()->create();
        $reminder = Reminder::factory()->create();
        $route = route('reminders.index', [
            'channel' => $reminder->channel->external_id,
        ]);

        $response = $this->actingAs($user)
            ->get($route);
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['description'], $reminder->description);
    }

    public function test_user_can_get_reminder(): void
    {
        $user = User::factory()->create();
        $reminder = Reminder::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('reminders.show', ['reminder' => $reminder->external_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['description'], $reminder->description);
    }
}
