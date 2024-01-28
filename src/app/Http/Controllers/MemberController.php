<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\Member;
use Illuminate\Http\Request;

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
        ]);
        $members = Member::query();
        if(isset($fields['username'])){
            $members->whereUsername($fields['username']);
        }
        if(isset($fields['discord_id'])){
            $members->whereDiscordId($fields['discord_id']);
        }
        return [
            'status' => true,
            'data' => $members->get(),
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'discord_id' => ['required','unique:App\Models\Member,discord_id'],
            'guild' => ['uuid', 'required','exists:App\Models\Guild,external_id'],
            'total_comments' => ['integer','min:0'],
            'username' => ['string', 'required'],
            'verified_by_member' => ['uuid','exists:App\Models\Member,external_id'],
        ]);

        $member = new Member();
        $member->fill($fields);
        $member->guild()
            ->associate(Guild::whereExternalId($fields['guild'])->first());
        if(isset($fields['verified_by_member'])){
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $fields = $request->validate([
            'total_comments' => ['integer','min:0'],
            'username' => ['string',],
            'verified_by_member' => ['uuid','exists:App\Models\Member,external_id'],
            'increment_comments' => ['bool','prohibited_unless:total_comments,null'],
        ]);
        $member->fill($fields);
        if(isset($fields['verified_by_member'])){
            $member->verifiedBy()->associate(Member::whereExternalId($fields['verified_by_member'])->first());
        }
        if(isset($fields['increment_comments'])){
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
