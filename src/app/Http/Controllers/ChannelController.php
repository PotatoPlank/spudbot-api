<?php

namespace App\Http\Controllers;

use App\Http\Requests\Channel\ChannelCreateRequest;
use App\Http\Requests\Channel\ChannelRequest;
use App\Http\Resources\ChannelResource;
use App\Models\Channel;
use App\Models\Guild;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ChannelRequest $request)
    {
        $channels = Channel::with('guild');
        if ($request->has('discord_id')) {
            $channels->whereDiscordId($request->validated('discord_id'));
        }
        if ($request->has('guild')) {
            $channels->whereGuildId(Guild::whereExternalId($request->validated('guild'))->first()?->id);
        }
        return ChannelResource::collection($channels->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChannelCreateRequest $request)
    {
        $channel = new Channel();
        $channel->discord_id = $request->validated('discord_id');
        $channel->guild()->associate(Guild::whereExternalId($request->validated('guild'))->first());
        $channel->save();


        return new ChannelResource($channel->load('guild'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Channel $channel)
    {
        return new ChannelResource($channel->load('guild'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChannelRequest $request, Channel $channel)
    {
        if ($request->has('discord_id')) {
            $channel->discord_id = $request->validated('discord_id');
        }
        if ($request->has('guild')) {
            $channel->guild()->associate(Guild::whereExternalId($request->validated('guild'))->first());
        }


        $channel->save();


        return new ChannelResource($channel->load('guild'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Channel $channel)
    {
        $channel->delete();

        return response(status: 204);
    }
}
