<?php

namespace Tests\Feature\Channel;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteChannelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_channel(): void
    {
        $user = User::factory()->create();
        $channel = Channel::factory()->create();
        $response = $this->actingAs($user)->delete(route('channels.destroy', ['channel' => $channel->external_id]));

        $response->assertStatus(200);
        $this->assertTrue($response['status']);
    }
}
