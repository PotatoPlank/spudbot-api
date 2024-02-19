<?php

namespace Tests\Feature\Guild;

use App\Models\Guild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetGuildTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_guilds(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('guilds.index'));
        $response->assertStatus(200);
    }

    public function test_user_can_see_guilds(): void
    {
        $user = User::factory()->create();
        Guild::factory()->create();

        $response = $this->actingAs($user)->get(route('guilds.index'));
        $response->assertStatus(200);

        $this->assertTrue($response['status']);
        $this->assertNotCount(0, $response['data']);
    }

    public function test_user_can_search_guild(): void
    {
        $user = User::factory()->create();
        $guild = Guild::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('guilds.index', ['discord_id' => $guild->discord_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['discord_id'], $guild->discord_id);
    }

    public function test_user_can_get_guild(): void
    {
        $user = User::factory()->create();
        $guild = Guild::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('guilds.show', ['guild' => $guild->external_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['discord_id'], $guild->discord_id);
    }
}
