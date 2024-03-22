<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Guild;
use App\Rules\UniqueDiscordId;
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
            'guild' => ['uuid', 'exists:App\Models\Guild,external_id',],
        ]);

        $channels = Channel::query();
        if (isset($fields['discord_id'])) {
            $channels->whereDiscordId($fields['discord_id']);
        }
        if (isset($fields['guild'])) {
            $channels->whereGuildId(Guild::whereExternalId($fields['guild'])->first()?->id);
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
            'discord_id' => ['required', new UniqueDiscordId(Channel::query()),],
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
            'discord_id' => ['string',],
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
