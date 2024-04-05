<?php

namespace App\Http\Controllers;

use App\Http\Requests\Guild\GuildCreateRequest;
use App\Http\Requests\Guild\GuildRequest;
use App\Http\Resources\GuildResource;
use App\Models\Guild;

class GuildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GuildRequest $request)
    {
        $guilds = Guild::query();
        if ($request->has('discord_id')) {
            $guilds->whereDiscordId($request->validated('discord_id'));
        }
        return GuildResource::collection($guilds->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuildCreateRequest $request)
    {
        $guild = new Guild();
        $guild->fill($request->validated());

        $guild->save();

        return new GuildResource($guild);
    }

    /**
     * Display the specified resource.
     */
    public function show(Guild $guild)
    {
        return new GuildResource($guild);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuildRequest $request, Guild $guild)
    {
        if ($request->has('channel_announce_id')) {
            $guild->channel_announce_id = $request->validated('channel_announce_id');
        }
        if ($request->has('channel_thread_announce_id')) {
            $guild->channel_thread_announce_id = $request->validated('channel_thread_announce_id');
        }
        $guild->save();

        return new GuildResource($guild);
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
