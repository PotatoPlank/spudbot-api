<?php

namespace App\Http\Controllers;

use App\Http\Requests\Member\MemberCreateRequest;
use App\Http\Requests\Member\MemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Guild;
use App\Models\Member;
use Illuminate\Support\Facades\Schema;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MemberRequest $request)
    {
        $members = Member::with(['verifiedBy', 'guild']);
        if ($request->has('username')) {
            $members->whereUsername($request->validated('username'));
        }
        if ($request->has('discord_id')) {
            $members->whereDiscordId($request->validated('discord_id'));
        }
        if ($request->has('guild')) {
            $members->whereGuildId(Guild::whereExternalId($request->validated('guild'))->first()?->id);
        }
        if ($request->has('guild_discord_id')) {
            $members->whereGuildId(Guild::whereDiscordId($request->validated('guild_discord_id'))->first()?->id);
        }
        $orderByColumn = 'username';
        $direction = 'asc';
        if ($request->has('sort') && Schema::hasColumn('members', $request->validated('sort'))) {
            $orderByColumn = $request->validated('sort');
            $direction = $request->validated('direction', 'asc');
        }
        return MemberResource::collection(
            $members->orderBy($orderByColumn, $direction)
                ->limit($request->validated('limit') ?? 50)
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MemberCreateRequest $request)
    {
        $member = new Member();

        $member->fill([
            ...$request->validated(),
            'total_comments' => $request->validated('total_comments') ?? 0,
        ]);
        $member->guild()
            ->associate(Guild::whereExternalId($request->validated('guild'))->first());
        if ($request->has('verified_by_member')) {
            $member->verifiedBy()
                ->associate(Member::whereExternalId($request->validated('verified_by_member'))->first());
        }
        $member->save();

        return new MemberResource($member->load(['verifiedBy', 'guild']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return new MemberResource($member->load(['verifiedBy', 'guild']));
    }

    public function attendance(Member $member)
    {
        return $member->eventAttendance()->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MemberRequest $request, Member $member)
    {
        $member->fill($request->validated());
        if ($request->has('verified_by_member')) {
            if ($member->external_id === $request->validated('verified_by_member')) {
                return response([
                    'status' => false,
                    'message' => 'A member cannot verify themselves.'
                ], 302);
            }
            $member->verifiedBy()->associate(
                Member::whereExternalId($request->validated('verified_by_member'))->first()
            );
        }
        if ($request->has('increment_comments')) {
            ++$member->total_comments;
        }
        $member->save();

        return new MemberResource($member->load(['verifiedBy', 'guild']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return response(status: 204);
    }
}
