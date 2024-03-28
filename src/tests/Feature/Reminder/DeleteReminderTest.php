<?php

namespace Tests\Feature\Reminder;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteReminderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_reminder(): void
    {
        $user = User::factory()->create();
        $reminder = Reminder::factory()->create();
        $response = $this->actingAs($user)->delete(
            route('reminders.destroy', ['reminder' => $reminder->external_id])
        );

        $response->assertStatus(204);
    }
}
