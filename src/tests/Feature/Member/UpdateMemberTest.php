<?php

namespace Tests\Feature\Member;

use App\Models\Guild;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateMemberTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validMemberFields
     */
    public function test_guest_cannot_update_member($totalComments, $verifiedBy, $username, $incrementComments): void
    {
        Guild::factory()->create();
        $member = Member::factory()->create();
        $payload = [];
        if ($totalComments !== null) {
            $payload['total_comments'] = $totalComments;
        }
        if ($verifiedBy !== null) {
            $payload['verified_by_member'] = $verifiedBy;
        }
        if ($username !== null) {
            $payload['username'] = $username;
        }
        if ($incrementComments !== null) {
            $payload['increment_comments'] = $incrementComments;
        }

        $route = route('members.update', ['member' => $member->external_id]);
        $response = $this->put($route, $payload);

        $response->assertStatus(302);
    }

    /**
     * @dataProvider validMemberFields
     */
    public function test_user_can_update_member($totalComments, $verifiedBy, $username, $incrementComments): void
    {
        Guild::factory()->create();
        $user = User::factory()->create();
        $member = Member::factory()->create();
        $payload = [];
        if ($totalComments !== null) {
            $payload['total_comments'] = $totalComments;
        }
        if ($verifiedBy !== null) {
            $payload['verified_by_member'] = Member::factory()->verified()->create()->external_id;
        }
        if ($username !== null) {
            $payload['username'] = $username;
        }
        if ($incrementComments !== null) {
            $payload['increment_comments'] = $incrementComments;
        }

        $route = route('members.update', ['member' => $member->external_id]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(200);
    }

    /**
     * @dataProvider validMemberFields
     */
    public function test_user_cannot_update_invalid_member(
        $totalComments,
        $verifiedBy,
        $username,
        $incrementComments
    ): void {
        $user = User::factory()->create();

        $payload = [
            'username' => fake()->userName
        ];
        $route = route('members.update', ['member' => fake()->uuid()]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(404);
    }

    public function test_user_cannot_verify_self(): void
    {
        $user = User::factory()->create();
        Guild::factory()->create();
        $member = Member::factory()->create();

        $payload = [
            'verified_by_member' => $member->external_id,
        ];
        $route = route('members.update', ['member' => $member->external_id]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(302);
    }

    public function test_user_cannot_be_verified_twice(): void
    {
        $user = User::factory()->create();
        Guild::factory()->create();
        $member = Member::factory()->verified()->create();

        $payload = [
            'verified_by_member' => $member->external_id,
        ];
        $route = route('members.update', ['member' => $member->external_id]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(302);
    }

    public function test_unverified_user_cannot_verify(): void
    {
        $user = User::factory()->create();
        Guild::factory()->create();
        $member = Member::factory()->create();

        $payload = [
            'verified_by_member' => Member::factory()->create()->external_id,
        ];
        $route = route('members.update', ['member' => $member->external_id]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(302);
    }

    public function test_an_invalid_user_cannot_verify(): void
    {
        $user = User::factory()->create();
        Guild::factory()->create();
        $member = Member::factory()->create();

        $payload = [
            'verified_by_member' => fake()->uuid,
        ];
        $route = route('members.update', ['member' => $member->external_id]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(302);
    }

    public static function validMemberFields(): array
    {
        return [
            [
                'total_comments' => random_int(0, 100),
                'verified_by_member' => null,
                'username' => fake()->userName,
                'increment_comments' => null,
            ],
            [
                'total_comments' => null,
                'verified_by_member' => null,
                'username' => fake()->userName,
                'increment_comments' => true,
            ],
            [
                'total_comments' => null,
                'verified_by_member' => true,
                'username' => fake()->userName,
                'increment_comments' => null,
            ],
            [
                'total_comments' => null,
                'verified_by_member' => true,
                'username' => null,
                'increment_comments' => true,
            ],
        ];
    }
}
