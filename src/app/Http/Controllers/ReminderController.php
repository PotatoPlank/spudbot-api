<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Guild;
use App\Models\Reminder;
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
        ]);

        $reminders = Reminder::query();
        if (isset($fields['guild'])) {
            $reminders->whereGuildId(Guild::whereExternalId($fields['guild'])->first()->id);
        }
        if (isset($fields['channel'])) {
            $reminders->whereChannelId(Channel::whereExternalId($fields['channel'])->first()->id);
        }
        return [
            'status' => true,
            'data' => $reminders->get(),
        ];
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
            'mention_role' => ['string', 'nullable',],
            'scheduled_at' => ['date_format:Y-m-d\TH:i:sP', 'required',],
            'repeats' => ['string', 'nullable',],
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

        return [
            'status' => true,
            'data' => $reminder,
        ];
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
            'mention_role' => ['string',],
            'scheduled_at' => ['date_format:Y-m-d\TH:i:sP',],
            'repeats' => ['string',],
            'description' => ['string',],
        ]);

        $reminder->fill($fields);


        $reminder->save();


        return [
            'status' => true,
            'data' => $reminder,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reminder $reminder)
    {
        $reminder->delete();

        return [
            'status' => true,
        ];
    }
}
