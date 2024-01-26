<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\Member;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    /**
     * Display comment leaderboard.
     */
    public function comments()
    {
        return Member::limit(30)->orderBy('total_comments', 'desc')->get();
    }
}
