<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\EventCreateRequest;
use App\Http\Requests\Event\EventRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Guild;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EventRequest $request)
    {
        $events = Event::with(['guild']);
        if ($request->has('guild')) {
            $events->whereGuildId(Guild::whereExternalId($request->validated('guild'))->first()->id);
        }
        if ($request->has('channel')) {
            $events->whereDiscordChannelId($request->validated('channel'));
        }
        if ($request->has('native_id')) {
            $events->whereNativeEventId($request->validated('native_id'));
        }
        if ($request->has('sesh_id')) {
            $events->whereSeshMessageId($request->validated('sesh_id'));
        }
        if ($request->has('guild_discord_id')) {
            $events->whereGuildId(Guild::whereDiscordId($request->validated('guild_discord_id'))->first()?->id);
        }
        return EventResource::collection($events->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventCreateRequest $request)
    {
        $event = new Event();
        $event->guild()->associate(Guild::whereExternalId($request->validated('guild'))->first());
        $event->discord_channel_id = $request->validated('discord_channel_id');
        $event->name = $request->validated('name');
        $event->type = $request->validated('type');
        $event->sesh_message_id = $request->validated('sesh_id');
        $event->native_event_id = $request->validated('native_id');
        $event->scheduled_at = $request->validated('scheduled_at');
        $event->save();

        return new EventResource($event->load(['guild']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return new EventResource($event->load(['guild']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, Event $event)
    {
        $event->fill($request->validated());
        $event->save();


        return new EventResource($event->load(['guild']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response(status: 204);
    }
}
