<?php

use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\ModifierController;
use App\Http\Controllers\Api\LineController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\EntityController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return response()->json($request->user(), 200);
})->middleware('auth:sanctum');

// ----- MODIFIERS ----- \\
Route::apiResource('modifiers', ModifierController::class)->middleware('auth:sanctum');

// ----- CURRENCIES ----- \\
Route::apiResource('currencies', CurrencyController::class)->middleware('auth:sanctum');

// ----- ITEMS ----- \\
Route::apiResource('items', ItemController::class)->middleware('auth:sanctum');

// ----- LINES ----- \\
Route::apiResource('lines', LineController::class)->middleware('auth:sanctum');

// ----- INVOICES ----- \\
Route::apiResource('invoices', InvoiceController::class)->middleware('auth:sanctum');

// ----- ENTITIES ----- \\
Route::apiResource('entities', EntityController::class)->middleware('auth:sanctum');

// ----- TRANSACTIONS ----- \\
Route::apiResource('transactions', TransactionController::class)->middleware('auth:sanctum');

// ----- USERS ----- \\
Route::apiResource('users', UserController::class)->middleware('auth:sanctum');

// ----- AUTH ----- \\
Route::post('register', AuthController::class . '@register');
Route::post('login', AuthController::class . '@login');
Route::post('logout', AuthController::class . '@logout')->middleware('auth:sanctum');
Route::addRoute(['GET', 'PATCH', 'PUT', 'DELETE'], 'login', function () {
    return response()->json(['message' => 'Login required'], 401);
})->name('login');
Route::get('session', AuthController::class . '@session')->middleware('auth:sanctum');
