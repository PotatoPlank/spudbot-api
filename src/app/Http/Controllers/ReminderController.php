<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reminder\ReminderCreateRequest;
use App\Http\Requests\Reminder\ReminderRequest;
use App\Http\Resources\ReminderResource;
use App\Models\Channel;
use App\Models\Guild;
use App\Models\Reminder;
use Carbon\Carbon;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ReminderRequest $request)
    {
        $reminders = Reminder::with(['guild', 'channel']);
        if ($request->has('guild')) {
            $reminders->whereGuildId(Guild::whereExternalId($request->validated('guild'))->first()?->id);
        }
        if ($request->has('channel')) {
            $reminders->whereChannelId(Channel::whereExternalId($request->validated('channel'))->first()?->id);
        }
        if ($request->has('has_passed')) {
            $reminders->where(
                'scheduled_at',
                '<=',
                Carbon::parse($request->validated('has_passed'))->toDateTimeString()
            );
        }
        return ReminderResource::collection($reminders->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReminderCreateRequest $request)
    {
        $reminder = new Reminder();
        $reminder->description = $request->validated('description');
        $reminder->mention_role = $request->validated('mention_role');
        $reminder->scheduled_at = $request->validated('scheduled_at');
        $reminder->repeats = $request->validated('repeats');
        $reminder->channel()->associate(Channel::whereExternalId($request->validated('channel'))->first());
        $reminder->guild()->associate(Guild::whereExternalId($request->validated('guild'))->first());
        $reminder->scheduled_at = $request->validated('scheduled_at');
        $reminder->save();

        return new ReminderResource($reminder->load(['guild', 'channel']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Reminder $reminder)
    {
        return $reminder;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReminderRequest $request, Reminder $reminder)
    {
        $reminder->fill(
            $request->safe()->only(
                [
                    'mention_role',
                    'scheduled_at',
                    'repeats',
                    'description',
                ]
            )
        );


        $reminder->save();


        return new ReminderResource($reminder->load(['guild', 'channel']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reminder $reminder)
    {
        $reminder->delete();

        return response(status: 204);
    }
}
