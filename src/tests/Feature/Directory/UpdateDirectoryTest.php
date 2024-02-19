<?php

namespace Tests\Feature\Directory;

use App\Models\Directory;
use App\Models\Guild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_update_directory(): void
    {
        Guild::factory()->create();
        $user = User::factory()->create();
        $directory = Directory::factory()->create();
        $payload = [
            'embed_id' => $directory->embed_id,
        ];

        $route = route('directories.update', ['directory' => $directory->external_id]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(302);
    }

    public function test_user_cannot_update_invalid_thread(): void
    {
        $user = User::factory()->create();
        $directory = Directory::factory()->create();

        $payload = [
            'embed_id' => $directory->embed_id,
        ];
        $route = route('directories.update', ['directory' => fake()->uuid()]);
        $response = $this->actingAs($user)->put($route, $payload);

        $response->assertStatus(404);
    }
}
