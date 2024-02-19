<?php

namespace Tests\Feature\Member;

use App\Models\Guild;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_members(): void
    {
        $route = route('members.index');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);
    }

    public function test_user_can_see_members(): void
    {
        $route = route('members.index');
        $user = User::factory()->create();
        Guild::factory()->create();
        Member::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);

        $this->assertTrue($response['status']);
        $this->assertNotCount(0, $response['data']);
    }

    public function test_user_can_search_member(): void
    {
        $user = User::factory()->create();
        Guild::factory()->create();
        $member = Member::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('members.index', ['discord_id' => $member->discord_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['discord_id'], $member->discord_id);
    }

    public function test_user_can_search_member_username(): void
    {
        $user = User::factory()->create();
        Guild::factory()->create();
        $member = Member::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('members.index', ['username' => $member->username]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['username'], $member->username);
    }

    public function test_user_can_get_member(): void
    {
        $user = User::factory()->create();
        Guild::factory()->create();
        $member = Member::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('members.show', ['member' => $member->external_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['discord_id'], $member->discord_id);
    }
}
