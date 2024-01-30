<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Guild;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fields = $request->validate([
            'discord_id' => 'string',
        ]);

        $channels = Channel::query();
        if (isset($fields['discord_id'])) {
            $channels->whereDiscordId($fields['discord_id']);
        }
        return [
            'status' => true,
            'data' => $channels->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'discord_id' => ['required', 'unique:App\Models\Member,discord_id'],
            'guild' => ['uuid', 'required', 'exists:App\Models\Guild,external_id'],
        ]);

        $channel = new Channel();
        $channel->discord_id = $fields['discord_id'];
        $channel->guild()->associate(Guild::whereExternalId($fields['guild'])->first());
        $channel->save();


        return [
            'status' => true,
            'data' => $channel,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Channel $channel)
    {
        return $channel;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Channel $channel)
    {
        $fields = $request->validate([
            'discord_id' => ['unique:App\Models\Member,discord_id'],
            'guild' => ['uuid', 'exists:App\Models\Guild,external_id'],
        ]);

        if (isset($fields['discord_id'])) {
            $channel->discord_id = $fields['discord_id'];
        }
        if (isset($fields['guild'])) {
            $channel->guild()->associate(Guild::whereExternalId($fields['guild'])->first());
        }


        $channel->save();


        return [
            'status' => true,
            'data' => $channel,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Channel $channel)
    {
        $channel->delete();

        return [
            'status' => true,
        ];
    }
}
