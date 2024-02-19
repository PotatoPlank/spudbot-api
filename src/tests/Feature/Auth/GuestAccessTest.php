<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class GuestAccessTest extends TestCase
{
    /**
     * @dataProvider protectedGetRoutesData
     */
    public function test_guest_cannot_get_protected_routes(string $routeName): void
    {
        $response = $this->get(route($routeName));

        $response->assertStatus(302);
    }

    public static function protectedGetRoutesData(): array
    {
        return [
            ['channels.index'],
            ['directories.index'],
            ['guilds.index'],
            ['members.index'],
            ['threads.index'],
        ];
    }
}
