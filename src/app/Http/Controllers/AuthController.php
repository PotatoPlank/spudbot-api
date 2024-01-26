<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Attempt authentication.
     */
    public function attempt(Request $request)
    {
        $credentials = $request->validate([
            'email' =>'required',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials)){
            Auth::user()->tokens()->delete();
            return [
                'success' => true,
                'token' => Auth::user()->createToken('api')->plainTextToken,
                'user' => auth('sanctum')->user(),
            ];
        }

        return [
            'success' => false,
        ];
    }

    /**
     * Check authentication status
     */
    public function is(Request $request)
    {
        return [
            'user' => auth('sanctum')->user(),
            'authenticated' => auth('sanctum')->check(),
        ];
    }
}
