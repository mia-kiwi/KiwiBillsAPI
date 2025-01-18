<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Http\Resources\InvoiceResource;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();

        if ($invoices->isEmpty()) {
            return response()->json(['message' => 'No invoices found'], 204);
        } else {
            return InvoiceResource::collection($invoices);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string',
            'info' => 'nullable|string',
            'reference' => 'nullable|string',
            'received_at' => 'nullable|date',
            'due_at' => 'nullable|date',
            'issued_at' => 'nullable|date',
            'issued_by' => 'required|string|exists:entities,id',
            'payable_to' => 'required|string|exists:entities,id',
            'payable_by' => 'required|string|exists:entities,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $invoice = Invoice::create([
            'title' => $request->title,
            'info' => $request->info,
            'reference' => $request->reference,
            'received_at' => $request->received_at,
            'due_at' => $request->due_at,
            'issued_at' => $request->issued_at,
            'issued_by' => $request->issued_by,
            'payable_to' => $request->payable_to,
            'payable_by' => $request->payable_by,
        ]);

        return response()->json([
            'message' => 'Invoice created',
            'data' => new InvoiceResource($invoice),
        ], 201);
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice === null) {
            return response()->json(['message' => 'Invoice not found'], 404);
        } else {
            return new InvoiceResource($invoice);
        }
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        if ($invoice === null) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string',
            'info' => 'nullable|string',
            'reference' => 'nullable|string',
            'received_at' => 'nullable|date',
            'due_at' => 'nullable|date',
            'issued_at' => 'nullable|date',
            'issued_by' => 'required|string|exists:entities,id',
            'payable_to' => 'required|string|exists:entities,id',
            'payable_by' => 'required|string|exists:entities,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $invoice->update([
            'title' => $request->title,
            'info' => $request->info,
            'reference' => $request->reference,
            'received_at' => $request->received_at,
            'due_at' => $request->due_at,
            'issued_at' => $request->issued_at,
            'issued_by' => $request->issued_by,
            'payable_to' => $request->payable_to,
            'payable_by' => $request->payable_by,
        ]);

        return response()->json([
            'message' => 'Invoice updated',
            'data' => new InvoiceResource($invoice),
        ]);
    }

    public function destroy($id)
    {
        $invoice = Invoice::find($id);

        if ($invoice === null) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted']);
    }
}
