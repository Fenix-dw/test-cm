<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request) : JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'message' => 'Invalid credentials, User unauthenticated'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = Auth::user()->createToken('token')->plainTextToken;

        $cookie = cookie('auth_token',$token,60*24);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ])->withCookie($cookie);
    }

    public function logout(Request $request): JsonResponse
    {
        $cookie = Cookie::forget('auth_token');
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout'
        ])->withCookie($cookie);
    }
}
