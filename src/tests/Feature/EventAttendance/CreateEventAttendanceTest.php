<?php

namespace EventAttendance;

use App\Models\Event;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateEventAttendanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validAttendanceData
     * @param $status
     * @param $noShow
     * @return void
     */
    public function test_user_can_create_event_attendance($status, $noShow): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $member = Member::factory()->create();

        $route = route('events.attendance.store', [
            'event' => $event->external_id,
        ]);

        $payload = [
            'member' => $member->external_id,
            'status' => $status,
            'no_show' => $noShow,
        ];
        $response = $this->actingAs($user)->post($route, $payload);

        $response->assertStatus(201);
    }

    /**
     * @dataProvider invalidAttendanceData
     * @param $status
     * @param $noShow
     * @return void
     */
    public function test_user_cannot_create_invalid_event_attendance($status, $noShow): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        $member = Member::factory()->create();

        $route = route('events.attendance.store', [
            'event' => $event->external_id,
        ]);
        $response = $this->actingAs($user)->post($route, [
            'member' => $member->external_id,
            'status' => $status,
            'no_show' => $noShow,
        ]);

        $response->assertStatus(302);
    }


    public static function invalidAttendanceData(): array
    {
        return [
            [
                'status' => null,
                'no_show' => fake()->boolean(),
            ],
        ];
    }

    public static function validAttendanceData(): array
    {
        return [
            [
                'status' => fake()->word(),
                'no_show' => fake()->boolean(),
            ],
        ];
    }
}
