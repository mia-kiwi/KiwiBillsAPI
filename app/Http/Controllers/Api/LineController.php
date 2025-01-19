<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Line;
use App\Http\Resources\LineResource;
use Illuminate\Support\Facades\Validator;

class LineController extends Controller
{
    public function index()
    {
        $lines = Line::all();

        if ($lines->isEmpty()) {
            return response()->json(['message' => 'No lines found'], 204);
        } else {
            return LineResource::collection($lines);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'index' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'vat' => 'required|decimal:0,2',
            'item_id' => 'required|exists:items,id',
            'invoice_id' => 'exists:invoices,id',
            'modifier_ids' => 'array|nullable|exists:modifiers,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $line = Line::create([
            'index' => $request->index,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'vat' => $request->vat,
            'item_id' => $request->item_id,
            'invoice_id' => $request->invoice_id,
        ]);

        // Attach the modifiers to the line
        try {
            if ($request->has('modifier_ids')) {
                $line->modifiers()->attach($request->modifier_ids);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add modifiers'], 404);
        }

        return response()->json([
            'message' => 'Line created',
            'data' => new LineResource($line),
        ], 201);
    }

    public function show($id)
    {
        $line = Line::find($id);

        if ($line === null) {
            return response()->json(['message' => 'Line not found'], 404);
        } else {
            return new LineResource($line);
        }
    }

    public function update(Request $request, $id)
    {
        $line = Line::find($id);

        if ($line === null) {
            return response()->json(['message' => 'Line not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'index' => 'sometimes|required|integer|min:0',
            'description' => 'sometimes|nullable|string',
            'quantity' => 'sometimes|required|integer|min:1',
            'vat' => 'sometimes|required|decimal:0,2',
            'item_id' => 'sometimes|required|exists:items,id',
            'invoice_id' => 'sometimes|required|exists:invoices,id',
            'modifier_ids' => 'sometimes|array|nullable|exists:modifiers,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $line->update($request->all());

        // Sync the modifiers to the line
        try {
            if ($request->has('modifier_ids')) {
                $line->modifiers()->sync($request->modifier_ids);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to sync modifiers'], 404);
        }

        return response()->json([
            'message' => 'Line updated',
            'data' => new LineResource($line),
        ]);
    }

    public function destroy($id)
    {
        $line = Line::find($id);

        if ($line === null) {
            return response()->json(['message' => 'Line not found'], 404);
        }

        // Detach the modifiers from the line
        try {
            $line->modifiers()->detach();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to detach modifiers'], 404);
        }

        $line->delete();

        return response()->json(['message' => 'Line deleted']);
    }
}
