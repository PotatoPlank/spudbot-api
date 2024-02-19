<?php

namespace Tests\Feature\Directory;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateDirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_directory(): void
    {
        $user = User::factory()->create();

        $route = route('directories.store');
        $payload = [
            'embed_id' => (string)random_int(1000000, 9999999),
            'directory_channel' => Channel::factory()->create()->external_id,
            'forum_channel' => Channel::factory()->create()->external_id,
        ];
        $response = $this->actingAs($user)->post($route, $payload);

        $response->assertStatus(200);
    }

    /**
     * @dataProvider invalidDirectoryData
     * @param $embedId
     * @param $directoryId
     * @param $channelId
     * @return void
     */
    public function test_user_cannot_create_invalid_directory($embedId, $directoryId, $channelId): void
    {
        $user = User::factory()->create();

        $route = route('directories.store');
        $response = $this->actingAs($user)->post($route, [
            'embed_id' => $embedId,
            'directory_channel' => $directoryId ? Channel::factory()->create()->external_id : null,
            'forum_channel' => $channelId ? Channel::factory()->create()->external_id : null,
        ]);

        $response->assertStatus(302);
    }


    public static function invalidDirectoryData(): array
    {
        return [
            [
                'embed_id' => null,
                'directory_channel' => true,
                'forum_channel' => true,
            ],
            [
                'embed_id' => (string)random_int(1000000, 9999999),
                'directory_channel' => true,
                'forum_channel' => null,
            ],
            [
                'embed_id' => (string)random_int(1000000, 9999999),
                'directory_channel' => null,
                'forum_channel' => true,
            ],
        ];
    }
}
