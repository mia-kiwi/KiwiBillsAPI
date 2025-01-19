<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();

        if ($items->isEmpty()) {
            return response()->json(['message' => 'No items found'], 204);
        } else {
            return ItemResource::collection($items);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'reference' => 'nullable|string',
            'unit_price' => 'required|decimal:0,2',
            'currency_id' => 'required|exists:currencies,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $item = Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'reference' => $request->reference,
            'unit_price' => $request->unit_price,
            'currency_id' => $request->currency_id,
        ]);

        return response()->json([
            'message' => 'Item created',
            'data' => new ItemResource($item),
        ], 201);
    }

    public function show($id)
    {
        $item = Item::find($id);

        if ($item === null) {
            return response()->json(['message' => 'Item not found'], 404);
        } else {
            return new ItemResource($item);
        }
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if ($item === null) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|nullable|string',
            'reference' => 'sometimes|nullable|string',
            'unit_price' => 'sometimes|required|decimal:0,2',
            'currency_id' => 'sometimes|required|exists:currencies,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $item->update($request->all());

        return response()->json([
            'message' => 'Item updated',
            'data' => new ItemResource($item),
        ]);
    }

    public function destroy($id)
    {
        $item = Item::find($id);

        if ($item === null) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Item deleted']);
    }
}
