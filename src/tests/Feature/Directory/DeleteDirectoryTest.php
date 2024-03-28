<?php

namespace Tests\Feature\Directory;

use App\Models\Directory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_directory(): void
    {
        $user = User::factory()->create();
        $directory = Directory::factory()->create();
        $response = $this->actingAs($user)->delete(
            route('directories.destroy', ['directory' => $directory->external_id])
        );

        $response->assertStatus(204);
    }
}
