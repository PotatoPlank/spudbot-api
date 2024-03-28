<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\Member;

class LeaderboardController extends Controller
{
    /**
     * Display comment leaderboard.
     */
    public function comments()
    {
        return MemberResource::collection(Member::limit(30)->orderBy('total_comments', 'desc')->get());
    }
}
