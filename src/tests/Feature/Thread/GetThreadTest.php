<?php

namespace Tests\Feature\Thread;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetThreadTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_threads(): void
    {
        $route = route('threads.index');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);
    }

    public function test_user_can_see_threads(): void
    {
        $route = route('threads.index');
        $user = User::factory()->create();
        Thread::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);

        $this->assertTrue($response['status']);
        $this->assertNotCount(0, $response['data']);
    }

    public function test_user_can_search_thread(): void
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('threads.index', ['discord_id' => $thread->discord_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['discord_id'], $thread->discord_id);
    }

    public function test_user_can_get_thread(): void
    {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('threads.show', ['thread' => $thread->external_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['discord_id'], $thread->discord_id);
    }
}
