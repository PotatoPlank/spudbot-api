<?php

namespace Tests\Feature\Guild;

use App\Models\Guild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteGuildTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_delete_guild(): void
    {
        $guild = Guild::factory()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete(route('guilds.destroy', ['guild' => $guild->external_id]));

        $response->assertStatus(200);
        $this->assertFalse($response['status']);
    }
}
