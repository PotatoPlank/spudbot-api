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
   Route::apiResource('guilds', GuildController::class);
   Route::apiResource('channels', ChannelController::class);
   Route::apiResource('directories', DirectoryController::class);
   Route::apiResource('events', EventController::class);
   Route::apiResource('event/{externalId}/attendance', EventAttendanceController::class);
   Route::apiResource('members', MemberController::class);
   Route::apiResource('reminders', ReminderController::class);
   Route::apiResource('threads', ThreadController::class);


   Route::get('leaderboard/comments', [LeaderboardController::class, 'comments']);
});
