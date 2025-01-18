<?php

use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\ModifierController;
use App\Http\Controllers\Api\LineController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\EntityController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ----- MODIFIERS ----- \\
Route::apiResource('modifiers', ModifierController::class);

// ----- CURRENCIES ----- \\
Route::apiResource('currencies', CurrencyController::class);

// ----- ITEMS ----- \\
Route::apiResource('items', ItemController::class);

// ----- LINES ----- \\
Route::apiResource('lines', LineController::class);

// ----- INVOICES ----- \\
Route::apiResource('invoices', InvoiceController::class);

// ----- ENTITIES ----- \\
Route::apiResource('entities', EntityController::class);

// ----- TRANSACTIONS ----- \\
Route::apiResource('transactions', TransactionController::class);
