<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\EventAttendanceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GuildController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ThreadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('auth', [AuthController::class, 'is']);

Route::post('auth', [AuthController::class, 'attempt']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function (){
   Route::apiResource('guilds', GuildController::class)->parameters([
       'guilds' => 'guild:external_id',
   ]);
   Route::apiResource('channels', ChannelController::class)->parameters([
       'channels' => 'channel:external_id',
   ]);
   Route::apiResource('directories', DirectoryController::class)->parameters([
       'directories' => 'directory:external_id',
   ]);
   Route::apiResource('events', EventController::class)->parameters([
       'events' => 'event:external_id',
   ]);
   Route::apiResource('event/{externalId}/attendance', EventAttendanceController::class)->parameters([
       'eventAttendance' => 'eventAttendance:external_id',
   ]);
   Route::apiResource('members', MemberController::class)->parameters([
       'members' => 'member:external_id',
   ]);
   Route::apiResource('reminders', ReminderController::class)->parameters([
       'reminders' => 'reminder:external_id',
   ]);
   Route::apiResource('threads', ThreadController::class)->parameters([
       'threads' => 'thread:external_id',
   ]);


   Route::get('leaderboard/comments', [LeaderboardController::class, 'comments']);
});
