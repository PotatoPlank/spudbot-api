<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Rules\UniqueDiscordId;
use Illuminate\Http\Request;

class GuildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fields = $request->validate([
            'discord_id' => 'string',
        ]);
        $guilds = Guild::query();
        if (isset($fields['discord_id'])) {
            $guilds->whereDiscordId($fields['discord_id']);
        }
        return [
            'status' => true,
            'data' => $guilds->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'discord_id' => ['required', new UniqueDiscordId(Guild::query()),],
            'channel_announce_id' => [],
            'channel_thread_announce_id' => [],
        ]);
        $guild = new Guild();
        $guild->fill($fields);

        $guild->save();

        return [
            'status' => true,
            'data' => $guild,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Guild $guild)
    {
        return $guild;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guild $guild)
    {
        $fields = $request->validate([
            'channel_announce_id' => [],
            'channel_thread_announce_id' => [],
        ]);
        if (isset($fields['channel_announce_id'])) {
            $guild->channel_announce_id = $fields['channel_announce_id'];
        }
        if (isset($fields['channel_thread_announce_id'])) {
            $guild->channel_thread_announce_id = $fields['channel_thread_announce_id'];
        }
        $guild->save();

        return [
            'status' => true,
            'data' => $guild,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guild $guild)
    {
        //$guild->delete();

        return [
            'status' => false,
            'message' => 'Not currently possible to delete guilds',
        ];
    }
}
