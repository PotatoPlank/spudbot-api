<?php

namespace Tests\Feature\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateReminderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_reminder(): void
    {
        $user = User::factory()->create();
        $reminder = Reminder::factory()->create();
        $payload = [
            'mention_role' => $reminder->mention_role,
            'scheduled_at' => $reminder->scheduled_at,
            'repeats' => $reminder->repeats,
            'description' => $reminder->description,
        ];

        $route = route('reminders.update', ['reminder' => $reminder->external_id]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(200);
    }

    public function test_user_cannot_update_invalid_reminder(): void
    {
        $user = User::factory()->create();
        $reminder = Reminder::factory()->create();

        $payload = [
            'mention_role' => $reminder->mention_role,
            'scheduled_at' => $reminder->scheduled_at,
            'repeats' => $reminder->repeats,
            'description' => $reminder->description,
        ];
        $route = route('reminders.update', ['reminder' => fake()->uuid()]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(404);
    }
}
