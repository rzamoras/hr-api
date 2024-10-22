<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only(['user_name', 'password']))) {
            $token = $request->user()->createToken('token');

            return response()->json(["token" => $token->plainTextToken]);
        }

        return response()->json(["message" => 'Username and Password not match'], 401);
    }

    public function cookieLogin(Request $request): JsonResponse
    {
        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only(['username', 'password']))) {
            $request->session()->regenerate();

            return response()->json(['message' => 'Login successful'], 200);
        }

        return response()->json('Username and Password not match', 401);
    }
}
