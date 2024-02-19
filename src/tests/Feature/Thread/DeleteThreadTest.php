<?php

namespace Tests\Feature\Thread;

use App\Models\Guild;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteThreadTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_thread(): void
    {
        Guild::factory()->create();
        $user = User::factory()->create();
        $thread = Thread::factory()->create();
        $response = $this->actingAs($user)->delete(route('threads.destroy', ['thread' => $thread->external_id]));

        $response->assertStatus(200);
        $this->assertTrue($response['status']);
    }
}
