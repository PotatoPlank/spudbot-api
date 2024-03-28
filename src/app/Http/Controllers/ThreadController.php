<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThreadResource;
use App\Models\Channel;
use App\Models\Guild;
use App\Models\Thread;
use App\Rules\UniqueDiscordId;
use Illuminate\Http\Request;

class ThreadController extends Controller
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

        $threads = Thread::with(['guild', 'channel']);
        if (isset($fields['discord_id'])) {
            $threads->whereDiscordId($fields['discord_id']);
        }
        if (isset($fields['guild'])) {
            $threads->whereGuildId(Guild::whereExternalId($fields['guild'])->first()?->id);
        }
        return ThreadResource::collection($threads->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'discord_id' => ['required', new UniqueDiscordId(Thread::query()),],
            'guild' => ['required', 'uuid', 'exists:App\Models\Guild,external_id'],
            'channel' => ['required', 'uuid', 'exists:App\Models\Channel,external_id'],
            'tag' => ['nullable', 'string',],
        ]);

        $thread = new Thread();
        $thread->discord_id = $fields['discord_id'];
        $thread->guild()->associate(Guild::whereExternalId($fields['guild'])->first());
        $thread->channel()->associate(Channel::whereExternalId($fields['channel'])->first());
        $thread->tag = $fields['tag'] ?? '';
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
    public function update(Request $request, Thread $thread)
    {
        $fields = $request->validate([
            'tag' => ['nullable', 'string',],
        ]);

        $thread->tag = $fields['tag'] ?? '';
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
