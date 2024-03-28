<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReminderResource;
use App\Models\Channel;
use App\Models\Guild;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fields = $request->validate([
            'guild' => ['uuid', 'exists:App\Models\Guild,external_id',],
            'channel' => ['uuid', 'exists:App\Models\Channel,external_id',],
            'has_passed' => ['date_format:Y-m-d\TH:i:sP',],
            'scheduled_at' => ['date',],
        ]);

        $reminders = Reminder::with(['guild', 'channel']);
        if (isset($fields['guild'])) {
            $reminders->whereGuildId(Guild::whereExternalId($fields['guild'])->first()?->id);
        }
        if (isset($fields['channel'])) {
            $reminders->whereChannelId(Channel::whereExternalId($fields['channel'])->first()?->id);
        }
        if (isset($fields['has_passed'])) {
            $reminders->where('scheduled_at', '<=', Carbon::parse($fields['has_passed'])->toDateTimeString());
        }
        return ReminderResource::collection($reminders->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'guild' => ['required', 'uuid', 'exists:App\Models\Guild,external_id',],
            'channel' => ['required', 'uuid', 'exists:App\Models\Channel,external_id',],
            'description' => ['string', 'required',],
            'mention_role' => ['nullable', 'string',],
            'scheduled_at' => ['date_format:Y-m-d\TH:i:sP', 'required',],
            'repeats' => ['nullable', 'string',],
        ]);

        $reminder = new Reminder();
        $reminder->description = $fields['description'];
        $reminder->mention_role = $fields['mention_role'];
        $reminder->scheduled_at = $fields['scheduled_at'];
        $reminder->repeats = $fields['repeats'];
        $reminder->channel()->associate(Channel::whereExternalId($fields['channel'])->first());
        $reminder->guild()->associate(Guild::whereExternalId($fields['guild'])->first());
        $reminder->scheduled_at = $fields['scheduled_at'];
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
    public function update(Request $request, Reminder $reminder)
    {
        $fields = $request->validate([
            'mention_role' => ['nullable', 'string',],
            'scheduled_at' => ['date_format:Y-m-d\TH:i:sP',],
            'repeats' => ['string',],
            'description' => ['string',],
        ]);

        $reminder->fill($fields);


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
