<?php

namespace EventAttendance;

use App\Models\EventAttendance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetEventAttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_event_attendance(): void
    {
        $user = User::factory()->create();
        $attendance = EventAttendance::factory()->create();
        $route = route('events.attendance.index', [
            'event' => $attendance->event->external_id,
        ]);

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);
    }

    public function test_user_can_see_event_attendance(): void
    {
        $user = User::factory()->create();
        $attendance = EventAttendance::factory()->create();
        $route = route('events.attendance.index', [
            $attendance->event->external_id,
        ]);

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);

        $this->assertNotCount(0, $response['data']);
    }

    public function test_user_can_get_event(): void
    {
        $user = User::factory()->create();
        $attendance = EventAttendance::factory()->create();
        $route = route('events.attendance.show', [
            'event' => $attendance->event->external_id,
            'eventAttendance' => $attendance->external_id,
        ]);

        $response = $this->actingAs($user)
            ->get($route);
        $response->assertStatus(200);

        $this->assertEquals($response['data']['status'], $attendance->status);
    }
}
