<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        return response()->json([
            'message' => 'Public registration is disabled. Please contact the administrator.'
        ], 403);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('name', $request->name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken($user->name);

        return response()->json([
            'message' => 'Login successful',
            'token' => $token->plainTextToken,
            'user' => $user,
            'expires_at' => $token->accessToken->expires_at,
        ], 200);
    }

    public function logout(Request $request)
    {
        // Delete all tokens (even previous ones)
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }

    public function session(Request $request)
    {
        return response()->json([
            'message' => 'Session active',
            'user' => $request->user(),
            'expires_at' => $request->user()->currentAccessToken()->expires_at,
        ], 200);
    }
}
