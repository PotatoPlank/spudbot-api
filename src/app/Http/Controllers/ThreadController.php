<?php

namespace App\Http\Controllers;

use App\Http\Requests\Thread\ThreadCreateRequest;
use App\Http\Requests\Thread\ThreadRequest;
use App\Http\Resources\ThreadResource;
use App\Models\Channel;
use App\Models\Guild;
use App\Models\Thread;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ThreadRequest $request)
    {
        $threads = Thread::with(['guild', 'channel']);
        if ($request->has('discord_id')) {
            $threads->whereDiscordId($request->validated('discord_id'));
        }
        if ($request->has('guild')) {
            $threads->whereGuildId(Guild::whereExternalId($request->validated('guild'))->first()?->id);
        }
        return ThreadResource::collection($threads->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ThreadCreateRequest $request)
    {
        $thread = new Thread();
        $thread->discord_id = $request->validated('discord_id');
        $thread->guild()->associate(Guild::whereExternalId($request->validated('guild'))->first());
        $thread->channel()->associate(Channel::whereExternalId($request->validated('channel'))->first());
        $thread->tag = $request->validated('tag') ?? '';
        $thread->save();

        return new ThreadResource($thread->load(['guild', 'channel']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Thread $thread)
    {
        return new ThreadResource($thread->load(['guild', 'channel']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ThreadRequest $request, Thread $thread)
    {
        $thread->tag = $request->validated('tag') ?? '';
        $thread->save();

        return new ThreadResource($thread->load(['guild', 'channel']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread)
    {
        $thread->delete();

        return response(status: 204);
    }
}
