<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Http\Resources\CurrencyResource;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();

        if ($currencies->isEmpty()) {
            return response()->json(['message' => 'No currencies found'], 204);
        } else {
            return CurrencyResource::collection($currencies);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:4|unique:currencies',
            'name' => 'nullable|string',
            'symbol' => 'required|string|max:3',

        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $currency = Currency::create([
            'id' => $request->id,
            'name' => $request->name,
            'symbol' => $request->symbol,
        ]);

        return response()->json([
            'message' => 'Currency created',
            'data' => new CurrencyResource($currency),
        ], 201);
    }

    public function show($id)
    {
        $currency = Currency::find($id);

        if ($currency === null) {
            return response()->json(['message' => 'Currency not found'], 404);
        } else {
            return new CurrencyResource($currency);
        }
    }

    public function update(Request $request, $id)
    {
        $currency = Currency::find($id);

        if ($currency === null) {
            return response()->json(['message' => 'Currency not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|nullable|string',
            'symbol' => 'sometimes|string|max:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $currency->update($request->all());

        return response()->json([
            'message' => 'Currency updated',
            'data' => new CurrencyResource($currency),
        ]);
    }

    public function destroy($id)
    {
        $currency = Currency::find($id);

        if ($currency === null) {
            return response()->json(['message' => 'Currency not found'], 404);
        }

        $currency->delete();

        return response()->json(['message' => 'Currency deleted']);
    }
}
