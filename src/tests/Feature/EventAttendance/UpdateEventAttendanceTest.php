<?php

namespace EventAttendance;

use App\Models\EventAttendance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateEventAttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_event_attendance(): void
    {
        $user = User::factory()->create();
        $attendance = EventAttendance::factory()->create();
        $payload = [
            'status' => 'yes',
            'no_show' => false,
        ];

        $route = route('events.attendance.update', [
            'event' => $attendance->event->external_id,
            'eventAttendance' => $attendance->external_id,
        ]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(200);
    }

    public function test_user_cannot_update_invalid_event_attendance(): void
    {
        $user = User::factory()->create();
        $attendance = EventAttendance::factory()->create();

        $payload = [
            'status' => 'yes',
            'no_show' => 'yes',
        ];
        $route = route('events.attendance.update', [
            'event' => $attendance->event->external_id,
            'eventAttendance' => fake()->uuid,
        ]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(404);
    }
}
