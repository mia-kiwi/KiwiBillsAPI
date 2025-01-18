<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modifier;
use App\Http\Resources\ModifierResource;
use Illuminate\Support\Facades\Validator;

class ModifierController extends Controller
{
    public function index()
    {
        $modifiers = Modifier::all();

        if ($modifiers->isEmpty()) {
            return response()->json(['message' => 'No modifiers found'], 204);
        } else {
            return ModifierResource::collection($modifiers);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|unique:modifiers',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'value' => 'required|decimal:0,2',
            'is_percentage' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $modifier = Modifier::create([
            'id' => $request->id,
            'name' => $request->name,
            'description' => $request->description,
            'value' => $request->value,
            'is_percentage' => $request->is_percentage,
        ]);

        return response()->json([
            'message' => 'Modifier created',
            'data' => new ModifierResource($modifier),
        ], 201);
    }

    public function show($id)
    {
        $modifier = Modifier::find($id);

        if ($modifier === null) {
            return response()->json(['message' => 'Modifier not found'], 404);
        } else {
            return new ModifierResource($modifier);
        }
    }

    public function update(Request $request, $id)
    {
        $modifier = Modifier::find($id);

        if ($modifier === null) {
            return response()->json(['message' => 'Modifier not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'value' => 'required|decimal:0,2',
            'is_percentage' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $modifier->update([
            'name' => $request->name,
            'description' => $request->description,
            'value' => $request->value,
            'is_percentage' => $request->is_percentage,
        ]);

        return response()->json([
            'message' => 'Modifier updated',
            'data' => new ModifierResource($modifier),
        ]);
    }

    public function destroy($id)
    {
        $modifier = Modifier::find($id);

        if ($modifier === null) {
            return response()->json(['message' => 'Modifier not found'], 404);
        }

        $modifier->delete();

        return response()->json(['message' => 'Modifier deleted']);
    }
}
