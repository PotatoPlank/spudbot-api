<?php

namespace Tests\Feature\Member;

use App\Models\Guild;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateMemberTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validMemberData
     * @param $discordId
     * @param $totalComments
     * @param $username
     * @param $verifiedByMember
     * @return void
     */
    public function test_user_can_create_member($discordId, $totalComments, $username, $verifiedByMember): void
    {
        $user = User::factory()->create();
        $guild = Guild::factory()->create();

        $route = route('members.store');
        $payload = [
            'discord_id' => $discordId,
            'total_comments' => $totalComments,
            'username' => $username,
            'guild' => $guild->external_id,
        ];
        if (isset($verifiedByMember)) {
            $payload['verified_by_member'] = Member::factory()->create()->external_id;
        }
        $response = $this->actingAs($user)->post($route, $payload);

        $response->assertStatus(201);
    }

    /**
     * @dataProvider invalidMemberData
     * @param $discordId
     * @param $totalComments
     * @param $username
     * @return void
     */
    public function test_user_cannot_create_invalid_user($discordId, $totalComments, $username): void
    {
        $user = User::factory()->create();
        $guild = Guild::factory()->create();

        $route = route('members.store');
        $response = $this->actingAs($user)->post($route, [
            'discord_id' => $discordId,
            'total_comments' => $totalComments,
            'username' => $username,
            'guild' => $guild->external_id,
        ]);

        $response->assertStatus(302);
    }

    public static function validMemberData(): array
    {
        return [
            [
                'discord_id' => random_int(10000000, 99999999),
                'total_comments' => random_int(0, 1000),
                'username' => fake()->userName,
                'verified_by_member' => null,
            ],
            [
                'discord_id' => random_int(10000000, 99999999),
                'total_comments' => null,
                'username' => fake()->userName,
                'verified_by_member' => null,
            ],
            [
                'discord_id' => random_int(10000000, 99999999),
                'total_comments' => null,
                'username' => fake()->userName,
                'verified_by_member' => true,
            ],
        ];
    }

    public static function invalidMemberData(): array
    {
        return [
            [
                'discord_id' => null,
                'total_comments' => random_int(0, 1000),
                'username' => fake()->userName,
            ],
            [
                'discord_id' => random_int(10000000, 99999999),
                'total_comments' => -1,
                'username' => fake()->userName,
            ],
            [
                'discord_id' => random_int(10000000, 99999999),
                'total_comments' => -1,
                'username' => null,
            ],
        ];
    }
}
