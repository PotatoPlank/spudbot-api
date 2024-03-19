<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guild;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fields = $request->validate([
            'guild' => ['uuid', 'exists:App\Models\Guild,external_id',],
            'channel' => ['string',],
            'native_id' => ['string',],
            'sesh_id' => ['string',],
            'guild_discord_id' => 'string',
        ]);

        $events = Event::query();
        if (isset($fields['guild'])) {
            $events->whereGuildId(Guild::whereExternalId($fields['guild'])->first()?->id);
        }
        if (isset($fields['channel'])) {
            $events->whereDiscordChannelId($fields['channel']);
        }
        if (isset($fields['native_id'])) {
            $events->whereNativeEventId($fields['native_id']);
        }
        if (isset($fields['sesh_id'])) {
            $events->whereSeshMessageId($fields['sesh_id']);
        }
        if (isset($fields['guild_discord_id'])) {
            $events->whereGuildId(Guild::whereDiscordId($fields['guild_discord_id'])->first()?->id);
        }
        return [
            'status' => true,
            'data' => $events->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'guild' => ['required', 'uuid', 'exists:App\Models\Guild,external_id'],
            'discord_channel_id' => ['nullable', 'string'],
            'name' => ['string', 'required'],
            'type' => [Rule::in(['SESH', 'NATIVE'], 'required')],
            'sesh_id' => ['nullable', 'string',],
            'native_id' => ['nullable', 'string',],
            'scheduled_at' => ['date_format:Y-m-d\TH:i:sP', 'required',],
        ]);

        $event = new Event();
        $event->guild()->associate(Guild::whereExternalId($fields['guild'])->first());
        $event->discord_channel_id = $fields['discord_channel_id'];
        $event->name = $fields['name'];
        $event->type = $fields['type'];
        $event->sesh_message_id = $fields['sesh_id'];
        $event->native_event_id = $fields['native_id'];
        $event->scheduled_at = $fields['scheduled_at'];
        $event->save();

        return [
            'status' => true,
            'data' => $event,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return $event;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $fields = $request->validate([
            'discord_channel_id' => ['nullable', 'string',],
            'name' => ['string', 'required'],
            'scheduled_at' => ['date_format:Y-m-d\TH:i:sP', 'required',],
        ]);

        $event->fill($fields);
        $event->save();


        return [
            'status' => true,
            'data' => $event,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return [
            'status' => true,
        ];
    }
}
