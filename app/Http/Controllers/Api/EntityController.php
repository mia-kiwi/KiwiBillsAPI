<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entity;
use App\Http\Resources\EntityResource;
use Illuminate\Support\Facades\Validator;

class EntityController extends Controller
{
    public function index()
    {
        $entities = Entity::all();

        if ($entities->isEmpty()) {
            return response()->json(['message' => 'No entities found'], 204);
        } else {
            return EntityResource::collection($entities);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|unique:entities',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'type' => 'nullable|string|in:individual,group',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $item = Entity::create([
            'id' => $request->id,
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'type' => $request->type,
        ]);

        return response()->json([
            'message' => 'Entity created',
            'data' => new EntityResource($item),
        ], 201);
    }

    public function show($id)
    {
        $item = Entity::find($id);

        if ($item === null) {
            return response()->json(['message' => 'Entity not found'], 404);
        } else {
            return new EntityResource($item);
        }
    }

    public function update(Request $request, $id)
    {
        $item = Entity::find($id);

        if ($item === null) {
            return response()->json(['message' => 'Entity not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
            'address' => 'sometimes|nullable|string',
            'phone' => 'sometimes|nullable|string',
            'email' => 'sometimes|nullable|email',
            'website' => 'sometimes|nullable|url',
            'type' => 'sometimes|required|string|in:individual,group',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $item->update($request->all());

        return response()->json([
            'message' => 'Entity updated',
            'data' => new EntityResource($item),
        ]);
    }

    public function destroy($id)
    {
        $item = Entity::find($id);

        if ($item === null) {
            return response()->json(['message' => 'Entity not found'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Entity deleted']);
    }
}
