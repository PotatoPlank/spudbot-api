<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\Member;
use Illuminate\Http\Request;

class EventAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Event $event)
    {
        $attendances = $event->eventAttendances();

        return [
            'status' => true,
            'data' => $attendances->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $fields = $request->validate([
            'member' => ['required', 'uuid', 'exists:App\Models\Member,external_id'],
            'status' => ['string', 'required'],
            'no_show' => ['boolean', 'required'],
        ]);

        $eventAttendance = new EventAttendance();
        $eventAttendance->event()->associate($event->first());
        $eventAttendance->member()->associate(Member::whereExternalId($fields['member'])->first());
        $eventAttendance->status = $fields['status'];
        $eventAttendance->no_show = $fields['no_show'];
        $eventAttendance->save();

        return [
            'status' => true,
            'data' => $eventAttendance,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, EventAttendance $eventAttendance)
    {
        return $eventAttendance;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event, EventAttendance $eventAttendance)
    {
        $fields = $request->validate([
            'status' => ['string',],
            'no_show' => ['boolean',],
        ]);

        $eventAttendance->fill($fields);
        $eventAttendance->save();


        return [
            'status' => true,
            'data' => $eventAttendance,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, EventAttendance $eventAttendance)
    {
        $eventAttendance->delete();

        return [
            'status' => true,
        ];
    }
}
