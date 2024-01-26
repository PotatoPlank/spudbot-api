<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Guild;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        if(User::whereName('Potato')->exists()){
            return;
        }
        $guild = new Guild();
        $guild->discord_id = 123275987342;
        $guild->channel_announce_id = null;
        $guild->channel_thread_announce_id = null;
        $guild->save();

        $member = new Member();
        $member->discord_id = 35905803948;
        $member->guild_id = 1;
        $member->total_comments = 10;
        $member->username = 'potato';
        $member->verified_by = null;
        $member->save();



        $user = new User();
        $user->password = Hash::make('password');
        $user->name = 'Potato';
        $user->email = 'pt@pt.com';
        $user->email_verified_at = Carbon::now();
        $user->save();
    }
}
