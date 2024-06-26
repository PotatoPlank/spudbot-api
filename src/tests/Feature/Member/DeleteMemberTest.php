<?php

namespace Tests\Feature\Member;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_member(): void
    {
        $member = Member::factory()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete(route('members.destroy', ['member' => $member->external_id]));

        $response->assertStatus(204);
    }
}
