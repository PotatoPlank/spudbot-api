<?php

namespace Tests\Feature\Channel;

use App\Models\Channel;
use App\Models\Guild;
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
        Guild::factory()->create();
        Channel::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);

        $this->assertTrue($response['status']);
        $this->assertNotCount(0, $response['data']);
    }

    public function test_user_can_search_channel(): void
    {
        $user = User::factory()->create();
        Guild::factory()->create();
        $channel = Channel::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('channels.index', ['discord_id' => $channel->discord_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['discord_id'], $channel->discord_id);
    }

    public function test_user_can_get_channel(): void
    {
        $user = User::factory()->create();
        Guild::factory()->create();
        $channel = Channel::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('channels.show', ['channel' => $channel->external_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['discord_id'], $channel->discord_id);
    }
}
