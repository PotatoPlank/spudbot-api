<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fields = $request->validate([
            'username' => 'string',
            'discord_id' => 'string',
            'guild' => ['uuid', 'exists:App\Models\Guild,external_id',],
            'guild_discord_id' => 'string',
            'sort' => ['string',],
            'direction' => ['string', Rule::in(['asc', 'desc'])],
            'limit' => ['numeric', 'min:1', 'max:50'],
        ]);
        $members = Member::query();
        if (isset($fields['username'])) {
            $members->whereUsername($fields['username']);
        }
        if (isset($fields['discord_id'])) {
            $members->whereDiscordId($fields['discord_id']);
        }
        if (isset($fields['guild'])) {
            $members->whereGuildId(Guild::whereExternalId($fields['guild'])->first()?->id);
        }
        if (isset($fields['guild_discord_id'])) {
            $members->whereGuildId(Guild::whereDiscordId($fields['guild_discord_id'])->first()?->id);
        }
        $orderByColumn = 'username';
        $direction = 'asc';
        if (isset($fields['sort']) && Schema::hasColumn('members', $fields['sort'])) {
            $orderByColumn = $fields['sort'];
            $direction = $fields['direction'] ?? 'asc';
        }
        return [
            'status' => true,
            'data' => $members
                ->orderBy($orderByColumn, $direction)
                ->limit($fields['limit'] ?? 50)
                ->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'discord_id' => ['required', 'unique:App\Models\Member,discord_id'],
            'guild' => ['uuid', 'required', 'exists:App\Models\Guild,external_id'],
            'total_comments' => ['numeric', 'nullable', 'min:0'],
            'username' => ['string', 'required'],
            'verified_by_member' => ['uuid', 'nullable', 'exists:App\Models\Member,external_id'],
        ]);

        if (!$fields['total_comments']) {
            $fields['total_comments'] = 0;
        }

        $member = new Member();
        $member->fill($fields);
        $member->guild()
            ->associate(Guild::whereExternalId($fields['guild'])->first());
        if (isset($fields['verified_by_member'])) {
            $member->verifiedBy()
                ->associate(Member::whereExternalId($fields['verified_by_member'])->first());
        }
        $member->save();

        return [
            'status' => true,
            'data' => $member,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return $member;
    }

    public function attendance(Member $member)
    {
        return $member->eventAttendance()->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $fields = $request->validate([
            'total_comments' => ['integer', 'min:0'],
            'username' => ['string',],
            'verified_by_member' => ['uuid', 'exists:App\Models\Member,external_id'],
            'increment_comments' => ['bool', 'prohibited_unless:total_comments,null'],
        ]);
        $member->fill($fields);
        if (isset($fields['verified_by_member'])) {
            if ($member->verifiedBy()->exists()) {
                return response([
                    'status' => false,
                    'message' => 'This member is already verified.'
                ], 302);
            }
            if ($member->external_id === $fields['verified_by_member']) {
                return response([
                    'status' => false,
                    'message' => 'A member cannot verify themselves.'
                ], 302);
            }
            $verifyingMember = Member::whereExternalId($fields['verified_by_member'])->first();
            if (!$verifyingMember->verifiedBy()->exists()) {
                return response([
                    'status' => false,
                    'message' => 'An unverified member cannot verify another member.'
                ], 302);
            }


            $member->verifiedBy()->associate(Member::whereExternalId($fields['verified_by_member'])->first());
        }
        if (isset($fields['increment_comments'])) {
            ++$member->total_comments;
        }
        $member->save();

        return [
            'status' => true,
            'data' => $member,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return [
            'status' => true,
        ];
    }
}
