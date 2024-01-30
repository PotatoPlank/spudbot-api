<?php

namespace Tests\Feature\Directory;

use App\Models\Directory;
use App\Models\Guild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_directories(): void
    {
        $route = route('directories.index');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);
    }

    public function test_guest_cannot_get_directories(): void
    {
        $route = route('directories.index');
        $response = $this->get($route);

        $response->assertStatus(302);
    }

    public function test_user_can_see_directories(): void
    {
        $route = route('directories.index');
        $user = User::factory()->create();
        Guild::factory()->create();
        Directory::factory()->create();

        $response = $this->actingAs($user)->get($route);
        $response->assertStatus(200);

        $this->assertTrue($response['status']);
        $this->assertNotCount(0, $response['data']);
    }

    public function test_user_can_search_directory(): void
    {
        $user = User::factory()->create();
        Guild::factory()->create();
        $directory = Directory::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('directories.index', ['embed_id' => $directory->embed_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['data'][0]['embed_id'], $directory->embed_id);
    }

    public function test_user_can_get_directory(): void
    {
        $user = User::factory()->create();
        Guild::factory()->create();
        $directory = Directory::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('directories.show', ['directory' => $directory->external_id]));
        $response->assertStatus(200);

        $this->assertEquals($response['embed_id'], $directory->embed_id);
    }
}
