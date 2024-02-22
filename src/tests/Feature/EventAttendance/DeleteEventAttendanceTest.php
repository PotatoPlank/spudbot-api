<?php

namespace EventAttendance;

use App\Models\EventAttendance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteEventAttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_event_attendance(): void
    {
        $user = User::factory()->create();
        $eventAttendance = EventAttendance::factory()->create();
        $response = $this->actingAs($user)->delete(
            route('events.attendance.destroy', [
                'event' => $eventAttendance->event()->first()->external_id,
                'eventAttendance' => $eventAttendance->external_id,
            ])
        );

        $response->assertStatus(200);
        $this->assertTrue($response['status']);
    }
}
