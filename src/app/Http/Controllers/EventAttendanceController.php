<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventAttendance\EventAttendanceCreateRequest;
use App\Http\Requests\EventAttendance\EventAttendanceRequest;
use App\Http\Resources\EventAttendanceResource;
use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\Member;

class EventAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EventAttendanceRequest $request, Event $event)
    {
        $attendances = $event->eventAttendances()->with(['event', 'member']);

        if ($request->has('member')) {
            $attendances->whereMemberId(Member::whereExternalId($request->validated('member'))->first()?->id);
        }

        return EventAttendanceResource::collection($attendances->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventAttendanceCreateRequest $request, Event $event)
    {
        $eventAttendance = new EventAttendance();
        $eventAttendance->event()->associate($event);
        $eventAttendance->member()->associate(Member::whereExternalId($request->validated('member'))->first());
        $eventAttendance->status = $request->validated('status');
        $eventAttendance->no_show = $request->validated('no_show');
        $eventAttendance->save();

        return new EventAttendanceResource($eventAttendance->load(['event', 'member']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, EventAttendance $eventAttendance)
    {
        return new EventAttendanceResource($eventAttendance->load(['event', 'member']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventAttendanceRequest $request, Event $event, EventAttendance $eventAttendance)
    {
        $eventAttendance->fill($request->validated());
        $eventAttendance->save();


        return new EventAttendanceResource($eventAttendance->load(['event', 'member']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, EventAttendance $eventAttendance)
    {
        $eventAttendance->delete();

        return response(status: 204);
    }
}
