<?php

namespace Tests\Feature\Directory;

use App\Models\Directory;
use App\Models\Guild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_directory(): void
    {
        Guild::factory()->create();
        $user = User::factory()->create();
        $directory = Directory::factory()->create();
        $response = $this->actingAs($user)->delete(
            route('directories.destroy', ['directory' => $directory->external_id])
        );

        $response->assertStatus(200);
        $this->assertTrue($response['status']);
    }

    public function test_guest_cannot_delete_directory(): void
    {
        Guild::factory()->create();
        $directory = Directory::factory()->create();
        $response = $this->delete(route('directories.destroy', ['directory' => $directory->external_id]));

        $response->assertStatus(302);
    }
}
