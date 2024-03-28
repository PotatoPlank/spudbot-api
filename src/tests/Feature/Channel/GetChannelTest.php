<?php

namespace Tests\Feature\Channel;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetChannelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_channels(): void
    {
        $route = route('channels.index');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);
    }

    public function test_user_can_see_channels(): void
    {
        $route = route('channels.index');
        $user = User::factory()->create();
        Channel::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);

        $this->assertNotCount(0, $response['data']);
    }

    public function test_user_can_search_channel_by_discord_id(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('channels.index', ['discord_id' => $channel->discord_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['discord_id'], $channel->discord_id);
    }

    public function test_user_can_search_channel_by_guild(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('channels.index', ['guild' => $channel->guild->external_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['guild']['external_id'], $channel->guild->external_id);
    }

    public function test_user_can_get_channel(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('channels.show', ['channel' => $channel->external_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data']['discord_id'], $channel->discord_id);
    }
}
