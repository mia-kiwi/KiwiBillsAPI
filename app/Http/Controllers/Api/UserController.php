<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No users found'], 204);
        } else {
            return UserResource::collection($users);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:64|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'abilities' => 'sometimes|required|array',
            'password' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'abilities' => $request->abilities,
            'password' => $request->password,
        ]);

        return response()->json([
            'message' => 'User created',
            'data' => new UserResource($user),
        ], 201);
    }

    public function show($id)
    {
        $user = User::find($id);

        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        } else {
            return new UserResource($user);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:64|unique:users,name',
            'email' => 'sometimes|required|email|unique:users,email',
            'password' => 'sometimes|required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $user->update($request->all());

        return response()->json([
            'message' => 'User updated',
            'data' => new UserResource($user),
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
