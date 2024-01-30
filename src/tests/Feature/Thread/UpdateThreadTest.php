<?php

namespace Tests\Feature\Thread;

use App\Models\Channel;
use App\Models\Guild;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateThreadTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_update_thread(): void
    {
        Guild::factory()->create();
        Channel::factory()->create();
        $thread = Thread::factory()->create();
        $payload = [
            'tag' => fake()->words(3, true),
        ];

        $route = route('threads.update', ['thread' => $thread->external_id]);
        $response = $this->put($route, $payload);

        $response->assertStatus(302);
    }

    public function test_user_can_update_thread(): void
    {
        Guild::factory()->create();
        $user = User::factory()->create();
        Channel::factory()->create();
        $thread = Thread::factory()->create();
        $payload = [
            'tag' => fake()->words(3, true),
        ];

        $route = route('threads.update', ['thread' => $thread->external_id]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(200);
    }

    public function test_user_cannot_update_invalid_thread(): void
    {
        $user = User::factory()->create();

        $payload = [
            'tag' => fake()->words(3, true),
        ];
        $route = route('threads.update', ['thread' => fake()->uuid()]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(404);
    }
}
