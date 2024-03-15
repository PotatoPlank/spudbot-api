<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        if (User::whereName('Potato')->exists()) {
            return;
        }

        $user = new User();
        $user->password = Hash::make('password');
        $user->name = 'Potato';
        $user->email = 'pt@pt.com';
        $user->email_verified_at = Carbon::now();
        $user->save();
    }
}
