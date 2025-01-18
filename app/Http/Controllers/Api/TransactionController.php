<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Http\Resources\TransactionResource;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();

        if ($transactions->isEmpty()) {
            return response()->json(['message' => 'No transactions found'], 204);
        } else {
            return TransactionResource::collection($transactions);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'nullable|string',
            'amount' => 'required|decimal:0,2',
            'currency_id' => 'required|exists:currencies,id',
            'invoice_id' => 'required|exists:invoices,id',
            'payment_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $transaction = Transaction::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'currency_id' => $request->currency_id,
            'invoice_id' => $request->invoice_id,
            'payment_date' => $request->payment_date ?? now(),
        ]);

        return response()->json([
            'message' => 'Transaction created',
            'data' => new TransactionResource($transaction),
        ], 201);
    }

    public function show($id)
    {
        $transaction = Transaction::find($id);

        if ($transaction === null) {
            return response()->json(['message' => 'Transaction not found'], 404);
        } else {
            return new TransactionResource($transaction);
        }
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if ($transaction === null) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'nullable|string',
            'amount' => 'required|decimal:0,2',
            'currency_id' => 'required|exists:currencies,id',
            'invoice_id' => 'required|exists:invoices,id',
            'payment_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $transaction->update([
            'description' => $request->description,
            'amount' => $request->amount,
            'currency_id' => $request->currency_id,
            'invoice_id' => $request->invoice_id,
            'payment_date' => $request->payment_date ?? now(),
        ]);

        return response()->json([
            'message' => 'Transaction updated',
            'data' => new TransactionResource($transaction),
        ]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if ($transaction === null) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted']);
    }
}
